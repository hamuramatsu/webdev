<?php
// file path
$path = getcwd() . '/databases';

// open database
$db = new SQLite3($path.'/message_board.db');

$room = $_GET['room'];

// clear database for this room
$sql = "DELETE FROM messages WHERE room = :room";
$statement = $db->prepare($sql);
$statement->bindValue(':room', $room, SQLITE3_TEXT);  // bind the room param
$statement->execute(); 

echo "Cleared messages in room: $room";

// close the database
$db->close();
unset($db);

exit();
?>