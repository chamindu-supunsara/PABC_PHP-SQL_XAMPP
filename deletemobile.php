<?php   
include 'connection.php';  
if (isset($_GET['id'])) {  
      $id = $_GET['id'];  
      $query = "DELETE FROM `bills` WHERE id = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
        $message = "Record Delete Successfully";
        echo "<script>alert('$message');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'AdminTransactions.php'; });</script>";
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
}  
 ?>  