<!DOCTYPE html>
<html lang="en">

<?php
session_start();
$message="";
if(isset($_POST['submit'])) {
	
 include 'connection.php';
 
 $email=$_POST["email"];
 $password=$_POST["password"];


 $sql="SELECT * FROM admin_details WHERE email='$email' and password='$password'";

$result = mysqli_query($conn,$sql);

$row= mysqli_fetch_array($result);

if ($row != null) {
    $_SESSION['loginGuardAdmin'] = $row['email'];
}
   
	if(mysqli_num_rows($result) == 1) {
         
       	header("location: AdminDashboard.php");
      }else 
	  {
        $msg = "Your Login Name or Password is invalid";		 
      }
	  
	  echo "<script type='text/javascript'>alert('$msg');</script>";
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form name="adminlogin" action="" method="post">
                <h1>Sign In</h1>
                <span>Use your password</span>
                <br>
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
                <br>
                <button type="submit" id="log" name="submit" class="btn">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Admin!</h1>
                    <p>Enter your personal details to Sign In to system</p>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>