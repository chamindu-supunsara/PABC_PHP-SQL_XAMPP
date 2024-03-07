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

  $email = $_POST['email'];
  $amount = $_POST['amount'];
  $mobileno = $_POST['mobileno'];
  $type = $_POST['type'];
  $accountno = $_POST['accountno'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else {

    $sql = "INSERT INTO accounts" . "(email,amount,mobileno,type,accountno) " . "VALUES ('$email','$amount','$mobileno','$type','$accountno')";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Account Create Successful!";
      echo "<script>alert('$successMessage');</script>";

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
  <title>Accounts</title>
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
          <!-- <a href="rateus.php" class="<?= $page == "rateus.php" ? 'active' : '' ?>">Rate Us</a> -->
        </div>
      </div>
    </nav>
    <div class="main-body" style="overflow: auto;">
      <h2>Accounts</h2>
      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Create a New Account</h4>
          </div>
          <div class="card">
            <form name="accounts" action="" method="post">
            <?php
              include("connection.php");
              $email = $_SESSION['loginGuard'];
              $sql = "SELECT * FROM customer_register WHERE email = '$email'";

              $result = mysqli_query($conn, $sql);

              if($result) {
                if(mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {

                    ?>
                    <div class="form-group">
                      <label for="name">Email:</label>
                      <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="amount">Amount:</label>
                      <input type="number" id="amount" name="amount" required>
                    </div>

                    <div class="form-group">
                      <label for="mobileno">Mobile No:</label>
                      <input type="text" id="mobileno" name="mobileno" required>
                      <span id="mobile-error-msg" style="color: red; display: none; font-size: 12px;">Please enter a valid mobile number.</span>
                    </div>

                    <div class="form-group">
                      <label for="accountno">Account No:</label>
                      <input type="password" id="accountno" name="accountno" required>
                    </div>

                    <div class="form-group">
                      <label for="type">Account Type:</label>
                      <select id="type" name="type" required>
                        <option value="0" hidden>Select Type</option>
                        <option value="Savings">Savings</option>
                        <option value="Fixed">Fixed</option>
                        <option value="Current">Current</option>
                      </select>
                    </div>

                    <button type="submit" name="submit">Create</button>
              <?php
                }
              }
            }
              ?>
            </form>
          </div>
        </div>
        <div class="list1">
          <div class="row">
            <h4>Read Me</h4>
          </div>
          <div class="promo_card1" style="margin-left: 10px;">
          <h1>Create Account</h1>
          <br>
          <p>Take charge of your money with the Pan Asia Savings Account that will do
            more than just keep your money in the bank. Coupled with a variety of benefits,
            your money will both grow and be accessible whenever and wherever you need it.</p>
          <br>
          <p>We bring you a multitude of fixed deposit strategies that guarantee a higher 
            return for your investment for a better future.</p>
          <br>
          <p>Offering you a range of savings / investment options that generate higher 
            returns for your savings, together with flexibility and convenience to assist 
            you in achieving your big dreams.</p>
        </div>
        </div>
      </div>
      <br>
      <div class="row">
            <h3>Pan Asia Bank Account Types</h3>
          </div>
      <div class="row">
        <div class="promo_card">
          <h1>Saving</h1>
          <span>Range of savings</span>
          <button>See More</button>
        </div>
        <div class="promo_card" style="margin-left: 10px;">
          <h1>Fixed</h1>
          <span>Fixed deposit strategies</span>
          <button>See More</button>
        </div>
        <div class="promo_card" style="margin-left: 10px;">
          <h1>Current</h1>
          <span>Manage day-to-day finances</span>
          <button>See More</button>
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

  document.addEventListener("DOMContentLoaded", function() {
    generateUniqueNumber();
  });

  function generateUniqueNumber() {
      // Generate a random unique number
      var uniqueNumber = Math.floor(Math.random() * 9000000000) + 1000000000;

      // Set the generated number as the value of the input field
      document.getElementById("accountno").value = uniqueNumber;
  }
</script>

<script>
    var mobileInput = document.getElementById("mobileno");
    var errorMessage = document.getElementById("mobile-error-msg");

    mobileInput.addEventListener("input", function() {
      var mobileNumberPattern = /^\d{10}$/;
      if (mobileNumberPattern.test(mobileInput.value)) {
        errorMessage.style.display = "none";
      } else {
        errorMessage.style.display = "block";
      }
    });
</script>

</html>