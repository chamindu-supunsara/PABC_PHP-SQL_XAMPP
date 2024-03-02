<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<?php $dbhost = 'localhost';
  $dbuser = 'root'; 
  $dbpass = '';
   $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
   
    if(!$conn ) { 
  if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
  }
    } echo '';
	 
	 $db= mysqli_select_db($conn,'pabc');
	
	if(!$db){
		
	 echo 'Select database first ';
	
	}else
	 echo '';	
?> 
</body>
</html>