<div id="chatbot-widget">
    <button id="chatbot-toggle" type="button" aria-label="Mở chat" aria-expanded="false">
        <span id="chatbot-logo-mark">H</span>
    </button>

    <div id="chatbot-box">
        <div id="chatbot-header">
            <div id="chatbot-header-left">
                <span id="chatbot-header-logo">H</span>
                <span id="chatbot-header-title">HAIAH xin chào</span>
            </div>
            <button id="chatbot-close" type="button" aria-label="Đóng">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div id="chatbot-messages">
            <div class="chatbot-row bot">
                <span class="chatbot-avatar">H</span>
                <div class="chatbot-msg bot">Xin chào! Tôi có thể giúp gì cho bạn?</div>
            </div>
        </div>

        <form id="chatbot-form">
            <input type="text" id="chatbot-input" placeholder="Nhập tin nhắn của bạn" autocomplete="off" required>
            <button type="submit" id="chatbot-send" aria-label="Gửi">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M2 21l21-9L2 3v7l15 2-15 2v7z"/></svg>
            </button>
        </form>
    </div>
</div>

<style>
    #chatbot-widget { position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: inherit; }

    /* Nút tròn: chưa bấm = chữ H, đang mở = chữ A */
    #chatbot-toggle {
        width: 56px; height: 56px; border-radius: 50%;
        background: linear-gradient(180deg, #2a2a33, #1f1f26);
        color: #ffffff; border: 2px solid #e0392c; font-size: 24px; cursor: pointer;
        box-shadow: 0 6px 18px rgba(0,0,0,0.45), 0 0 0 4px rgba(224,57,44,0.12);
        transition: transform .15s ease, filter .15s ease, background .2s ease, box-shadow .2s ease;
    }
    #chatbot-toggle:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(224,57,44,0.35), 0 0 0 4px rgba(224,57,44,0.18); }
    #chatbot-toggle.is-open {
        background: linear-gradient(135deg, #e0392c, #f26a2e);
        border-color: #f26a2e;
    }
    #chatbot-logo-mark {
        font-family: Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 22px;
        letter-spacing: 0.5px;
    }

    /* Khung chat */
    #chatbot-box {
        display: none; flex-direction: column; position: absolute; bottom: 70px; right: 0;
        width: 340px; height: 460px; max-width: calc(100vw - 40px);
        background: linear-gradient(180deg, #1f1f26, #19191f); border-radius: 18px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.55); overflow: hidden;
        border: 1px solid #2e2e37;
    }
    #chatbot-box.open { display: flex; animation: chatbot-pop .18s ease-out; }
    @keyframes chatbot-pop { from { opacity: 0; transform: translateY(8px) scale(.98); } to { opacity: 1; transform: none; } }

    #chatbot-header {
        background:
            radial-gradient(260px 120px at 0% 0%, rgba(224,57,44,.22), transparent 70%),
            radial-gradient(240px 120px at 100% 0%, rgba(245,158,11,.14), transparent 70%),
            #1c1c22;
        color: #ffffff; padding: 14px 16px;
        display: flex; justify-content: space-between; align-items: center;
        border-bottom: 1px solid #2e2e37; flex-shrink: 0;
        position: relative;
    }
    #chatbot-header::after {
        content: ""; position: absolute; left: 0; right: 0; bottom: -1px; height: 2px;
        background: linear-gradient(90deg, #e0392c, #f26a2e);
    }
    #chatbot-header-left { display: flex; align-items: center; gap: 10px; }
    #chatbot-header-logo {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 50%;
        background: linear-gradient(135deg, #e0392c, #f26a2e);
        font-family: Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 14px;
        color: #ffffff; flex-shrink: 0;
    }
    #chatbot-header-title { font-weight: 700; font-size: 15px; letter-spacing: .02em; }
    #chatbot-close {
        background: transparent; border: 1px solid transparent; color: #b8b8c2; cursor: pointer;
        width: 30px; height: 30px; border-radius: 50%; line-height: 0;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .15s ease;
    }
    #chatbot-close:hover { color: #fca5a5; background: rgba(248,113,113,.14); border-color: rgba(248,113,113,.45); }

    /* Vùng tin nhắn */
    #chatbot-messages {
        flex: 1; padding: 14px; overflow-y: auto;
        background:
            radial-gradient(420px 220px at 10% -10%, rgba(224,57,44,.10), transparent 60%),
            #151519;
        display: flex; flex-direction: column; gap: 10px;
    }
    #chatbot-messages::-webkit-scrollbar { width: 6px; }
    #chatbot-messages::-webkit-scrollbar-thumb { background: #3a3a45; border-radius: 999px; }
    .chatbot-row { display: flex; align-items: flex-end; gap: 7px; }
    .chatbot-row.user { justify-content: flex-end; }
    .chatbot-avatar {
        width: 24px; height: 24px; border-radius: 50%;
        background: linear-gradient(135deg, #e0392c, #f26a2e); color: #ffffff;
        font-family: Georgia, 'Times New Roman', serif; font-weight: 700; font-size: 11px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .chatbot-msg { padding: 9px 13px; border-radius: 16px; max-width: 75%; font-size: 13.5px; line-height: 1.45; word-wrap: break-word; }
    .chatbot-msg.bot {
        background: #26262f; color: #e5e5ec; border: 1px solid #34343f;
        border-bottom-left-radius: 4px;
    }
    .chatbot-msg.user {
        background: linear-gradient(135deg, #e0392c, #f26a2e); color: #ffffff;
        border-bottom-right-radius: 4px;
    }

    /* Ô nhập */
    #chatbot-form {
        display: flex; align-items: center; gap: 8px; padding: 10px 12px;
        border-top: 1px solid #2e2e37; background: #1c1c22; flex-shrink: 0;
    }
    #chatbot-input {
        flex: 1; border: 1px solid #3a3a45; border-radius: 999px; padding: 9px 14px;
        font-size: 13.5px; outline: none; background: #16161b; color: #ffffff;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    #chatbot-input::placeholder { color: #8a8a96; }
    #chatbot-input:focus { border-color: #e0392c; box-shadow: 0 0 0 1px #e0392c; }
    #chatbot-send {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #e0392c, #f26a2e); color: #ffffff;
        border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: transform .15s ease, filter .15s ease;
    }
    #chatbot-send:hover { filter: brightness(1.1); transform: translateY(-1px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('chatbot-toggle');
    const logoMark = document.getElementById('chatbot-logo-mark');
    const box = document.getElementById('chatbot-box');
    const closeBtn = document.getElementById('chatbot-close');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    // Chưa bấm: chữ H. Đang mở khung chat: chữ A.
    function setOpen(open) {
        box.classList.toggle('open', open);
        toggle.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Đóng chat' : 'Mở chat');
        logoMark.textContent = open ? 'A' : 'H';
        if (open) input.focus();
    }

    toggle.addEventListener('click', () => setOpen(!box.classList.contains('open')));
    closeBtn.addEventListener('click', () => setOpen(false));

    function addMessage(text, sender) {
        const row = document.createElement('div');
        row.className = 'chatbot-row ' + sender;

        if (sender === 'bot') {
            const avatar = document.createElement('span');
            avatar.className = 'chatbot-avatar';
            avatar.textContent = 'H';
            row.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = 'chatbot-msg ' + sender;
        bubble.textContent = text;
        row.appendChild(bubble);

        messages.appendChild(row);
        messages.scrollTop = messages.scrollHeight;
        return row;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, 'user');
        input.value = '';
        const typingRow = addMessage('Đang trả lời...', 'bot');

        try {
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: text }),
            });

            const data = await response.json();
            typingRow.remove();
            addMessage(data.reply, 'bot');
        } catch (error) {
            typingRow.remove();
            addMessage('Có lỗi xảy ra, vui lòng thử lại.', 'bot');
        }
    });
});
</script>
