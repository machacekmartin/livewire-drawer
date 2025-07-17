<div
    x-data="drawer"
    x-on:close-drawer.window="close"
    x-on:open-drawer.window="open($event.detail.component, $event.detail.props)"
    x-on:keydown.escape.window="close"
    @foreach ($closeOnEvents as $event) x-on:{{ $event }}.window="close" @endforeach
>
    <div
        x-cloak
        x-show="opened"
        x-transition.opacity.duration.500ms
        x-on:click="close"
        class="fixed inset-0 pointer-events-auto bg-black/50 backdrop-blur-sm z-[1000]"
    >
    </div>

    <div
        x-cloak
        x-show="opened"
        class="fixed z-[1000] mb-6 shadow-lg bg-white max-w-md transition-all overflow-y-auto md:max-h-[calc(100%-2rem)] md:top-4 md:right-4 top-0 right-0 flex flex-col max-h-full h-screen w-full md:rounded-xl"
        x-transition:enter="transition ease-in-out duration-500"
        x-transition:enter-start="md:translate-x-[calc(100%+2rem)] translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-500"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="md:translate-x-[calc(100%+2rem)] translate-x-full"
    >
        <div wire:loading.class.remove="opacity-0" class="absolute top-20 place-items-center mx-auto w-full opacity-0 transition-opacity">
            <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"width="24" height="24">
                <path d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                    stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                    stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900"></path>
            </svg>
        </div>

        <div class="relative">
            <div class="flex justify-between items-center p-5 mb-1">
                <div class="text-base font-semibold leading-7 text-gray-900 md:text-lg">
                    {{ $title }}
                </div>

                <div>
                    <button x-on:click="close" wire:loading.class="hidden" class="flex justify-center items-center cursor-pointer">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>

        <div class="relative flex-1 px-5 text-sm">
            @if ($componentName)
                @livewire($componentName, $componentProps)
            @endif
        </div>
    </div>
</div>
