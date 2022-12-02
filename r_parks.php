<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Parkings";
$icon="fa fa-area-chart";
$menu="-";

include 'inc.head.php';

$where="";
$tname="ep_parks p left join ep_locations l on p.loc=l.locid";
$cols="pin,pout,plat,jk,locname,prc,tprc";
$colsrc="plat";

$opt1="";
$opt2='<option value="MOTOR">MOTOR</option><option value="MOBIL">MOBIL</option>';
$opt3='';
$opt4="";


include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from ep_locations order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
/*
$rs=exec_qry($conn,"select distinct paymentstatus from orders");
while($row=fetch_row($rs)){
	$opt2.="<option value='".$row[0]."'>".$row[0]."</option>";
}
$rs=exec_qry($conn,"select distinct ordertype from orders");
while($row=fetch_row($rs)){
	$opt3.="<option value='".$row[0]."'>".$row[0]."</option>";
}
*/
disconnect($conn);

?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="home.php">Home</a></li>
                    <li class="active"><?php echo $title;?></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
					
				</div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
				
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
									<div class="col-md-2">
										<select class="form-control" name="loc" id="loc">
										<option value="">All Location</option>
										<?php echo $opt1?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="jk" id="jk">
										<option value="">All Vehicle</option>
										<?php echo $opt2?>
										</select>
									</div>
									<div class="col-md-2">
										<div class="input-group">
                                            <input id="df" name="df" type="text" class="form-control datepicker" placeholder="From" value="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-md-2">
										<div class="input-group">
                                            <input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="To" value="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-md-2">
										<button class="btn btn-info" onclick="tblupdate()"><i class="fa fa-search"></i> Filter</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
												<th>IN</th>
												<th>OUT</th>
                                                <th>Plat</th>
                                                <th>Vehicle</th>
												<th>Location</th>
												<th>Rate/Hour</th>
												<th>Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

<?php
include 'inc.logout.php';
?>

    <!-- START SCRIPTS -->
        <!-- START PLUGINS --
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script-->
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		
		
<script src="js/plugins/datatables/dataTables.buttons.js"></script>
<script src="js/plugins/datatables/buttons.flash.js"></script>
<script src="js/plugins/datatables/jszip.min.js"></script>
<script src="js/plugins/datatables/pdfmake.min.js"></script>
<script src="js/plugins/datatables/vfs_fonts.js"></script>
<script src="js/plugins/datatables/buttons.html5.js"></script>
<script src="js/plugins/datatables/buttons.print.js"></script>

<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">
		
		<!--fancybox-->
	<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.3.4.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.fancybox-1.3.4.css" media="screen" />
	
        <!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
	var mytbl;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrf<t>Bip>',
	buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "desc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.loc= $("#loc").val(),
				d.jk= $("#jk").val(),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

