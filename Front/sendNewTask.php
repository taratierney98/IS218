<?php
session_start();
$username = $_SESSION["username"];

$title = $_POST["title"]; 
$des = $_POST["des"];
$date = $_POST["date"];
$time = $_POST["time"];

$info = "{\"title\":\"$title\" , \"description\":\"$des\", \"date\":\"$date\", \"time\":\"$time\", \"username\":\"$username\"}";

// Send the user's username and the title, description, and due date/time for a new task to the backend so a new entry
// can be added to the database
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/addNewTask.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
$response = curl_exec($ch);
curl_close($ch);

print $response; // Here for testing purposes
?>