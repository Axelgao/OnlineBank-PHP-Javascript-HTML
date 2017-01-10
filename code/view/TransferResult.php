<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
   <b>Transfer Successful!</b>

   <p>Transfer Details:</p>

   <p>From</p>

<table class="table table-bordered table-striped">
	<tr>
		<th>Account Number</th>
		<th>Description</th>
		<th>Amount</th>
		<th>Time</th>
		<th>Balance</th>
	</tr>
    <tr>
		<td><?=$accountFrom->getAccountNumber()?></td>
		<td><?=$tranz->getDescription()?></td>
		<td><?=$tranz->getAmount()?></td>
		<td><?=$tranz->getTransactionTime()?></td>
		<td><?=$accountFrom->getBalance()?></td>
	</tr>
</table>

   <p>To</p>
   
<table class="table table-bordered table-striped">
	<tr>
		<th>Account Number</th>
		<th>Description</th>
		<th>Amount</th>
		<th>Time</th>
		<th>Balance</th>
	</tr>
    <tr>
		<td><?=$accountTo->getAccountNumber()?></td>
		<td><?=$tranz->getDescription()?></td>
		<td><?=$tranz->getAmount()?></td>
		<td><?=$tranz->getTransactionTime()?></td>
		<td><?=$accountTo->getBalance()?></td>
	</tr>
</table>


<p>
<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
