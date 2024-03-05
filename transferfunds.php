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
  $beneficiary_email = $_POST['beneficiary_email'];
  $sender_email = $_POST['sender_email'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else { //if(!empty($errorMessage))

    $sql = "INSERT INTO fund_transfer" . "(source_account_number,
    transfer_amount,payment_type,account_type,fund_transfer_type,
    beneficiary_account_no,remarks,beneficiary_email,sender_email) " . "VALUES ('$source_account_number','$transfer_amount','$payment_type','$account_type','$fund_transfer_type','$beneficiary_account_no','$remarks','$beneficiary_email','$sender_email')";

    $updateSql = "UPDATE accounts SET amount = amount - $transfer_amount WHERE accountno = $source_account_number";

    $results = mysqli_query($conn, $sql);
    $updateResult = mysqli_query($conn, $updateSql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Funds Transfer Successfully!";
      echo "<script>alert('$successMessage');</script>";
      echo "<script>setTimeout(function(){ window.location.href = 'Dashboard.php'; });</script>";
    }

    if (!$updateResult) {
      die('Could not update account balance: ' . mysqli_error($conn));
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tranfer Funds</title>
    <link rel="stylesheet" href="transfund.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#">Welcome</a>
      <div class="search_box">
        <h2>PABC Online Banking</h2>
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
          <!-- <a href="rateus.php" class="<?= $page == "rateus.php"? 'active':'' ?>">Rate Us</a> -->
        </div>
      </div>
    </nav>
    <div class="main-body">
      <h2>Fund Transfer</h2>
        <div class="row">
        </div>
          <div class="card">
            <form name="fundtransfer" action="" method="post">
              <?php
              include("connection.php");
              $email = $_SESSION['loginGuard'];
              $sql = "SELECT * FROM accounts WHERE email = '$email'";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="form-group">
                  <label for="source_account_number">Source Account Number:</label>
                  <select id="source_account_number" name="source_account_number" required>
                      <option value="" hidden>Select Account</option>
                      <?php
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $row['accountno'] . "'>" . $row['accountno'] . " - " . $row['type'] . "</option>";
                      }
                      ?>
                  </select>
                </div>
                <?php
              } else {
                echo "No accounts found";
              }
              mysqli_close($conn);
              ?>

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
                <span id="mobile-error" style="color: red; display: none; font-size: 12px;">Please enter a valid account number.</span>
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
                <input type="email" id="sender_email" name="sender_email" value="<?php echo $_SESSION['loginGuard']; ?>">
              </div>

              <button type="submit" name="submit">Proceed</button>
              <button type="button" name="reset" style="background-color: #000;">Reset</button>
            </form>
          </div>
    </div>
    <div class="sidebar">
    <h4>Accounts</h4>
      <?php
        include("connection.php");
        $email = $_SESSION['loginGuard'];
        $sql = "SELECT * FROM accounts WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              ?>
              <div class="balance">
                  <i class="fa-solid fa-money-check-dollar icon"></i>
                  <div class="info">
                      <h5><?php echo $row['type']; ?></h5>
                      <h5><?php echo $row['accountno']; ?></h5>
                      <span><i class='fa-solid fa-rupee-sign'></i> <?php echo number_format($row['amount']); ?></span>
                  </div>
              </div>
              <?php
          }
      } else {
          echo "No accounts found";
      }
      mysqli_close($conn);
      ?>
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

<script>
    var mobileInput1 = document.getElementById("beneficiary_account_no");
    var errorMessage = document.getElementById("mobile-error");

    mobileInput1.addEventListener("input", function() {
      var mobileNumberPattern = /^\d*$/;
      if (mobileNumberPattern.test(mobileInput1.value)) {
        errorMessage.style.display = "none";
      } else {
        errorMessage.style.display = "block";
      }
    });
</script>

</html>