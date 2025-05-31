<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User' . $user_id;
$club_id = $_SESSION['club_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Club Chat</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f8;
      margin: 0;
      padding: 40px;
    }
    .chat-container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      font-family: 'Playfair Display', serif;
      color: #2f2f4f;
    }
    #chat-box {
      border: 1px solid #ccc;
      border-radius: 10px;
      height: 300px;
      overflow-y: scroll;
      padding: 10px;
      background: #fafafa;
      margin-bottom: 15px;
    }
    .chat-message {
      margin: 5px 0;
    }
    input[type="text"] {
      width: 80%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }
    button {
      padding: 10px 20px;
      background: #2f2f4f;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }
    button:hover {
      background: #444466;
    }
    .back {
      margin-top: 20px;
    }
    .back a {
      text-decoration: none;
      color: #2f2f4f;
    }
  </style>
</head>
<body>

<div class="chat-container">
  <h2>💬 Club Chat</h2>

  <div id="chat-box"></div>

  <form id="chat-form">
    <input type="text" id="message" placeholder="Type your message..." required>
    <button type="submit">Send</button>
  </form>

  <div class="back">
    <a href="admin_panel.php">← Back to Admin Panel</a>
  </div>
</div>

<script>
  const chatForm = document.getElementById('chat-form');
  const chatBox = document.getElementById('chat-box');

  // Fetch messages every 2 seconds
  setInterval(() => {
    fetch('get_messages.php')
      .then(response => response.text())
      .then(data => {
        chatBox.innerHTML = data;
        chatBox.scrollTop = chatBox.scrollHeight;
      });
  }, 2000);

  // Send message
  chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const message = document.getElementById('message').value;

    fetch('send_message.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'message=' + encodeURIComponent(message)
    })
    .then(() => {
      document.getElementById('message').value = '';
    });
  });
</script>

</body>
</html>
