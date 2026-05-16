<div x-data="notificationDropdown()" x-init="init()" class="relative">
    <button @click="toggle()"
        class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span x-show="unreadCount > 0" x-text="unreadCount"
            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
    </button>

    <div x-show="open" @click.away="open = false" style="display: none;"
        class="absolute right-0 z-50 mt-2 w-80 bg-white dark:bg-slate-800 rounded-md shadow-lg overflow-hidden border border-gray-100 dark:border-slate-700 ring-1 ring-black ring-opacity-5">
        <div
            class="px-4 py-3 bg-gray-50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Notifikasi</h3>
            <span x-show="unreadCount > 0" class="text-xs bg-red-100 text-red-600 py-0.5 px-2 rounded-full font-medium"
                x-text="unreadCount + ' Baru'"></span>
        </div>
        <div class="max-h-96 overflow-y-auto">
            <template x-if="notifications.length > 0">
                <div>
                    <template x-for="notification in notifications" :key="notification.id">
                        <a href="#" @click.prevent="markAsRead(notification)"
                            class="block px-4 py-3 border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors"
                            :class="{'bg-blue-50 dark:bg-slate-700/80': !notification.read_at}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <template x-if="notification.data.type === 'success'">
                                        <div
                                            class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </template>
                                    <template x-if="notification.data.type === 'action'">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </template>
                                    <template x-if="notification.data.type === 'warning'">
                                        <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                    </template>
                                    <template x-if="notification.data.type === 'error'">
                                        <div class="h-8 w-8 rounded-full bg-rose-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-rose-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </template>
                                    <template x-if="notification.data.type === 'info'">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </template>
                                </div>
                                <div class="ml-3 w-0 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="notification.data.title"></p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                                        x-text="notification.data.message"></p>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500"
                                        x-text="formatDate(notification.created_at)"></p>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
            <template x-if="notifications.length === 0">
                <div class="px-4 py-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada notifikasi saat ini.</p>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationDropdown', () => ({
            open: false,
            notifications: [],
            unreadCount: 0,
            pollingInterval: null,

            init() {
                this.fetchNotifications();
                this.fetchUnreadCount();

                // Poll every 30 seconds
                this.pollingInterval = setInterval(() => {
                    this.fetchUnreadCount();
                }, 30000);
            },

            toggle() {
                this.open = !this.open;
                if (this.open) {
                    this.fetchNotifications();
                }
            },

            fetchNotifications() {
                fetch('{{ route('notifications.index') }}')
                    .then(response => response.json())
                    .then(data => {
                        this.notifications = data;
                    })
                    .catch(error => console.error('Error fetching notifications:', error));
            },

            fetchUnreadCount() {
                fetch('{{ route('notifications.unreadCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        this.unreadCount = data.count;
                    })
                    .catch(error => console.error('Error fetching unread count:', error));
            },

            markAsRead(notification) {
                if (!notification.read_at) {
                    fetch(`/notifications/${notification.id}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                        .then(data => {
                            if (data.action_url) {
                                window.location.href = data.action_url;
                            }
                        });
                } else if (notification.data.action_url) {
                    window.location.href = notification.data.action_url;
                }
            },

            formatDate(dateString) {
                const date = new Date(dateString);
                return new Intl.DateTimeFormat('id-ID', {
                    day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit'
                }).format(date);
            }
        }));
    });
</script>