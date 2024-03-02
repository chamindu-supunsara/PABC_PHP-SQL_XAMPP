<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuardAdmin'])) {
    header("Location: LoginAdmin.php");
    exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

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
            <form name="fundtransfer" action="" method="post">

              <div class="form-group">
                <label for="transfer_amount">Transfer Amount:</label>
                <input type="number" id="transfer_amount" name="transfer_amount" required>
              </div>

              <div class="form-group">
                <label for="beneficiary_account_no">Beneficiary Account No:</label>
                <input type="text" id="beneficiary_account_no" name="beneficiary_account_no" required>
              </div>

              <div class="form-group">
                <label for="remarks">Remarks:</label>
                <input type="text" id="remarks" name="remarks" required>
              </div>

              <div class="form-group">
                <label for="beneficiary_email">Beneficiary Email:</label>
                <input type="email" id="beneficiary_email" name="beneficiary_email" required>
              </div>

              <div class="form-group">
                <label for="sender_email">Beneficiary Email:</label>
                <input type="email" id="sender_email" name="sender_email" required>
              </div>

              <button type="submit" name="submit">Proceed</button>
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