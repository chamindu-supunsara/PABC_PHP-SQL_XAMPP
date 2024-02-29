<!DOCTYPE html>
<html lang="en">

<?php
session_start();
$message="";
if(isset($_POST['submit'])) {
	
 include 'connection.php';
 
 $email=$_POST["email"];
 $password=$_POST["password"];


 $sql="SELECT * FROM customer_register WHERE email='$email' and password='$password'";

$result = mysqli_query($conn,$sql);

$row= mysqli_fetch_array($result);

if ($row != null) {
    $_SESSION['loginGuard'] = $row['email'];
}
   
	if(mysqli_num_rows($result) == 1) {
         
       	header("location: Dashboard.php");
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
    <title>Customer Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form name="UserData" action="regCustomer.php" method="post">
                <h1>Create Account</h1>
                <span>Use your email for registeration</span>
                <br>
                <input type="text" id="name" name="name" placeholder="Name">
                <input type="text" id="nic" name="nic" placeholder="NIC">
                <input type="text" id="phoneno" name="phoneno" placeholder="Phone No">
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
                <br>
                <button type="submit" id="reg" name="submit" class="btn" onClick="regFunction()">Sign Up</button> 
            </form>
        </div>
        <div class="form-container sign-in">
            <form name="login" action="" method="post">
                <h1>Sign In</h1>
                <span>Use your password</span>
                <br>
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="password" id="password" name="password" placeholder="Password">
                <br>
                <button type="submit" id="log" name="submit" class="btn" onClick="regFunction()">Sign In</button> 
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to Sign In to system</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Dear Customer's</h1>
                    <p>Register with your personal details to Sign Up to system</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>