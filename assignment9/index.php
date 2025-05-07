<!doctype html>
<html>
  <head>
    <title>Assignment 9</title>

    <!-- Bring in our helpers library -->
    <script src="helpers.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <h1>A9 Chat Application</h1>

    <!-- Username selection panel -->
    <div id="username-panel">
      Select a username:
      <input type="text" id="username" maxlength="50">
      <button id="start">Start Chatting</button>
    </div>

    <!-- room selection -->
    <label>Select a room:</label>
    <select id="room-select">
      <option value="room1">Room 1</option>
      <option value="room2">Room 2</option>
      <option value="room3">Room 3</option>
    </select>

    <!-- Message interface panel -->
    <div id="message-panel" class="hidden">
      <textarea id="messages" readonly></textarea>
      <input type="text" id="message" maxlength="50">
      <button id="save">Send Message</button>
    </div>

    <!-- Link to admin page -->
     <div id="admin-link">
       <a href="admin.php">Go to Admin Page</a>
     </div>

    <script>
      // DOM references
      const usernamePanel = document.getElementById('username-panel');
      const usernameInput = document.getElementById('username');
      const startButton = document.getElementById('start');

      const messagePanel = document.getElementById('message-panel');
      const messages = document.getElementById('messages');
      const messageInput = document.getElementById('message');
      const saveButton = document.getElementById('save');

      const roomSelect = document.getElementById('room-select');
      let currentRoom = roomSelect.value;

      roomSelect.onchange = function() {
        currentRoom = roomSelect.value;
        messages.value = "";  // clear messages view
        joinChatRoom(); // log activity
        getChatMessages();    // refresh messages for new room
      };

      // log activity when user joins a room
      function joinChatRoom() {
        const username = user;
        const room = currentRoom;
        // Call the server to log the activity when the user enters the room
        fetch(`logactivity.php?username=${username}&room=${room}&action=joined`)
            .then(response => response.text())
            .then(data => {
                console.log(data); // Logs the activity to the server
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });
      }

      let user = ""; // stores the selected username

      // Start chat: hide username panel and show message panel
      startButton.onclick = function() {
        if (usernameInput.value.trim() === "") {
          alert("Please enter a username.");
          return;
        }
        user = usernameInput.value.trim();
        joinChatRoom(); // log activity

        usernamePanel.classList.add("hidden");
        messagePanel.classList.remove("hidden");
      }

      // track message count
      let lastMessageCounts = {};  // track message count per room
      
      // scroll variable
      let isUserScrolling = false;

      // Fetch and display all chat messages
      function getChatMessages() {
        // console.log("Fetching messages for room:", currentRoom);
        performFetch({
          method: 'GET',
          url: 'getentries.php',
          data: { room: currentRoom }, 
          success: function(data) {
            const arrayData = JSON.parse(data);
            // console.log(arrayData);

            // Initialize count for this room if not there
            if (!(currentRoom in lastMessageCounts)) {
              lastMessageCounts[currentRoom] = 0;
            }
            
            // Check if new messages appeared
            const isNewMessage = arrayData.length > lastMessageCounts[currentRoom];
            lastMessageCounts[currentRoom] = arrayData.length; // update count

              messages.value = ""; // clear previous messages

            for (let i = 0; i < arrayData.length; i++) { // create all messages in db 
              createEntry(arrayData[i]['username'], arrayData[i]['message'], isNewMessage);
            }

            // Auto-scroll ONCE after rendering all if user is not scrolling
            if (isNewMessage && !isUserScrolling) {
              // messages.scrollTop = messages.scrollHeight;
              messages.scrollTo({
                top: messages.scrollHeight,
                behavior: 'smooth'
          });
            }

            setTimeout(getChatMessages, 2000); // poll again
          },
          error: function() {
            console.log("Error: Couldn't fetch messages.");
            setTimeout(getChatMessages, 2000);
          }
        });
      }

      // Append a single message to the textarea
      function createEntry(user, msg) {
        messages.value += `${user}: ${msg}\n`;
      }

      // Save a new message to the server
      saveButton.onclick = function() {
        const messageText = messageInput.value.trim();
        if (!messageText) {
          alert("message too short.");
          return
        };

        performFetch({
          method: 'POST',
          url: 'saveentry.php',
          data: {
            username: user,
            message: messageText,
            room: currentRoom
          },
          success: function(data) {
            createEntry(user, messageText); // append to textarea
            if (!isUserScrolling) {
              messages.scrollTop = messages.scrollHeight; // scroll to bottom
            }
            messageInput.value = ""; // clear input
          },
          error: function() {
            console.log("Error: Couldn't save message.");
          }
        });
      }

      // Start fetching messages
      getChatMessages();


      // Listen for scroll events to detect if user is manually scrolling
      messages.addEventListener('scroll', () => {
        isUserScrolling = true; // wser is scrolling
      });
      
      // When scrolling stops, reset the flag
      messages.addEventListener('scrollend', () => {
        isUserScrolling = false; // User has stopped scrolling
      });

    </script>
  </body>
</html>