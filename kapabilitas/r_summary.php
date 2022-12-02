<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Tickets Summary Report";
$icon="fa fa-file-text";
$menu="rsummary";

include 'inc.head.php';

$where="1=1";
$tname="tm_tickets t left join tm_kanwils k on k.locid=t.k";
$tname="tm_tickets";
$cols="ticketno,dt,h,d,locname,grp,st,typ,p,s";
$colsrc="";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";

include 'inc.db.php';
$conn=connect();
/*
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$optcus.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select distinct grp from tm_tickets");
while($row=fetch_row($rs)){
	$optgrp.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct s from tm_tickets");
while($row=fetch_row($rs)){
	$opttstatus.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct typ from tm_tickets");
while($row=fetch_row($rs)){
	$optsubj.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
*/

/*graph data sources
$sql="select status as label, count(status) as value from tickets ";
$rs=exec_qry($conn,$sql." group by label");
$donut_status=json_encode(fetch_alla($rs));

$sql="select cusname as label, count(customer) as value from tickets t left join customers c on t.customer=c.cusid ";
$rs=exec_qry($conn,$sql." group by label");
$donut_customer=json_encode(fetch_alla($rs));

$sql="select dsc as label, count(sla) as value from tickets t left join urgencies u on t.sla=u.lvl ";
$rs=exec_qry($conn,$sql." group by label");
$donut_sla=json_encode(fetch_alla($rs));

$sql="select a.name as y, b.status as s, count(distinct b.rowid) as v from pics a join prospects b on a.prospectid=b.prospectid where org='INTERNAL'";
$rs=exec_qry($conn,$sql." group by y,s order by y");
$abar=fetch_alla($rs);
$bar=array();
$row=array();
$y="";
for($i=0;$i<count($abar);$i++){
	if($y!=$abar[$i]['y']){
		if($y!=""){
			$bar[]=$row;
		}
		$row=array();
		$row['y']=$abar[$i]['y']; $y=$row['y'];
	}
	$row[$abar[$i]['s']]=$abar[$i]['v'];
}
if(count($row)){$bar[]=$row;}

$sql="select date(dtm) as y, count(rowid) as a from tickets";
$rs=exec_qry($conn,$sql." group by y order by y");
$bar_daily=json_encode(fetch_alla($rs));
*/
//echo json_encode($aline);
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
					<!--a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                --></div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
					<div class="row" style="display:none;">
                        <div class="col-md-12">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary Tickets</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-bar-daily" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
					</div>
					
                    <div class="row" style="display:none;">
                        <div class="col-md-4">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary Ticketing by Customer</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-customer" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>

                        <div class="col-md-4">

                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary Ticketing by SLA</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-sla" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->
                        </div>

                        <div class="col-md-4"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Summary Ticketing by Status</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-status" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 

                        </div>
                    </div>
					
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
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
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
					
					<div class="row" style="">
                        <div class="col-md-4">
                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Gedung</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="satu" class="table">
                                        <thead>
                                            <tr>
                                                <th>Gedung</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
					    <div class="col-md-4">
                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Jenis Link</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="dua" class="table">
                                        <thead>
                                            <tr>
                                                <th>Link</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
					    <div class="col-md-4">
                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Gedung & Jenis Link</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="tiga" class="table">
                                        <thead>
                                            <tr>
                                                <th>Gedung</th>
                                                <th>Link</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
					</div>
					<div class="row" style="">
                        <div class="col-md-4">
                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Lokasi & Jenis Link</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="empat" class="table">
                                        <thead>
                                            <tr>
                                                <th>Kantor</th>
                                                <th>Link</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
                        <div class="col-md-4">
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Gedung & Jenis Gangguan</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="lima" class="table">
                                        <thead>
                                            <tr>
                                                <th>Gedung</th>
                                                <th>Gangguan</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->
                        </div>
                        <div class="col-md-4"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Resolve Time</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="enam" class="table">
                                        <thead>
                                            <tr>
                                                <th>Hour</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 
                        </div>
					</div>
					<div class="row" style="">
                    	<div class="col-md-4"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Resolve Time>24Hr By Jenis Gangguan</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="tujuh" class="table">
                                        <thead>
                                            <tr>
                                                <th>Gangguan</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 
                        </div>
						<div class="col-md-4"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By Date</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="delapan" class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 
                        </div>
						<div class="col-md-4"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">By User</h3>                                
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="sembilan" class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 
                        </div>
                    </div>
					
                    <div class="row" style="display:none;">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
									<div class="col-md-2">
										<select class="form-control" name="status" id="status">
										<option value="">All Status</option>
										<?php echo $opttstatus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="customer" id="customer">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="pic" id="pic">
										<option value="">All Type</option>
										<?php echo $optsubj?>
										</select>
									</div>
									<div class="col-md-2">
										<button class="btn btn-info" onclick="tblupdate()"><i class="fa fa-search"></i> Filter</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
                    <div class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Detail</th>
                                                <th>Gedung</th>
                                                <th>Group</th>
                                                <th>Link</th>
                                                <th>Link</th>
                                                <th>Problem</th>
                                                <th>Status</th>
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

        <script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		
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
var mytbl1, mytbl2, mytbl3, mytbl4, mytbl5, mytbl6, mytbl7, mytbl8, mytbl9, jvalidate;

