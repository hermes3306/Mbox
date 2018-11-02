<?php
	$hname	= trim(`hostname`);
	$myIP	=	gethostbyname(trim(`hostname`));
	echo $hname . "(" .  $myIP . ")";

?>
