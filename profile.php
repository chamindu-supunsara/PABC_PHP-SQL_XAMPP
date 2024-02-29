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
  $nic = $_POST['nic'];
  $phoneno = $_POST['phoneno'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($errorMessage)) {
      echo("<p>There was an error with your form:</p>\n");
      echo("<ul>" . $errorMessage . "</ul>\n");
  } else {
      $sql = "UPDATE customer_register SET name='$name', nic='$nic', phoneno='$phoneno', password='$password' WHERE email='$email'";

      $results = mysqli_query($conn, $sql);

      if (!$results) {
          die('Could not update data: ' . mysqli_error($conn));
      } else {
          $successMessage = "Profile Updated Successfully!";
          echo "<script>alert('$successMessage');</script>";

          echo "<script>setTimeout(function(){ window.location.href = 'profile.php'; });</script>";
      }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
      <h2>Profile</h2>
        <div class="row">
        </div>
          <div class="card">
            <form name="profile" action="" method="post">
              <?php
              include("connection.php");
              $email = $_SESSION['loginGuard'];
              $sql = "SELECT * FROM customer_register WHERE email = '$email'";

              $result = mysqli_query($conn, $sql);

              if($result) {
                if(mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_array($result)) {
                    // print_r($row);

                    ?>
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="nic">NIC:</label>
                      <input type="text" id="nic" name="nic" value="<?php echo $row['nic']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="phoneno">Mobile No:</label>
                      <input type="text" id="phoneno" name="phoneno" value="<?php echo $row['phoneno']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="password">Password:</label>
                      <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required>
                    </div>

                    <button type="submit" name="submit">Update Profile</button>
                    <button type="button" name="reset" style="background-color: #000;">Reset</button>
                    <?php
                  }
                }
              }
              ?>
            </form>
          </div>
    </div>
    <div class="sidebar">
      <h4>Currency Rates</h4>
      
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