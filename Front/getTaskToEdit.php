<?php
// Recieve the task infomation (for the task that the user wants to edit) from the backend
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/returnTaskToEdit.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$recieved = curl_exec($ch);
curl_close($ch);

// Send information to editTask.php to be displayed
print $recieved;
?>