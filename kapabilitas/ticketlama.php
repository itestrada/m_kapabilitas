<?php
include 'inc.chksession.php';
include 'inc.common.php';

$pkid=$_GET['id'];
$title="Ticket# $pkid";
$icon="fa fa-ticket";
$menu="ticket";

include 'inc.head.php';

$where="ticketid='$pkid'";
$tname="tm_notes";
$cols="lastupd,s,updby,replace(notes,'\n','<br />'),attc,rowid";
$colsrc="";

$opt1="<option value=''></option>";$opt2="<option value=''></option>";

include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select probid,probname from tm_problems order by probname");
$allotherproblems="[";
while($row=fetch_row($rs)){
	$opt2.='<option value="'.$row[0].'">'.$row[1].'</option>';
	$allotherproblems.=$allotherproblems=='['?'"'.$row[0].'"':',"'.$row[0].'"';
}
$allotherproblems.=']';
disconnect($conn);

$g=isset($_GET['g'])?$_GET['g']:"";

$dis="disabled";
if($s_LVL=="0"||$s_LVL==1||$s_LVL>=4||$g=="1"){
	$dis="";
}
$vis='style="display:none;"';
if($s_GRP==""||$s_GRP=="jarkom"){
	$vis="";
}
$optpgd=""; $pgddis="";
if($s_LVL==4){
	$optpgd=',equals : ["new","closed","open","progress","pending"]';
	$pgddis='disabled';
}
$opteng="";
if($s_LVL==5){
	$opteng=',equals : ["progress","pending","solved"]';
}
$superonly="disabled";
if($s_LVL==0){
	$superonly="";
}
?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
//include 'inc.menu.php';
?>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				
					<div class="row">
                            <div class="panel panel-default">
							<div class="panel-body">
						<form class="form-horizontal" id="myf">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="tm_tickets">
									<input type="hidden" name="columns" value="grp,s,sn,l,p,st,typ,d,solving,blink">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
									<input type="hidden" id="lnk" name="lnk">
								
								<div class="form-group">
									<label class="col-md-1 control-label">Ticket No</label>
									<div class="col-md-2">
										<input readonly type="text" class="form-control input-sm" name="ticketno" id="ticketno" placeholder="auto">
									</div>
									<label class="col-md-1 control-label">Created By</label>
									<div class="col-md-2">
										<input readonly type="text" class="form-control input-sm" name="createdby" id="createdby" placeholder="auto">
									</div>
									<label class="col-md-1 control-label">Created On</label>
									<div class="col-md-2">
										<div class="input-group">
                                            <input readonly id="dtm" name="dtm" type="text" class="form-control" placeholder="auto">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<label class="col-md-1 control-label">Report Date</label>
									<div class="col-md-2">
										<div class="input-group">
                                            <input readonly id="dt" name="dt" type="text" class="form-control datepicker" placeholder="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									
								</div>
									<div class="form-group">
										<label class="col-md-1 control-label">Unit ID</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="i" id="i" placeholder="...">
										</div>
										<label class="col-md-1 control-label">Nama</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="h" id="h" placeholder="...">
										</div>
										<label class="col-md-1 control-label">IP WAN</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="ipwan" id="ipwan" placeholder="...">
										</div>
										<label class="col-md-1 control-label">PIC 1</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="pic" id="pic" placeholder="...">
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-md-1 control-label">Jenis Layanan</label>
										<div class="col-md-2">
											<select <?php echo $superonly?> class="form-control input-sm" name="st" id="st" onchange="stChange();" style="-webkit-appearance: menulist;">
											<?php echo $optst?>
											</select>
										</div>
										<label class="col-md-1 control-label">Cabang</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="cabang" id="cabang" placeholder="...">
										</div>
										<label class="col-md-1 control-label">IP LAN</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="iplan" id="iplan" placeholder="...">
										</div>
										<label class="col-md-1 control-label">Contact 1</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="contact" id="contact" placeholder="...">
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-md-1 control-label">Jenis Gangguan</label>
										<div class="col-md-2">
											<!--input disabled type="text" class="form-control input-sm" name="typ" id="typ" placeholder="..."-->
											<select <?php echo $superonly?> class="form-control input-sm" name="typ" id="typ" style="-webkit-appearance: menulist;">
											<?php echo $opttyp?>
											</select>
										</div>
										<label class="col-md-1 control-label">Area</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="area" id="area" placeholder="...">
										</div>
										<label class="col-md-1 control-label">SID</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="sid" id="sid" placeholder="...">
										</div>
										<label class="col-md-1 control-label">PIC 2</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="pic2" id="pic2" placeholder="...">
										</div>
										
									</div>
									<div class="form-group">
										<label class="col-md-1 control-label">Detail</label>
										<div class="col-md-2">
											<textarea <?php echo $superonly?> class="form-control input-sm" name="d" id="d" placeholder="..."></textarea>
										</div>
										<label class="col-md-1 control-label">Polda</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="k" id="k" placeholder="...">
											<!--select disabled class="form-control" name="k" id="k">
											<?php echo $opt1?>
											</select-->
										</div>
										<div class="col-md-3">
										</div>
										<label class="col-md-1 control-label">Contact 2</label>
										<div class="col-md-2">
											<input readonly type="text" class="form-control input-sm" name="contact2" id="contact2" placeholder="...">
										</div>
									</div>
									
								<div class="form-group">
									<label class="col-md-1 control-label">Group</label>
									<div class="col-md-2">
										<select <?php echo $pgddis?> class="form-control" name="grp" id="grp" onchange="statusChange();" style="-webkit-appearance: menulist;">
										<?php echo $optgrp?>
										</select>
									</div>
									<label class="col-md-1 control-label">Status</label>
									<div class="col-md-2">
										<select <?php echo $dis?> class="form-control" name="s" id="s" onchange="statusChange();" style="-webkit-appearance: menulist;">
										<option value="new">new</option>
										<option value="open">open</option>
										<option value="progress">progress</option>
										<option value="pending">pending</option>
										<option value="solved">solved</option>
										<option value="closed">closed</option>
										</select>
									</div>
									
									
									<label class="col-md-1 control-label blink">Secondary Link</label>
									<div class="col-md-2 blink">
										<select <?php echo $pgddis?> class="form-control" name="blink" id="blink" style="-webkit-appearance: menulist;">
										<?php echo $optblink?>
										</select>
									</div>
									
									
									<label class="col-md-1 control-label jarkom">Serial#</label>
									<div class="col-md-2 jarkom">
										<input <?php echo $pgddis?> type="text" class="form-control input-sm" name="sn" id="sn" placeholder="...">
									</div>
									<label class="col-md-1 control-label engineer">Filtering</label>
									<div class="col-md-2 engineer">
											<!--input type="text" class="form-control input-sm" name="pic" id="pic" placeholder="..."-->
											<select <?php echo $pgddis?> class="form-control" name="p" id="p" style="-webkit-appearance: menulist;">
											<?php echo $opt2?>
											<option value="RMA">RMA</option>
											<option value="Tidak RMA">Tidak RMA</option>
											<option value="Force Majeur">Force Majeur</option>
											</select>
									</div>
									<label class="col-md-1 control-label jarkom">Jenis Jarkom</label>
									<div class="col-md-5 jarkom">
										<select <?php echo $pgddis?> class="form-control selectpicker" name="jp[]" id="jp" multiple style="-webkit-appearance: menulist;">
										<?php echo $optjp?>
										</select>
									</div>
									<label class="col-md-1 control-label " style="display:none;">Address</label>
									<div class="col-md-2 " style="display:none;">
										<input <?php echo $pgddis?> type="text" class="form-control input-sm" name="l" id="l" placeholder="...">
									</div>
									<!--label class="col-md-1 control-label">Install Date</label>
									<div class="col-md-2">
										<div class="input-group">
                                            <input <?php echo $dis?> id="tp" name="tp" type="text" class="form-control datepicker" placeholder="">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div-->
										<label class="col-md-1 control-label engineer">Solving</label>
										<div class="col-md-2 engineer">
											<textarea <?php echo $pgddis?> class="form-control input-sm" name="solving" id="solving" placeholder="..."></textarea>
										</div>
										
								</div>								
						</form>
							</div>
							</div>
							<div class="panel panel-default">
							<div class="panel-body">
						<form id="myf2" class="form-horizontal">
								<input type="hidden" name="t" value="notes">
									<input type="hidden" name="tname" value="tm_notes">
									<input type="hidden" name="svt" value="SAVE">
									<input type="hidden" name="columns" value="ticketid,notes,s">
									<input type="hidden" name="id" value="0">
									
									<input type="hidden" name="ticketid" value="<?php echo $pkid;?>">
									<input type="hidden" name="attc" value="">
									<input type="hidden" name="s" id="s2" value="">
									
								<div class="form-group">
									<label class="col-md-1 control-label">Notes</label>
									<div class="col-md-3">
										<!--div id="notes"></div-->
										<textarea <?php echo $dis?> class="form-control input-sm" name="notes" id="notes"></textarea>
									</div>
									<label class="col-md-1 control-label">Attachment</label>
									<div class="col-md-3">
										<input <?php echo $dis?> type="file" class="form-control input-sm" name="fattc" id="fattc" placeholder="...">
									</div>
									<!--div class="col-md-1">
										<button type="button" class="btn btn-warning" onclick="resetMyForms();if($('#myf2').valid()){sendDataFile('#myf2','SAVE');}">Make a Note</button>
									</div-->
									<label class="col-md-1 control-label"></label>
									<div class="col-md-3">
									<?php if($s_LVL!=3){?>
										<button <?php echo $dis?> type="button" class="btn btn-success" onclick="sendForms();">Submit</button>
									<?php if($s_LVL==0||$s_LVL==1){?>
										<button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button>
									<?php }
										}?>
										<button type="button" class="btn btn-info" onclick="parent.$.fancybox.close();">Cancel</button>
									</div>
									
								</div>
						</form>									
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
                                                <th>Date/Time</th>
                                                <th>Status</th>
                                                <th>By</th>
                                                <th>Notes</th>
                                                <th>Attachment</th>
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
	
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrf<t>ip>',
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
				//d.sever= $("#sever").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "s" : {
            required : true <?php echo $optpgd.$opteng;?>
        },
		"blink" : {
			required : true
		},
		"grp" : {
            required : true,
			equals : function(element){
				if($("#st").val()=="router/switch/ip-phn"){
					return ["jarkom"];
				}else{
					return ["jarkom","link"];
				}
			}
        },
		"typ" : {
            required : true
        },
		"l" : {
			required : function(element){
						if ($("#s").val() == "solved" && $("#grp").val()=="jarkom") {
							return true;
						}
						else {
							return false;
						}
			}
		},
		"sn" : {
			required : function(element){
						if ($("#s").val() == "solved" && $("#grp").val()=="jarkom") {
							return true;
						}
						else {
							return false;
						}
			}
		},
		"jp" : {
			required : function(element){
						if ($("#s").val() == "solved" && $("#grp").val()=="jarkom") {
							return true;
						}
						else {
							return false;
						}
			}
		},
		"solving" : {
			required : function(element){
						if ($("#s").val() == "solved") {
							return true;
						}
						else {
							return false;
						}
			}
		},
		"p" : {
			required : function(element){
						if ($("#s").val() == "solved" || $("#s").val() == "pending") {
							return true;
						}
						else {
							return false;
						}
			},
			equals : function(element){
					if($("#s").val() == "pending" && $("#grp").val() == "jarkom"){
						return ["RMA","Force Majeur"];
					}else{
						if($("#s").val() == "solved" && $("#grp").val() == "jarkom"){
							return ["RMA","Tidak RMA","Force Majeur"];
						}else{
							return <?php echo $allotherproblems?>;
						}
					}
			}
		}
    }});
	jvalidate2 = $("#myf2").validate({rules :{
        "notes" : {
            required : true
		}
	}});
	
	//getData('<?php echo $pkid;?>');
	$(".selectpicker").selectpicker();
	//resetMyForms();
	$('#id').val('<?php echo $pkid;?>');
	getTicket();
});


