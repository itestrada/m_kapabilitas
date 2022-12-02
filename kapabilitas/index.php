<?php
$title="Login";
include "inc.common.php";
include "inc.db.php";

function getmac(){
	return "MAC:MAC:MAC:MAC";
}

$u="";
$p="";
$msg="";

if(isset($_POST["u"])){$u=$_POST["u"];}
if(isset($_POST["p"])){$p=$_POST["p"];}
if(isset($_GET["m"])){$msg=$_GET['m'];}


if($u!=""){
$loggedin=false;

$sql="select username,userlevel,usergrp,userloc from tm_users where isactive='Y' and (userid='$u') and userpwd=MD5('$p')";

	$conn = connect();
	$rs = exec_qry($conn,$sql);
	if ($row = fetch_row($rs)) {
		session_start();
		//if (!isset($_SESSION['s_ID'])) {
    		$_SESSION['s_ID'] = $u;
		//}
		//if (!isset($_SESSION['s_NAME'])) {
    		$_SESSION['s_NAME'] = $row[0];
		//}
		//if (!isset($_SESSION['s_LVL'])) {
    		$_SESSION['s_LVL'] = $row[1];
		//}
		//if (!isset($_SESSION['s_GRP'])) {
    		$_SESSION['s_GRP'] = $row[2];
			$_SESSION['s_LOC'] = $row[3];
		//}
		//if (!isset($_SESSION['s_MAC'])) {
    		$_SESSION['s_MAC'] = getmac();
		//}
		/*$sqlm="select menu from custom_user_menus where userid='$u'";
		$rsm=exec_qry($conn,$sqlm);
		$mnu=fetch_all($rsm);
		if(count($mnu)>0){
			$_SESSION['s_MENU']=$mnu[0];
		}
		*if (!isset($_SESSION['s_ISADMIN'])) {
    		$_SESSION['s_ISADMIN'] = $row[4];
		}
		$msg = "Welcome to Site Manager.<br>";
		$title = "Welcome ".$_SESSION['s_NAME'];*/
		$loggedin=true;
	}else{
		$msg="Invalid ID or password.";
	}

	disconnect($conn);
	//if($u=="a"&&$p=="a"){$loggedin=true;session_start();$_SESSION['s_ID']="user";$_SESSION['s_NAME']="Nama User";}else{$msg="Invalid ID or password.";}
if($loggedin){
	if($_SESSION['s_LVL']==9){
		header("Location: homexx$env");
	}else{
		header("Location: home$env");
	}
}
}
?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $app."-".$title;?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon-16.png" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <style>
		body {
		  background-image: url('/img/gambar-tni1.jpeg');
		}
	</style>
    <body>
        
        <div class="login-container" style="background-color:rgba(0,0,0,0.05);">
        
            <div class="login-box animated fadeInDown">
                <div class="" style="text-align:center;"><img width="100%" src="img/logo-login.png"><!--&nbsp;&nbsp;<img src="img/bi.png" width="37" height="37"--></div><br />
                <div class="login-body" style="background-color:rgba(65,70,47,0.73);">
                    <div class="login-title "><strong>Welcome</strong>, Please login</div>
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="u" placeholder="User ID"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="p" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div-->
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">Log In</button>
							<a href="#" onclick="reset_form('#myf2',jvalidate2);" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_small">Forgot Password</a>
                        </div>
						<div class="col-md-6">
                        <?php if($anonfeedback){?>
						    <a href="updatesql.txt" class="btn btn-link btn-block fancybox">Feedback</a>
						<?php } if($anonsurvey){?>
							<a href="#" class="btn btn-link btn-block">Survey</a>
						<?php }?>
							<a href="#" onclick="reset_form('#myf',jvalidate);" data-toggle="modal" data-target="#modal_large" class="btn btn-link btn-block">Register Here</a>
							<a href="#" class="btn-block btn dropdown-toggle" style="color:#fefefe;" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-headphones"></i>Helpdesk</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="whatsapp://send?phone=6287886297626"><span class="fa fa-whatsapp"></span> Almer (+62-878-8629-7626)</a></li>
								<li><a href="whatsapp://send?phone=6281318098840"><span class="fa fa-whatsapp"></span> Azhar (+62-813-1809-8840)</a></li>
								<li><a href="whatsapp://send?phone=6281317447160"><span class="fa fa-whatsapp"></span> Alif (+62-813-1744-7160)</a></li>
							</ul>
						</div>
                        
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div style="text-align:center;">
                        <a style="color:#000;" href="#">&copy; 2019 </a>
                    </div>
                    <!--div class="pull-right">
                        <a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div-->
                </div>
				<?php if($msg!=""){?>
							<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><i class="fa fa-info-circle"></i></strong> <?php echo $msg;?>
                            </div> 
				<?php } ?>
            </div>
			
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa fa-user"></i> Register</b></h4>
                    </div>
					
						<form class="form-horizontal" id="myf">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="register">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group">
									<label for="userid" class="col-md-2 control-label">User ID</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" maxlength="20" name="userid" id="userid" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="username" class="col-md-2 control-label">Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="username" id="username" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userphone" class="col-md-2 control-label">Phone</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="userphone" id="userphone" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-2 control-label">Mail</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="usermail" id="usermail" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="userlvl" class="col-md-2 control-label">Otorisasi</label>
									<div class="col-md-10">
										<select class="form-control" name="userlevel" id="userlevel">
										<option value="4">PIC</option>
										<option value="3">Helpdesk</option>
										<option value="2">Supervisor</option>
										<option value="5">Engineer</option>
										<option value="6">Supplier</option>
										</select>
										<!--input type="hidden" class="form-control input-sm" name="userlevel" id="userlevel" value="4"-->
									</div>
								</div>
								<div class="form-group">
									<label for="usergrp" class="col-md-2 control-label">Group</label>
									<div class="col-md-10">
										<select class="form-control" name="usergrp" id="usergrp">
											<option value="">-</option>
											<?php echo $optgrp?>
										</select>
										<!--input type="hidden" class="form-control input-sm" name="usergrp" id="usergrp" value="" placeholder="..."-->
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-2 control-label">Polda</label>
									<div class="col-md-10">
										<select class="form-control" name="polda" id="polda" onchange="getCombo('cloc','#userloc',this.value);">
											<option value=""></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-2 control-label">Location</label>
									<div class="col-md-10">
										<select class="form-control" name="userloc" id="userloc">
											<option value=""></option>
										</select>
									</div>
								</div>
								<!--div class="form-group">
									<label for="userloc" class="col-md-2 control-label">Location</label>
									<div class="col-md-10">
										<div class="input-group">
										<input type="text" class="form-control input-sm" name="userloc" id="userloc" placeholder="...">
										<span onclick="getOutlet();" class="input-group-addon add-on"><i class="fa fa-check"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-md-2 control-label">Location Name</label>
									<div class="col-md-10">
										<input type="text" readonly class="form-control input-sm" name="oname" id="oname" placeholder="...">
									</div>
								</div-->
							</div>
							</div>
						</form>
					
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Register</button>
						<!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->                        
                    </div>
                </div>
            </div>
        </div>
        
		<div class="modal" id="modal_small" tabindex="-3" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><b><i class="fa fa-lock"></i> Forgot Password</b></h4>
                    </div>
					
						<form class="form-horizontal" id="myf2">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="passwd">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group">
									<label for="userid" class="col-md-2 control-label">User ID</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="userid" id="userid2" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label for="usermail" class="col-md-2 control-label">Mail</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="usermail" id="usermail2" placeholder="...">
									</div>
								</div>
							</div>
							</div>
						</form>
                    
					<div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf2').valid()){sendDataFile('#myf2','SAVE');}">Reset My Password</button>
                        <!--button type="button" class="btn btn-default" data-dismiss="modal">Close</button-->
                    </div>
                </div>
            </div>
        </div>
		
		<div class="modal" id="modal_no_head" tabindex="-2" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">                    
                    <div class="modal-body" style="text-align: center; font-size: 15px;">
					   <div id="processing">
                        <h3><i class='fa fa-spin fa-spinner'></i></h3>
						 Processing...
					   </div>
					   <div id="processing_msgs">
					   </div>
                    </div>
                    <div id="btndone" class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

			
        </div>
        <!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
			
			<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
			<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
			
			<script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		
            <!-- END PLUGINS -->
			<!-- START TEMPLATE -->
            <script type="text/javascript" src="js/plugins.js"></script>        
            <script type="text/javascript" src="js/actions.js"></script>        
            <!-- END TEMPLATE -->
			
			<script>
