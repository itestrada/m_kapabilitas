<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Detail Tickets Report";
$icon="fa fa-file-text";
$menu="rtick";

include 'inc.head.php';

$where="";
$tname="tm_tickets t left join tm_kanwils k on k.locid=t.k left join tm_ips i on i.oid=t.i and i.layanan=t.st";
$cols="ticketno,dt,i,h,d,locname,sid,st,grp,typ,s,solved,closed,t.lastupd,t.updby,t.rowid";
$colsrc="h,d,locname";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";

include 'inc.db.php';
$conn=connect();
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
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="">
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
										<option value="">All Gedung</option>
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
										<select class="form-control" name="st" id="st">
										<option value="">All Service</option>
										<?php echo $optst?>
										</select>
									</div>
									<!--div class="col-md-1">
										<select class="form-control" name="blink" id="blink">
										<option value="">All Secondary Link</option>
										<?php echo $optblink?>
										</select>
									</div-->
									<div class="col-md-1">
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
                                                <th>SID</th>
                                                <th>Service</th>
                                                <th>Group</th>
                                                <th>Problem</th>
                                                <th>Status</th>
                                                <th>Solved On</th>
                                                <th>Closed On</th>
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
	var mytbl, jvalidate;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrB<t>ip>',
	lengthMenu: [[10,25,50,100,-1],["10","25","50","100","All"]],
	buttons: [
            'copy', 'csv', 'excel', 'print',
			{
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
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
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.s= $("#status").val(),
				d.typ= $("#pic").val(),
				d.k= $("#customer").val(),
				d.grp= $("#grp").val(),
				d.st= $("#st").val(),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.blink= $("#blink").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
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
	
	runChart();
});

function tblupdate(){
	mytbl.ajax.reload();
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