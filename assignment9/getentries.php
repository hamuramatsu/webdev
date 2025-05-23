<?php

  // file path
  $path = getcwd() . '/databases';

  // open database
  $db = new SQLite3($path.'/message_board.db');

  // database contains a single table named 'messages' with the following properties:
  // id      INTEGER PRIMARY KEY AUTOINCREMENT
  // username  TEXT
  // message TEXT

  //room from query param
  $room = $_GET['room'];  // get the room from the query parameter
 

  // extract all messages from the database
  $sql = "SELECT * FROM messages WHERE room = :room";
  $statement = $db->prepare($sql);
  $statement->bindValue(':room', $room, SQLITE3_TEXT);  // bind the room param
  $result = $statement->execute(); 


  // store all results in an associative array that we will send back to the HTML page
  $send_back = array();

  // visit all records
  while ($row = $result->fetchArray()) {
    // echo "Room in DB: " . $row['room'] . "\n";
    // create a mini-array to hold this record
    $record = array();
    $record['id'] = $row['id'];
    $record['username'] = $row['username'];
    $record['message'] = $row['message'];
    $record['room'] = $row['room'];

    // add record to the main array
    array_push($send_back, $record);
  }


  // close the database
  $db->close();
  unset($db);

  // turn the array into a JSON object and print it to the browser
  print json_encode($send_back);
  exit();

 ?>