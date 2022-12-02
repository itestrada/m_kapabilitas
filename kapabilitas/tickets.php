<?php
include 'inc.chksession.php';
include 'inc.common.php';

//0:master 3:readonly 4:pgd 5:engineer

$title="Ticket";
$icon="fa fa-ticket";
$menu="tickets";

include 'inc.head.php';

$pic=isset($_GET['pic'])?$_GET['pic']:"";
$g=isset($_GET['grp'])?$_GET['grp']:"";
$a=isset($_GET['a'])?$_GET['a']:"";
$s=isset($_GET['s'])?$_GET['s']:"";

$titles=$title;
$titles=isset($_GET['grp'])?"My Group ".$title:$titles;
$titles=isset($_GET['pic'])?"Open ".$title:$titles;
$titles=$a!=""?"Overdue ".$title:$titles;
$titles=substr($s,0,2)=="30"?"Last 30days ".$title:$titles;
$titles=substr($s,0,2)=="rm"?"RMA ".$title:$titles;
$titles=substr($s,0,2)=="re"?"Relokasi ".$title:$titles;
$titles=$title==$titles?"All ".$title:$titles;

$titles.=$s!=""?" ".substr($s,2):"";

$where=" 1=1 ";
//$where.=$s_LVL==4 && $g!=""?" and k in (select kanwil from tm_kanwilusers where user='$s_ID')":""; //my group
if($s_LVL==5){
	$where.=" and (grp like '%$s_GRP%' or grp='')"; //engineer
}
if($s_LVL==4||$s_LVL==6){
	$where.=" and i = '$s_LOC'"; //PIC
}

//Open
$where.=$a!=""?" and o='1'":""; //alerted
$where.=$pic!="" && ($s_LVL!=5)?" and s<>'closed'":""; //all
//$where.=$pic!="" && $s_LVL==4?" and s='solved' and k in (select kanwil from tm_kanwilusers where user='$s_ID')":""; //officer
//$where.=$pic!="" && $s_LVL==4?" and s='solved'":""; //officer
$where.=$pic!="" && $s_LVL==5?" and s in ('new','open','pending','progress')":""; //engineer

//from home
if(substr($s,0,2)=="30"){
	if(substr($s,2)=='open'){
	//$where.=$s!=""?" and s in ('open','new','progress') and typ in $homewidget and datediff(date(now()),date(dt))<=30":"";
	$where.=$s!=""?" and s in ('open','new','progress') and datediff(date(now()),date(dt))<=30":"";
	}else{
	//$where.=$s!=""?" and s like '%".substr($s,2)."%' and typ in $homewidget and datediff(date(now()),date(dt))<=30":"";
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and datediff(date(now()),date(dt))<=30":"";
	}
}
if(substr($s,0,2)=="rm"){
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and p='RMA'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and p='RMA'":"";
	}
}
if(substr($s,0,2)=="re"){
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and typ = 'relokasi'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and typ = 'relokasi'":"";
	}
}
//echo "aaaaaa".$where;

$tname="tm_tickets";
$tnames="tm_tickets t left join tm_kanwils k on k.locid=t.k";
$cols="ticketno,dt,i,h,d,locname,grp,typ,st,s,t.lastupd,t.updby,t.rowid";
$colsrc="h,d";
$srceq="ticketno,i";

$opt1="<option value=''></option>";$opt2="<option value=''></option>";

