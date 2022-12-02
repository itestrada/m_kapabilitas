<?php
include 'inc.chksession.php';
include 'inc.common.php';
$title="Change Profile";
include 'inc.head.php';

$icon="fa fa-magic";

$menu="cpwd";

include 'inc.db.php';

$opt1=$optgrp;
$opt2="<option value='0'>super</option><option value='4'>PIC</option><option value='5'>Engineer</option><option value='3'>Helpdesk</option><option value='2'>Supervisor</option><option value='6'>Supplier</option>";

$polda='';
$conn=connect();
$rs=exec_qry($conn,"select kanwil from tm_outlets where oid='$s_LOC'");
if($row=fetch_row($rs)) $polda=$row[0];
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
                    
                    <div class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form id="myfnm">
									<div class="col-md-4">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input title="ID" class="form-control" type="text" name="uid" value="<?php echo $s_ID;?>" disabled><br />
									<input title="Name" class="form-control" type="text" name="uname" value="<?php echo $s_NAME;?>" disabled><br />
									<input title="Old Password" class="form-control" type="password" name="old" value="" placeholder="Old Password"><br />
									<input title="New Password" class="form-control" type="password" name="new" value="" placeholder="New Password"><br />
									<input title="Re-Type Password" class="form-control" type="password" name="ret" value="" placeholder="Re-Type Password"><br />
									<button type="button" class="btn btn-success" onclick="sendData('#myf');">Submit</button>
									<br /><br/><div id="pesan"></div>
									</div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
						<div class="col-md-6">
							<div  class="row">
								<div class="col-md-10">
								
									<form class="form-horizontal" id="myf">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									
								<div class="form-group">
									<label for="userid" class="col-md-3 control-label">ID</label>
									<div class="col-md-9">
										<input type="text" readonly class="form-control input-sm" name="uid" value="<?php echo $s_ID?>" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-md-3 control-label">Name</label>
									<div class="col-md-9">
										<input type="text" readonly class="form-control input-sm" value="<?php echo $s_NAME?>" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userpwd" class="col-md-3 control-label">Old Password</label>
									<div class="col-md-9">
										<input type="password" class="form-control input-sm" name="old" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userpwd" class="col-md-3 control-label">New Password</label>
									<div class="col-md-9">
										<input type="password" class="form-control input-sm" name="new" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userpwd" class="col-md-3 control-label">Re-Type Password</label>
									<div class="col-md-9">
										<input type="password" class="form-control input-sm" name="ret" placeholder="...">
									</div>
								</div>
							</div>
							<div class="panel-footer"><div class="pull-right">
							<button type="button" class="btn btn-warning" onclick="sendData('#myf');">Change Password</button>
							</div></div>
							</div>
						</form>
							
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-10">
									
									<form class="form-horizontal" id="myf2">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="profile">
									<input type="hidden" name="tname" value="tm_users">
									<input type="hidden" id="svt" name="svt" value="SAVE">
									<input type="hidden" name="columns" value="username,usermail,userphone,userloc">
									<input type="hidden" name="id" id="rowid" value="">
									
								<div class="form-group">
									<label for="userid" class="col-md-3 control-label">ID</label>
									<div class="col-md-9">
										<input type="text" readonly class="form-control input-sm" name="userid" id="userid" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-md-3 control-label">Name</label>
									<div class="col-md-9">
										<input type="text" class="form-control input-sm" name="username" id="username" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-3 control-label">Mail</label>
									<div class="col-md-9">
										<input type="text" class="form-control input-sm" name="usermail" id="usermail" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-3 control-label">Phone</label>
									<div class="col-md-9">
										<input type="text" class="form-control input-sm" name="userphone" id="userphone" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-3 control-label">Polda</label>
									<div class="col-md-9">
										<select class="form-control" name="polda" id="polda" onchange="getCombo('cloc','#userloc',this.value);">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-3 control-label">Location</label>
									<div class="col-md-9">
										<select class="form-control" name="userloc" id="userloc">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="userlvl" class="col-md-3 control-label">Level</label>
									<div class="col-md-9">
										<select class="form-control" disabled name="userlevel" id="userlevel">
										<?php echo $opt2;?>
										</select>
										<!--input type="text" class="form-control input-sm" name="userlevel" id="userlevel" placeholder="..."-->
									</div>
								</div>
								<div class="form-group">
									<label for="usergrp" class="col-md-3 control-label">Group</label>
									<div class="col-md-9">
										<select class="form-control" disabled name="usergrp" id="usergrp">
											<option value="">All</option>
											<?php echo $opt1;?>
										</select>
										<!--input type="text" class="form-control input-sm" name="usergrp" id="usergrp" placeholder="..."-->
									</div>
								</div>
								
								<!--div class="form-group">
									<label for="usermail" class="col-md-3 control-label">Location</label>
									<div class="col-md-9">
										<div class="input-group">
										<input type="text" class="form-control input-sm" name="userloc" id="userloc" placeholder="...">
										<span onclick="getOutlet();" class="input-group-addon add-on"><i class="fa fa-check"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-3 control-label">Location Name</label>
									<div class="col-md-9">
										<input type="text" readonly class="form-control input-sm" name="oname" id="oname" placeholder="...">
									</div>
								</div-->
							</div>
							<div class="panel-footer"><div class="pull-right">
							<button type="button" class="btn btn-info" onclick="if($('#myf2').valid()){sendData('#myf2');}">Update My Profile</button>
							</div></div>
							</div>
							</div>
						</form>
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
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
var jvalidate;
$(document).ready(function (){
	$("#userloc").keydown(function (e){
			var keycode = (e.keyCode ? e.keyCode : e.which);
			if (keycode == '13' || keycode == '9') {
				if($('#userloc').val()!="") getOutlet();
			}else{
				$("#oname").val("");
			}
		});
		
	$("#userlevel").val("<?php echo $s_LVL?>");
	$("#usergrp").val("<?php echo $s_GRP?>");
	
	jvalidate = $("#myf2").validate({
		rules :{
			"userid" : {
				required : true
			},
			"username" : {
				required : true
			},
			"userloc" : {
				required : function(element){
					return $("#userlevel").val()=="4";
				}
			},
			"polda" : {
				required : function(element){
					return $("#userlevel").val()=="4";
				}
			},
			"userphone" : {
				required : true
			},
			"oname" : {
				required  : function(element){
					return $("#userlevel").val()=="4"||$("#userloc").val()!="";
				}
			},
			"usermail" : {
				required : true,
				email : true
			}
		}});
		
	get_profile();
});

	
function initLoc(){
	getCombo("cloc","#userloc",$("#polda").val(),"<?php echo $s_LOC?>");
}
function get_profile(){
	$.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'profile',id:'0'},
		success: function(data){
			var json=JSON.parse(data);
			$.each(json[0],function (key,val){
				$('#'+key).val(val);
			});
			//if($('#userloc').val()!="") getOutlet();
			getCombo("cpolda","#polda","","<?php echo $polda?>");
		}
	});
}

