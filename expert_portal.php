<?php
// expert_portal.php
include 'auth_check.php';
// Removed session_start(); to prevent duplicate session warning
if ($_SESSION['role'] !== 'expert') {
    header('Location: login.html');
    exit();
}
$expert_name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plant Care Chat - Expert</title>
    <link rel="stylesheet" href="care.css">
    <style>
        body { background: #eafaf1; }
        .chat-container { max-width: 700px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #b2dfdb44; padding: 24px; }
        .chat-header { color: #388e3c; font-size: 1.3rem; margin-bottom: 12px; }
        .chat-box { height: 380px; overflow-y: auto; background: #f1f8e9; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .msg { margin-bottom: 12px; }
        .msg .sender { font-weight: bold; color: #388e3c; }
        .msg .text { display: inline-block; background: #c8e6c9; color: #222; border-radius: 8px; padding: 8px 14px; margin-top: 2px; }
        .msg.expert .text { background: #a5d6a7; }
        .reply-row { display: flex; gap: 8px; margin-bottom: 8px; }
        .reply-row input { padding: 10px; border-radius: 6px; border: 1px solid #b2dfdb; }
        .reply-row button { background: #388e3c; color: #fff; border: none; border-radius: 6px; padding: 10px 18px; cursor: pointer; }
        /* Removed .logout-link styling */
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        Welcome, <?php echo htmlspecialchars($expert_name); ?> (Expert)
        <!-- Removed Logout link from here -->
    </div>
    <div class="chat-box" id="chatBox"></div>
    <form id="replyForm" class="reply-row">
        <input type="text" id="receiverInput" placeholder="Client name (e.g. Ali)" required>
        <input type="text" id="msgInput" placeholder="Type your reply..." required>
        <button type="submit">Send</button>
    </form>
</div>
<script>
const chatBox = document.getElementById('chatBox');
function renderMessages(msgs) {
    chatBox.innerHTML = '';
    msgs.forEach(m => {
        const div = document.createElement('div');
        div.className = 'msg' + (m.sender === 'expert' ? ' expert' : '');
        div.innerHTML = `<span class=\"sender\">${m.sender} to ${m.receiver}:</span> <span class=\"text\">${m.message}</span>`;
        chatBox.appendChild(div);
    });
    chatBox.scrollTop = chatBox.scrollHeight;
}
async function fetchMessages() {
    const res = await fetch('get_messages.php');
    const msgs = await res.json();
    renderMessages(msgs);
}
setInterval(fetchMessages, 3000);
fetchMessages();
document.getElementById('replyForm').onsubmit = async e => {
    e.preventDefault();
    const receiver = document.getElementById('receiverInput').value.trim();
    const msg = document.getElementById('msgInput').value.trim();
    if (!receiver || !msg) return;
    const fd = new FormData();
    fd.append('receiver', receiver);
    fd.append('message', msg);
    const res = await fetch('send_reply.php', { method: 'POST', body: fd });
    if ((await res.text()).trim() === 'success') {
        document.getElementById('msgInput').value = '';
        fetchMessages();
    }
};
</script>
</body>
</html>
