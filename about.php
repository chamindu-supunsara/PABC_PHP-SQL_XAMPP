<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuard'])) {
    header("Location: LoginCustomer.php");
    exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

// Continue with the rest of your Dashboard.php code here...

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="aboutus.css">
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
        <h1>About Us</h1>
      </div>
      <div class="list1" style="margin-top: 1rem;">
        <div class="card">
          <p>Pan Asia Bank’s secret to success is its story of delivering financial inclusion, world-class products 
            and services and living its values in every customer transaction. As a pioneer in Sri Lanka’s banking 
            industry, Pan Asia Bank has many first to its credit across technology platforms, unique products and 
            superlative service. The Bank has developed a unique reputation and culture of being ambitious, 
            results-oriented, respectful and caring, and supportive of traditional values – a true testament of 
            the brand’s positioning as a Truly Sri Lankan Bank.
          </p><br>
          <p>
          The lifeblood of the Bank is its people, who are committed to extend empathy, care and a helping hand for financial inclusion and to see its customers prosper.
          </p><br>
          <p>
          The Bank’s financial performance has been characterised by strength and resilience and  it stands as 
          one of the strongest banks in Sri Lanka. Pan Asia Banks’ spirit of innovation and growth coupled with a 
          prudent approach to growth and risk has served it well in the most challenging years in the banking industry.
          </p><br>
          <p>
          Pan Asia Bank’s prosperity is linked inextricably to the communities it serves, helping them to face challenges 
          with confidence through financing sustainable projects and conducting meaningful Corporate Social Responsibility 
          projects to uplift communities.
          </p>
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