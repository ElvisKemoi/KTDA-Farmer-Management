<?php 
require_once('includes/connection.php'); 
session_start(); 

if (isset($_POST['btnRegister'])) {
    // Get and sanitize inputs
    $farmerID = trim($_POST['txtFarmerID']);
    $fname = trim($_POST['txtFName']);
    $lname = trim($_POST['txtLName']);
    $address = trim($_POST['txtAddress']);
    $telno = trim($_POST['txtTelNo']);
    $nic = trim($_POST['txtNIC']);
    $password = trim($_POST['txtPsw']);

    // Optional: Hash the password
    $hashed_password = $password; // Use password_hash($password, PASSWORD_DEFAULT) for production

    // Prepare insert statement
    $query = "INSERT INTO FARMER (FarmerID, FName, LName, Address, TelNo, NIC, Password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssss", $farmerID, $fname, $lname, $address, $telno, $nic, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $msg = "Registration successful!";
        } else {
            $msg = "Error: Could not register farmer.";
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
	<title>Farmer Registration</title>
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
				<li class="nav-item"><a href="farmerLogin.php" class="nav-link">FARMER LOGIN</a></li>
				<li class="nav-item"><a href="FarmerRegistration.php" class="nav-link active">FARMER REGISTRATION</a></li>
				<li class="nav-item"><a href="ClerkLogin.php" class="nav-link">CLERK LOGIN</a></li>
			</ul>
		</collapse>	
	</nav><!-- class="navbar" -->

	<div class="wrapper">
	<div class="head clearfix">
		<h1>Register</h1>
	</div><!-- head -->
	
	<div class="contain clearfix">
		<div class="column">
			<img class="sidepic" src="wave/ka.svg">
		</div><!-- column -->

		<div class="column">
			<img class="contactpic" src="wave/profilepic.svg">
			<form action="FarmerRegistration.php" class="signup" method="post">
                <label><b><?php echo (isset($msg)) ? $msg : ''; ?></b></label>
                <br>
                <input type="text" name="txtFarmerID" placeholder="Farmer ID" required>
                <br>
                <input type="text" name="txtFName" placeholder="First Name" required>
                <br>
                <input type="text" name="txtLName" placeholder="Last Name" required>
                <br>
                <input type="text" name="txtAddress" placeholder="Address" required>
                <br>
                <input type="text" name="txtTelNo" placeholder="Telephone No." required>
                <br>
                <input type="text" name="txtNIC" placeholder="NIC" required>
                <br>
                <input type="password" name="txtPsw" placeholder="Password" required>
                <br>
                <button type="submit" name="btnRegister" class="btn btn-success btn-lg" style="margin-left: 937px;">Register</button>
                <br>
            </form>

		</div><!-- column -->
	</div><!-- contain -->

		<div class="copyrights">
			<div class="left">
				Department of Agriculture | Copyrights &copy; All Rights Reserved | Tel : 011 587 4256
			</div><!-- left -->
		</div><!-- copyrights -->
	</div><!-- wrapper -->
</body>
</html>