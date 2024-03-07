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
    <title>Manage Users</title>
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
      <div class="promo_card">
        <h1>All Users</h1>
      </div>
        <div class="history_lists">
          <div class="list2">
                <div class="row">
                  <h3>User Details</h3>
                  <script>
                    function tableToExcelTrans() {
                      var table2excel = new Table2Excel();
                      table2excel.export(document.querySelectorAll("table.tableAllUsers"));
                    }
                  </script>
                  <button onclick="tableToExcelTrans()"><i class="fas fa-download"></i> Report</button>
                </div>
                <table class="tableAllUsers">
                  <thead>
                    <tr>
                      <th>Client ID</th>
                      <th></th>
                      <th>Name</th>
                      <th></th>
                      <th>Mobile No</th>
                      <th></th>
                      <th>Email</th>
                      <th></th>
                      <th>Nic</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      include("connection.php");
                      $sql = "SELECT * FROM customer_register";
                      $result = mysqli_query($conn, $sql);

                      if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                              $sql = "SELECT * FROM customer_register";
                              $result = mysqli_query($conn, $sql);

                              if (mysqli_num_rows($result) > 0) {
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      ?>
                                      <tr>
                                          <td><?php echo $row['clientid']; ?></td>
                                          <td></td>
                                          <td><?php echo $row['name']; ?></td>
                                          <td></td>
                                          <td><?php echo $row['phoneno']; ?></td>
                                          <td></td>
                                          <td><?php echo $row['email']; ?></td>
                                          <td></td>
                                          <td><?php echo $row['nic']; ?></td>
                                          <td>
                                            <div class="row">
                                              <button onclick="location.href='AdminEditUsers.php?clientid=<?php echo $row['clientid']; ?>'">Edit</button>
                                              <button class="" style="margin-left: 2px; background-color: red; color: white;" onclick="location.href='deleteUser.php?clientid=<?php echo $row['clientid']; ?>'">Delete</button>
                                            </div>
                                          </td>
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