@extends('layouts.app')

@section('title', 'Chat dengan ResepinBot - ResepinAja')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-comments mr-3 text-orange-500"></i>
                Chat dengan ResepinBot
            </h1>
            <p class="text-gray-600 mt-2">Tanya apa saja tentang resep makanan!</p>
        </div>

        <!-- Tombol Bersihkan Chat -->
        <div class="mb-6">
            <form method="POST" action="{{ route('chat.clear') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-trash mr-2"></i> Bersihkan Chat
                </button>
            </form>
        </div>

        <!-- Chat Container -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Chat Box -->
            <div class="bg-white rounded-lg shadow-md p-6 h-[calc(100vh-300px)] flex flex-col">
                <!-- Messages -->
                <div id="chat-box" class="flex-grow space-y-4 overflow-y-auto p-4">
                    @if(count($messages) === 0)
                        <div class="text-center py-8">
                            <p class="text-lg font-medium text-gray-700">Hai! Aku ResepinBot ( ◕ ‿◕ )</p>
                            <p class="text-lg font-medium text-gray-700">Mau tanya tentang resep apa nih?</p>
                            <p class="text-sm text-gray-500 mt-2">Coba tanya: "Rekomendasikan resep untuk musim hujan!" atau "Resep cepat 15 menit?"</p>
                        </div>
                    @endif

                    @foreach($messages as $index => $msg)
                        <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }} mb-4">
                            <div class="max-w-[80%]">
                                @if($msg['role'] === 'user')
                                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                        <div class="markdown-content text-gray-800" id="ai-msg-{{ $index }}" data-rendered="true">{{ $msg['content'] }}</div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 text-right">Kamu</div>
                                @else
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <div class="flex items-center mb-2">
                                            <span class="badge bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                <i class="fas fa-robot mr-1"></i> ResepinBot
                                            </span>
                                        </div>
                                        <div class="markdown-content text-gray-800" id="ai-msg-{{ $index }}">
                                            {{ $msg['content'] }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input Form -->
                <div class="border-t pt-4 mt-4">
                    <form id="chat-form">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" id="message-input" name="message" class="input flex-1"
                                placeholder="Ketik pertanyaanmu disini ( ≧◡≦ )" required>
                            <button type="submit" class="btn btn-primary px-6">
                                <i class="fas fa-paper-plane mr-1"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk rendering Markdown dan AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        // Auto scroll to bottom
        function scrollToBottom() {
            const chatBox = document.getElementById('chat-box');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        }

        // Render markdown for specific element
        function renderMarkdown(element) {
            if (element && element.id && element.id.startsWith('ai-msg-')) {
                const markdownText = element.textContent;
                element.innerHTML = marked.parse(markdownText);
            }
        }

        // Render all markdown on page load
        function renderAllMarkdown() {
            const aiMessages = document.querySelectorAll('.markdown-content');
            aiMessages.forEach(function(el) {
                if (!el.hasAttribute('data-rendered')) {
                    renderMarkdown(el);
                    el.setAttribute('data-rendered', 'true');
                }
            });
        }

        // Add message to chat UI
        function addMessageToChat(role, content, index) {
            const chatBox = document.getElementById('chat-box');
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex mb-4 ${role === 'user' ? 'justify-end' : 'justify-start'}`;

            if (role === 'user') {
                messageDiv.innerHTML = `
                    <div class="max-w-[80%]">
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                            <div class="markdown-content text-gray-800">${content}</div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-right">Kamu</div>
                    </div>
                `;
            } else {
                messageDiv.innerHTML = `
                    <div class="max-w-[80%]">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center mb-2">
                                <span class="badge bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-robot mr-1"></i> ResepinBot
                                </span>
                            </div>
                            <div class="markdown-content text-gray-800" id="ai-msg-${index}">${content}</div>
                        </div>
                    </div>
                `;
            }
            chatBox.appendChild(messageDiv);

            // Render markdown for AI messages
            if (role === 'ai') {
                const aiElement = document.getElementById(`ai-msg-${index}`);
                renderMarkdown(aiElement);
            }
            scrollToBottom();
        }

        // Add loading animation to chat
        function addLoadingMessage() {
            const chatBox = document.getElementById('chat-box');
            const loadingDiv = document.createElement('div');
            loadingDiv.id = 'loading-message';
            loadingDiv.className = 'flex justify-start mb-4';
            loadingDiv.innerHTML = `
                <div class="max-w-[80%]">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <div class="flex items-center mb-2">
                            <span class="badge bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-robot mr-1"></i> ResepinBot
                            </span>
                        </div>
                        <div class="text-gray-800">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            chatBox.appendChild(loadingDiv);
            scrollToBottom();
        }

        function removeLoadingMessage() {
            const loadingMsg = document.getElementById('loading-message');
            if (loadingMsg) {
                loadingMsg.remove();
            }
        }

        // AJAX form submission
        document.addEventListener('DOMContentLoaded', function() {
            renderAllMarkdown();
            setTimeout(scrollToBottom, 100);

            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');

            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (!message) return;

                // Disable input
                messageInput.disabled = true;
                const submitBtn = chatForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mengirim...';

                // Add user message to UI
                addMessageToChat('user', message, Date.now());

                // Clear input
                messageInput.value = '';

                // Add loading animation
                addLoadingMessage();

                try {
                    const response = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message: message })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    // Remove loading animation
                    removeLoadingMessage();

                    if (data.success) {
                        // Add AI response to UI
                        addMessageToChat('ai', data.reply, data.index);
                    } else {
                        addMessageToChat('ai', 'Yahhh maaf banget nih... aku lagi error ( ╥ ﹏ ╥ ) Coba tanya lagi nanti ya?🙏✨', Date.now());
                    }
                } catch (error) {
                    console.error('Error:', error);
                    removeLoadingMessage();
                    addMessageToChat('ai', 'Yahhh maaf banget nih... aku lagi error ( ╥ ﹏ ╥ ) Coba tanya lagi nanti ya?🙏✨', Date.now());
                } finally {
                    // Re-enable input
                    messageInput.disabled = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i> Kirim';
                    messageInput.focus();
                }
            });
        });
    </script>

    <style>
        /* Styling for typing indicator */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 0;
        }

        .typing-indicator span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #ea580c);
            animation: typing 1.4s infinite;
            opacity: 0.7;
            box-shadow: 0 2px 6px rgba(249, 115, 22, 0.4);
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.5;
            }
            30% {
                transform: translateY(-12px);
                opacity: 1;
                box-shadow: 0 4px 12px rgba(249, 115, 22, 0.6);
            }
        }

        /* Markdown styling */
        .markdown-content h1,
        .markdown-content h2,
        .markdown-content h3 {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            color: #f97316;
            font-weight: 700;
        }

        .markdown-content h1 {
            font-size: 1.5rem;
        }

        .markdown-content h2 {
            font-size: 1.25rem;
        }

        .markdown-content h3 {
            font-size: 1.1rem;
        }

        .markdown-content ul,
        .markdown-content ol {
            padding-left: 1.5rem;
        }

        .markdown-content code {
            background: rgba(249, 115, 22, 0.15);
            color: #f97316;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-family: 'Courier New', monospace;
            border: 1px solid rgba(249, 115, 22, 0.3);
        }

        .markdown-content pre {
            background: #1e1e1e;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            border: 2px solid #374151;
        }

        .markdown-content pre code {
            background: none;
            padding: 0;
            color: #ffffff;
            border: none;
        }

        .markdown-content blockquote {
            border-left: 4px solid #f97316;
            padding-left: 1rem;
            margin-left: 0;
            color: #6b7280;
            background: rgba(249, 115, 22, 0.05);
            padding: 0.75rem 1rem;
            border-radius: 0 6px 6px 0;
        }

        .markdown-content p {
            margin-bottom: 0.5rem;
            color: #1f2937;
            line-height: 1.6;
        }

        .markdown-content strong {
            color: #f97316;
            font-weight: 700;
        }

        .markdown-content ul li,
        .markdown-content ol li {
            margin-bottom: 0.25rem;
            color: #1f2937;
        }
    </style>
@endsection