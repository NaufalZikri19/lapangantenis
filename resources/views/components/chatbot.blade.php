@php
    $pendingBookingCount = auth()->check() ? auth()->user()->bookings()->where('status', 'pending')->count() : 0;
@endphp

<div x-data="chatbot({{ $pendingBookingCount }})" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Widget Button -->
    <button @click="toggleChat()"
        class="w-14 h-14 bg-gray-900 hover:bg-black text-white rounded-full shadow-xl shadow-gray-900/20 flex items-center justify-center transition-all hover:scale-105 duration-200 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
        <i data-lucide="message-circle" class="w-6 h-6" x-show="!isOpen"></i>
        <i data-lucide="x" class="w-6 h-6" x-show="isOpen" x-cloak></i>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="closeIfNotMobile()"
        class="fixed inset-0 sm:absolute sm:inset-auto sm:bottom-16 sm:right-0 sm:mb-4 w-full sm:w-96 bg-white sm:rounded-2xl shadow-2xl shadow-gray-900/10 sm:border border-gray-200/60 flex flex-col overflow-hidden origin-bottom-right z-[60] sm:z-auto h-full sm:h-[600px] sm:max-h-[calc(100vh-120px)]"
        x-cloak>

        <!-- Header -->
        <div class="bg-white p-4 border-b border-gray-100 shrink-0 flex items-center justify-between relative z-10">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center shrink-0 text-white shadow-sm">
                        <i data-lucide="bot" class="w-5 h-5"></i>
                    </div>
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-green-500 border-2 border-white"></span>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm tracking-tight">AI Assistant</h3>
                    <p class="text-[11px] text-gray-500 font-medium">Selalu siap membantu</p>
                </div>
            </div>
            <!-- Close button -->
            <button @click="isOpen = false"
                class="p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 rounded-full transition-colors focus:outline-none">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-6 bg-gray-50/30" id="chat-messages"
            style="scroll-behavior: smooth;">
            <!-- Empty State / Welcome Message -->
            <template x-if="messages.length === 0 && !hasPendingNotification">
                <div class="flex flex-col items-center justify-center h-full space-y-4 opacity-80 pt-10 pb-10">
                    <div
                        class="w-16 h-16 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-yellow-500">
                        <i data-lucide="sparkles" class="w-8 h-8"></i>
                    </div>
                    <div class="text-center space-y-1 px-4">
                        <p class="text-gray-800 text-sm font-semibold">Gumbreg AI</p>
                        <p class="text-gray-500 text-xs font-medium">Tanyakan seputar jadwal atau pembayaran lapangan
                            tenis.</p>
                    </div>
                </div>
            </template>

            <!-- Messages Loop -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div class="flex flex-col gap-1.5 max-w-[85%]">
                        <div :class="msg.role === 'user' ? 'bg-gray-900 text-white rounded-2xl rounded-tr-sm shadow-sm' : 'bg-white border border-gray-100 text-gray-700 rounded-2xl rounded-tl-sm shadow-sm'"
                            class="px-4 py-2.5 text-[13px] sm:text-sm leading-relaxed whitespace-pre-wrap"
                            x-text="msg.content">
                        </div>
                        <span :class="msg.role === 'user' ? 'text-right' : 'text-left'"
                            class="text-[10px] text-gray-400 px-1 font-medium tracking-wide" x-text="msg.time"></span>
                    </div>
                </div>
            </template>

            <!-- Loading State -->
            <div x-show="isLoading" class="flex justify-start items-end gap-2">
                <div class="flex flex-col gap-1.5 max-w-[85%]">
                    <div
                        class="bg-white border border-gray-100 text-gray-500 rounded-2xl rounded-tl-sm shadow-sm px-4 py-3.5 flex gap-1.5 items-center w-fit">
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s">
                        </div>
                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s">
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 px-1 font-medium tracking-wide">Bot sedang mengetik...</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div
            class="px-4 py-3 bg-white flex gap-2 overflow-x-auto whitespace-nowrap scrollbar-hide border-t border-gray-100 shrink-0">
            <button @click="sendQuickAction('Booking Sekarang')"
                class="px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-white border border-gray-200 rounded-full hover:border-gray-900 hover:text-gray-900 text-gray-600 transition-all shadow-sm shrink-0 focus:outline-none focus:ring-2 focus:ring-gray-100">Booking
                Sekarang</button>
            <button @click="sendQuickAction('Lihat Jadwal')"
                class="px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-white border border-gray-200 rounded-full hover:border-gray-900 hover:text-gray-900 text-gray-600 transition-all shadow-sm shrink-0 focus:outline-none focus:ring-2 focus:ring-gray-100">Lihat
                Jadwal</button>
            <button @click="sendQuickAction('Status Booking')"
                class="px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-white border border-gray-200 rounded-full hover:border-gray-900 hover:text-gray-900 text-gray-600 transition-all shadow-sm shrink-0 focus:outline-none focus:ring-2 focus:ring-gray-100">Status
                Booking</button>
            <button @click="sendQuickAction('Cara Pembayaran')"
                class="px-3.5 py-1.5 text-[11px] sm:text-xs font-semibold bg-white border border-gray-200 rounded-full hover:border-gray-900 hover:text-gray-900 text-gray-600 transition-all shadow-sm shrink-0 focus:outline-none focus:ring-2 focus:ring-gray-100">Cara
                Pembayaran</button>
        </div>

        <!-- Input Area -->
        <div class="p-3 sm:p-4 bg-white shrink-0">
            <form @submit.prevent="sendMessage"
                class="flex items-end gap-2 relative bg-gray-50 p-1.5 rounded-2xl border border-gray-200 focus-within:border-gray-300 focus-within:ring-4 focus-within:ring-gray-100 transition-all">
                <textarea x-model="newMessage" x-ref="chatInput"
                    class="w-full bg-transparent border-none px-3 py-2.5 text-[13px] sm:text-sm focus:ring-0 resize-none overflow-hidden max-h-32 placeholder-gray-400"
                    placeholder="Ketik pesan..." rows="1"
                    @keydown.enter.prevent="if(!isLoading && newMessage.trim().length > 0) sendMessage()"
                    @input="adjustTextareaHeight($event.target)"></textarea>

                <button type="submit" :disabled="isLoading || newMessage.trim().length === 0"
                    class="p-2.5 bg-gray-900 text-white rounded-xl hover:bg-black transition-all disabled:opacity-40 disabled:cursor-not-allowed shrink-0 flex items-center justify-center shadow-sm">
                    <i data-lucide="send" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatbot', (pendingCount) => ({
            isOpen: false,
            isLoading: false,
            newMessage: '',
            messages: [],
            pendingCount: pendingCount,
            hasPendingNotification: false,

            init() {
                // Smart Notification on Init
                if (this.pendingCount > 0) {
                    this.hasPendingNotification = true;
                    this.messages.push({
                        role: 'bot',
                        content: 'Halo! Anda masih memiliki ' + this.pendingCount + ' booking yang belum dibayar. Mau saya bantu arahkan cara pembayarannya?',
                        time: this.getCurrentTime()
                    });
                }
            },

            closeIfNotMobile() {
                if (window.innerWidth >= 640) {
                    this.isOpen = false;
                }
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    setTimeout(() => {
                        this.scrollToBottom();
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                        // Auto focus on desktop
                        if (window.innerWidth >= 640) {
                            this.$refs.chatInput.focus();
                        }
                    }, 50);
                }
            },

            getCurrentTime() {
                return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            },

            adjustTextareaHeight(el) {
                el.style.height = 'auto';
                el.style.height = (el.scrollHeight < 128 ? el.scrollHeight : 128) + 'px';
            },

            scrollToBottom() {
                const container = document.getElementById('chat-messages');
                if (container) {
                    // Use smooth scrolling
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            },

            sendQuickAction(text) {
                this.newMessage = text;
                this.sendMessage();
            },

            async sendMessage() {
                if (this.newMessage.trim() === '' || this.isLoading) return;

                const messageText = this.newMessage.trim();

                // Keep history (excluding the new message we are about to push)
                const currentHistory = JSON.parse(JSON.stringify(this.messages));

                // Add user message
                this.messages.push({
                    role: 'user',
                    content: messageText,
                    time: this.getCurrentTime()
                });

                this.newMessage = '';

                // Reset textarea height
                if (this.$refs.chatInput) {
                    this.$refs.chatInput.style.height = 'auto';
                }

                this.isLoading = true;
                setTimeout(() => this.scrollToBottom(), 50);

                try {
                    const response = await fetch('{{ route("chatbot.handle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: messageText,
                            history: currentHistory // Send previous messages for context
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.messages.push({
                            role: 'bot',
                            content: data.reply,
                            time: this.getCurrentTime()
                        });
                    } else {
                        this.messages.push({
                            role: 'bot',
                            content: data.error || 'Maaf, sistem sedang sibuk. Coba lagi sebentar.',
                            time: this.getCurrentTime()
                        });
                    }
                } catch (error) {
                    console.error('Chatbot error:', error);
                    this.messages.push({
                        role: 'bot',
                        content: 'Maaf, sistem sedang sibuk. Coba lagi sebentar.',
                        time: this.getCurrentTime()
                    });
                } finally {
                    this.isLoading = false;
                    setTimeout(() => {
                        this.scrollToBottom();
                        // Refocus input if not mobile to prevent keyboard popping repeatedly
                        if (window.innerWidth >= 640 && this.isOpen) {
                            this.$refs.chatInput.focus();
                        }
                    }, 50);
                }
            }
        }));
    });
</script>