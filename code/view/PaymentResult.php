<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
   <b>Payment Successful!</b>

   <p>Payment Details:</p>

<table class="table table-bordered table-striped">
	<tr>
		<th>Account Number</th>
		<th>Destination Account</th>
		<th>Amount</th>
		<th>Time</th>
	</tr>
    <tr>
		<td><?=$account->getAccountNumber()?></td>
		<td><?=$tranz->getDescription()?></td>
		<td><?=$tranz->getAmount()?></td>
		<td><?=$tranz->getTransactionTime()?></td>
	</tr>
</table>
<p>
<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
