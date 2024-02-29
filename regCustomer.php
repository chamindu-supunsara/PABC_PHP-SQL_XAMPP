<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 

if(isset($_POST['submit'])) {  

include ("connection.php");
  
   $name=$_POST['name'];
   $nic=$_POST['nic'];
   $phoneno=$_POST['phoneno'];
   $email=$_POST['email'];
   $password=$_POST['password'];  
   
   if(!empty($errorMessage))
	  {
	    echo("<p>There was an error with your form:</p>\n");

	    echo("<ul>" . $errorMessage . "</ul>\n");

	  }
   else{//if(!empty($errorMessage))
    
	$sql = "INSERT INTO customer_register". "(name,nic,phoneno,email,password) ". "VALUES ('$name','$nic','$phoneno','$email','$password')";
	
	$results = mysqli_query($conn, $sql);
            
            if(!$results) {
               die('Could not enter data: ' . mysqli_error($conn));
            }
			else
			{
                $successMessage = "Registration Successful!";
                echo "<script>alert('$successMessage');</script>";

                // Redirect to LoginCustomer page after a delay
                echo "<script>setTimeout(function(){ window.location.href = 'LoginCustomer.php'; });</script>";
			}	
     } 
   
}
?>
</body>
</html>