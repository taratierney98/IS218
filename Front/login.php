<?php
// Recieve username and password from login.html
$username = $_POST["username"]; 
$password = $_POST["password"];
 
$userpass = "{\"username\":\"$username\" , \"password\":\"$password\"}";

// Send username and password to backend to verify  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/IS218/Project2/Back/login.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $userpass);
$login_response = curl_exec($ch); // recieve backend's response
curl_close($ch);

$response = JSON_decode($login_response); 
$status = $response -> {'login'}; // either T or F
$fname = $response -> {'fname'};
$lname = $response -> {'lname'};

// If login credentials were valid, save the user's username, password, first name,
// and last name in the sessions's array so they can be accessed in other files
if($status == "T")
{
	session_start();
	$_SESSION["logged-in"] = true;
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password; 
	$_SESSION["fname"] = $fname; 
	$_SESSION["lname"] = $lname; 
}

// Print the login status so login.html can recieve it and act accordingly
print $status;
?>