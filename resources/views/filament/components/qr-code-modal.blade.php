<div class="flex flex-col items-center justify-center space-y-4">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
        <img src="{{ $qrUrl }}" alt="QR Code" class="w-64 h-64">
    </div>
    <div class="text-center">
        <p class="text-sm text-gray-500 mb-2">Quét mã để truy cập danh thiếp</p>
        <p class="font-mono text-xs bg-gray-100 p-2 rounded">{{ $url }}</p>
    </div>
    <a href="{{ $qrUrl }}&download=1" target="_blank" download="qrcode.png" 
       class="fi-btn fi-btn-size-md fi-btn-color-primary relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-btn-color-primary gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50"
       style="background-color: rgb(234 179 8); color: white;">
       <span class="fi-btn-label">Tải xuống QR</span>
    </a>
</div>
