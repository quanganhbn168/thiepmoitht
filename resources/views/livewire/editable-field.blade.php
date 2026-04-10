<div class="relative group inline-block" wire:key="editable-field-{{ $field }}">
    @if($editing)
        {{-- Edit Mode --}}
        <div class="flex items-center gap-2">
            <input type="text" 
                wire:model="value" 
                wire:keydown.enter="save"
                wire:keydown.escape="cancel"
                class="border-2 border-pink-400 rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-pink-300 {{ $class }}"
                style="font-size: inherit; font-family: inherit;"
                autofocus>
            <button wire:click="save" class="p-1 bg-green-500 text-white rounded hover:bg-green-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
            <button wire:click="cancel" class="p-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @else
        {{-- Display Mode --}}
        <{{ $tag }} class="{{ $class }}">{{ $value }}</{{ $tag }}>
        
        {{-- Edit Button (only if editable) --}}
        @if(request()->has('key'))
            <button wire:click="startEditing" 
                class="absolute -right-6 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity p-1 bg-pink-500 text-white rounded-full hover:bg-pink-600">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </button>
        @endif
    @endif
</div>