include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select probid,probname from tm_problems order by probname");
while($row=fetch_row($rs)){
	$opt2.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
disconnect($conn);


$dis="disabled";
if(($s_GRP==""&&$s_LVL=="0")||$s_LVL>4||$g=="1"){
	$dis="";
}
$vis='style="display:none;"';
if($s_GRP==""||$s_GRP=="jarkom"){
	$vis="";
}
$optdis="";
if($s_LVL==5){
	$optdis="disabled";
}
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
                    <!--li><a href="home.php">Home</a></li-->
                    <li class="active">&nbsp;</li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $titles;?></h2>
				<?php if(($s_LVL==0||$s_LVL==3||$s_LVL==4)&&$s==''){?>
					<a href="#" onclick="if($('#i').val()!=''){getOutlet();}else{getCombo('cpolda','#k'); openForm(0);}" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
					<?php if($s_LVL==0&&$s_GRP==""&&false){?>
					<a class="btn btn-danger pull-right" href="JavaScript:;" data-fancybox data-type="iframe" data-src="md_bi.php"><i class="fa fa-indent"></i> Batch Input</a>
				<?php }}?>
				</div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-1">
											From
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="fdf" name="fdf" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="fdt" name="fdt" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											<button class="btn btn-info" onclick="tblupdate()"><i class="fa fa-search"></i> Filter</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body"  style="padding-right: 0px;">
								<div class="form-group">
									<div class="col-md-3 control-label">Status<!--/div>
									<div class="col-md-1"-->
										<select multiple id="fs" class="form-control selectpicker">
										<option value="new">new</option>
										<option value="open">open</option>
										<option value="progress">progress</option>
										<option value="pending">pending</option>
										<option value="solved">solved</option>
										<option value="closed">closed</option>
										</select>
									</div>
									<div class="col-md-3 control-label">Jenis Layanan<!--/div>
									<div class="col-md-2"-->
										<select multiple class="form-control selectpicker" id="fst">
										<?php echo $optst?>
										</select>
									</div>
									<div class="col-md-3 control-label">Jenis Gangguan<!--/div>
									<div class="col-md-2"-->
										<select multiple class="form-control selectpicker" id="ftyp">
										<?php echo $opttyp?>
										</select>
									</div>
									<div class="col-md-2 control-label">Group<!--/div>
									<div class="col-md-1"-->
										<select multiple class="form-control selectpicker" id="fgrp">
										<?php echo $optgrp?>
										</select>
									</div>
									
									<div class="col-md-1 pull-right" style="padding-right: 0px;"><br />
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
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Lokasi ID</th>
                                                <th>Subject</th>
                                                <th>Detail</th>
                                                <th>Gedung</th>
                                                <th>Group</th>
                                                <th>Gangguan</th>
												<th>Layanan</th>
                                                <th>Status</th>
                                                <th>Last Update</th>
                                                <th>Updated By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
		<div class="modal" id="modal_large" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="margin-top: 1px;">
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
									<input type="hidden" name="columns" value="h,d,k,i">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<!--div class="form-group">
									<label class="col-md-2 control-label">Ticket No</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control input-sm" name="ticketno" id="ticketno" placeholder="auto">
									</div>
									<label class="col-md-2 control-label">Created By</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control input-sm" name="createdby" id="createdby" placeholder="auto">
									</div>
									
								</div-->
								<div class="form-group">
									<label class="col-md-2 control-label">Report Date/Time</label>
									<div class="col-md-4">
										<div class="input-group">
                                            <input id="dt" name="dt" type="text" class="form-control" placeholder="<?php echo date('Y-m-d H:i')?>">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<label class="col-md-2 control-label">Lokasi</label>
									<div class="col-md-4">
									<?php if($s_LOC==""){?>
											<select class="form-control" name="k" id="k" onchange="getCombo('cloc','#i',this.value);">
												<option value=""></option>
											</select>
										<!--div class="input-group">
											<input type="text" class="form-control input-sm" name="i" id="i" placeholder="...">
											<span onclick="getOutlet();" class="input-group-addon add-on"><i class="fa fa-check"></i></span>
										</div-->
									<?php }else{?>
											<input type="text" readonly class="form-control input-sm" name="i" id="i" value="<?php echo $s_LOC?>">
											<input type="hidden" name="k" id="k" />
									<?php }?>
									</div>
									
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Nama</label>
									<div class="col-md-4">
											<input type="hidden" name="h" id="h" />
									<?php if($s_LOC==""){?>
											<select class="form-control" onchange="$('#h').val(this.options[this.selectedIndex].text);" name="i" id="i">
												<option value=""></option>
											</select>
									<?php }else{?>
											<input readonly type="text" class="form-control input-sm" name="oname" id="oname" placeholder="auto">
									<?php }?>
									</div>
									<label class="col-md-2 control-label">Detail</label>
									<div class="col-md-4">
										<textarea class="form-control input-sm" name="d" id="d" placeholder="..."></textarea>
									</div>
								</div>
									
							</div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<!--button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button-->
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="tblupdate();getNotif();">Close</button>                                                
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
		<script type="text/javascript" src="js/jquery.datetimepicker.full.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css" />
		<!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
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

var mytbl, jvalidate;
$(document).ready(function() {
	$("#i").keydown(function (e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == '13' || keycode == '9') {
			getOutlet();
		}else{
			clearAuto();
		}
	});
	
	$.fn.dataTable.ext.errMode = 'none';
	
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrf<t>ip>',
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[0,"desc"]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tnames); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.srceq= '<?php echo $srceq; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.g= '<?php echo $g; ?>',
				d.ms= getMultipleValues('#fs'),
				d.mst= getMultipleValues('#fst'),
				d.mtyp= getMultipleValues('#ftyp'),
				d.mgrp= getMultipleValues('#fgrp'),
				d.df= $("#fdf").val(),
				d.dt= $("#fdt").val(),
				d.x= '<?php echo $menu; ?>'
			}
		},
		drawCallback: function( settings ) {
			console.log('kekekekeke');
			$(".fancy").fancybox({
				type : 'iframe',
				afterClose : function(instance, current, e){
					console.log('heheheheh');
					tblupdate();
				}
			});
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "d" : {
            required : true
        },
		"oname" : {
            required : true
        },
		"i" : {
            required : true
        }
    }});
	$.datetimepicker.setLocale('en');
	$("#dt").datetimepicker({
		format:'Y-m-d H:i',
		step: 1
	});
	$(".selectpicker").selectpicker();
	setTimeout(tblupdate,60*1000);
});

