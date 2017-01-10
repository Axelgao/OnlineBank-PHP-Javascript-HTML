<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<h2>Please input account detail</h2>
<?php
if (isset($errorMessage)) {
    ?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

<?php

$status = $account->getStatus();
if (isset($status)) {
    ?>
<form action="index.php" method="post">
	<input type="hidden" name="action" value="Account" /> <input
		type="hidden" name="method" value="updateAccount" /> <input
		type="hidden" name="id" value="<?=$account->getId()?>" />
	<div class="form-group">
		<label for="accountNumber">Account Number:</label>
		<?=$account->getAccountNumber()?>
	</div>
	<div class="form-group">
		<label for="status">Status:</label>
		<?php
        
        if (! isset($status) || $status == "0") {
            print "Closed";
        } else {
        ?>
        <input type="radio" name="status" value="1"
			<?php if($account->getStatus()=="1"){print "checked='checked'";}?>>
		Open <input type="radio" name="status" value="0"
			<?php if($account->getStatus()=="0"){print "checked='checked'";}?>> Closed
        <?php }?>
	</div>
	<div class="form-group">
		<label for="description">Description:</label> <input type="text"
			class="form-control" name='description' id='description'
			placeholder="description" value="<?=$account->getDescription()?>" />
	</div>
	<input class="btn btn-primary" type="submit" name="submit" value="save">
    <?php }?>
    <a class="btn btn-default"
		href="index.php?action=UserHome&method=findAccount">Return</a>
</form>
