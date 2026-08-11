<div class="fi-topbar-item flex items-center ms-4">
    @if($propertiList->count() > 1)
        {{-- Dropdown if multiple properties available --}}
        <x-filament::dropdown placement="bottom-end">
            <x-slot name="trigger">
                <button
                    type="button"
                    class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-50 focus:outline-none dark:text-gray-200 dark:hover:bg-white/5"
                >
                    <x-filament::icon
                        icon="heroicon-o-building-office-2"
                        class="h-5 w-5 text-primary-600 dark:text-primary-400"
                    />
                    
                    <span class="max-w-[150px] truncate text-left">
                        {{ $currentProperti ? $currentProperti->nama_properti : 'Pilih Properti' }}
                    </span>
                    
                    <x-filament::icon
                        icon="heroicon-m-chevron-down"
                        class="h-4 w-4 text-gray-500 dark:text-gray-400"
                    />
                </button>
            </x-slot>

            <x-filament::dropdown.list class="max-h-64 overflow-y-auto">
                @foreach($propertiList as $properti)
                    <x-filament::dropdown.list.item
                        wire:click="switchProperti('{{ $properti->id }}')"
                        icon="{{ $currentId === $properti->id ? 'heroicon-m-check-circle' : 'heroicon-o-building-office' }}"
                        color="{{ $currentId === $properti->id ? 'primary' : 'gray' }}"
                    >
                        {{ $properti->nama_properti }}
                    </x-filament::dropdown.list.item>
                @endforeach
            </x-filament::dropdown.list>
        </x-filament::dropdown>
    @elseif($currentProperti)
        {{-- Read-only view if only one property available --}}
        <div class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
            <x-filament::icon
                icon="heroicon-o-building-office-2"
                class="h-5 w-5 text-primary-600 dark:text-primary-400"
            />
            <span class="max-w-[200px] truncate">
                {{ $currentProperti->nama_properti }}
            </span>
        </div>
    @endif
</div>
