<?php

  // file path
  $path = getcwd() . '/databases';

  // open database
  $db = new SQLite3($path.'/message_board.db');

  // database contains a single table named 'messages' with the following properties:
  // id      INTEGER PRIMARY KEY AUTOINCREMENT
  // user  TEXT
  // message TEXT

  // grab the incoming data
  $msg = $_POST['message'];
  $user = $_POST['username'];
  $room = $_POST['room'];

  // make sure we have both values
  if ($msg && $user && $room) {

    // construct SQL to store this message
    $sql = "INSERT INTO messages (username, message, room) VALUES (:user, :msg, :room)";
    $statement = $db->prepare($sql);
    $statement->bindParam(':user', $user);
    $statement->bindParam(':msg', $msg);
    $statement->bindParam(':room', $room);

    // store the message
    $statement->execute();

    // get the 'id' value that was just inserted
    $id = $db->lastInsertRowID();

    // close the database
    $db->close();
    unset($db);

    // print this back to the calling page
    print ($id);
    exit();
  }
  

  print ("ERROR");
  exit();

 ?>
