<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Lokasi";
$icon="fa fa-map-marker";
$menu="outlet";

include 'inc.head.php';

$where="";
$tname="tm_outlets";
$cols="oid,oname,kanwil,ket,pic,contact,pic2,contact2,rowid";
$cols="oid,oname,kanwil,ket,sid,rowid";
$colsrc="oid,oname,kanwil,ket,sid";

$opt1="";

include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
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
					<a style="margin-right:5px;" href="#" onclick="openBatch('myff');" data-toggle="modal" data-target="#modal_file" class="btn btn-warning pull-right"><i class="fa fa-upload"></i> Import</a>
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
                                                <th>ID</th>
                                                <th>Name</th>
												<th>Gedung</th>
												<th>Keterangan</th>
												<th>SID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
		<div class="modal" id="modal_file" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myff">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="batch_<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname?>">
									<input type="hidden" name="columns" value="">
									<input type="hidden" id="svtf" name="svt" value="">
								
								<!--div class="form-group">
									<label class="col-md-2 control-label">File</label>
									<div class="col-md-10">
										<input type="file" class="form-control input-sm" name="uploaded_file" id="uploaded_file" placeholder="...">
										<br /><a target="_blank" href="sample_outlets.xls">Click Sample Upload File XLS 2003 Format</a>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">NIK</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="nik" id="nik" placeholder="...">
									</div>
								</div>
								<--div id="ccp" class="form-group">
									<label for="cp" class="col-md-2 control-label">Change Password</label>
									<div class="col-md-10">
										<input type="checkbox" value="Y" class="" name="cp" id="cp">
									</div>
								</div-->
								<div class="form-group">
									<label class="col-md-2 control-label">Data (<a target="_blank" href="sample_outlets.xls">Sample</a>)</label>
									<div class="col-md-10">
										<textarea class="form-control input-sm" rows="10" name="data" id="data" placeholder="..."></textarea>
									</div>
								</div>
								
								
							</div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button class="btn btn-success" type="button" onclick="sendData('#myff','ADD');">Add</button>
						<button class="btn btn-warning" type="button" onclick="sendData('#myff','REP');">Replace</button>
						<button class="btn btn-danger" type="button" onclick="sendData('#myff','DEL');">Delete</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                        
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
										<input type="hidden" name="columns" value="oid,oname,bw,kanwil,ipwan,iplan,ket,sid,pic,pic2,contact,contact2">
										<input type="hidden" id="svt" name="svt" value="">
										<input type="hidden" name="id" id="id" value="0">
										
									<div class="form-group">
										<label class="col-md-2 control-label">ID</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="oid" id="oid" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Name</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="oname" id="oname" placeholder="...">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">IP WAN</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="ipwan" id="ipwan" placeholder="...">
										</div>
										<label class="col-md-2 control-label">IP LAN</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="iplan" id="iplan" placeholder="...">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Bandwidth</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="bw" id="bw" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Gedung</label>
										<div class="col-md-4">
											<!--input type="text" class="form-control input-sm" name="kanwil" id="kanwil" placeholder="..."-->
											<select class="form-control" name="kanwil" id="kanwil">
											<?php echo $opt1?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Keterangan</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="ket" id="ket" placeholder="...">
										</div>
										<label class="col-md-2 control-label">SID</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="sid" id="sid" placeholder="...">
										</div>
										
									</div>
									<!--div class="form-group">
										<label class="col-md-2 control-label">PIC</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="pic" id="pic" placeholder="...">
										</div>
										<label class="col-md-2 control-label">PIC 2</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="pic2" id="pic2" placeholder="...">
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Contact 1</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="contact" id="contact" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Contact 2</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="contact2" id="contact2" placeholder="...">
										</div>
									</div-->
									
								</div>
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
        <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		<!-- END PLUGINS -->

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
				//d.sever= $("#sever").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "oid" : {
            required : true
        },
		"oname" : {
            required : true
        },
		"kanwil" : {
            required : true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

			function sendData(f,svt){	
			
				manage_msgs('start');
				$("#modal_no_head").modal('show');
				$("#svtf").val(svt);
				
				var url='datasave<?php echo $env;?>';
				var mtd='POST';
				var frmdata=$(f).serialize();
				
				//alert(frmdata);
				
				$.ajax({
					type: mtd,
					url: url,
					data: frmdata,
					success: function(data){
						$("#processing_msgs").html(data);
						manage_msgs('end');
					}
				});
				
			};
</script>
	
    </body>
</html>

