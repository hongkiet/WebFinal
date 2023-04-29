<?php
function connect_to_db() {
    $server = '127.0.0.1';
    $username = 'root';
    $password = '';
    $db = 'account_akk_music';

  $conn = new mysqli($server, $username, $password, $db);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}
?>