function loadTable(divid,cols,tname,where,grpby,x){
var mytbl=$(divid).DataTable({
	dom: 'T<"clear"><lrB<t>ip>',
	buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	searching: false,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= cols,
				d.tname= tname,
				d.csrc= '',
				d.where= where,
				d.grpby= grpby,
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.x= '<?php echo $menu; ?>'+x;
			}
		}
	});
	
	return mytbl;
}

$(document).ready(function() {
	mytbl1 = loadTable('#satu','<?php echo base64_encode("k,count(k) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("k");?>','satu');
	mytbl2 = loadTable('#dua','<?php echo base64_encode("st,count(st) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("st");?>','dua');
	mytbl3 = loadTable('#tiga','<?php echo base64_encode("k,st,count(k) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("k,st");?>','tiga');
	mytbl4 = loadTable('#empat','<?php echo base64_encode("left(h,3) as sbj,st,count(k) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("left(h,3),st");?>','empat');
	mytbl5 = loadTable('#lima','<?php echo base64_encode("k,typ,count(k) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("k,typ");?>','lima');
	mytbl6 = loadTable('#enam','<?php echo base64_encode("HOUR(TIMEDIFF(solved,dtm))+1 as hrs,count(rowid) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where." and s in ('solved','closed')");?>','<?php echo base64_encode("(HOUR(TIMEDIFF(solved,dtm))+1)");?>','enam');
	mytbl7 = loadTable('#tujuh','<?php echo base64_encode("typ,count(rowid) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where." and s in ('solved','closed') and (HOUR(TIMEDIFF(solved,dtm))+1)>24");?>','<?php echo base64_encode("typ");?>','tujuh');
	mytbl8 = loadTable('#delapan','<?php echo base64_encode("day(dt) as dy,count(rowid) as cnt"); ?>','<?php echo base64_encode($tname); ?>','<?php echo base64_encode($where);?>','<?php echo base64_encode("day(dt)");?>','delapan');
	mytbl9 = loadTable('#sembilan','<?php echo base64_encode("n.updby,count(distinct ticketid) as cnt"); ?>','<?php echo base64_encode("tm_notes n join tm_tickets t on t.ticketno=n.ticketid"); ?>','<?php echo base64_encode("n.s in ('solved','closed') and n.updby<>'system'");?>','<?php echo base64_encode("n.updby");?>','sembilan');
	
	/*
	jvalidate = $("#myf").validate({
    rules :{
        "customer" : {
            required : true
        },
		"reason" : {
            required : function(element) {
						if ($("#status").val() == "QO") {
							return true;
						}
						else {
							return false;
						}
					}
        }
    }});
	*/
	//runChart();
});

function tblupdate(){
	mytbl1.ajax.reload();
	mytbl2.ajax.reload();
	mytbl3.ajax.reload();
	mytbl4.ajax.reload();
	mytbl5.ajax.reload();
	mytbl6.ajax.reload();
	mytbl7.ajax.reload();
	mytbl8.ajax.reload();
	mytbl9.ajax.reload();
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}
</script>


<?php //include "r_tickets.incc.php";?>
	
    </body>
</html>