var jvalidate, jvalidate2;
$(document).ready(function() {
	$(".fancybox").fancybox({'type':'iframe'});
	
	$("#userloc").keydown(function (e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == '13' || keycode == '9') {
			if($('#userloc').val()!="") getOutlet();
		}else{
			$("#oname").val("");
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
		"polda" : {
			required : function(element){
				return $("#userlevel").val()=="4"||$("#userlevel").val()=="6";
			}
		},
		"userloc" : {
			required : function(element){
				return $("#userlevel").val()=="4"||$("#userlevel").val()=="6";
			}
		},
		"usergrp" : {
			required : function(element){
				return $("#userlevel").val()=="5";
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
	jvalidate2 = $("#myf2").validate({
	rules :{
		"userid" : {
			required : true
		},
		"usermail" : {
			required : true,
			email : true
		}
	}});
	
	getCombo("cpolda","#polda");
});

function sendDataFile(f,svt){
	manage_msgs('start');
	$("#modal_no_head").modal('show');
	$("#svt").val(svt);
	
	var url='register.php';
	var mtd='POST';
	var frmdata=new FormData($(f)[0]);
	
	//alert(frmdata);
	
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			$("#processing_msgs").html(data);
			manage_msgs('end');
		},
		error: function(xhr,status){
			$("#processing_msgs").html(status);
			manage_msgs('end');
		},
		cache: false,
		contentType: false,
		processData: false
	});

};

function manage_msgs(s){
	if(s=='start'){
		$("#btndone").hide();
		$("#processing").show();
		$("#processing_msgs").hide();
	}else{
		$("#btndone").show();
		$("#processing").hide();
		$("#processing_msgs").show();
	}
}
function reset_form(f,v){
	v.resetForm();$(".error").removeClass("error"); $(".valid").removeClass("valid"); $(f).find('input[type=text]').val('');
}

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
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}

			</script>
    </body>
</html>

