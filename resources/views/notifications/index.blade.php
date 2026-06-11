@extends(Auth::user()->isAdmin() ? 'layouts.admin' : 'layouts.customer')

@section('title', 'Semua Notifikasi')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div
                class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white">Riwayat Notifikasi</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar semua notifikasi yang pernah Anda
                        terima.</p>
                </div>

                <div
                    class="flex flex-col sm:flex-row items-stretch sm:items-center w-full sm:w-auto gap-2 sm:gap-3 mt-4 sm:mt-0">
                    @if($notifications->count() > 0)
                        <button onclick="deleteAllNotifications()"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 dark:text-rose-400 font-semibold text-sm rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-500/50 w-full sm:w-auto">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            Hapus Semua
                        </button>
                    @endif

                    <button onclick="markAllAsRead()"
                        class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-semibold text-sm rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500/50 w-full sm:w-auto">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        Tandai Semua Dibaca
                    </button>
                </div>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800/50">
                @forelse($notifications as $notification)
                    <div
                        class="p-4 sm:p-6 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ is_null($notification->read_at) ? 'bg-yellow-50/50 dark:bg-slate-800/80' : '' }}">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="shrink-0 pt-1">
                                @php
                                    $type = $notification->data['type'] ?? 'info';
                                    $bgClass = 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300';
                                    $icon = 'info';

                                    if ($type === 'success') {
                                        $bgClass = 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400';
                                        $icon = 'check-circle-2';
                                    } elseif ($type === 'warning') {
                                        $bgClass = 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400';
                                        $icon = 'alert-triangle';
                                    } elseif ($type === 'error') {
                                        $bgClass = 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400';
                                        $icon = 'x-circle';
                                    } elseif ($type === 'action') {
                                        $bgClass = 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
                                        $icon = 'bell-ring';
                                    }
                                @endphp

                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $bgClass }}">
                                    <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-4 mb-1">
                                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                        {{ $notification->data['title'] ?? 'Notifikasi' }}
                                    </h3>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                        {{ $notification->created_at->locale('id')->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-600 dark:text-slate-300">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>

                                @if(isset($notification->data['action_url']))
                                    @php
                                        $actionUrl = $notification->data['action_url'];
                                        try {
                                            $parsed = parse_url($actionUrl);
                                            $actionUrl = isset($parsed['path']) ? url($parsed['path'] . (isset($parsed['query']) ? '?' . $parsed['query'] : '')) : $actionUrl;
                                        } catch (\Exception $e) {
                                        }
                                    @endphp
                                    <div class="mt-3">
                                        <a href="{{ $actionUrl }}" onclick="markSingleAsRead('{{ $notification->id }}')"
                                            class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                                            Lihat Detail <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Status & Actions -->
                            <div class="shrink-0 flex flex-col items-center gap-3 pt-1">
                                @if(is_null($notification->read_at))
                                    <span
                                        class="w-2.5 h-2.5 rounded-full bg-yellow-500 shadow-[0_0_8px_rgba(234,179,8,0.5)]"></span>
                                @endif
                                <button onclick="deleteNotification('{{ $notification->id }}')"
                                    class="p-1.5 text-slate-400 hover:text-rose-500 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors tooltip"
                                    title="Hapus Notifikasi">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div
                            class="w-16 h-16 mx-auto bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="bell-off" class="w-8 h-8 text-slate-400 dark:text-slate-500"></i>
                        </div>
                        <h3 class="text-base font-medium text-slate-900 dark:text-white mb-1">Belum Ada Notifikasi</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Riwayat notifikasi Anda akan muncul di sini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function markAllAsRead() {
                fetch('{{ route('notifications.markAllAsRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Toast alert
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                                color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                            });

                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });

                            // Reload page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    });
            }

            function deleteAllNotifications() {
                Swal.fire({
                    title: 'Hapus Semua Notifikasi?',
                    text: "Semua riwayat notifikasi Anda akan dihapus permanen",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('notifications.deleteAll') }}', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                                        color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                                    });

                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            });
                    }
                })
            }

            function markSingleAsRead(id) {
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            }

            function deleteNotification(id) {
                Swal.fire({
                    title: 'Hapus Notifikasi?',
                    text: "Notifikasi yang dihapus tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/notifications/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                                        color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                                    });

                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message
                                    });

                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            });
                    }
                })
            }
        </script>
    @endpush
@endsection