@if(session('success') || session('error') || session('warning') || session('info'))
    <div id="notification-wrapper" class="fixed bottom-6 right-6 z-[9999] pointer-events-none">
        <div class="notification-stack space-y-3">

            @if(session('success'))
                <div class="notification-toast pointer-events-auto" data-type="success">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[320px] max-w-[420px]">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0.5">Berhasil!</p>
                            <p class="text-sm text-gray-600">{{ session('success') }}</p>
                        </div>

                        <button onclick="closeToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="notification-toast pointer-events-auto" data-type="error">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[320px] max-w-[420px]">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0.5">Error!</p>
                            <p class="text-sm text-gray-600">{{ session('error') }}</p>
                        </div>

                        <button onclick="closeToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="notification-toast pointer-events-auto" data-type="warning">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[320px] max-w-[420px]">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0.5">Peringatan!</p>
                            <p class="text-sm text-gray-600">{{ session('warning') }}</p>
                        </div>

                        <button onclick="closeToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="notification-toast pointer-events-auto" data-type="info">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[320px] max-w-[420px]">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0.5">Informasi</p>
                            <p class="text-sm text-gray-600">{{ session('info') }}</p>
                        </div>

                        <button onclick="closeToast(this)" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0); }
            to { opacity: 0; transform: translateX(100%); }
        }

        .notification-toast { animation: slideIn 0.3s ease-out; }
        .notification-toast.hiding { animation: slideOut 0.3s ease-in forwards; }

        .notification-toast:hover {
            transform: translateX(-4px);
            transition: transform 0.2s ease;
        }

        @media (max-width: 640px) {
            #notification-wrapper {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
            }

            .notification-toast > div {
                min-width: 100%;
            }
        }
    </style>

    <script>
        function closeToast(button) {
            const toast = button.closest('.notification-toast');
            if (toast) {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.notification-toast');

            toasts.forEach((toast, index) => {
                toast.style.animationDelay = `${index * 0.1}s`;

                setTimeout(() => {
                    if (toast && toast.parentElement) {
                        toast.classList.add('hiding');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 5000 + (index * 100));
            });
        });
    </script>
@endif
