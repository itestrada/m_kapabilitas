<?php
include "inc.chksession.php";
include "inc.common.php";
include "inc.db.php";

//error_reporting(E_ERROR);
//ini_set('display_error',1);
//set_time_limit(60*5);

//excel 2003 loader
require "excel_reader.php";

include 'inc.sendmail.php';

function crud($conn,$fcols="",$fvals=""){
	$s_ID=$_SESSION['s_ID'];
	$id=$_POST['id'];
	$table=$_POST['tname'];
	$columns=$_POST['columns'];
	$acols = explode(",",$columns);
	$msg="Data has been saved";
	$sql="";
	$proc="insert";
	
	$afcols = explode(",",$fcols);
	$afvals = explode(",",$fvals);
	
	if($id=="0"){
		for($i=0;$i<count($acols);$i++){
			$sql.=$sql==""?"":",";
			$val=isset($_POST[$acols[$i]])?post($_POST[$acols[$i]],$conn):'';
			$sql.="'".$val."'";
		}
		$columns.=$fcols==""?"":",$fcols";
		$sql.=$fvals==""?"":",$fvals";
		$sql="insert into $table ($columns,lastupd,updby) values ($sql,now(),'$s_ID')";
	}else{
		$addcomma=false;
		for($i=0;$i<count($acols);$i++){
			if(isset($_POST[$acols[$i]])){
				$sql.=$addcomma?",":"";
				$sql.=$acols[$i]."='".post($_POST[$acols[$i]],$conn)."'";
				$addcomma=true;
			}
		}
		for($i=0;$i<count($afcols);$i++){
			$sql.=$sql!=""&&$afcols[$i]!=""?",":"";
			$sql.=$afcols[$i]==""?"":$afcols[$i]."=".$afvals[$i]."";
		}
		$proc="update";
		$sql="update $table set $sql,lastupd=now(),updby='$s_ID' where rowid=$id";
	}
	if($_POST['svt']=="DEL"){
		$proc="delete";
		$sql="delete from $table where rowid=$id";
		$msg="Data has been deleted";
	}
		
		$rs=exec_qry($conn,$sql);
		if(db_error($conn)!=""){
			$msg=db_error($conn);
			//echo count($afcols);
		}else{
			$xsql=base64_encode($sql);
			//$rs=exec_qry($conn,"insert into cms_logs values (null,'$table','$proc','$s_ID',now(),'$xsql')");
		}
	return $msg;
}
function process_file($svt,$fileinput,$lnk="",$dir=""){
		$file_path = "";
		$file_name = "";
		if(isset($_FILES[$fileinput])){
			$file_name = basename($_FILES[$fileinput]['name']);
			$fileInfo = pathinfo($_FILES[$fileinput]['name']);
			//$file_path = $file_path . 'reference_' . $nip . "." . $fileInfo['extension'];
			//$file_name = date('Ymdhis');
			if($file_name!=""){
				$file_name = date('Ymdhis'). "_". $file_name;
				$file_path = $dir .  $file_name;
			}
		}
		if($svt!="DEL"){
			if($file_path!=""){
				if(file_exists($file_path)){
					unlink($file_path);
				}
				/*if($lnk!=""){
					if(file_exists($lnk)){
						unlink($lnk);
						$lnk="";
					}
				}*/
				if(!move_uploaded_file($_FILES[$fileinput]['tmp_name'], $file_path)) {
					$file_path=$lnk;
				}
			}else{
				$file_path = $lnk;
			}
		}else{
			$file_path=$lnk;
			if($file_path!="" && file_exists($file_path)){
				unlink($file_path);
				$file_path="";
			}
		}
		return $file_path;
}

