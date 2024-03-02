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
    <title>Transactions</title>
    <link rel="stylesheet" href="Dashboard.css">
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
      <div class="promo_card">
        <h1>All Transactions</h1>
      </div>
      <div class="history_list">
        <div class="list1">
          <div class="row">
            <h4>Funds Transactions</h4>
            <script>
              function tableToExcelTrans() {
                var table2excel = new Table2Excel();
                table2excel.export(document.querySelectorAll("table.tabletrans"));
              }
            </script>
            <button onclick="tableToExcelTrans()">Download</button>
          </div>
          <table class="tabletrans">
            <thead>
              <tr>
                <th>Source Account No</th>
                <th>Account Type</th>
                <th>Beneficiary Account No</th>
                <th>Beneficiary Email</th>
                <th>Payment Type</th>
                <th>Transfer Type</th>
                <th>Tranfer Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
                include("connection.php");
                $email = $_SESSION['loginGuard'];
                $sql = "SELECT * FROM accounts WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sen_email = $_SESSION['loginGuard'];
                        $sql = "SELECT * FROM fund_transfer WHERE sender_email = '$sen_email'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['source_account_number']; ?></td>
                                    <td><?php echo $row['account_type']; ?></td>
                                    <td><?php echo $row['beneficiary_account_no']; ?></td>
                                    <td><?php echo $row['beneficiary_email']; ?></td>
                                    <td><?php echo $row['payment_type']; ?></td>
                                    <td><?php echo $row['fund_transfer_type']; ?></td>
                                    <td>Rs <?php echo number_format($row['transfer_amount']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "No transactions found";
                        }
                    }
                } else {
                    echo "No accounts found";
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="row">
        <div class="list2">
          <div class="row">
            <h4>Mobile Bills Payments</h4>
            <script>
            function tableToExcel() {
              var table2excel = new Table2Excel();
              table2excel.export(document.querySelectorAll("table.table2"));
            }
            </script>
            <button onclick="tableToExcel()">Download</button>
          </div>
          <table class="table2">
            <thead>
              <tr>
                <th>Provider</th>
                <th>Acc No</th>
                <th>Mobile No</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
            <?php
                include("connection.php");
                $email = $_SESSION['loginGuard'];
                $sql = "SELECT * FROM accounts WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sen_email = $_SESSION['loginGuard'];
                        $sql = "SELECT * FROM bills WHERE email = '$sen_email'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><?php echo $row['accountno']; ?></td>
                                    <td><?php echo $row['mobileno']; ?></td>
                                    <td>Rs <?php echo number_format($row['amount']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "No transactions found";
                        }
                    }
                } else {
                    echo "No accounts found";
                }
              ?>
            </tbody>
          </table>
        </div>
        <div class="list2">
          <div class="row">
            <h4>Utility Bills Payments</h4>
            <script>
              function tableToExcelUtility() {
                var table2excel = new Table2Excel();
                table2excel.export(document.querySelectorAll("table.table3"));
              }
            </script>
            <button onclick="tableToExcelUtility()">Download</button>
          </div>
          <table class="table3">
            <thead>
              <tr>
                <th>Type</th>
                <th>Acc No</th>
                <th>Email</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
                include("connection.php");
                $email = $_SESSION['loginGuard'];
                $sql = "SELECT * FROM accounts WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sen_email = $_SESSION['loginGuard'];
                        $sql = "SELECT * FROM utilitybills WHERE email5 = '$sen_email'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['type1']; ?></td>
                                    <td><?php echo $row['accountno2']; ?></td>
                                    <td><?php echo $row['email5']; ?></td>
                                    <td>Rs <?php echo number_format($row['amount3']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "No transactions found";
                        }
                    }
                } else {
                    echo "No accounts found";
                }
              ?>
            </tbody>
          </table>
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
<script type="text/javascript" src="table2excel.js"></script>
<script type="text/javascript" src="script.js"></script>

</html>