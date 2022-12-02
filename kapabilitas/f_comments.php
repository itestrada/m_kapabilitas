<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Comment";
$icon="fa fa-comments";
$menu="-";

include 'inc.head.php';

$where="";
$where2="";

if($s_LVL==9){
	$where="uid='$s_ID'";
	$where2="where locid in (select kanwil from tm_kanwilusers where user='$s_ID')";
	$menu="comment";
}

$tname="tm_comments";
$cols="lastupd,n,st,k,txt,rowid";
$colsrc="st,k";

$opt1="";


include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils $where2 order by locname");
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
				<?php if($s_LVL==9){?>
				<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                <?php }?>
				</div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
					<div class="row">
						<div class="col-md-12">
                            <div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-2">
											From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="fdf" name="fdf" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="fdt" name="fdt" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 control-label">Service<!--/div>
										<div class="col-md-2"-->
											<select class="form-control" id="fst">
											<option value="">All Service</option>
											<?php echo $optst?>
											</select>
										</div>
										<div class="col-md-2 control-label">Polda<!--/div>
										<div class="col-md-2"-->
											<select class="form-control" id="fk">
											<option value="">All Polda</option>
											<?php echo $opt1?>
											</select>
										</div>
										<div class="col-md-1"><br />
											<button type="button" class="btn btn-info pull-right" onclick="tblupdate();"><i class="fa fa-refresh"></i> Refresh</button>
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
                                                <th>On</th>
												<th>By</th>
												<th>Service</th>
                                                <th>Polda</th>
												<th>Comment</th>
												
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
									<input type="hidden" name="columns" value="st,n,k,txt,uid">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
									<input type="hidden" name="n" value="<?php echo $s_NAME;?>">
									<input type="hidden" name="uid" value="<?php echo $s_ID;?>">
									
								<div class="form-group">
									<label class="col-md-2 control-label">Service</label>
									<div class="col-md-10">
										<select name="st" id="st" class="form-control input-sm">
										<?php echo $optst?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Kanwil</label>
									<div class="col-md-10">
										<select name="k" id="k" class="form-control input-sm">
										<?php echo $opt1?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Comment</label>
									<div class="col-md-10">
										<textarea class="form-control input-sm" name="txt" id="txt" placeholder="..."></textarea>
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
        
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>        
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		
		<script src="js/plugins/datatables/dataTables.buttons.js"></script>
		<script src="js/plugins/datatables/buttons.flash.js"></script>
		<script src="js/plugins/datatables/jszip.min.js"></script>
		<script src="js/plugins/datatables/pdfmake.min.js"></script>
		<script src="js/plugins/datatables/vfs_fonts.js"></script>
		<script src="js/plugins/datatables/buttons.html5.js"></script>
		<script src="js/plugins/datatables/buttons.print.js"></script>

		<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">
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
				d.st= $("#fst").val(),
				d.k= $("#fk").val(),
				d.fdf= $("#fdf").val(),
				d.fdt= $("#fdt").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "st" : {
            required : true
        },
		"k" : {
            required : true
        },
		"txt" : {
            required : true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

