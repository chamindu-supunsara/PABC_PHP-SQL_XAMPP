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
    mysqli_query($conn,"UPDATE accounts set clientid='" . $_POST['clientid'] . "', accountno='" . $_POST['accountno'] . "', email='" . $_POST['email'] . "', amount='" . $_POST['amount'] . "', mobileno='" . $_POST['mobileno'] . "', type='" . $_POST['type'] . "' WHERE clientid='" . $_POST['clientid'] . "'");
    $message = "Account Update Successfully";
    echo "<script>alert('$message');</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'AdminAccounts.php'; });</script>";
}
$result = mysqli_query($conn,"SELECT * FROM accounts WHERE clientid='" . $_GET['clientid'] . "'");
$row= mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account Details</title>
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
                <label for="accountno">Account No:</label>
                <input type="text" id="accountno" name="accountno" value="<?php echo $row['accountno']; ?>" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
              </div>

              <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" value="<?php echo $row['amount']; ?>" required>
              </div>

              <div class="form-group">
                <label for="mobileno">Mobile No:</label>
                <input type="text" id="mobileno" name="mobileno" value="<?php echo $row['mobileno']; ?>" required>
              </div>

              <div class="form-group">
                <label for="type">Account Type:</label>
                <input type="text" id="type" name="type" value="<?php echo $row['type']; ?>" required>
              </div>

                <button type="submit" name="submit">Update</button>
                <button type="button" name="Back" style="background-color: #000;" onclick="window.location.href = 'AdminAccounts.php';">Back</button>
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