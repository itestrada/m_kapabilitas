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

<form class="uk-form" method="post" action="md_bi_save.php">
<input type="hidden" name="sv" value="NEW">
    <fieldset data-uk-margin>
		Table<br />
		<select name="tname">
			<option value="tm_tickets">tm_tickets (please use small number for rowid)</option>
		</select><br /><br />
		Data  - copy paste from <a target="_blank" href="tm_tickets.xlsx">excel</a> <font color="red">(1st row = field name)</font><br />
		<textarea name="data" rows="10" cols="150"></textarea><br />
        <button type="button" onclick="this.form.sv.value='NEW';this.form.submit();" class="uk-button uk-button-success uk-icon-plus"> Add</button>
		<button type="button" onclick="this.form.sv.value='REP';this.form.submit();" class="uk-button uk-button-success uk-icon-exchange"> Update (first col=ID)</button>
		<button type="button" onclick="this.form.sv.value='DEL';this.form.submit();" class="uk-button uk-button-danger uk-icon-trash"> Delete (ID)</button>
    </fieldset>
</form>		
<br />
            
			<hr class="uk-grid-divider">
			
			
		</div>
 
 	</body>
 
</html>
