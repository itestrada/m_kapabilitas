<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Survey";
$icon="fa fa-binoculars";
$menu="survey";

include 'inc.head.php';

$where="";

if($s_LVL==9){
	$where="uid='$s_ID'";
}

$tname="tm_surveys";
$cols="n,df,dt,rowid";
$colsrc="n";

$opt1="";

/*
include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
disconnect($conn);
*/
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
                                                <th>Survey</th>
                                                <th>From</th>
												<th>To</th>
												<th></th>
												
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
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="n,df,dt">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
									
								<div class="form-group">
									<label class="col-md-2 control-label">Survey Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="n" id="n" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">From</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm datepicker" name="df" id="df" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">To</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm datepicker" name="dt" id="dt" placeholder="...">
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
		
		
			<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
			<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		

		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>        
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
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
				//d.st= $("#fst").val(),
				//d.k= $("#fk").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "n" : {
            required : true
        },
		"df" : {
            required : true,
			date: true
        },
		"dt" : {
            required : true,
			date: true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

