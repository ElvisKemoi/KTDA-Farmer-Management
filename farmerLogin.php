<?php 
require_once('includes/connection.php'); 
session_start(); 

if (isset($_POST['btnLogin'])) {
    
    // Retrieve input safely
    $userID = trim($_POST['txtUName']);
    $password = trim($_POST['txtPsw']);

    // Prepare SQL query to prevent SQL injection
    $query = "SELECT Password FROM Farmer WHERE FarmerId = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        echo $userID . " " .$password;

        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $hashed_password);
            mysqli_stmt_fetch($stmt);

            // Verify the hashed password
			// todo create better way to authenticate user 
            if ($password == $hashed_password) {
                $_SESSION['userID'] = $userID;
                $_SESSION['role'] = 'farmer';
                header("Location: FarmersView.php");
                exit;
            } else {
                $msg = "Invalid Username or Password";
            }
        } else {
            $msg = "Invalid Username or Password";
        }
        mysqli_stmt_close($stmt);
    } else {
        $msg = "Database error!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Farmer Log In</title>
	<link href="https://fonts.googleapis.com/css?family=Baloo+Da+2|Cabin|Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	<nav class="navbar navbar-expand-sm navbar-dark bg-success fixed-top">
		<a href="#" class="navbar-brand"><img src="img/ktdalogo.png" alt="" style="width: 200px;"></a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbar_id"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse justify-content-center" id="navbar_id">
        <ul class="navbar-nav">
				<li class="nav-item"><a href="index.html" class="nav-link ">HOME</a></li>
				<li class="nav-item"><a href="Login.php" class="nav-link">AGRICULTURAL OFFICER LOGIN</a></li>
				<li class="nav-item"><a href="farmerLogin.php" class="nav-link active">FARMER LOGIN</a></li>
				<li class="nav-item"><a href="FarmerRegistration.php" class="nav-link">FARMER Registration</a></li>
				<li class="nav-item"><a href="ClerkLogin.php" class="nav-link">CLERK LOGIN</a></li>
        </ul>
		</collapse>	
	</nav><!-- class="navbar" -->

	<div class="wrapper">
	<div class="head clearfix">
		<h1>Log In</h1>
	</div><!-- head -->
	
	<div class="contain clearfix">
		<div class="column">
			<img class="sidepic" src="wave/ka.svg">
		</div><!-- column -->

		<dic class="column">
			<img class="contactpic" src="wave/profilepic.svg">
			<form action="farmerLogin.php" class="signup"  method="post">
				<br>
				<label for="lblMsg"><b><?php echo (isset($msg)) ? $msg : ''; ?></b></label>
				<br>
				<input type="text" name="txtUName" placeholder="Farmer ID" required>
				<br>
				<input type="password" name="txtPsw" placeholder="Password" required>
				<br>
				<br>
				<button type="submit" name="btnLogin" value="HTML" class="btn btn-success btn-lg">Log In</button>
			</form>
		</dic><!-- column -->
	</div><!-- contain -->

		<div class="copyrights">
			<div class="left">
				Department of Agriculture | Copyrights &copy; All Rights Reserved | Tel : 011 587 4256
			</div><!-- left -->
		</div><!-- copyrights -->
	</div><!-- wrapper -->
</body>
</html>