<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuard'])) {
    header("Location: LoginCustomer.php");
    exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

if (isset($_POST['submit'])) {

  include("connection.php");

  $source_account_number = $_POST['source_account_number'];
  $transfer_amount = $_POST['transfer_amount'];
  $payment_type = $_POST['payment_type'];
  $account_type = $_POST['account_type'];
  $fund_transfer_type = $_POST['fund_transfer_type'];
  $beneficiary_account_no = $_POST['beneficiary_account_no'];
  $remarks = $_POST['remarks'];
  $beneficiary_name = $_POST['beneficiary_name'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else { //if(!empty($errorMessage))

    $sql = "INSERT INTO fund_transfer" . "(source_account_number,
    transfer_amount,payment_type,account_type,fund_transfer_type,
    beneficiary_account_no,remarks,beneficiary_name) " . "VALUES ('$source_account_number','$transfer_amount','$payment_type','$account_type','$fund_transfer_type','$beneficiary_account_no','$remarks','$beneficiary_name')";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Funds Transfer Successfully!";
      echo "<script>alert('$successMessage');</script>";

      // Redirect to LoginCustomer page after a delay
      echo "<script>setTimeout(function(){ window.location.href = 'Dashboard.php'; });</script>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="transfund.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#">Welcome</a>
      <div class="search_box">
        <input type="text" placeholder="Search">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
      </div>
    </div>
    <div class="header-icons">
      <i class="fa-solid fa-right-from-bracket" id="logoutIcon"></i>
      <div class="account">
        <h4><?php echo $_SESSION['loginGuard']; ?></h4>
      </div>
    </div>
  </header>
  <div class="container">
    <nav>
      <div class="side_navbar">
        <span>Main Menu</span>
        <a href="Dashboard.php" class="<?= $page == "Dashboard.php"? 'active':''; ?>">Dashboard</a>
        <a href="transferfunds.php" class="<?= $page == "transferfunds.php"? 'active':'' ?>">Tranfer Funds</a>
        <a href="accounts.php" class="<?= $page == "accounts.php"? 'active':'' ?>">Accounts</a>
        <a href="transactions.php" class="<?= $page == "transactions.php"? 'active':'' ?>">Transactions</a>
        <a href="paybills.php" class="<?= $page == "paybills.php"? 'active':'' ?>">Pay Bills</a>
        <a href="profile.php" class="<?= $page == "profile.php"? 'active':'' ?>">Profile</a>
        <div class="links">
          <span>Quick Link</span>
          <a href="about.php" class="<?= $page == "about.php"? 'active':'' ?>">About Us</a>
          <a href="contactus.php" class="<?= $page == "contactus.php"? 'active':'' ?>">Contact Us</a>
          <a href="rateus.php" class="<?= $page == "rateus.php"? 'active':'' ?>">Rate Us</a>
        </div>
      </div>
    </nav>
    <div class="main-body">
      <h2>Fund Transfer</h2>
        <div class="row">
        </div>
          <div class="card">
            <form name="fundtransfer" action="" method="post">
              <div class="form-group">
                <label for="source_account_number">Source Account Number:</label>
                <select id="source_account_number" name="source_account_number" required>
                  <option value="0" hidden>Select Type</option>
                  <option value="Savings">Savings</option>
                  <option value="Fixed">Fixed</option>
                  <option value="Current">Current</option>
                </select>
              </div>

              <div class="form-group">
                <label for="transfer_amount">Transfer Amount:</label>
                <input type="number" id="transfer_amount" name="transfer_amount" required>
              </div>

              <div class="form-group">
                <label for="payment_type">Payment Type:</label>
                <select id="payment_type" name="payment_type" required>
                  <option value="0" hidden>Select Type</option>
                  <option value="Immediate Payment">Immediate Payment</option>
                  <option value="Future Date">Future Date</option>
                  <option value="Recurrent">Recurrent</option>
                </select>
              </div>

              <div class="form-group">
                <label for="account_type">Account Type:</label>
                <select id="account_type" name="account_type" required>
                  <option value="0" hidden>Select Type</option>
                  <option value="Account">Account</option>
                  <option value="Pay Another Bank Credit Card">Pay Another Bank Credit Card</option>
                </select>
              </div>

              <div class="form-group">
                <label for="fund_transfer_type">Fund Transfer Type:</label>
                <select id="fund_transfer_type" name="fund_transfer_type" required>
                  <option value="0" hidden>Select Type</option>
                  <option value="Intrabank Transfers">Intrabank Transfers</option>
                  <option value="Domestic Payments">Domestic Payments</option>
                  <option value="International Transfers">International Transfers</option>
                </select>
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
                <label for="beneficiary_name">Beneficiary Name:</label>
                <input type="text" id="beneficiary_name" name="beneficiary_name" required>
              </div>

              <button type="submit" name="submit">Proceed</button>
              <button type="button" name="reset" style="background-color: #000;">Reset</button>
            </form>
          </div>
    </div>
    <div class="sidebar">
      <h4>Accounts</h4>
      
      <div class="balance">
        <i class="fas fa-dollar icon"></i>
        <div class="info">
          <h5>Dollar</h5>
          <span><i class="fas fa-dollar"></i>25,000.00</span>
        </div>
      </div>
      
      <div class="balance">
        <i class="fa-solid fa-rupee-sign icon"></i>
        <div class="info">
          <h5>PKR</h5>
          <span><i class="fa-solid fa-rupee-sign"></i>300,000.00</span>
        </div>
      </div>
      <div class="balance">
        <i class="fas fa-euro icon"></i>
        <div class="info">
          <h5>Euro</h5>
          <span><i class="fas fa-euro"></i>25,000.00</span>
        </div>
      </div>
      <div class="balance">
        <i class="fa-solid fa-indian-rupee-sign icon"></i>
        <div class="info">
          <h5>INR</h5>
          <span><i class="fa-solid fa-indian-rupee-sign"></i>220,000.00</span>
        </div>
      </div>
      <div class="balance">
        <i class="fa-solid fa-sterling-sign icon"></i>
        <div class="info">
          <h5>Pound</h5>
          <span><i class="fa-solid fa-sterling-sign"></i>30,000.00</span>
        </div>
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