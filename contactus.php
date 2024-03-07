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

  $name = $_POST['name'];
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  if (!empty($errorMessage)) {
    echo ("<p>There was an error with your form:</p>\n");

    echo ("<ul>" . $errorMessage . "</ul>\n");
  } else {

    $sql = "INSERT INTO contact_us" . "(name,telephone,email,subject,message) " . "VALUES ('$name','$telephone','$email','$subject','$message')";

    $results = mysqli_query($conn, $sql);

    if (!$results) {
      die('Could not enter data: ' . mysqli_error($conn));
    } else {
      $successMessage = "Message Send Successfully!";
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
    <title>Contact Us</title>
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
      <div class="promo_card">
        <h1>Contact Us</h1>
      </div>
      <div class="history_lists">
        <div class="list1">
          <div class="row">
            <h4>Send us a Message</h4>
          </div>
          <div class="card">
            <form name="contact" action="" method="post">
              <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
              </div>

              <div class="form-group">
                <label for="telephone">Telephone:</label>
                <input type="text" id="telephone" name="telephone" required>
                <span id="mobile-error-msg" style="color: red; display: none; font-size: 12px;">Please enter a valid mobile number.</span>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
              </div>

              <div class="form-group">
                <label for="message">Message:</label>
                <input type="text" id="message" name="message" required>
              </div>

              <button type="submit" name="submit">Send</button>
            </form>
          </div>
        </div>
        <div class="list1">
          <div class="row">
            <h4>Read Me</h4>
          </div>
          <div class="promo_card1" style="margin-left: 10px;">
          <h2>We, at Pan Asia Bank, are eager to serve your personal and business needs.</h2>
          <br>
          <p>Would you like to chat with our customer service representative?</p>
          <br>
          <p>Monday to Friday. 7am to 10pm</p>
          <br>
          <h3>Email</h3>
          <p>customerservice@pabcbank.com</p>
          <br>
          <h3>Fax</h3>
          <p>+94 11 4 667 222</p>
          <br>
          <h3>Send us your CV today</h3>
          <p>careers@pabcbank.com</p>
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

<script>
    var mobileInput = document.getElementById("telephone");
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