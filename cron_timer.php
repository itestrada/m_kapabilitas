<?php 
include 'inc.db.php';

$conn = connect();

$rs=exec_qry($conn,"update tm_tickets set solved = closed where solved is null and closed is not null");

//select all timers
$sql="select grp,typ,mnt from tm_timers";
//echo $sql;
$timers = fetch_alla(exec_qry($conn,$sql));

for($i=0;$i<count($timers);$i++){
	$grp=$timers[$i]['grp'];
	$typ=$timers[$i]['typ'];
	$mnt=$timers[$i]['mnt'];
	
	$tickets=array();
	//select tickets match with the timer
	$sql="select ticketno,s from tm_tickets where grp='$grp' and typ='$typ' and s not in ('closed','pending')
	and mod(timestampdiff(minute,date_format(lastupd,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00')),$mnt)=0
	and timestampdiff(minute,date_format(dtm,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))>0";
	//echo $sql;
	$tickets=fetch_alla(exec_qry($conn,$sql));
	for($j=0;$j<count($tickets);$j++){
		$ticket=$tickets[$j]['ticketno'];
		$s=$tickets[$j]['s'];
		$sql="insert into tm_notes (ticketid,notes,s,lastupd,updby) values ('$ticket','Please respond [ $grp ]','$s',now(),'system')";
		//echo $sql;
		$rs=exec_qry($conn,$sql);
		$rs=exec_qry($conn,"update tm_tickets set o='1' where ticketno='$ticket'");
		//echo $sql;
	}
}

disconnect($conn);
?>