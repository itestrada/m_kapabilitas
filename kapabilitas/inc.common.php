<?php
$env=".php";
$app="Manajemen Kapabilitas ";

$saya = 'style="margin-right:5px;margin-left:25px;"';
$bukansaya = 'style="margin-left:5px;margin-right:25px;"';

$media=true;
$forum=true;
$survey=false;
$feedback=false;
$anonfeedback=false;
$anonsurvey=false;
$menuloaded=false;

$onetofive=array("1"=>"Very Bad","2"=>"Bad","3"=>"Average","4"=>"Good","5"=>"Very Good");
$onetothree=array("1"=>"Bad","2"=>"Average","3"=>"Good");
$onetoten=array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10");
$surveyopt=array("1-3"=>$onetothree,"1-5"=>$onetofive,"1-10"=>$onetoten);

$optsurvey="<option value='1-3'>1-3 score</option><option value='1-5'>1-5 score</option><option value='1-10'>1-10 score</option>";

$homewidget="('offline','keluhan lambat','link up-down','link intermitten','ganti IP WAN ke LAN','ganti IP LAN ke WAN')";
$homewidget2="('pengecekan router','pengecekan switch','pengecekan ip phone')";

$r_templates=array(
			array("0","Relokasi","tm_tickets",
			"Tanggal,Jam,Kode,Nama,Polda,Layanan,#,Pelaksanaan,Status,Selesai,Ket",
			"date(dt) as d,time(dt) as t,i,h,k,st,ticketno,tp,s,closed,solving,ticketno","typ='relokasi'"), // id,title,tbl,caps,cols,where
			array("1","PSB","tm_tickets",
			"Tanggal,Jam,Kode,Nama,Polda,Layanan,#,Pelaksanaan,Status,Selesai,Ket",
			"date(dt) as d,time(dt) as t,i,h,k,st,ticketno,tp,s,closed,solving,ticketno","typ='psb'"),
			array("2","Gangguan","tm_tickets",
			"Tanggal,Jam,Nama,Polda,Layanan,Problem,#,Penyebab,Perbaikan,Selesai,Total,Sec.Link,W,W/O",
			"date(dt) as d,time(dt) as t,h,k,st,d,ticketno,p,solving,closed,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,ticketno","typ in $homewidget"),
			array("3","Migrasi","tm_tickets",
			"Tanggal,Jam,Kode,Nama,Polda,Layanan,#,Pelaksanaan,Status,Selesai,Ket",
			"date(dt) as d,time(dt) as t,i,h,k,st,ticketno,tp,s,closed,solving,ticketno","typ='migrasi'")
			);

			

$optgrp="<option value='link'>link</option><option value='cpe'>cpe</option><option value='aplikasi'>aplikasi</option>";
$opttyp="
<option value='offline'>offline</option>
<option value='keluhan lambat'>keluhan lambat</option>
<option value='link up-down'>link up-down</option>
<option value='link intermitten'>link intermitten</option>
<option value='ganti IP WAN ke LAN'>ganti IP WAN ke LAN</option>
<option value='ganti IP LAN ke WAN'>ganti IP LAN ke WAN</option>
<option value='migrasi'>migrasi</option>
<option value='psb'>psb</option>
<option value='relokasi'>relokasi</option>
<option value='reposisi modem'>reposisi modem</option>
<option value='vsat reposisi'>vsat reposisi</option>
<option value='vpn reposisi'>vpn reposisi</option>
<option value='fo reposisi'>fo reposisi</option>
<option value='pengecekan router'>pengecekan router</option>
<option value='pengecekan switch'>pengecekan switch</option>
<option value='pengecekan ip phone'>pengecekan ip phone</option>
";
$optjp="
<option value='router'>router</option>
<option value='switch'>switch</option>
<option value='juniper'>juniper</option>
<option value='ip phone'>ip phone</option>
<option value='handset ip phone'>handset ip phone</option>
<option value='adaptor ip phone'>adaptor ip phone</option>
<option value='adaptor router'>adaptor router</option>
";
$optst="
<option value='vpn'>vpn</option>
<option value='vsat'>vsat</option>
<option value='m2m'>m2m</option>
<option value='astinet'>astinet</option>
<option value='vicon'>vicon</option>
<option value='wifi station'>wifi station</option>
<option value='router/switch/ip-phn'>router/switch/ip phone</option>
";

$optblink="
<option value='-'>-</option>
<option value='m2m'>m2m</option>
";

function array_to_radio($id,$hidden,$arr){
	$return="";
	$return .= '<input type="hidden" name="key_'.$id.'" value="'.$hidden.'">';
	foreach($arr as $key=>$val){
		$return .= '<input type="radio" name="val_'.$id.'" value="'.$key.'">&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	return $return;
}
?>
