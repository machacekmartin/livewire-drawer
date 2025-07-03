<?php

namespace App\Livewire\Components;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use Livewire\Wireable;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;

class Drawer extends Component
{
    public ?string $componentName = null;

    public ?string $componentClass = null;

    public array $componentProps = [];

    public ?string $title = null;

    public array $closeOnEvents = [];

    #[On(['open-drawer'])]
    public function mountComponent(string $component, array $props): void
    {
        $this->componentName = $component;
        $this->componentClass = app(ComponentRegistry::class)->getClass($component);
        $this->componentProps = $this->resolvePropsWithTypes($props);

        $this->title = method_exists($this->componentClass, 'getTitle') ? $this->componentClass::getTitle() : '';
        $this->closeOnEvents = method_exists($this->componentClass, 'getCloseEvents') ? $this->componentClass::getCloseEvents() : [];
    }

    public function unmountComponent(): void
    {
        $this->reset();
    }

    private function resolvePropsWithTypes(array $props): array
    {
        $componentInstance = new $this->componentClass;

        $publicProperties = (new ReflectionClass($componentInstance))->getProperties(ReflectionProperty::IS_PUBLIC);
        $keyedPublicProperties = collect($publicProperties)->keyBy(fn (ReflectionProperty $property) => $property->getName());

        $props = collect($props);

        // throw an exception when input props contain a variable that is not a public property of the component
        $props->each(function (mixed $value, string $key) use ($keyedPublicProperties) {
            if (! $keyedPublicProperties->has($key)) {
                throw new Exception('Drawer component does not have a public property $' . $key);
            }
        });

        // cast each property to its desired type
        return $props->mapWithKeys(function ($value, $key) use ($keyedPublicProperties) {
            return [$key => $this->resolveInstance($value, $keyedPublicProperties[$key]->getType())];
        })->all();
    }

    private function resolveInstance(mixed $value, ?ReflectionType $type): mixed
    {
        if ($type instanceof ReflectionUnionType) {
            throw new Exception('Drawer component does not support Union types: ' . $type);
        }

        if ($type instanceof ReflectionIntersectionType) {
            throw new Exception('Drawer component does not support Intersection types: ' . $type);
        }

        // Missing type
        if ($type === null) {
            return $value;
        }

        /** @var ReflectionNamedType $type */
        $class = $type->getName();

        // Native primitive types
        if ($type->isBuiltin()) {
            return $value;
        }

        // Enums
        if (enum_exists($class)) {
            return $class::from($value);  /** @phpstan-ignore-line */
        }

        // Collections
        if ($class === Collection::class) {
            return collect($value);  /** @phpstan-ignore-line */
        }

        // Wireables
        if (is_subclass_of($class, Wireable::class)) {
            return $class::fromLivewire($value);
        }

        // Models
        if (is_subclass_of($class, Model::class)) {
            throw new Exception('Drawer component does not support model injection. Use locked model key instead.');
        }

        throw new Exception('Drawer component could not resolve type: ' . $class);
    }
}
