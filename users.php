<?php
include 'inc.chksession.php';
include 'inc.common.php';
if($s_LVL>1){
	header("Location: home.php");
}
$title="Users";
$icon="fa fa-users";
$menu="users";

include 'inc.head.php';

$opt1="<option value=''>all</option><option value='wm'>warehouse management</option>
<option value='slsprs'>sales person</option><option value='slsadm'>sales admin</option><option value='slssup'>sales support</option>
$optusropr
<option value='oprmgmt'>OPR Management</option><option value='oprmain'>OPR Maintenance</option>";

$opt2="<option value='6'>user</option><option value='0'>super</option>";

$where="";
$wherex="";
if($s_LVL>0){
	$where=" usergrp='$s_GRP' and userid<>'$s_ID'";
	$wherex=" where grp='$s_GRP'";
	$opt2="<option value='3'>operator</option>";
}
$tname="custom_users";
$cols="userid,username,usermail,usergrp,rowid";
$colsrc="userid,username";

/*
include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select grp from custom_menus $wherex");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[0].'</option>';
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
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Mail</th>
												<th>Group</th>
												<th width="220px"></th>
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
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group">
									<label for="userid" class="col-md-2 control-label">ID</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="userid" id="userid" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-md-2 control-label">Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="username" id="username" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userlvl" class="col-md-2 control-label">Level</label>
									<div class="col-md-10">
										<select class="form-control" name="userlevel" id="userlevel">
										<?php echo $opt2;?>
										</select>
										<!--input type="text" class="form-control input-sm" name="userlevel" id="userlevel" placeholder="..."-->
									</div>
								</div>
								<div class="form-group">
									<label for="usergrp" class="col-md-2 control-label">Group</label>
									<div class="col-md-10">
										<select class="form-control" name="usergrp" id="usergrp">
											<?php echo $opt1;?>
										</select>
										<!--input type="text" class="form-control input-sm" name="usergrp" id="usergrp" placeholder="..."-->
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-2 control-label">Mail</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="usermail" id="usermail" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userpwd" class="col-md-2 control-label">Password</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="userpwd" id="userpwd" placeholder="...">
									</div>
								</div>
								<div id="ccp" class="form-group">
									<label for="cp" class="col-md-2 control-label">Is Active</label>
									<div class="col-md-10">
										<select name="isactive" id="isactive">
										<option value=""></option>
										<option value="N">N</option>
										<option value="Y">Y</option>
										</select>
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
        "userid" : {
            required : true
        },
		"username" : {
            required : true
        },
		"userlevel" : {
            required : true
        },
		"usergrp" : {
            required : false
        },
		"usermail" : {
            required : false,
			email : true
        },
		"userpwd" : {
            required : function(element) {
						if ($("#id").val() > 0) {
							return false;
						}
						else {
							return true;
						}
			}
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

