<?php
session_start();
$username = $_SESSION["username"];

$id = $_POST["id"]; 
$operation = $_POST["operation"];

$info = "{\"username\":\"$username\",\"id\":\"$id\",\"operation\":\"$operation\"}";

// Send the username, task id, and desired operation to the backend so changes can be made accordingly
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/makeChange.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
$recieved = curl_exec($ch);
curl_close($ch);

print $recieved; // Here for testing purposes

?>