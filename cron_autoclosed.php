<?php 
/*run at cron job per minute
command : * * * * * php /path/to/cron_autoclosed.php
*/

include 'inc.db.php';

$conn = connect();

//cleanup empty solved date
$rs=exec_qry($conn,"update tm_tickets set solved = closed where solved is null and closed is not null");

//auto close 
$sql="select ticketno from tm_tickets where 
s='solved' and timestampdiff(minute,date_format(solved,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))>=1440";
$tickets=fetch_alla(exec_qry($conn,$sql));
for($j=0;$j<count($tickets);$j++){
	$ticket=$tickets[$j]['ticketno'];
//	$s=$tickets[$j]['s'];
	$sql="insert into tm_notes (ticketid,notes,s,lastupd,updby) values ('$ticket','Closed by system','closed',now(),'system')";
	//echo $sql;
	$rs=exec_qry($conn,$sql);
	$rs=exec_qry($conn,"update tm_tickets set closed=now(), s='closed', lastupd=now(), updby='system' where ticketno='$ticket'");
	//echo $sql;
}
disconnect($conn);
?>