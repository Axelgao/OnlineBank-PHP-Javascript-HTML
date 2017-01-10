<?php
/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */
?>
<h2>Pay a bill</h2>
<?php
if(isset($errorMessage)){?>
<div class="alert alert-danger">
	<h4><?=$errorMessage?></h4>
</div>
<?php } ?>

	<form action="index.php" method="post">
		<input type="hidden" name="action" value="Payment" /> 
		<input type="hidden" name="method" value="pay" /> 
    	<p>From
   		<select name="accountId">
          <?php foreach($accountList as $value) {?>
             <option value="<?=$value->getId()?>"><?=$value->getAccountNumber()?> $<?=$value->getBalance()?></option>
          <?php }?>
        </select>
    	To Account Number: <input type="text" name="outerAccount" size="20" value="" />
    	</p>
    	<p>
    		Amount: <input type="text" name="amount" size="10" value="" />
    	</p>
    	<p>
    		Description: <input type="text" name="description" size="20" value="" />
    	</p>
		<input class="btn btn-default" type="submit" name="submit" value="pay" />
	</form>
