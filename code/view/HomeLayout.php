<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Welcome to First National Bank</h1>
		</div>

		<div>
			<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Home</a>
			<a class="btn btn-default" href="index.php?action=Transfer&method=transfer">Transfer</a> 
			<a class="btn btn-default" href="index.php?action=Payment&method=pay">Payment</a>
			<a class="btn btn-default" href="index.php?action=ChangePassword&method=changePassword">Change Password</a>
			<a class="btn btn-default" href="index.php?action=ATM&method=atm">ATM</a>
			<a class="btn btn-default" href="index.php?action=Default&method=logout">Log Out</a>
			Welcome! 
			<?php
			require_once ("model/UserHandler.php");
				
			$loginUser = $_SESSION["loginUser"];
			print($loginUser->getLoginName())
			?>. Logged in at <?=$loginUser->getTimeOfLogin() ?>
			
		</div>

    <?php require_once('Dispatcher.php'); ?>
	</div>
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
<body>
<html>