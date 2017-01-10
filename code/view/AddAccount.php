<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<h2>Please input new account detail</h2>
<?php
if(isset($errorMessage)){?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

<form action = "index.php" method = "post">
	<input type="hidden" name="action" value="Account" /> 
	<input type="hidden" name="method" value="addAccount" />
	<div class="form-group">
		<label for="accountNumber">Account Number:</label>
		<input type="text" class="form-control" name='accountNumber'
			id='accountNumber' placeholder="account number"
			value="<?=$account->getAccountNumber()?>"/>
	</div>
	<div class="form-group">
		<label for="description">Description:</label>
		<input type="text" class="form-control" name='description'
			id='description' placeholder="description"
			value="<?=$account->getDescription()?>"/>
	</div>
    <input class="btn btn-primary" type ="submit" name ="submit" value = "save">
    <a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
    
</form>
