<?php
session_start();
$username = $_SESSION["username"];

$id = $_POST["id"];
$title = $_POST["title"]; 
$des = $_POST["des"];
$date = $_POST["date"];
$time = $_POST["time"];

$info = "{\"tid\":\"$id\" ,\"title\":\"$title\" , \"description\":\"$des\", \"date\":\"$date\", \"time\":\"$time\", \"username\":\"$username\"}";
//print $info;

// Send the user and task information to the backend so the database can be updated
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/updateEditedTask.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
$response = curl_exec($ch);
curl_close($ch);

?>