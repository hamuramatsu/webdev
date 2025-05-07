<!doctype html>
<html>
<head>
  <title>Admin Page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Admin Login</h1>

<div id="login-panel">
  Username: <input type="text" id="admin-username"><br>
  Password: <input type="password" id="admin-password"><br>
  <button id="login-btn">Login</button>
</div>

<div id="back">
  <a href="index.php">Go Back</a>
</div>

<div id="admin-panel" style="display:none;">

  <h2>Welcome, Admin!</h2>

  <label>Clear chat room:</label>
  <select id="clear-room-select">
    <option value="room1">Room 1</option>
    <option value="room2">Room 2</option>
    <option value="room3">Room 3</option>
  </select>
  <button id="clear-btn">Clear Room</button>

  <h2>Usage Logs</h2>
  <pre id="logs"></pre>
</div>

<script>
const loginBtn = document.getElementById('login-btn');
const adminPanel = document.getElementById('admin-panel');
const loginPanel = document.getElementById('login-panel');
const clearBtn = document.getElementById('clear-btn');
const clearRoomSelect = document.getElementById('clear-room-select');
const logsPre = document.getElementById('logs');

loginBtn.onclick = function() {
  const user = document.getElementById('admin-username').value;
  const pass = document.getElementById('admin-password').value;

  if (user === 'pikachu' && pass === 'pokemon') {
    loginPanel.style.display = 'none';
    adminPanel.style.display = 'block';
    fetchLogs();
  } else {
    alert('Invalid credentials');
  }
};

clearBtn.onclick = function() {
  const room = clearRoomSelect.value;
  fetch('clearroom.php?room=' + room)
    .then(res => res.text())
    .then(data => alert(data));
};

function fetchLogs() {
  fetch('logs.php')
    .then(res => res.text())
    .then(data => logsPre.textContent = data);
}
</script>

</body>
</html>