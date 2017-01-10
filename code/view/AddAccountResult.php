<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<?php 
if(isset($errorMessage)){?>
<p>
	<h4><?=$errorMessage?></h4>
	<p>
<?php }else { ?>

<b>Successful!</b>

<p>Details:</p>

<table class="table table-bordered table-striped">
	<tr>
		<th>Account Number</th>
		<th>Description</th>
		<th>Available</th>
		<th>Balance</th>
	</tr>
    <tr>
		<td><?=$account->getAccountNumber()?></td>
		<td><?=$account->getDescription()?></td>
		<td>
			<?php
            if ($account->getStatus() == 1) {
                print "Open";
            } else {
                print "Close";
            }
            ?>
		</td>
		<td><?=$account->getBalance()?></td>
	</tr>
   <?php }?>
</table>
<p>
<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
