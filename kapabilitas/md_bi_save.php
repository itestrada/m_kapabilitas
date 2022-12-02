<?php
include 'inc.chksession.php';
?>
<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BAST Batch Input</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="uikit/css/uikit.docs.min.css">
		<link rel="stylesheet" href="datatables/css/jquery.dataTables.min.css">
		
		<script src="vendor/jquery.js"></script>
        <script src="uikit/js/uikit.min.js"></script>
		<script src="datatables/js/jquery.dataTables.min.js"></script>
		
    </head>
 
    <body>
 
        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
 

<div><h3>Batch Input<h3></div>

<hr class="uk-grid-divider">

<?php
include 'inc.db.php';

$sv=$_POST['sv'];
$tname=$_POST['tname'];
$data=explode("\r\n",$_POST['data']);

//echo count($data);

$conn = connect();

$columns=str_replace("	",",",$data[0]);
$acol=explode(",",$columns);

$inserted=0;
$error=0;

for($i=1;$i<count($data)-1;$i++){

$aval=explode("	",$data[$i]);
if($sv=="DEL"){
	$sql="delete from $tname where ".$acol[0]."='".$aval[0]."'";
	$result = exec_qry($conn,$sql);
}
if($sv=="REP"){
	$s="";
	for($j=1;$j<count($aval);$j++){
		if($s!=""){
			$s.=",";
		}
		$s.=$acol[$j]."='".$aval[$j]."'";
	}
	$sql="update $tname set $s where ".$acol[0]."='".$aval[0]."'";
	$result = exec_qry($conn,$sql);
}
if($sv=="NEW"){
	$val=str_replace("	","','",$data[$i]);
	$sql="insert into $tname (".$columns.") values ('".$val."')";
	//echo $sql.";<br>";
	$result = exec_qry($conn,$sql);
}
//echo $i."<br>";
if(db_error($conn)<>""){
	echo $sql.";<br>";
	echo "ERROR : ".db_error($conn)."<br>";
	$error++;
}else{
	$inserted++;
}
}
$i--;
echo "<br><br> Total : $i <br> Inserted/Updated/Deleted : $inserted <br> Error : $error <br>";

disconnect($conn);

?>

Done.

<br /><br />
<button onclick="history.go(-1);">Back</button>
<hr class="uk-grid-divider">
			
		</div>
 
 	</body>
 
</html>
