@props(['messages' => collect(), 'reunion' => null])

@php
    $submitUrl = $reunion
        ? route('reunion.message.store', ['reunion' => $reunion->slug])
        : route('reunion.demo.message');

    $messages = collect($messages);
@endphp

<!-- SỔ LƯU BÚT -->
<section id="guestbook" class="relative overflow-hidden bg-[#f7f3ea] px-5 py-16 text-slate-900 sm:py-24">
    <div class="pointer-events-none absolute inset-0 opacity-70"
        style="background-image: linear-gradient(90deg, rgba(148,163,184,.08) 1px, transparent 1px), linear-gradient(180deg, rgba(148,163,184,.08) 1px, transparent 1px); background-size: 44px 44px;">
    </div>

    <div class="relative mx-auto max-w-6xl">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_430px] lg:items-start">
            <div>
                <div class="max-w-2xl" data-aos="fade-up">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white/80 px-4 py-1.5 text-[11px] font-bold uppercase tracking-[0.22em] text-blue-800 shadow-sm">
                        <i class="fas fa-book-open text-amber-500"></i>
                        Ký ức thanh xuân
                    </span>
                    <h2 class="mt-4 font-serif text-3xl font-bold leading-tight text-slate-950 sm:text-5xl">
                        Sổ lưu bút
                    </h2>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600 sm:text-base">
                        Lưu lại những lời nhắn thật gần gũi trước ngày trở về, để mỗi lần đọc lại vẫn thấy nguyên vẹn
                        không khí của một thời áo trắng.
                    </p>
                </div>

                <div id="guestbook-list" class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2" data-aos="fade-up"
                    data-aos-delay="100">
                    @if($messages->count() > 0)
                        @foreach($messages as $index => $msg)
                            @php
                                $name = trim($msg->name ?: 'Bạn cũ');
                                $initial = mb_strtoupper(mb_substr($name, 0, 1));
                            @endphp

                            <article
                                class="group relative overflow-hidden rounded-2xl border border-white/80 bg-white/90 p-5 shadow-[0_18px_45px_rgba(15,23,42,0.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_55px_rgba(15,23,42,0.12)]">
                                <div
                                    class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-700 via-amber-400 to-blue-700 opacity-80">
                                </div>

                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-900 text-sm font-bold text-white shadow-sm">
                                        {{ $initial }}
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="truncate text-sm font-bold text-slate-900">{{ $name }}</h3>
                                        <p class="mt-0.5 text-xs font-medium text-slate-400">
                                            {{ optional($msg->created_at)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>

                                <p class="mt-5 break-words text-[15px] leading-7 text-slate-700">
                                    “{{ $msg->content }}”
                                </p>
                            </article>
                        @endforeach
                    @else
                        <article
                            class="md:col-span-2 rounded-2xl border border-dashed border-blue-200 bg-white/75 p-8 text-center shadow-sm">
                            <div
                                class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-700">
                                <i class="fas fa-pen-nib text-xl"></i>
                            </div>
                            <h3 class="mt-4 font-serif text-2xl font-bold text-slate-900">Chưa có trang lưu bút nào</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                                Hãy là người đầu tiên gửi một lời nhắn để mở đầu cuốn sổ kỷ niệm này.
                            </p>
                        </article>
                    @endif
                </div>
            </div>

            <aside
                class="relative rounded-[1.75rem] border border-white/80 bg-white p-4 shadow-[0_28px_70px_rgba(15,23,42,0.12)]"
                data-aos="fade-left" data-aos-delay="150">
                <div class="guestbook-paper relative overflow-hidden rounded-[1.35rem] border border-blue-100 px-5 py-6 sm:px-7 sm:py-8">
                    <div class="mb-6 border-b border-blue-100 pb-5">
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-amber-600">Viết vào sổ</p>
                        <h3 class="mt-2 font-serif text-2xl font-bold text-blue-950">Gửi lời nhắn của bạn</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Một câu chuyện ngắn, một lời hẹn, hoặc chỉ là lời chào cũng đủ làm ngày hội ngộ ấm hơn.
                        </p>
                    </div>

                    <form class="space-y-5" onsubmit="handleGuestbook(event)">
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500"
                                for="guestbook-name">
                                Tên của bạn
                            </label>
                            <input
                                class="w-full rounded-2xl border border-blue-100 bg-white/85 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm outline-none transition placeholder:text-slate-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                type="text" id="guestbook-name" name="name" placeholder="VD: Nguyễn Văn Nam - 12A1"
                                required>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-[0.18em] text-slate-500"
                                for="guestbook-msg">
                                Lời nhắn
                            </label>
                            <textarea
                                class="min-h-[170px] w-full resize-none rounded-2xl border border-blue-100 bg-white/85 px-4 py-3 text-sm leading-7 text-slate-700 shadow-sm outline-none transition placeholder:text-slate-300 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                                id="guestbook-msg" name="content" placeholder="Viết vài dòng cho bạn bè, thầy cô..."
                                required></textarea>
                        </div>

                        <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-blue-900 px-6 py-3.5 text-sm font-bold uppercase tracking-[0.12em] text-white shadow-[0_16px_35px_rgba(30,58,138,0.28)] transition hover:-translate-y-0.5 hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-70">
                            <i class="fas fa-paper-plane text-xs"></i>
                            Gửi lưu bút
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>

@once
<style>
    .guestbook-paper {
        background-color: #fffdf8;
        background-image:
            linear-gradient(to bottom, rgba(96, 165, 250, .18) 1px, transparent 1px),
            linear-gradient(to right, rgba(248, 113, 113, .2) 1px, transparent 1px);
        background-position: 0 25px, 34px 0;
        background-size: 100% 34px, 100% 100%;
    }
</style>
<script>
    function handleGuestbook(e) {
        e.preventDefault();

        const btn = e.target.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        const name = document.getElementById('guestbook-name').value;
        const content = document.getElementById('guestbook-msg').value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        btn.innerHTML = 'ĐANG GỬI...';
        btn.disabled = true;

        fetch(@js($submitUrl), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ name: name, content: content })
        })
            .then(async response => {
                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    throw new Error(payload.message || 'Không gửi được lưu bút.');
                }

                return response.json();
            })
            .then(() => {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Đã lưu!',
                        text: 'Cảm ơn bạn đã gửi lưu bút. Lời nhắn đã được ghi lại.',
                        icon: 'success',
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#1e3a8a'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    alert('Đã gửi lưu bút!');
                    window.location.reload();
                }

                e.target.reset();
            })
            .catch(error => {
                if(typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Chưa gửi được',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#1e3a8a'
                    });
                } else {
                    alert(error.message);
                }
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    }
</script>
@endonce
