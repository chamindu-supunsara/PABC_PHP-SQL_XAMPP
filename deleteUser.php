<?php   
include 'connection.php';  
if (isset($_GET['clientid'])) {  
      $id = $_GET['clientid'];  
      $query = "DELETE FROM `customer_register` WHERE clientid = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
        $message = "User Delete Successfully";
        echo "<script>alert('$message');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'AdminManageUsers.php'; });</script>";
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
}  
 ?>  