function load_excel($jenis,$file,$col,$conn,$tname,$pk="",$replace=false){
		$s_ID=$_SESSION['s_ID'];
		
		$data = new Spreadsheet_Excel_Reader($file,false);
		//    menghitung jumlah baris file xls
		$baris = $data->rowcount($sheet_index=0);
		//build cols
		$cols="";$pkeys=array();
		$pks=explode(',',$pk);
		for($j=0;$j<$col;$j++){
			$cols.=($cols=="")?$data->val(1,$j):",".$data->val(1,$j);
			if(in_array($data->val(1,$j),$pks)){$pkeys[]=$j;}
		}
		$acols=explode(",",$cols);
		$tot=0; $ins=0; $upd=0; $err=0; $eline=""; $skip=0;
		$msg="";
		for($i=2;$i<=$baris;$i++){
			$tot++;
			//build val
			$vals=""; $uvals=""; $where="";
			for($j=1;$j<$col;$j++){
				$vals.=($vals=="")?"'".post($data->val($i,$j),$conn)."'":",'".post($data->val($i,$j),$conn)."'";
				$uvals.=($uvals=="")?$acols[$j-1]."='".post($data->val($i,$j),$conn)."'":",".$acols[$j-1]."='".post($data->val($i,$j),$conn)."'";
			}
			$sql="insert into $tname ($cols,lastupd,updby) values ($vals,now(),'$s_ID')";
			//$msg.=$sql."<br>";
			$rs=exec_qry($conn,$sql);
			if(affected_row($conn)>0){
				$ins++;
			}else{
				if($replace&&count($pkeys)>0){
					$u=false;
					$w='';
					for($k=0;$k<count($pkeys);$k++){
						$w.=$w==''?$pks[$k]."='".post($data->val($i,$pkeys[$k]),$conn)."'":" and ".$pks[$k]."='".post($data->val($i,$pkeys[$k]),$conn)."'";
					}
					$sql="update $tname set $uvals, lastupd=now(), updby='$s_ID' where $w";
					//$msg.=$sql;
					$rs=exec_qry($conn,$sql);
					if(affected_row($conn)>0){
						$upd++;$u=true;
					}
				}
				if(db_error($conn)!=""){$err++; $eline.=$eline==""?($i-1)."-".db_error($conn):", ".($i-1)."-".db_error($conn);}else{if(!$u){$skip++;}}
				//if(db_error($conn)!=""){$err++; $eline.=$eline==""?($i-1):", ".($i-1);}else{if(!$u){$skip++;}}
			}
			//$msg.=$sql."<br>";
		}
		//$rem=$eline==""?"":"Error Line : $eline";
		//$afile=explode("/",$file);
		//$sq="insert into load_data (jenis,file,dtmstart,dtmend,tot,ins,upd,skp,err,rem) values ('$jenis','".$afile[1]."','$mulai',now(),$tot,$ins,$upd,$skip,$err,'$rem')";
		//$rs=exec_qry($conn,$sq);
		$msg.="Total Read=$tot , Inserted=$ins , Updated=$upd , Skipped:$skip , Error=$err (Line : $eline)";
	return $msg;
}

function multiple_select($f){
	$return="";
	for($i=0;$i<count($_POST[$f]);$i++){
		$return.=$return==""?"":";";
		$return.=$_POST[$f][$i];
	}
	return $return;
}

function post($field,$theconn=null){
	//$return = isset($_POST[$field])?$_POST[$field]:"";
	return $theconn==null?$field:esc_str($theconn,$field);
}

$conn=connect();

$msg="Invalid command.";
$t=$_POST['t'];

if($t=="cpwd"){
	$new=$_POST['new'];
	$old=$_POST['old'];
	$ret=$_POST['ret'];
	if($ret!=""&&$old!=""&&$new!=""){
		if($ret==$new){
			$sql="update tm_users set userpwd=md5('$new') where userid='$s_ID' and userpwd=md5('$old')";
			$rs=exec_qry($conn,$sql);
			if(affected_row($conn)>0){
				$msg="Password changed.";
			}else{
				$msg="Invalid old password.";
			}
		}else{
			$msg="New password and re-type password doesnt match.";
		}
	}else{
		$msg="Old/New/Re-Type password could not blank.";
	}
}
if($t=="users"){
	$userpwd=$_POST["userpwd"]==""?"":"userpwd";
	$pwd=$_POST["userpwd"]==""?"":"md5('".$_POST["userpwd"]."')";
	
	$msg=crud($conn,$userpwd,$pwd);
}
if($t=="profile"){
	$msg=crud($conn);
}


if($t=="mobileuser"){
	$pwd=($_POST['hupwd']=="")?"":"upwd";
	$vpwd=($_POST['hupwd']=="")?"":"md5('".$_POST['hupwd']."')";
	$msg=crud($conn,$pwd,$vpwd);
}
if($t=="kanwil"){
	$msg=crud($conn);
}
if($t=="outlet"){
	$msg=crud($conn);
}
if($t=="ips"){
	$msg=crud($conn);
}
if($t=="kanwiluser"){
	$msg=crud($conn);
}
if($t=="problem"){
	$msg=crud($conn);
}
if($t=="notify"){
	$msg=crud($conn);
}
if($t=="comment"){
	$msg=crud($conn);
}
if($t=="forum"){
	$msg=crud($conn);
}
if($t=="survey"){
	$msg=crud($conn);
}
if($t=="surveyd"){
	$msg=crud($conn);
}
if($t=="surveydeu"){
	$msg="Data has been saved";
	$cnt=$_POST['cnt']; $id=$_POST['id'];$uid=$_POST['uid'];
	$rs=exec_qry($conn,"delete from tm_surveyresult where survid='$id' and uid='$uid'");
	for($i=1;$i<=$cnt;$i++){
		$qid=$_POST['key_'.$i];
		$val=isset($_POST['val_'.$i])?$_POST['val_'.$i]:"0";
		$sql="insert into tm_surveyresult (survid,qid,v,uid,lastupd,updby) values ('$id','$qid','$val','$uid',now(),'$s_ID')";
		$rs=exec_qry($conn,$sql);
		//echo $sql;
	}
	if(db_error($conn)!=""){
		$msg=db_error($conn);
	}
}
if($t=="ticket"){
	if(isset($_POST['jp'])){
		$jp=multiple_select("jp");
		//$msg=$jp;
		$msg=crud($conn,"jp","'$jp'");
	}else{
		$msg=crud($conn);
	}
}

