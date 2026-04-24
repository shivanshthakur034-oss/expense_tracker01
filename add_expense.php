<?php
include("session.php");
$update = false;
$del = false;
$error_message = "";
$expenseamount = "";
$expensedate = date("Y-m-d");
$expensecategory = "";

// fifgf


if (isset($_POST['add']) || isset($_POST['update'])) {
    $expenseamount = trim($_POST['expenseamount']);
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

  
    if (!is_numeric($expenseamount) || $expenseamount <= 0) {
        $error_message = "Expense amount must be a positive number.";
    } elseif (empty($expensecategory)) {
        $error_message = "Please select a category.";
    } else {
        if (isset($_POST['add'])) {
            $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory')";
            if (mysqli_query($con, $expenses)) {
                header('location: add_expense.php');
                exit;
            } else {
                $error_message = "Database error: " . mysqli_error($con);
            }
        } elseif (isset($_POST['update'])) {
            $id = $_GET['edit'];
            $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory' WHERE user_id='$userid' AND expense_id='$id'";
            if (mysqli_query($con, $sql)) {
                header('location: manage_expense.php');
                exit;
            } else {
                $error_message = "Update error: " . mysqli_error($con);
            }
        }
    }
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM expenses WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        header('location: manage_expense.php');
    } else {
        echo "ERROR: " . mysqli_error($con);
    }
    exit;
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
    } else {
        die("WARNING: AUTHORIZATION ERROR");
    }
}

if (isset($_GET['delete'])) {
    $del = true;
    $id = $_GET['delete'];
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
    } else {
        die("WARNING: AUTHORIZATION ERROR");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Expense Manager - Add Expenses</title>
    <link href="css/style.css" rel="stylesheet">
    <script src="js/feather.min.js"></script>
    <style>
        .try {
            font-size: 28px;
            color: #333;
            padding: 15px 70px 5px 0px;
        }
        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
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
                <a href="index.php" class="list-group-item list-group-item-action"><span data-feather="home"></span> Dashboard</a>
                <a href="add_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="plus-square"></span> Add Expenses</a>
                <a href="manage_expense.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Manage Expenses</a>
                <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>
            </div>
            <div class="sidebar-heading">Settings</div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span> Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action"><span data-feather="power"></span> Logout</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>
                <div class="col-md-12 text-center">
                    <h3 class="try">Add Your Daily Expenses</h3>
                </div>
                <hr>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md" style="margin:0 auto;">
                        <?php if (!empty($error_message)): ?>
                            <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
                        <?php endif; ?>
                        <form action="" method="POST" id="expenseForm" novalidate>
                            <div class="form-group row" style="margin-top: 20px;">
                                <label for="expenseamount" class="col-sm-6 col-form-label"><b>Enter Amount</b></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control col-sm-12" value="<?php echo htmlspecialchars($expenseamount); ?>" id="expenseamount" name="expenseamount" min="0.01" step="0.01" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="expensedate" class="col-sm-6 col-form-label"><b>Date</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo htmlspecialchars($expensedate); ?>" name="expensedate" id="expensedate" required>
                                </div>
                            </div>
                            <fieldset class="form-group">
                                <div class="row">
                                    <label class="col-form-label col-sm-6 pt-0"><b>Category</b></label>
                                    <div class="col-md">
                                        <select class="form-control" id="expensecategory" name="expensecategory" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $categories_query = "SELECT * FROM expense_categories";
                                            $categories_result = mysqli_query($con, $categories_query);
                                            while ($row = mysqli_fetch_assoc($categories_result)) {
                                                $category_name = htmlspecialchars($row['category_name']);
                                                $selected = ($category_name === $expensecategory) ? 'selected' : '';
                                                echo "<option value=\"$category_name\" $selected>$category_name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <?php if ($update): ?>
                                        <button class="btn btn-lg btn-block btn-warning" type="submit" name="update">Update</button>
                                    <?php elseif ($del): ?>
                                        <button class="btn btn-lg btn-block btn-danger" type="submit" name="delete">Delete</button>
                                    <?php else: ?>
                                        <button type="submit" name="add" class="btn btn-lg btn-block btn-success">Add Expense</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/app.js"></script>
    <script>
        feather.replace();
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('expenseForm');
            const amountInput = document.getElementById('expenseamount');
            
            amountInput.addEventListener('input', function() {
                if (this.value < 0) {
                    this.setCustomValidity('Amount must be positive');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            form.addEventListener('submit', function(e) {
                if (amountInput.value <= 0 || !amountInput.value) {
                    e.preventDefault();
                    alert('Please enter a positive amount.');
                    amountInput.focus();
                    return false;
                }
            });
        });
    </script>
</body>
</html>

