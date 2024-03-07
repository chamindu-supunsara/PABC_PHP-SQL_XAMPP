<?php   
include 'connection.php';  
if (isset($_GET['clientid'])) {  
      $id = $_GET['clientid'];  
      $query = "DELETE FROM `accounts` WHERE clientid = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
        $message = "Account Delete Successfully";
        echo "<script>alert('$message');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'AdminAccounts.php'; });</script>";
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
}  
 ?>  