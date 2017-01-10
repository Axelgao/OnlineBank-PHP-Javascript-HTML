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
<h2>Please Enter your ID and Password<br>
	If you do not have Account yet, please click "Join"</h2>
<br/>
<?php
if(isset($errorMessage)){?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

<form action = "index.php" method = "post">
	<input type="hidden" name="action" value="LogIn" /> 
	<input type="hidden" name="method" value="login" />
	<div class="form-group">
	<label for="ID">Login Name :</label> 
	<input class="form-control" type = text name = ID  placeholder="login name"/><br/>
	</div>
	<div class="form-group">
	<label for="ID">Password : </label>
	<input class="form-control" type = password name = password  placeholder="password"/><br/>
	</div>

	<input type = checkbox name="rememberMe" value="RememberMe">
	<font size = "2">Remember Me </font>

    <input class="btn btn-primary" type ="submit" name ="submit" value = "Log In">
	<a class="btn btn-default" href = "index.php?action=Join&method=join">Join</a>
</form>

	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</div>
</body>
</html>