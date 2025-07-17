<?php

namespace Machacekm\LivewireDrawer;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Machacekm\LivewireDrawer\Drawer;

class LivewireDrawerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/livewire-drawer.php', 'livewire-drawer'
        );
    }

    public function boot(): void
    {
        Livewire::component('drawer', Drawer::class);

        $this->publishes([
            __DIR__.'/../config/livewire-drawer.php' => config_path('livewire-drawer.php'),
        ], 'livewire-drawer-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/livewire-drawer'),
        ], 'livewire-drawer-views');

        $this->publishes([
            __DIR__.'/../resources/js' => resource_path('js/vendor/livewire-drawer'),
        ], 'livewire-drawer-assets');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-drawer');
    }
} 