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
    <title>Dashboard</title>
    <link rel="stylesheet" href="DashboardAdmin.css">
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
    <nav>
      <div class="side_navbar">
        <span>Main Menu</span>
        <a href="AdminDashboard.php" class="<?= $page == "AdminDashboard.php"? 'active':''; ?>">Dashboard</a>
        <a href="AdminAccounts.php" class="<?= $page == "AdminAccounts.php"? 'active':'' ?>">View Client Accounts</a>
        <a href="AdminManageUsers.php" class="<?= $page == "AdminManageUsers.php"? 'active':'' ?>">Manage Users</a>
        <a href="AdminTransactions.php" class="<?= $page == "AdminTransactions.php"? 'active':'' ?>">Manage Transactions</a>
      </div>
    </nav>
    <div class="main-body">
      <h2>Dashboard</h2>
      <div class="promo_card">
        <h1>Welcome to PABC</h1>
        <span>Lorem ipsum dolor sit amet.</span>
        <button>Learn More</button>
      </div>
      <div class="history_lists">
        <div class="list1">
            <div class="row">
              <h4>Funds Transactions</h4>
              <script>
                    function tableToExcelTrans() {
                      var table2excel = new Table2Excel();
                      table2excel.export(document.querySelectorAll("table.tableAllTrans"));
                    }
                  </script>
                  <button onclick="tableToExcelTrans()"><i class="fas fa-download"></i> Report</button>
            </div>
            <table class="tableAllTrans">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Source Account No</th>
                  <th>Account Type</th>
                  <th>Beneficiary Account No</th>
                  <th>Sender Email</th>
                  <th>Beneficiary Email</th>
                  <th>Payment Type</th>
                  <th>Transfer Type</th>
                  <th>Create Date</th>
                  <th>Tranfer Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  include("connection.php");
                  $sql = "SELECT * FROM accounts";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          $sql = "SELECT * FROM fund_transfer";
                          $result = mysqli_query($conn, $sql);

                          if (mysqli_num_rows($result) > 0) {
                              while ($row = mysqli_fetch_assoc($result)) {
                                  ?>
                                  <tr>
                                      <td><?php echo $row['id']; ?></td>
                                      <td><?php echo $row['source_account_number']; ?></td>
                                      <td><?php echo $row['account_type']; ?></td>
                                      <td><?php echo $row['beneficiary_account_no']; ?></td>
                                      <td><?php echo $row['sender_email']; ?></td>
                                      <td><?php echo $row['beneficiary_email']; ?></td>
                                      <td><?php echo $row['payment_type']; ?></td>
                                      <td><?php echo $row['fund_transfer_type']; ?></td>
                                      <td><?php echo $row['date']; ?></td>
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
<script type="text/javascript" src="table2excel.js"></script>
<script type="text/javascript" src="script.js"></script>

</html>