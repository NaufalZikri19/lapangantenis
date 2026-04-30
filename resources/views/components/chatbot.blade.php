<div x-data="chatbot()" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Widget Button -->
    <button @click="toggleChat()"
        class="w-14 h-14 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-105 duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
        <i data-lucide="message-circle" class="w-6 h-6" x-show="!isOpen"></i>
        <i data-lucide="x" class="w-6 h-6" x-show="isOpen" x-cloak></i>
    </button>

    <!-- Chat Window -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="isOpen = false"
        class="absolute bottom-16 right-0 sm:right-0 mb-4 w-[calc(100vw-3rem)] sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden origin-bottom-right"
        style="height: 500px; max-height: calc(100vh - 120px);" x-cloak>

        <!-- Header -->
        <div class="bg-yellow-500 p-4 text-white shrink-0 flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <i data-lucide="bot" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="font-bold text-sm">Asisten Lapangan Tenis</h3>
                <p class="text-xs text-yellow-50 opacity-90 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-400 inline-block"></span> Online
                </p>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50/50" id="chat-messages">
            <!-- Empty State / Welcome Message -->
            <template x-if="messages.length === 0">
                <div class="flex flex-col items-center justify-center h-full space-y-3 opacity-70">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                        <i data-lucide="hand" class="w-8 h-8"></i>
                    </div>
                    <p class="text-gray-500 text-sm font-medium text-center">Hai, ada yang bisa saya bantu?</p>
                </div>
            </template>

            <!-- Messages Loop -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' ? 'bg-yellow-500 text-white rounded-2xl rounded-tr-sm' : 'bg-white text-gray-700 border border-gray-100 rounded-2xl rounded-tl-sm shadow-sm'"
                        class="max-w-[80%] px-4 py-2 text-sm leading-relaxed whitespace-pre-wrap" x-text="msg.content">
                    </div>
                </div>
            </template>

            <!-- Loading State -->
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-sm shadow-sm px-4 py-3 flex gap-1">
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-gray-100 shrink-0">
            <form @submit.prevent="sendMessage" class="flex items-end gap-2 relative">
                <textarea x-model="newMessage"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500 transition-colors resize-none overflow-hidden max-h-32"
                    placeholder="Ketik pesan..." rows="1"
                    @keydown.enter.prevent="if(!isLoading && newMessage.trim().length > 0) sendMessage()"
                    @input="adjustTextareaHeight($event.target)"></textarea>

                <button type="submit" :disabled="isLoading || newMessage.trim().length === 0"
                    class="p-3 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shrink-0 flex items-center justify-center">
                    <i data-lucide="send" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatbot', () => ({
            isOpen: false,
            isLoading: false,
            newMessage: '',
            messages: [],

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    setTimeout(() => {
                        this.scrollToBottom();
                        // Re-initialize lucide icons for newly rendered content
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                    }, 50);
                }
            },

            adjustTextareaHeight(el) {
                el.style.height = 'auto';
                el.style.height = (el.scrollHeight < 128 ? el.scrollHeight : 128) + 'px';
            },

            scrollToBottom() {
                const container = document.getElementById('chat-messages');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            },

            async sendMessage() {
                if (this.newMessage.trim() === '' || this.isLoading) return;

                const messageText = this.newMessage.trim();

                // Add user message
                this.messages.push({ role: 'user', content: messageText });
                this.newMessage = '';

                // Reset textarea height
                const textarea = document.querySelector('textarea[x-model="newMessage"]');
                if (textarea) {
                    textarea.style.height = 'auto';
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
                        body: JSON.stringify({ message: messageText })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.messages.push({ role: 'bot', content: data.reply });
                    } else {
                        this.messages.push({ role: 'bot', content: data.error || 'Maaf, terjadi kesalahan. Coba lagi.' });
                    }
                } catch (error) {
                    console.error('Chatbot error:', error);
                    this.messages.push({ role: 'bot', content: 'Maaf, terjadi kesalahan komunikasi. Coba lagi.' });
                } finally {
                    this.isLoading = false;
                    setTimeout(() => this.scrollToBottom(), 50);
                }
            }
        }));
    });
</script>