function tblupdate(){
	mytbl.ajax.reload();
	
	setTimeout(tblupdate,60*1000);
}

function getMultipleValues(theid){
	var ret="";
	var arr=$(theid).val();
	if(arr){
		for(var i=0;i<arr.length;i++){
			if(ret==""){
				ret="'"+arr[i]+"'";
			}else{
				ret=ret+",'"+arr[i]+"'";
			}
		}
	}
	return ret;
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}

function multiSelect(id,data){
	/*
	if(id=="area"){
		$("#"+id).val(data.split(";"));
		$("#"+id).selectpicker('refresh');
	}
	if(id=="pic"){
		getPIC(data);
	}*/
	if(id=="ticketno"){
		//$("#notes").html('<a title="Notes" href="JavaScript:;" class="btn btn-warning" data-fancybox data-type="iframe" data-src="notes.php?id='+data+'">Notes</a>');
	}
}

function clearAuto(oin='kanwil,oname,iplan,ipwan,bw,ket,sid,pic,pic2,contact,contact2'){
	var outlets=oin.split(',');
	var toutlet=0;
	
	for(toutlet=0;toutlet<outlets.length;toutlet++){
		$('#'+outlets[toutlet]).val('');
	}
}

function getOutlet(){
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'houtlet',id:$('#i').val()};
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
						if(key=='oid'){$('#i').val(val);}
						if(key=='kanwil'){$('#k').val(val);}
						if(key=='oname'){$('#h').val(val);}
					});
				}
			}
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}
function stChange(){
	if($('#st').val()=='router/switch/ip-phn'){
		$('.class-grp').val('jarkom');
	}else{
		$('.class-grp').val('link');
	}
	//getIP();
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
