<?php
// Destroy session so that user cannot access protected pages without logging back in again

session_set_cookie_params(0,"/");
session_start();

error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set ('display_errors', 1);

$_SESSION = array(); // make $_SESSION empty
session_destroy(); // Kill server session
setcookie("PHPSESSID", "", time()-3600, "", 0,0);

?>

<!DOCTYPE html>
<meta charset = "UTF-8">
		
<html>
	<head>
		<style>
			body { font-family: Arial, Helvetica, sans-serif; color: black; 
					background-image: url("background.jpg");  background-repeat: no-repeat;   background-size: cover;}
				
			form { width:50%;  margin: auto; border:5px solid #f1f1f1; padding: 15px; background-color: white; opacity: 0.8; }
			input[type=text], input[type=password] { width: 95%; padding: 10px; margin: 5px 0 20px 0; display: inline-block;
						  border: none; background: #f1f1f1;}
			hr { border: 1px solid #f1f1f1;}
			.btn { display: inline-block; position: relative; margin: 10px; padding: 5px 30px;
 					text-align: center; font: 15px/20px Arial, sans-serif; 
					background-color: blue; color: white;   opacity: 0.8;}	
			.btn:hover { opacity: 1;}
			
			.logResp {color: blue;}
			
			
		</style>
	</head>

	<body>


		<br><br>
		<form id='myform' action="" method="post">

			<center>
			<p>You have been signed out</p>
			
			<input type=button id="return" class="btn" value="Return to login page"> <br>
			</center>
					
		</form>
		 
	</body>
	
</html> 

<script>

var ptrBtn = document.getElementById("return");
	ptrBtn.addEventListener("click",returnLogin);
	
// Redirect the user back to login.html when the "return to login page" button is pressed
function returnLogin()
{	
	window.location.href = "https://web.njit.edu/~tat22/IS218/Project2/Front/login.html"; 
}

</script>