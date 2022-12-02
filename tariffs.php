<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Tariffs";
$icon="fa fa-tags";
$menu="tariff";

include 'inc.head.php';

$where="";
$tname="ep_tariff t left join ep_locations l on t.loc=l.locid";
$tnamex="ep_tariff";
$cols="locname,jk,ds,de,if(se='0','Regular','Special Event') as s,prc,if(isdaily='1','Daily','Hourly') as dh,t.rowid";
$colsrc="locname";

$opt1="";


include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from ep_locations order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
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
					<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Vehicle</th>
												<th>From</th>
												<th>To</th>
												<th>Type</th>
												<th>Rate</th>
                                                <th>Tariff</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myf">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tnamex;?>">
									<input type="hidden" name="columns" value="loc,jk,ds,de,se,prc">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group">
									<label class="col-md-2 control-label">Location</label>
									<div class="col-md-10">
										<select name="loc" id="loc" class="form-control input-sm">
										<?php echo $opt1?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Vehicle</label>
									<div class="col-md-10">
										<select name="jk" id="jk" class="form-control input-sm">
										<option value="MOTOR">MOTOR</option>
										<option value="MOBIL">MOBIL</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">From</label>
									<div class="col-md-10">
										<div class="input-group">
                                            <input id="ds" name="ds" type="text" class="form-control datepicker" placeholder="" value="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">To</label>
									<div class="col-md-10">
										<div class="input-group">
                                            <input id="de" name="de" type="text" class="form-control datepicker" placeholder="" value="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Type</label>
									<div class="col-md-10">
										<select name="se" id="se" class="form-control input-sm">
										<option value="0">Regular</option>
										<option value="1">Special Event</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Rate</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="prc" id="prc" placeholder="...">
									</div>
								</div>
							</div>
							<div class="panel-body" id="pesan"></div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		<!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
	var mytbl, jvalidate;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrf<t>ip>',
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				//d.sever= $("#sever").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "loc" : {
            required : true
        },
		"jk" : {
            required : true
        },
		"ds" : {
            required : true
        },
		"de" : {
            required : true
        },
		"se" : {
            required : true
        },
		"prc" : {
            required : true,
			number : true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

