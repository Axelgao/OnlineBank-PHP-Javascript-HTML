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
<h2>Please type your detail</h2>
<?php
if(isset($errorMessage)){?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

<form action = "index.php" method = "post">
	<input type="hidden" name="action" value="Join" /> 
	<input type="hidden" name="method" value="join" />
	<div class="form-group">
    <label for="loginName">Login Name : </label>
    <input class="form-control" type ="text" name = "loginName"  placeholder="login name" 
    value="<?=$user->getLoginName()?>"/>
	</div>
	<div class="form-group">
    <label for="firstName">First Name : </label>
    <input class="form-control" type = text name = "firstName"  placeholder="first name"
    value="<?=$user->getFirstName()?>"/>
	</div>
	<div class="form-group">
	<label for="lastName">Last Name : </label>
	<input class="form-control" type = text name = "lastName"  placeholder="last name"
    value="<?=$user->getLastName()?>"/>
	</div>
	<div class="form-group">
	<label for="address">Address : </label>
	<input class="form-control" type = text name = "address"  placeholder="address"
    value="<?=$user->getAddress()?>"/>
	</div>
	<div class="form-group">
	<label for="phoneNumber">Phone Number : </label>
	<input class="form-control" type = text name = "phoneNumber"  placeholder="phone number"
    value="<?=$user->getPhoneNumber()?>"/>
	</div>
	<div class="form-group">
	<label for="DateOfBirth">Date Of Birth: </label>
	<input class="form-control" type = text name = "DateOfBirth"  placeholder="date of birth, format: yyyy-mm-dd"
    value="<?=$user->getDateOfBirth()?>"/>
	</div>
	<div class="form-group">
	<label for="password">Password :        </label>
	<input class="form-control" type= password name= "password"  placeholder="password"/>
	</div>
	<div class="form-group">
	<label for="rePassword">Repeat Password : </label>
	<input class="form-control" type= password name="rePassword" placeholder="repeat password"/>
	</div>

    <input class="btn btn-primary" type ="submit" name ="submit" value = "submit">
    <a class="btn btn-default" href="index.php">Return</a>
    
</form>

	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</div>
</body>
</html>