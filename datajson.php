<?php
include 'inc.chksession.php';
include 'inc.db.php';

$conn = connect();

$q=$_POST['q'];
$id=isset($_POST['id'])?$_POST['id']:'0';
$idx=isset($_POST['idx'])?$_POST['idx']:'';

switch($q){
	case 'users': $sql="select userid,username,userlevel,usergrp,usermail,userphone,userloc,isactive from tm_users where rowid='$id'"; break;
	case 'profile': $sql="select * from tm_users where userid='$s_ID'"; break;
	case 'kanwiluser': $sql="select * from tm_kanwilusers where rowid='$id'"; break;
	case 'kanwil': $sql="select * from tm_kanwils where rowid='$id'"; break;
	case 'problem': $sql="select * from tm_problems where rowid='$id'"; break;
	case 'notify': $sql="select * from tm_timers where rowid='$id'"; break;
	case 'tickets': $sql="select * from tm_tickets where rowid='$id'"; break;
	case 'outlet': $sql="select * from tm_outlets where rowid='$id'"; break;
	case 'ips': $sql="select * from tm_ips where rowid='$id'"; break;
	case 'houtlet': $id= str_ireplace(" ","%",$id); $sql="select * from tm_outlets where oid='$id' or oname like '%$id%'"; break;
	case 'hip': $sql="select * from tm_ips where oid='$id' and layanan='$idx'"; break;
	case 'ticket': $sql="select * from tm_tickets t left join tm_outlets o on t.i=o.oid where t.rowid='$id'"; break;
	
	case 'comment': $sql="select * from tm_comments where rowid='$id'"; break;
	case 'survey': $sql="select * from tm_surveys where rowid='$id'"; break;
	case 'surveyd': $sql="select * from tm_survey where rowid='$id'"; break;
	
	case 'notif': $where="o='1'"; $lastupd="lastupd as tglj";
		if($s_LVL==4){$lastupd="dtm as tglj"; $where.=" and i = '$s_LOC'";} //pic
		$where.=$s_LVL<5?" and s<>'closed'":""; //all
		//$where.=$s_LVL==4?" and s='solved' and k in (select kanwil from tm_kanwilusers where user='$s_ID')":""; //pgd
		//$where.=$s_LVL==4?" and s='solved'":""; //pgd
		$where.=$s_LVL==5?" and s in ('new','open','pending','progress') and grp = '$s_GRP'":""; //eng
		$sql="select rowid,s,h,$lastupd from tm_tickets where $where order by lastupd desc"; 
		break;
		
	case 'log': $yang=$s_LOC==""?"1=1":"i='$s_LOC'";
		$sql="select rowid,s,h,lastupd,updby,d from tm_tickets where $yang order by lastupd desc limit 10"; break;
	
	case 'bar': $sql="select date(dt) as y, count(rowid) as a from tm_tickets where date(dt)<='$idx' and date(dt)>='$id' group by y";
	
}

//echo $sql;

$result = exec_qry($conn,$sql);
$output = fetch_alla($result);

disconnect($conn);

echo json_encode( $output );
?>