function tblupdate(){
	mytbl.ajax.reload();
}

function resetMyForms(){
	jvalidate.resetForm();
	jvalidate2.resetForm();
	$(".error").removeClass("error");
	$(".valid").removeClass("valid");
}

function statusChange(){
	$('#s2').val($('#s').val());
	if($('#s').val()=='solved'||$('#s').val()=='closed'||$('#s').val()=='pending'){
		$('.engineer').show();
		if($('#grp').val()=='jarkom'){
			$('.jarkom').show();
		}else{
			$('.jarkom').hide();
		}
	}else{
		$('.jarkom').hide();
		$('.engineer').hide();
	}
	if($('#s').val()=='solved'||$('#s').val()=='closed'){
		//$('#blink').attr('disabled',true);
		$('.blink').hide();
	}else{
		//$('#blink').attr('disabled',false);
		$('.blink').show();
	}
}

function sendForms(){
	resetMyForms();
	if($('#myf').valid() && $('#myf2').valid()){
		if($('#grp').val()=='jarkom' && !$("#jp").val() && ($('#s').val()=='solved'||$('#s').val()=='closed'||$('#s').val()=='pending')){
			$("#processing_msgs").html("Device Type is mandatory.");
			manage_msgs('end');
			$("#modal_no_head").modal('show');
		}else{
			sendDataFile('#myf2','SAVE');
			sendDataFile('#myf','SAVE');
			//alert('ok');
		}
	}
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}

