<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuardAdmin'])) {
    header("Location: LoginAdmin.php");
    exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

include("connection.php");
if(count($_POST)>0) {
    mysqli_query($conn,"UPDATE customer_register set clientid='" . $_POST['clientid'] . "', name='" . $_POST['name'] . "', nic='" . $_POST['nic'] . "', phoneno='" . $_POST['phoneno'] . "', email='" . $_POST['email'] . "', password='" . $_POST['password'] . "' WHERE clientid='" . $_POST['clientid'] . "'");
    $message = "User Update Successfully";
    echo "<script>alert('$message');</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'AdminManageUsers.php'; });</script>";
}
$result = mysqli_query($conn,"SELECT * FROM customer_register WHERE clientid='" . $_GET['clientid'] . "'");
$row= mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="EditPanel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#">Welcome Admin</a>
      <div class="search_box">
        <h2>PABC Online Banking</h2>
      </div>
    </div>
    <div class="header-icons">
      <i class="fa-solid fa-right-from-bracket" id="logoutIcon"></i>
      <div class="account">
        <h4><?php echo $_SESSION['loginGuardAdmin']; ?></h4>
      </div>
    </div>
  </header>
  <div class="container">
    <div class="main-body">
      <div class="card">
            <form name="editaccounts" action="" method="post">
              <div class="form-group">
                <label for="clientid">Client ID:</label>
                <input type="text" id="clientid" name="clientid" value="<?php echo $row['clientid']; ?>" required>
              </div>

              <div class="form-group">
                <label for="name">FullName:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
              </div>

              <div class="form-group">
                <label for="nic">NIC:</label>
                <input type="text" id="nic" name="nic" value="<?php echo $row['nic']; ?>" required>
              </div>

              <div class="form-group">
                <label for="phoneno">Phone No:</label>
                <input type="text" id="phoneno" name="phoneno" value="<?php echo $row['phoneno']; ?>" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div>

              <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>" required>
              </div>

                <button type="submit" name="submit">Update</button>
                <button type="button" name="Back" style="background-color: #000;" onclick="window.location.href = 'AdminManageUsers.php';">Back</button>
            </form>
          </div>
    </div>
  </div>
</body>
<script>
document.getElementById("logoutIcon").addEventListener("click", function() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }

    sessionStorage.clear();
    localStorage.clear();
    window.location.href = "index.html";
});
</script>

</html>