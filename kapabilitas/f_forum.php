<?php
include 'inc.chksession.php';
include 'inc.common.php';

include 'inc.db.php';

$menu='forumd';
$pkid=$_GET['id'];
$title = "";
$s='';
$grp='';

$optpgd=""; $pgddis="";
if($s_LVL==4){
	$optpgd=',equals : ["closed","open","progress","pending"]';
	$pgddis='disabled';
}
$opteng="";
if($s_LVL==5){
	$opteng=',equals : ["progress","pending","solved"]';
}

$conn=connect();
$rs=exec_qry($conn,"select * from tm_forums where rowid=$pkid");
$ticket=fetch_alla($rs);
$rs=exec_qry($conn,"select * from tm_forumd where forumid=$pkid order by rowid");
$notes=fetch_alla($rs);

disconnect($conn);
include 'inc.head.php';
if(count($ticket)<1){
	echo "<center>no record found</center>";
}else{
	$s=$ticket[0]['s'];
//	$grp=$ticket[0]['grp'];
?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
			
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				<br />
					<div class="row">
						<div class="col-md-12">
							<h4><?php echo $ticket[0]['h'] ?></h4>
							<div class="messages">
								<div class="item item-visible">
                                    <div class="text">
                                        <div class="heading">
                                            <a href="#"><?php echo $ticket[0]['createdby'] ?></a>
                                            <span class="date"><i class="fa fa-clock-o"></i> <?php echo $ticket[0]['created'] ?></span>
                                        </div>
                                        <?php echo str_ireplace("\n",'<br />', $ticket[0]['d']) ?>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="messages messages-img">
							<?php
							for($i=0;$i<count($notes);$i++){
							$css=strtolower($notes[$i]['updby'])==strtolower($s_ID)?$saya:$bukansaya;
							$in=$saya==$css?"in":"";
							$attc=$notes[$i]['attc']==""?"":substr($notes[$i]['attc'],strpos($notes[$i]['attc'],'/')+1);
							?>
                                <div class="item item-visible <?php echo $in?>">
                                    <div class="text" <?php echo $css?>>
                                        <div class="heading">
                                            <a href="#"><?php echo $notes[$i]['updby'] ?></a>
                                            <span class="date"><i class="fa fa-clock-o"></i> <?php echo $notes[$i]['lastupd'] ?></span>
                                        </div>
										<?php echo str_ireplace("\n",'<br />', $notes[$i]['notes']) ?><br /><br/>
										<a href="JavaScript:;" data-fancybox data-type="iframe" data-src="<?php echo $notes[$i]['attc'] ?>"><?php echo $attc?></a>
                                    </div>
                                </div>
							<?php
							}
							?>
                            </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h4>Post</h4>
							<div class="messages">
								<div class="item item-visible">
                                    <div class="text">
									<form id="myf">
										<input type="hidden" name="t" value="forum">
										<input type="hidden" name="tname" value="tm_forums">
										<input type="hidden" name="svt" value="SAVE">
										<input type="hidden" name="columns" value="s">
										<input type="hidden" name="id" value="<?php echo $pkid?>">
										<input type="hidden" name="s" id="s2" value="<?php echo $s?>">
										<input type="hidden" name="grp" id="grp2" value="<?php echo $grp?>">
									</form>
										<form id="myf2" class="form-horizontal">
										<input type="hidden" name="t" value="forumd">
										<input type="hidden" name="tname" value="tm_forumd">
										<input type="hidden" name="svt" value="SAVE">
										<input type="hidden" name="columns" value="forumid,notes">
										<input type="hidden" name="id" value="0">
										
										<input type="hidden" name="forumid" value="<?php echo $pkid;?>">
										
										<div class="form-group">
											<div class="col-md-4 control-label">Notes<!--/label>
											<div class="col-md-3"-->
												<!--div id="notes"></div-->
												<textarea class="form-control input-sm" name="notes" id="notes"></textarea>
											</div>
											<div class="col-md-4 control-label">Attachment<!--/label>
											<div class="col-md-2"-->
												<input type="file" class="form-control input-sm" name="fattc" id="fattc" placeholder="...">
											</div>
											<div class="col-md-4">
											<br /><br />
												<button type="button" class="btn btn-success" onclick="sendForms();">Submit</button>
												<button type="button" class="btn btn-info" onclick="parent.$.fancybox.close();">Close</button>
											</div>
										</div>
										</form>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="row">&nbsp;</div>
                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

<?php
}
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
		<script type='text/javascript' src='js/jquery-validate-multi-email.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	<script>
jQuery.validator.addMethod("equals", function(value, element, param) {
	//console.log(value);
	//console.log(param);
  return this.optional(element) || $.inArray(value,param) != -1;
}, "Please specify a different value");

	var mytbl, jvalidate, jvalidate2;
$(document).ready(function() {
	$(document).keypress(function (e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == '27') {
			parent.$.fancybox.close();
		}
	});
	
	jvalidate2 = $("#myf2").validate({rules :{
        "notes" : {
            required : true
		}
	}});
	
});

function tblupdate(){
	
}
function resetMyForms(){
	//jvalidate.resetForm();
	jvalidate2.resetForm();
	$(".error").removeClass("error");
	$(".valid").removeClass("valid");
}
function sendForms(){
	resetMyForms();
	if($('#myf2').valid()){
		//$('#s2').val($('#s').val()); $('#grp2').val($('#grp').val());
		/*if($('#grp').val()=='jarkom' && !$("#jp").val() && ($('#s').val()=='solved'||$('#s').val()=='closed'||$('#s').val()=='pending')){
			$("#processing_msgs").html("Device Type is mandatory.");
			manage_msgs('end');
			$("#modal_no_head").modal('show');
		}else{ */
			sendDataFile('#myf2','SAVE');
			sendDataFile('#myf','SAVE');
			//alert('ok');
		//}
	}
}

	</script>
    </body>
</html>
