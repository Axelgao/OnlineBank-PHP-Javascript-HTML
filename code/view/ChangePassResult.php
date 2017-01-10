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
Password changed successfully.
<?php }?>
<a class="btn btn-default" href="index.php?action=UserHome&method=findAccount">Return</a>
