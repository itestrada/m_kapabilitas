<?php
include 'inc.db.php';
include 'inc.sendmail.php';

$t = $_POST['t'];

$conn=connect();
$msg="invalid flag";

if($t=="register"){
		
	$id = $_POST['usermail'];
	$nm = $_POST['username'];
	$uid= $_POST['userid'];
		
	$msg="Registrasi berhasil, mail terkirim ke $id";
	$ival="";
	
	$cols = "userid,username,userlevel,usergrp,usermail,userloc,userphone";// $_POST['cols'];
	$acol = explode(",",$cols);
	$code = date('sdisHdi');
	
	for($i=0;$i<count($acol);$i++){
		if($acol[$i]=="photo"){
			$ival .= "'".$uphoto[0]."',";
		}elseif($acol[$i]=="password"){
			$ival .= "md5('".$_POST[$acol[$i]]."'),";
		}else{
			$ival .= "'".$_POST[$acol[$i]]."',";
		}
	}
	
	$sql="insert into tm_users ($cols,userpwd) values ($ival md5('$code'))";
	//echo $sql;
	
	$rs=exec_qry($conn,"select userid,usermail from tm_users where userid='$uid' or usermail='$id'");
	if($row=fetch_row($rs)){
		$msg="User ID/Email sudah ada.";//db_error($conn);
	}else{
		//send mail
		//$lnk = "http://localhost/htdocs/test/lg/confirm.php?id=".md5($id)."&key=".$code;
		//$m="halo $id <br /> klik link berikut untuk mengaktifkan account anda $lnk <br /> terima kasih <br /> aku aja";
		$rs = exec_qry($conn,$sql);
		$m = "Hi $nm, terima kasih sudah mendaftar.<br />Password anda adalah $code <br />rgds<br />admin";
		if(db_error($conn)==''){
			if(!send_mail($id,"Manajemen Kapabilitas",$m)){
				$msg="Registrasi Berhasil, gagal mengirim email. Mohon dicatat dan segera ubah, password anda adalah $code ";
				//$rs=exec_qry($conn,"delete from tm_users where userid='$userid'");
			}
		}else{
			$msg = "Registrasi gagal.";
		}
	}

}

if($t=="passwd"){
		
	$id = $_POST['usermail'];
	$uid= $_POST['userid'];

	$code=date('sdiHdis');
	
	$rs=exec_qry($conn,"update tm_users set userpwd=md5('$code') where userid='$uid' and usermail='$id'");
	if(affected_row($conn)>0){
		$m = "Hi,<br />Password baru anda adalah $code <br />rgds<br />admin";
			if(!send_mail($id,"Manajemen Kapabilitas",$m)){
				$msg="Gagal mengirim email.";
			}else{
				$msg="Password dikirim ke $id";
			}
	}else{
		$msg="User ID/Email tidak valid";
	}
	
}

if($t=="houtlet"){
	$id=str_ireplace(" ","%",$_POST["id"]);
	$rs=exec_qry($conn,"select oid,oname from tm_outlets where oid like '%$id%' or oname like '%$id%'");
	$all=fetch_alla($rs);
	$msg=json_encode($all);
}
if($t=='cpolda'){
	$sql="select locid as v, locname as t from tm_kanwils order by locname";
	$rs=exec_qry($conn,$sql);
	$all=fetch_alla($rs);
	$msg=json_encode($all);
}
if($t=='cloc'){
	$id=$_POST["id"];
	$sql="select oid as v, oname as t from tm_outlets where kanwil='$id' order by oname";
	$rs=exec_qry($conn,$sql);
	$all=fetch_alla($rs);
	$msg=json_encode($all);
}
	
disconnect($conn);
echo $msg;
?>