<div x-data="{
    open: false,
    cropper: null,
    previewUrl: '{{ $imageUrl }}',
    aspectRatio: {{ $aspectRatio }},

    init() {
        Livewire.on('image-updated', () => {
            location.reload();
        });
    },

    openModal() {
        this.open = true;
    },

    fileChosen(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            this.previewUrl = e.target.result;
            this.$nextTick(() => {
                this.initCropper();
            });
        };
        reader.readAsDataURL(file);
        this.openModal();
    },

    initCropper() {
        const image = document.getElementById('cropper-image-{{ $collectionName }}');
        if (this.cropper) {
            this.cropper.destroy();
        }
        this.cropper = new Cropper(image, {
            aspectRatio: this.aspectRatio,
            viewMode: 1,
            autoCropArea: 1,
        });
    },

    save() {
        if (!this.cropper) return;

        this.cropper.getCroppedCanvas().toBlob((blob) => {
            const file = new File([blob], 'cropped-image.jpg', { type: 'image/jpeg' });
            @this.upload('photo', file, () => {
                this.open = false;
                if (this.cropper) {
                    this.cropper.destroy();
                    this.cropper = null;
                }
            }, () => {
                alert('Có lỗi khi upload ảnh!');
            });
        }, 'image/jpeg', 0.9);
    },

    cancel() {
        this.open = false;
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
    }
}" class="relative group">
    
    {{-- Display Image --}}
    <img src="{{ $imageUrl }}" alt="Wedding Image" class="w-full h-auto object-cover">
    
    {{-- Edit Button (only if editable) --}}
    @if(request()->has('key'))
        <label class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
            <input type="file" accept="image/*" class="hidden" @change="fileChosen">
            <span class="text-white text-lg font-semibold flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Đổi ảnh
            </span>
        </label>
    @endif

    {{-- Cropper Modal --}}
    <div x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
        @keydown.escape.window="cancel()">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4 p-6" @click.away="cancel()">
            <h3 class="text-xl font-bold mb-4">Cắt ảnh</h3>
            
            <div class="max-h-[60vh] overflow-hidden">
                <img id="cropper-image-{{ $collectionName }}" :src="previewUrl" class="max-w-full">
            </div>
            
            <div class="flex justify-end gap-3 mt-4">
                <button @click="cancel()" class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-100">
                    Hủy
                </button>
                <button @click="save()" class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                    Lưu ảnh
                </button>
            </div>
        </div>
    </div>
</div>