if($t=="batch_outletx"){
	$col=13;
	$pk="oid";
	$tname=$_POST['tname'];
	$update=true;//isset($_POST['update'])?true:false;
	$file=process_file('SAVE',"uploaded_file","","tmps/");
	$msg="";
	if($file){
		$msg=load_excel('Outlets',$file,$col,$conn,$tname,$pk,$update);
	}else{
		$msg="File Upload failed.";
	}
}
if($t=="batch_outlet"){
	$msg="hokeee";
	$msg="";
	
	$data=explode("\r\n",$_POST['data']);
	$tname=$_POST['tname'];

	//echo count($data);
	$tot=0;
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	$inserted=0;
	$error=0;
	$deleted=0;
	$updated=0;

	for($i=1;$i<count($data)-1;$i++){

		$aval=explode("	",$data[$i]);

		if($_POST['svt']=="DEL"){
			$sql="delete from $tname where ".$acol[0]."='".$aval[0]."')";
			$result = exec_qry($conn,$sql);
			if(db_error($conn)<>""){
				//$msg .= $sql.";<br>";
				$msg .= "ERROR Line ".$i." : ".db_error($conn)."<br>";
				$error++;
			}else{
				$deleted+=affected_row($conn);
			}
		}

		if($_POST['svt']=="REP"){
			$ucols="";
			for($j=1;$j<count($aval);$j++){
				if($ucols!=""){$ucols.=",";}
				$ucols.=$acol[$j]."='".$aval[$j]."'";
			}
			$sql="update $tname set $ucols where ".$acol[0]."='".$aval[0]."'";
			$result = exec_qry($conn,$sql);
			if(db_error($conn)<>""){
				//$msg .= $sql.";<br>";
				$msg .= "ERROR Line ".$i." : ".db_error($conn)."<br>";
				$error++;
			}else{
				$updated+=affected_row($conn);
			}
		}

		if($_POST['svt']=="ADD"){
			$val=str_replace("	","','",$data[$i]);
			$sql="insert into $tname (".$columns.") values ('".$val."')";
			$result = exec_qry($conn,$sql);
			if(db_error($conn)<>""){
				//$msg .= $sql.";<br>";
				$msg .= "ERROR Line ".$i." : ".db_error($conn)."<br>";
				$error++;
			}else{
				$inserted++;
			}
		}
	}
	$i--;
	$msg .= "<br> Total Read : $i <br> Deleted : $deleted <br> Updated : $updated <br> Inserted : $inserted <br> Error : $error <br>";

}
if($t=="batch_ips"){
	$col=6;
	$pk="oid,layanan";
	$tname=$_POST['tname'];
	$update=true;//isset($_POST['update'])?true:false;
	$file=process_file('SAVE',"uploaded_file","","tmps/");
	$msg="";
	if($file){
		$msg=load_excel('IPs',$file,$col,$conn,$tname,$pk,$update);
	}else{
		$msg="File Upload failed.";
	}
}

if($t=="maintenances"){
	$msg=crud($conn,"dtm,createdby","now(),'$s_ID'");
}
if($t=="tickets"){
	if($_POST['id']=="0"){
		$i=$_POST['i'];
		//$typ=$_POST['typ'];
		//$st=$_POST['st'];
		//$grp=$_POST['grp'];
		$sql="select ticketno,s from tm_tickets where i='$i' and s<>'closed'";// and
			//timestampdiff(minute,date_format(dtm,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))<=120";
		$rs=exec_qry($conn,$sql);
		if($row=fetch_row($rs)){
			$msg="Ticket #".$row[0]." already existed<br />Location # $i status ".$row[1];
		}else{
			$rid=date("YmdHis");
			$d=$_POST['d'];
			$dt=($_POST['dt']=='')?"now()":"'".$_POST['dt']."'";
			$msg=crud($conn,"rowid,ticketno,dtm,createdby,dt","'$rid','$rid',now(),'$s_ID',$dt");
			if($msg=='Data has been saved'){
				//send_mail to/subj/msg
				$m="Hello,<br />New ticket created with # $rid <br /><p>$d</p><br /><br />Rgds,<br />admin";
				if(!send_mail("hafied.fajar@matrik.co.id","Manajemen Kapabilitas : New ticket $rid",$m)){
					$msg.=".<br />Send mail failed.";
				}else{
					$msg.=".<br />Mail sent.";
				}
			}
		}
	}else{
		$msg=crud($conn);
	}
}
if($t=="notes"){
	$fattc = process_file($_POST['svt'],"fattc",'',"uploads/");
	$msg=crud($conn,"attc","'$fattc'");
}
if($t=="forumd"){
	$fattc = process_file($_POST['svt'],"fattc",'',"uploads/");
	$msg=crud($conn,"attc","'$fattc'");
}

disconnect($conn);

echo $msg;
?>