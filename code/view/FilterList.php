<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<?php
if (isset($errorMessage)) {
    ?>
<p>
	
<h4><?=$errorMessage?></h4>
<p>
<?php } ?>
<br>

<?php if(isset($account)){?></p>
<p>Account Number: <?=$account->getAccountNumber()?></p>
<p>Balance: <?=$account->getBalance()?></p>
<p>Description: <?=$account->getDescription()?></p>
<p>Open Date: <?=$account->getDateOpen()?></p>

<form action = "index.php" method = "post">
	<input type="hidden" name="action" value="Filter" />
	<input type="hidden" name="method" value="filter" />
	<input type="hidden" name="accountId" value="<?=$account->getId()?>" />
    <p>Custom Date Range: <input type="text" name="fromDate" size="10" value="" />
	to
    <input type="text" name="toDate" size="10" value="" /></p>
	<p>Choose Function:
	<select name="type">
		<option value="W">Withdraw</option>
		<option value="D">Deposit</option>
		<option value="T">Transfer To</option>
		<option value="F">Transfer From</option>
		<option value="P">Payment</option>
	</select></p>
	<p>Choose Order:
	<select name="order">
		<option value="asc">ASC</option>
		<option value="desc">DESC</option>
	</select></p>
    <input class="btn btn-default" type="submit" name="submit" value="View" />
</form>
<?php }?>

<table class="table table-bordered table-striped">
	<tr>
		<th>No</th>
		<th>Type</th>
		<th>Amount</th>
		<th>Transaction Time</th>
		<th>Description</th>
	</tr>
    <?php $idx = 1;
    if(isset($tranzList)){
        foreach($tranzList as $value) {?>
        <tr>
    		<td><?=$idx?></td>
    		<td>
    		<?php
            switch($value->getTransactionType()) {
                case "D":
                    print "Deposit";
                    break;
                case "W":
                    print "Withdraw";
                    break;
    			case "F":
    				print "Transfer From";
    				break;
                case "T":
                    print "Transfer To";
                    break;
                case "P":
                    print "Pay";
                    break;
            }
            ?>
    		</td>
    		<td><?=$value->getAmount()?></td>
    		<td><?=$value->getTransactionTime()?></td>
    		<td><?=$value->getDescription()?></td>
    	</tr>
       <?php $idx++;
        }
    }?>
</table>

<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
