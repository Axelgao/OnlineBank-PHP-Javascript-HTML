<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<h2>Please type old passwrod and new password</h2>
<?php
if(isset($errorMessage)){?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

<form action = "index.php" method = "post">
	<input type="hidden" name="action" value="ChangePassword" /> 
	<input type="hidden" name="method" value="changePassword" />
    Old Password :<input type = password name="password" /><br/><br/>
    New Password :<input type = password name="newPassword" /><br/><br/>
    Repeat New Password :<input type = password name ="repeatNewPassword"/><br/><br/>
    <input class="btn btn-primary" type ="submit" name ="submit" value = "save">
    <a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
    
</form>
    