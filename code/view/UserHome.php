<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<br>
<table class="table table-bordered table-striped">
	<tr>
		<th>Account Number</th>
		<th>Description</th>
		<th>Available</th>
		<th>Balance</th>
		<th></th>
		<th></th>
	</tr>
    <?php foreach($accountList as $value) {?>
    <tr>
		<td>
			<a href="index.php?action=Account&method=updateAccount&id=<?=$value->getId()?>">
			<?=$value->getAccountNumber()?></a>
		</td>
		<td><?=$value->getDescription()?></td>
		<td>
				<?php
    if ($value->getStatus() == 1) {
        print "Open";
    } else {
        print "Close";
    }
    ?>
		</td>
		<td><?=$value->getBalance()?></td>
		<td><a href="index.php?action=Tranz&method=findTranz&accountId=<?=$value->getId()?>">Transaction</a></td>
		<td><a href="index.php?action=Filter&method=filter&accountId=<?=$value->getId()?>">Filter</a></td>
	</tr>
   <?php }?>
</table>

<a class="btn btn-default" href="index.php?action=Account&method=addAccount">Add Account</a>
