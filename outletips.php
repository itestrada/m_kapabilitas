<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="IP";
$icon="fa fa-tty";
$menu="ips";

include 'inc.head.php';

$where="";
$tname="tm_ips";
$tnames="tm_ips i left join tm_outlets o on o.oid=i.oid";
$cols="i.oid,oname,kanwil,area,i.layanan,i.sid,i.iplan,i.ipwan,i.rowid";
$colsrc="i.oid,oname,kanwil,area";

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
					<a style="margin-right:5px;" href="#" onclick="openBatch('myff');" data-toggle="modal" data-target="#modal_file" class="btn btn-warning pull-right"><i class="fa fa-upload"></i> Upload</a>
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
												<th>Polda</th>
												<th>Area</th>
												<th>Layanan</th>
												<th>SID</th>
												<th>IP LAN</th>
												<th>IP WAN</th>
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
									<input type="hidden" id="svtf" name="svtf" value="">
								
								<div class="form-group">
									<label class="col-md-2 control-label">File</label>
									<div class="col-md-10">
										<input type="file" class="form-control input-sm" name="uploaded_file" id="uploaded_file" placeholder="...">
										<br /><a target="_blank" href="sample_ips.xls">Click Sample Upload File XLS 2003 Format</a>
									</div>
								</div>
								<!--div class="form-group">
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
							</div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="sendDataFile('#myff','SAVE')">Save</button>
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
										<input type="hidden" name="columns" value="oid,ipwan,iplan,sid,layanan">
										<input type="hidden" id="svt" name="svt" value="">
										<input type="hidden" name="id" id="id" value="0">
										
									<div class="form-group">
										<label class="col-md-2 control-label">ID</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="oid" id="oid" placeholder="...">
										</div>
										<label class="col-md-2 control-label">SID</label>
										<div class="col-md-4">
											<input type="text" class="form-control input-sm" name="sid" id="sid" placeholder="...">
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
										<label class="col-md-2 control-label">Jenis Layanan</label>
										<div class="col-md-4">
											<select class="form-control" name="layanan" id="layanan" style="-webkit-appearance: menulist;">
											<?php echo $optst?>
											</select>
										</div>
									</div>
									
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
				d.tname= '<?php echo base64_encode($tnames); ?>',
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

</script>
	
    </body>
</html>

