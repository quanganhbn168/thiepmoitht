@props(['classDirs' => []])

<!-- RSVP - XÁC NHẬN THAM DỰ -->
<section id="rsvp" class="py-16 sm:py-24 bg-white relative px-5 overflow-hidden">
    <!-- Decorative bg -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-50 rounded-full blur-3xl opacity-50 -z-10"></div>

    <div class="max-w-xl mx-auto relative z-10">
        <div class="text-center mb-10" data-aos="fade-up">
            <span
                class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-700 font-semibold uppercase tracking-widest text-[10px] sm:text-xs mb-3 border border-blue-100">Xác
                nhận</span>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-blue-950">Xác Nhận <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600">Tham
                    Dự</span></h2>
            <p class="text-gray-500 text-sm sm:text-base mt-3">Giúp BTC chuẩn bị chu đáo nhất cho buổi hội ngộ.</p>
        </div>

        <!-- Premium RSVP Card -->
        <div class="relative bg-oly rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.08)] border border-yellow-200/50 p-6 sm:p-10 overflow-hidden"
            data-aos="fade-up" data-aos-delay="100">
            <!-- Lề vở -->
            <div class="oly-margin"></div>
            <!-- Inner Border -->
            <div class="absolute inset-2 border border-dashed border-gray-200 rounded-2xl pointer-events-none">
            </div>

            <form class="relative z-10 space-y-5" onsubmit="handleRsvp(event)">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2 pl-4 sm:pl-8">
                        <label class="block text-blue-900 font-bold text-sm mb-2" for="rsvp-name">Họ và tên
                            *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-50 transition text-sm font-medium text-gray-800"
                                type="text" id="rsvp-name" name="name" placeholder="VD: Nguyễn Văn A" required>
                        </div>
                    </div>

                    <div class="pl-4 sm:pl-8">
                        <label class="block text-blue-900 font-bold text-sm mb-2" for="rsvp-class">Lớp *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-graduation-cap text-gray-400"></i>
                            </div>
                            <select
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-50 transition text-sm font-medium text-gray-800 appearance-none"
                                id="rsvp-class" name="class" required>
                                <option value="">-- Chọn --</option>
                                @foreach(array_keys($classDirs) as $className)
                                    <option value="{{ $className }}">Lớp {{ $className }}</option>
                                @endforeach
                                <option value="Thầy/Cô giáo">Thầy/Cô giáo</option>
                                <option value="Khách mời">Khách mời</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pl-4 sm:pl-8">
                        <label class="block text-blue-900 font-bold text-sm mb-2" for="rsvp-guests">Khách đi
                            cùng</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-users text-gray-400"></i>
                            </div>
                            <input
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-50 transition text-sm font-medium text-gray-800"
                                type="number" id="rsvp-guests" name="guest_count" min="1" max="10" value="1">
                        </div>
                    </div>

                    <div class="sm:col-span-2 pl-4 sm:pl-8">
                        <label class="block text-blue-900 font-bold text-sm mb-2" for="rsvp-phone">Số Zalo/Điện
                            thoại</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone-alt text-gray-400"></i>
                            </div>
                            <input
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-50 transition text-sm font-medium text-gray-800"
                                type="tel" id="rsvp-phone" name="phone" placeholder="Để BTC tiện liên lạc">
                        </div>
                    </div>

                    <div class="sm:col-span-2 pl-4 sm:pl-8">
                        <label class="block text-blue-900 font-bold text-sm mb-2" for="rsvp-note">Lời nhắn</label>
                        <div class="relative">
                            <textarea
                                class="w-full p-4 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:outline-none focus:border-yellow-400 focus:ring-4 focus:ring-yellow-50 transition text-sm font-medium text-gray-800"
                                id="rsvp-note" name="note" rows="3" placeholder="Gửi lời chào tới các bạn..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="pl-4 sm:pl-8"><button type="submit"
                        class="w-full py-4 mt-2 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-600 text-white font-bold text-sm sm:text-base shadow-[0_8px_20px_rgba(234,179,8,0.3)] hover:-translate-y-0.5 hover:shadow-[0_12px_25px_rgba(234,179,8,0.4)] transition-all flex justify-center items-center gap-2">
                        <i class="fas fa-paper-plane"></i>GỬI XÁC NHẬN
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-4">* Thông tin của bạn được bảo mật tuyệt đối.
                    </p>
                </div>
            </form>
        </div>

        <!-- Success message -->
        <div id="rsvpSuccess"
            class="hidden mt-6 bg-green-50 border border-green-200 rounded-2xl p-6 text-center transform transition-all duration-500 shadow-sm relative z-10">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-check text-green-500 text-3xl"></i>
            </div>
            <h3 class="font-bold text-green-800 text-lg">Cảm ơn bạn!</h3>
            <p class="text-green-600 text-sm mt-1">Xác nhận tham dự đã được gửi trực tiếp đến BTC.</p>
        </div>
    </div>
</section>

@once
<style>
    /* Vở Ô Ly Pattern */
    .bg-oly {
        background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M24 0v24H0V0h24z' fill='none'/%3E%3Cpath d='M0 24V0h24' stroke='%23bfdbfe' stroke-width='1' fill='none' opacity='0.5'/%3E%3C/svg%3E");
    }

    .oly-margin {
        position: absolute;
        left: 36px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #fca5a5;
        border-right: 1px solid #fecaca;
        z-index: 0;
    }

    @media(min-width: 640px) {
        .oly-margin {
            left: 48px;
        }
    }
</style>
<script>
    function handleRsvp(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('reunion.demo.rsvp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
            .then(res => res.json())
            .then(res => {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Xác nhận thành công!',
                        text: 'Cảm ơn bạn đã xác nhận tham dự. Hẹn gặp lại bạn!',
                        icon: 'success',
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#1d4ed8'
                    });
                } else {
                    alert('Đã xác nhận tham dự!');
                }
                e.target.style.display = 'none';
                const successDiv = document.getElementById('rsvpSuccess');
                if(successDiv) successDiv.classList.remove('hidden');
            });
    }
</script>
@endonce
