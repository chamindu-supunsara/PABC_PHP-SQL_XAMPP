<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['loginGuardAdmin'])) {
    header("Location: LoginAdmin.php");
    exit();
}

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);

include("connection.php");
$sql = "SELECT * FROM accounts";
$result = mysqli_query($conn, $sql);

$dataPoints = array();

while ($row = mysqli_fetch_assoc($result)) {
  $dataPoints[] = array(
    "label" => $row['clientid'],
    "y" => $row['amount']
  );
}

include("connection.php");
$sql = "SELECT * FROM fund_transfer";
$result2 = mysqli_query($conn, $sql);

$dataPoint = array();

while ($row2 = mysqli_fetch_assoc($result2)) {
  $dataPoint[] = array(
    "label" => $row2['fund_transfer_type'],
    "y" => $row2['transfer_amount']
  );
}

include("connection.php");
$sql = "SELECT * FROM bills";
$result = mysqli_query($conn, $sql);

$dataPointbills = array();

while ($row3 = mysqli_fetch_assoc($result)) {
  $dataPointbills[] = array(
    "label" => $row3['id'],
    "y" => $row3['amount']
  );
}

include("connection.php");
$sql = "SELECT * FROM utilitybills";
$result = mysqli_query($conn, $sql);

$dataPointutility = array();

while ($row3 = mysqli_fetch_assoc($result)) {
  $dataPointutility[] = array(
    "label" => $row3['id'],
    "y" => $row3['amount3']
  );
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="DashboardAdmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
<script>
  window.onload = function() {

  var chart = new CanvasJS.Chart("chartContainerbar", {
    animationEnabled: true,
    theme: "light2",
    axisY: {
      title: "Amount",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    axisX: {
      title: "Transaction ID",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    data: [{
      type: "column",
      yValueFormatString: "#,###\" LKR\"",
      dataPoints: <?php echo json_encode($dataPoint, JSON_NUMERIC_CHECK); ?>
    }]
  });

  var chartbill = new CanvasJS.Chart("chartContainerbill", {
    animationEnabled: true,
    theme: "light3",
    axisY: {
      title: "Amount",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    axisX: {
      title: "Transaction ID",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    data: [{
      type: "column",
      yValueFormatString: "#,###\" LKR\"",
      dataPoints: <?php echo json_encode($dataPointbills, JSON_NUMERIC_CHECK); ?>
    }]
  });
  
  var chart2 = new CanvasJS.Chart("chartContainerpie", {
    animationEnabled: true,
    data: [{
      type: "pie",
      yValueFormatString: "#,###\" LKR\"",
      dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
  });

  var chart3 = new CanvasJS.Chart("chartContainerbar3", {
    animationEnabled: true,
    theme: "light2",
    axisY: {
      title: "Amount",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    axisX: {
      title: "Transaction ID",
      labelFormatter: function(e){
          if(e.value >= 1000){
              return (e.value / 1000).toFixed(1) + "k";
          }
          return e.value;
        }
    },
    data: [{
      type: "column",
      yValueFormatString: "#,###\" LKR\"",
      dataPoints: <?php echo json_encode($dataPointutility, JSON_NUMERIC_CHECK); ?>
    }]
  });

  chart.render();
  chartbill.render();
  chart2.render();
  chart3.render();
  }
</script>
</head>
<body>
  <header class="header">
    <div class="logo">
      <a href="#">Welcome Admin</a>
      <div class="search_box">
        <input type="text" placeholder="Search">
        <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
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
    </nav>
    <div class="main-body">
      <h1>Dashboard</h1>
      <!-- <div class="promo_card">
        <h1>Welcome to PABC Online Banking</h1>
        <span>Empowering your finances, one click at a time. </span>
      </div> -->

      <!-- <br> -->
      <div class="row">
        <div class="card">
            <h2>Accounts</h2>
            <div id="chartContainerpie" style="height: 325px; width: 425px;"></div>
        </div>

        <div class="card" style="margin-left: 10px;">
            <h2>Funds Transactions</h2>
            <div id="chartContainerbar" style="height: 325px; width: 425px;"></div>
        </div>
      </div>

      <div class="row">
        <div class="card">
            <h2>Mobile Payments</h2>
            <div id="chartContainerbill" style="height: 325px; width: 425px;"></div>
        </div>

        <div class="card" style="margin-left: 10px;">
            <h2>Utility Payments</h2>
            <div id="chartContainerbar3" style="height: 325px; width: 425px;"></div>
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
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

</html>