<?php
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

$conn=connect();

					$tot1=0;
					$open1=0;
					$pending1=0;
					$solved1=0;
					
					$tot2=0;
					$open2=0;
					$pending2=0;
					$solved2=0;
					
					$tot3=0;
					$open3=0;
					$pending3=0;
					$solved3=0;
					
					$yang=$s_LOC==""?"":" and i='$s_LOC'";
					
					
					//$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and datediff(date(now()),date(dt))<=30");
					$rs=exec_qry($conn,"select count(*) from tm_tickets where s<>'closed' and datediff(date(now()),date(dt))<=30 $yang");
					if($row=fetch_row($rs)){ $tot1=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where s in ('solved','closed') and datediff(date(now()),date(dt))<=30 $yang");
					if($row=fetch_row($rs)){ $solved1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where s='pending' and datediff(date(now()),date(dt))<=30 $yang");
					if($row=fetch_row($rs)){ $pending1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where s in ('open','new','progress') and datediff(date(now()),date(dt))<=30 $yang");
					if($row=fetch_row($rs)){ $open1=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi'");
					if($row=fetch_row($rs)){ $tot2=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ = 'relokasi' and s='solved'");
					if($row=fetch_row($rs)){ $solved2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s='pending'");
					if($row=fetch_row($rs)){ $pending2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open2=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where p='RMA'");
					if($row=fetch_row($rs)){ $tot3=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where p='RMA' and s='solved'");
					if($row=fetch_row($rs)){ $solved3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where p='RMA' and s='pending'");
					if($row=fetch_row($rs)){ $pending3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where p='RMA' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open3=$row[0];}
					
disconnect($conn);
$first=array("total"=>$tot1,"open"=>$open1,"solved"=>$solved1,"pending"=>$pending1);
$second=array("total"=>$tot2,"open"=>$open2,"solved"=>$solved2,"pending"=>$pending2);
$third=array("total"=>$tot3,"open"=>$open3,"solved"=>$solved3,"pending"=>$pending3);

$res=array($first,$second,$third);
echo json_encode($res);
?>