function multiSelect(id,data){
	if(id=="jp"){
		$("#"+id).val(data.split(";"));
		$("#"+id).selectpicker('refresh');
	}
	/*
	if(id=="pic"){
		getPIC(data);
	}
	if(id=="ticketno"){
		$("#notes").html('<a title="Notes" href="JavaScript:;" class="btn btn-warning" data-fancybox data-type="iframe" data-src="notes.php?id='+data+'">Notes</a>');
	}*/
	if(id=="s"){
		statusChange();
	}
}

function clearAuto(oin='kanwil,oname,iplan,ipwan,area,cabang,sid,pic,pic2,contact,contact2'){
	var outlets=oin.split(',');
	var toutlet=0;
	
	for(toutlet=0;toutlet<outlets.length;toutlet++){
		$('#'+outlets[toutlet]).val('');
	}
}
function getTicket(){
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'ticket',id:'<?php echo $pkid?>'};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			$.each(json[0],function (key,val){
				$('#'+key).val(val);
				if(key=='s'){statusChange();}
				if(key=='jp'){
					//console.log(key);
					$("#"+key).val(val.split(";"));
					$("#"+key).selectpicker('refresh');
				}
			});
			if(json.length<1){
				alert('Data not found');
			}
			getIP();
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}
function stChange(){
	if($('#st').val()=='router/switch/ip-phn'){
		$('#grp').val('jarkom');
	}else{
		$('#grp').val('link');
	}
	getIP();
}
function getIP(){
if($('#st').val()!=""&&$('#i').val()!=""){
	var vst=$('#st').val();
	if(vst=='router/switch/ip-phn'){
		//vst=$('#lnk').val();
	}
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'hip',id:$('#i').val(),idx:vst};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			clearAuto('iplan,ipwan,sid');
			var json=JSON.parse(data);
			$.each(json[0],function (key,val){
				$('#'+key).val(val);
			});
			if(json.length<1){
				alert('IP not found');
			}
		},
		error: function(xhr){
			console.log("Error:"+xhr);
			clearAuto('iplan,ipwan,sid');
		}
	});
}else{
	clearAuto('iplan,ipwan,sid');
}
}

function getPIC(x=""){
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'hdgrp',id:$('#grp').val()};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					var json=JSON.parse(data);
					console.log(json);
					$("#pic").find('option').remove();
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
					$("#pic").append(s);
				},
				error: function(xhr){
					console.log("Error:"+xhr);
				}
			});
}

</script>
	
    </body>
</html>
