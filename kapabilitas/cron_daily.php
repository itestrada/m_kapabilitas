<?php
include 'inc.db.php';
include 'inc.common.php';

$conn = connect();

if(strtolower(date('D'))!='sun'){
	$sql="update tm_tickets set s='open' where s='pending' and grp='link' and typ in $homewidget";
	$rs=exec_qry($conn,$sql);
}
if(strtolower(date('D'))=='mon'){
	$sql="update tm_tickets set s='open' where s='pending'  and typ='relokasi'";
	//$rs=exec_qry($conn,$sql);
}

disconnect($conn);
?>