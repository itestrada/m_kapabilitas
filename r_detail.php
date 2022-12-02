<?php
include 'inc.chksession.php';
include 'inc.common.php';

$id=$_GET['id'];
$id2=$_GET['id2'];
$r=$_GET['r'];

$title="Tickets";
$icon="fa fa-file-o";
$menu=$r;

include 'inc.head.php';

$where="";
$tname="tm_tickets t";

switch(substr($r,8)){
	case "satu": $where="k='$id'"; break;
	case "dua": $where="st='$id'"; break;
	case "tiga": $where="k='$id' and st='$id2'"; break;
	case "empat": $where="left(h,3)='$id' and st='$id2'"; break;
	case "lima": $where="k='$id' and typ='$id2'"; break;
	case "enam": $where="s in ('solved','closed') and (HOUR(TIMEDIFF(solved,dtm))+1)='$id'"; break;
	case "tujuh": $where="s in ('solved','closed') and (HOUR(TIMEDIFF(solved,dtm))+1)>24 and typ='$id'"; break;
	case "delapan": $where="day(dt)='$id'"; break;
	case "sembilan": $where="n.updby='$id' and n.s in ('solved','closed') and n.updby<>'system'"; $tname="tm_notes n join tm_tickets t on t.ticketno=n.ticketid"; break;
}

$cols="ticketno,dt,h,d,k,grp,st,typ,p,t.s,t.rowid";
$colsrc="";

?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
//include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <!--li><a href="home.php">Home</a></li-->
                    <li class="active">&nbsp;</li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
				<!--	<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                -->
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
                                                <th>Date</th>
                                                <th>Outlet</th>
                                                <th>Detail</th>
                                                <th>Kanwil</th>
                                                <th>Group</th>
                                                <th>Link</th>
                                                <th>Gangguan</th>
                                                <th>Filter</th>
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
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type='text/javascript' src='js/jquery-validate-multi-email.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <!-- END PAGE PLUGINS -->       
		
		<script src="js/plugins/datatables/dataTables.buttons.js"></script>
		<script src="js/plugins/datatables/buttons.flash.js"></script>
		<script src="js/plugins/datatables/jszip.min.js"></script>
		<script src="js/plugins/datatables/pdfmake.min.js"></script>
		<script src="js/plugins/datatables/vfs_fonts.js"></script>
		<script src="js/plugins/datatables/buttons.html5.js"></script>
		<script src="js/plugins/datatables/buttons.print.js"></script>

		<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">

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
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	searching: false,
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
				d.df= '<?php echo $_GET['df']; ?>',
				d.dt= '<?php echo $_GET['dt']; ?>',
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "notes" : {
            required : true
        }
    }});
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
	
    </body>
</html>
