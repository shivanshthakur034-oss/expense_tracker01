<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

if (isset($_POST['save'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];

    $sql = "UPDATE users SET firstname = '$fname', lastname='$lname' WHERE user_id='$userid'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: profile.php');
}

if (isset($_POST['but_upload'])) {

    $name = $_FILES['file']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    
    if (in_array($imageFileType, $extensions_arr)) {

        
        $query = "UPDATE users SET profile_path = '$name' WHERE user_id='$userid'";
        mysqli_query($con, $query);

      
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        header("Refresh: 0");
    }
}

?>
<html>




    <title>Expense Manager - Dashboard</title>

    
    <link href="css/style.css" rel="stylesheet">

    
    <script src="js/feather.min.js"></script>

    <style>
    .try {
  font-size: 28px;
  color: #333;
  padding: 15px 65px 5px 0px;
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
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>

      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>

    
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>
                <div class="col-md-12 text-center">
                <h3 class="try">Update Profile</h3>
                </div>                
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form class="form" method="post" action="" enctype='multipart/form-data'>
                            <div class="text-center mt-3">
                                <img src="uploads/default_profile.png" class="profile-img" width="120" alt="Profile Picture">
                            </div>
                            <div class="input-group col-md mb-3 mt-3">
                                
                            </div>


                        </form>


                        
                        <form class="form" action="" method="post" id="registrationForm" autocomplete="off">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">

                                        <div class="col-md">
                                            <label for="first_name">
                                                First name
                                            </label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $firstname; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">

                                        <div class="col-md">
                                            <label for="last_name">
                                                Last name
                                            </label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $lastname; ?>" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-md">
                                    <label for="email">
                                        Email
                                    </label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $useremail; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md">
                                    <br>
                                    <button class="btn btn-block btn-md btn-success" style="border-radius:0%;" name="save" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </form>
                        

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
