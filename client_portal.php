<?php
// client_portal.php
include 'auth_check.php';
if ($_SESSION['role'] !== 'client') {
    header('Location: login.html');
    exit();
}
$client_name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plant Care Chat - Client</title>
    <link rel="stylesheet" href="care.css">
    <style>
        body { background: #eafaf1; }
        .chat-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px #b2dfdb44; padding: 24px; }
        .chat-header { color: #388e3c; font-size: 1.3rem; margin-bottom: 12px; }
        .chat-box { height: 320px; overflow-y: auto; background: #f1f8e9; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .msg { margin-bottom: 12px; }
        .msg.me { text-align: right; }
        .msg .sender { font-weight: bold; color: #388e3c; }
        .msg .text { display: inline-block; background: #c8e6c9; color: #222; border-radius: 8px; padding: 8px 14px; margin-top: 2px; }
        .msg.me .text { background: #a5d6a7; }
        .send-row { display: flex; gap: 8px; }
        .send-row input { flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #b2dfdb; }
        .send-row button { background: #388e3c; color: #fff; border: none; border-radius: 6px; padding: 10px 18px; cursor: pointer; }
        .logout-link { float: right; color: #388e3c; text-decoration: underline; font-size: 0.95em; }
    </style>
</head>
<body>
<div class="chat-container">
    <div class="chat-header">
        Welcome, <?php echo htmlspecialchars($client_name); ?>
        <a class="logout-link" href="logout.php">Logout</a>
    </div>
    <div class="chat-box" id="chatBox"></div>
    <form id="sendForm" class="send-row">
        <input type="text" id="msgInput" placeholder="Type your message..." autocomplete="off" required>
        <button type="submit">Send</button>
    </form>
</div>
<script>
const chatBox = document.getElementById('chatBox');
function renderMessages(msgs) {
    chatBox.innerHTML = '';
    msgs.forEach(m => {
        const isMe = m.sender === '<?php echo $client_name; ?>';
        const div = document.createElement('div');
        div.className = 'msg' + (isMe ? ' me' : '');
        div.innerHTML = `<span class="sender">${m.sender}:</span> <span class="text">${m.message}</span>`;
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
document.getElementById('sendForm').onsubmit = async e => {
    e.preventDefault();
    const msg = document.getElementById('msgInput').value.trim();
    if (!msg) return;
    const fd = new FormData();
    fd.append('message', msg);
    const res = await fetch('send_message.php', { method: 'POST', body: fd });
    if ((await res.text()).trim() === 'success') {
        document.getElementById('msgInput').value = '';
        fetchMessages();
    }
};
</script>
</body>
</html>