function sendData(f){	
	manage_msgs('start');
	$("#modal_no_head").modal('show');
	
	var url='datasave.php';
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

function getOutlet(){
	var url='register.php';
	var mtd='POST';
	var frmdata={t:'houtlet',id:$('#userloc').val()};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			if(json.length<1){
				alert('Data not found');
			}else{
				//getIP();
				if(json.length>1){
					var lst="";
					for(var i=0;i<json.length;i++){
						$.each(json[i],function (key,val){
							if(key=='oname'){lst+=val+",";}
						});
					}
					alert('Hasil lebih dari 1 lokasi ('+lst+') mohon lebih spesifik.');
				}else{
					$.each(json[0],function (key,val){
						$('#'+key).val(val);
						if(key=='oid'){$('#userloc').val(val);}
					});
				}
			}
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}

function getCombo(q, fld, id="", x=""){ //q, field, id, selected
	var url='register.php';
	var mtd='POST';
	var frmdata={t:q,id:id};
	
	//alert(frmdata);
	
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			console.log(json);
			$(fld).find('option').remove();
			var s='<option value=""></option>';
			for(i=0;i<json.length;i++){
				v="";t="";
				$.each(json[i],function (key,val){
					if(key=='v'){v=val;}
					if(key=='t'){t=val;}
				});
				if(v==x){
					s+='<option selected value="'+v+'">'+t+'</option>';
				}else{
					s+='<option value="'+v+'">'+t+'</option>';
				}
			}
			$(fld).append(s);
			if(q=='cpolda'&&<?php  echo $s_LOC!=''?'true':'false';?>) setTimeout(initLoc,1500);
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}

	</script>
	
    </body>
</html>

