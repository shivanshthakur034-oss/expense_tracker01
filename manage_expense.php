<?php
include("session.php");

$selectedSort = isset($_GET['sort']) ? $_GET['sort'] : 'none';

$sortColumn = '';
switch ($selectedSort) {
    case 'month':
        $sortColumn = 'expensedate';
        break;
    case 'category':
        $sortColumn = 'expensecategory';
        break;
    case 'none':
    default:
        $sortColumn = 'expense_id DESC'; 
        break;
}

$orderByClause = $sortColumn ? "ORDER BY $sortColumn" : '';

$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid' $orderByClause");
?>
<!DOCTYPE html>
<html lang="en">


<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>Expense Manager - Dashboard</title>

<link href="css/style.css" rel="stylesheet">


<script src="js/feather.min.js"></script>
<style>
    .try {
  font-size: 28px;
  color: #333;
  padding: 15px 0px 5px 0px;
}

</style>

</head>


<body>
    <div class="d-flex" id="wrapper">
       
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
<img class="profile-img" src="uploads/default_profile.png" width="120" alt="Profile Picture">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action "><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>

      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>

    
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


<button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
    <span data-feather="menu"></span>
</button>
<div class="col-md-11 text-center">
    <h3 class="try">Manage Expenses</h3>
</div>
</nav>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                    <form method="GET" action="">
    <div class="form-group mt-3">
        <label for="sort">Sort By:</label>
        <select class="form-control" id="sort" name="sort" onchange="this.form.submit()">
            <option value="none" <?php if ($selectedSort === 'none') echo 'selected'; ?>>Recently Added</option>
            <option value="month" <?php if ($selectedSort === 'month') echo 'selected'; ?>>Month</option>
            <option value="category" <?php if ($selectedSort === 'category') echo 'selected'; ?>>Category</option>
        </select>
    </div>
</form>

                        <br>
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Sl No.</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Expense Category</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <?php $count=1; while ($row = mysqli_fetch_array($exp_fetched)) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $count;?></td>
                                    <td class="text-center"><?php echo $row['expensedate']; ?></td>
                                    <td class="text-center"><?php echo $row['expense']; ?></td>
                                    <td class="text-center"><?php echo $row['expensecategory']; ?></td>
                                    <td class="text-center">
                                        <a href="add_expense.php?edit=<?php echo $row['expense_id']; ?>" class="btn btn-primary btn-sm" style="border-radius:0%;">Edit</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="add_expense.php?delete=<?php echo $row['expense_id']; ?>" class="btn btn-danger btn-sm" style="border-radius:0%;">Delete</a>
                                    </td>
                                </tr>
                            <?php $count++; } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/app.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>
