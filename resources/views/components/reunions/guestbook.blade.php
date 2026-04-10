@props(['messages' => collect()])

<!-- SỔ LƯU BÚT -->
<section class="py-16 sm:py-24 bg-cover bg-center relative px-5 overflow-hidden"
    style="background-image: url('https://www.transparenttextures.com/patterns/wood-pattern.png'); background-color: #f3f4f6;">
    <!-- Lớp phủ cho nền gỗ -->
    <div class="absolute inset-0 bg-blue-900/10"></div>

    <div class="max-w-2xl mx-auto relative z-10">
        <div class="text-center mb-10" data-aos="fade-down">
            <span
                class="inline-block py-1.5 px-4 rounded-full bg-white/80 backdrop-blur text-blue-900 font-bold uppercase tracking-widest text-[10px] sm:text-xs mb-3 border border-white/50 shadow-sm">Ký
                Ức Thanh Xuân</span>
            <h2 class="text-3xl sm:text-5xl font-serif font-bold text-gray-800 drop-shadow-md">Sổ Lưu Bút <span
                    class="text-blue-700">Chuyền Tay</span></h2>
            <p class="text-gray-700 text-sm sm:text-base mt-2 font-medium italic">"Những dòng lưu bút giữ hộ tuổi
                học trò nhỏ bé..."</p>
        </div>

        <!-- Vùng hiển thị Lưu bút đã gửi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12" data-aos="fade-up" data-aos-delay="100"
            id="guestbook-list">
            @if(isset($messages) && $messages->count() > 0)
                @foreach($messages as $index => $msg)
                    <!-- Post-it Note Item -->
                    <div
                        class="relative bg-yellow-100/80 p-5 rounded-bl-3xl rounded-tr-md shadow-md border-t-4 border-yellow-300 transform transition-transform hover:-translate-y-2 {{ $index % 2 == 0 ? 'rotate-1' : '-rotate-2' }}">
                        <!-- Thẻ dán (Tape) -->
                        <div
                            class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-12 h-6 bg-yellow-400/30 backdrop-blur-sm border border-yellow-500/20 shadow-sm rotate-2 z-10">
                        </div>

                        <p class="font-accent text-xl text-gray-800 leading-relaxed min-h-[80px]">"{{ $msg->content }}"</p>

                        <div class="flex justify-between items-end mt-4 border-t border-yellow-200/50 pt-2">
                            <span class="font-bold text-sm text-blue-900">- {{ $msg->name }}</span>
                            <span class="text-xs text-gray-500">{{ $msg->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-1 md:col-span-2 text-center text-gray-500 py-8 bg-white/50 rounded-xl backdrop-blur">
                    <i class="fas fa-book-open text-3xl mb-2 opacity-50"></i>
                    <p>Chưa có trang lưu bút nào. Hãy là người đầu tiên viết nhé!</p>
                </div>
            @endif
        </div>

        <!-- Thiết kế mô phỏng Cuốn sổ thật (Notebook binder) -->
        <div class="relative bg-white shadow-[0_30px_60px_rgba(0,0,0,0.15)] rounded-r-3xl rounded-l-md border border-gray-300 ml-4 sm:ml-6 transform rotate-1 hover:rotate-0 transition-transform duration-500"
            data-aos="zoom-in" data-aos-delay="100">

            <!-- Gáy sổ (Binder Spiral holes & coils) -->
            <div class="absolute left-0 top-0 bottom-0 w-8 bg-gray-50 border-r border-gray-200 rounded-l-md z-20 flex flex-col justify-evenly py-6">
                <!-- Tạo các lỗ và lò xo kẽm giả -->
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <!-- ... x12 times ... -->
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
                <div class="w-10 h-3 rounded-full bg-gradient-to-b from-gray-200 via-gray-400 to-gray-500 border border-gray-600 shadow-[2px_2px_5px_rgba(0,0,0,0.3)] transform -translate-x-3"></div>
            </div>

            <!-- Giấy Vở Ô Ly Pattern -->
            <div class="ml-8 bg-oly rounded-r-3xl overflow-hidden relative z-10 rounded-l-md pt-10 pb-8 px-6 sm:px-10 min-h-[400px]">
                <!-- Lề đỏ -->
                <div class="oly-margin !left-8 sm:!left-14"></div>

                <!-- Hình dán Băng keo giả -->
                <div class="absolute -top-1 right-10 w-20 h-6 bg-yellow-100/50 transform rotate-3 border border-yellow-200/50 shadow-sm backdrop-blur-sm z-30 opacity-70">
                </div>

                <!-- Dấu mộc / Tem -->
                <div class="absolute bottom-10 right-4 w-16 h-16 rounded-full border-2 border-red-500/30 flex items-center justify-center transform -rotate-12 z-0">
                    <span class="text-red-500/30 font-bold uppercase text-[8px] text-center">Kỷ niệm<br>thời áo trắng</span>
                </div>

                <!-- Hiển thị nội dung Form -->
                <form class="relative z-10 pl-4 sm:pl-10 h-full flex flex-col justify-between"
                    onsubmit="handleGuestbook(event)">

                    <div class="mb-4">
                        <label class="block text-gray-400 font-bold text-[10px] sm:text-xs uppercase tracking-widest mb-1.5"
                            for="guestbook-name">Tên bạn là gì nhỉ?</label>
                        <!-- Dùng font accent (chữ viết tay) -->
                        <input
                            class="w-full bg-transparent border-0 border-b border-blue-200 focus:outline-none focus:ring-0 focus:border-blue-500 transition text-lg sm:text-2xl font-accent text-blue-800 placeholder:text-blue-300"
                            type="text" id="guestbook-name" name="name" placeholder="Ví dụ: Lớp trưởng Nam (12A1)..." required>
                    </div>

                    <div class="mb-6 flex-1">
                        <label class="block text-gray-400 font-bold text-[10px] sm:text-xs uppercase tracking-widest mb-1.5 mt-2"
                            for="guestbook-msg">Nhắn gửi thanh xuân...</label>
                        <textarea
                            class="w-full bg-transparent border-0 focus:outline-none focus:ring-0 transition text-lg sm:text-2xl font-accent text-gray-700 placeholder:text-gray-300 leading-8 resize-none min-h-[160px]"
                            id="guestbook-msg" name="content" placeholder="Ngày đó tao lỡ vạch mực vào áo mày..."
                            required></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="px-8 py-3 rounded-full bg-gradient-to-r from-blue-700 to-blue-900 border border-blue-950 text-white font-bold text-sm shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all flex items-center gap-2">
                            <i class="fas fa-paper-plane text-xs"></i> LƯU GIỮ
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bìa giấy lót lớp dưới tạo hiệu ứng xếp chồng -->
            <div class="absolute inset-y-1 right-[-4px] w-6 bg-white border border-gray-200 rounded-r-2xl z-0 shadow-lg"
                style="transform: skewY(2deg);"></div>
            <div class="absolute inset-y-2 right-[-8px] w-6 bg-gray-50 border border-gray-200 rounded-r-2xl z-[-1] shadow-lg"
                style="transform: skewY(-1deg);"></div>
        </div>
    </div>
</section>

@once
<script>
    function handleGuestbook(e) {
        e.preventDefault();

        const btn = e.target.querySelector('button[type="submit"]');
        const ogText = btn.innerHTML;
        btn.innerHTML = 'ĐANG LƯU...';
        btn.disabled = true;

        const name = document.getElementById('guestbook-name').value;
        const content = document.getElementById('guestbook-msg').value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('reunion.demo.message') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ name: name, content: content })
        })
            .then(res => res.json())
            .then(res => {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Đã lưu!',
                        text: 'Cảm ơn bạn đã gửi lưu bút! Lời nhắn đã được ghi lại 💕',
                        icon: 'success',
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#1d4ed8'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    alert('Đã gửi lưu bút!');
                    window.location.reload();
                }

                e.target.reset();
                btn.innerHTML = ogText;
                btn.disabled = false;
            });
    }
</script>
@endonce
