<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuard'])) {
  header("Location: LoginCustomer.php");
  exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

if (isset($_POST['submitmobile'])) {

  include("connection.php");

  $type = $_POST['type'];
  $accountno = $_POST['accountno'];
  $amount = $_POST['amount'];
  $mobileno = $_POST['mobileno'];
  $email = $_POST['email'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else { //if(!empty($errorMessage))

    $sql = "INSERT INTO bills" . "(type,accountno,amount,mobileno,email) " . "VALUES ('$type','$accountno','$amount','$mobileno','$email')";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Payment Successfully!";
      echo "<script>alert('$successMessage');</script>";

      // Redirect to LoginCustomer page after a delay
      echo "<script>setTimeout(function(){ window.location.href = 'Dashboard.php'; });</script>";
    }
  }
}

if (isset($_POST['submitbill'])) {

  include("connection.php");

  $type1 = $_POST['type1'];
  $accountno2 = $_POST['accountno2'];
  $amount3 = $_POST['amount3'];
  $mobileno4 = $_POST['mobileno4'];
  $email5 = $_POST['email5'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else { //if(!empty($errorMessage))

    $sql = "INSERT INTO utilitybills" . "(type1,accountno2,amount3,mobileno4,email5) " . "VALUES ('$type1','$accountno2','$amount3','$mobileno4','$email5')";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Payment Successfully!";
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
  <link rel="stylesheet" href="Dashboard.css">
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
        <a href="Dashboard.php" class="<?= $page == "Dashboard.php" ? 'active' : ''; ?>">Dashboard</a>
        <a href="transferfunds.php" class="<?= $page == "transferfunds.php" ? 'active' : '' ?>">Tranfer Funds</a>
        <a href="accounts.php" class="<?= $page == "accounts.php" ? 'active' : '' ?>">Accounts</a>
        <a href="transactions.php" class="<?= $page == "transactions.php" ? 'active' : '' ?>">Transactions</a>
        <a href="paybills.php" class="<?= $page == "paybills.php" ? 'active' : '' ?>">Pay Bills</a>
        <a href="profile.php" class="<?= $page == "profile.php" ? 'active' : '' ?>">Profile</a>
        <div class="links">
          <span>Quick Link</span>
          <a href="about.php" class="<?= $page == "about.php" ? 'active' : '' ?>">About Us</a>
          <a href="contactus.php" class="<?= $page == "contactus.php" ? 'active' : '' ?>">Contact Us</a>
          <a href="rateus.php" class="<?= $page == "rateus.php" ? 'active' : '' ?>">Rate Us</a>
        </div>
      </div>
    </nav>
    <div class="main-body" style="overflow: auto;">
      <h2>Pay Bills</h2>
      <div class="row">
            <h4>Quick Payments</h4>
          </div>
      <div class="row">
        <div class="promo_card">
          <h1>Mobile Bills</h1>
          
        </div>
        <div class="promo_card" style="margin-left: 10px;">
          <h1>Utility Bills</h1>
          
        </div>
      </div>
      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Make a Mobile Payment</h4>
          </div>
          <div class="card">
            <form name="billpayment" action="" method="post">
              <div class="form-group">
                <label for="type">Provider:</label>
                <select id="type" name="type" required>
                  <option value="0" hidden>Select Provider</option>
                  <option value="Dialog">Dialog</option>
                  <option value="Mobitel">Mobitel</option>
                  <option value="Hutch">Hutch</option>
                  <option value="SLT">SLT</option>
                  <option value="Airtel">Airtel</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <div class="form-group">
                <label for="accountno">Account No:</label>
                <input type="text" id="accountno" name="accountno" required>
              </div>

              <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required>
              </div>

              <div class="form-group">
                <label for="mobileno">Mobile No:</label>
                <input type="text" id="mobileno" name="mobileno" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
              </div>

              <button type="submit" name="submitmobile">Pay Now</button>
            </form>
          </div>
        </div>
        <div class="list1" style="margin-left: 10px;">
          <div class="row">
            <h4>Make a Payment</h4>
          </div>
          <div class="card">
            <form name="billpayment" action="" method="post">
              <div class="form-group">
                <label for="type1">Provider:</label>
                <select id="type1" name="type1" required>
                  <option value="0" hidden>Select Bill</option>
                  <option value="Water">Water</option>
                  <option value="Electricity">Electricity</option>
                  <option value="Pay Tv">Pay Tv</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="Education">Education</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <!-- <div class="form-group">
                <label for="type1">Bill Type:</label>
                <input type="text" id="type1" name="type1" required>
              </div> -->

              <div class="form-group">
                <label for="accountno2">Account No:</label>
                <input type="text" id="accountno2" name="accountno2" required>
              </div>

              <div class="form-group">
                <label for="amount3">Amount:</label>
                <input type="text" id="amount3" name="amount3" required>
              </div>

              <div class="form-group">
                <label for="mobileno4">Mobile No:</label>
                <input type="text" id="mobileno4" name="mobileno4" required>
              </div>

              <div class="form-group">
                <label for="email5">Email:</label>
                <input type="text" id="email5" name="email5" required>
              </div>

              <button type="submit" name="submitbill">Pay Now</button>
            </form>
          </div>
        </div>
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

</html>