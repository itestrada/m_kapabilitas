<?php
include 'inc.chksession.php';
include 'inc.common.php';

$pkid=$_GET['id'];

$title="Survey[Wrong ID]";
$icon="fa fa-edit";
$menu="surveydeu";

include 'inc.head.php';

$where="survid='$pkid'";
$tname="tm_survey";
$cols="srt,g,q,score";
$colsrc="";
$cnt=0;

include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select n,count(survid) from tm_surveys s left join tm_survey d on d.survid=s.rowid where s.rowid=$pkid");
while($row=fetch_row($rs)){
	$title=$row[0];
	$cnt=$row[1];
}
if(!is_numeric($cnt)){$cnt=0;}
if($cnt<1){$title.=" No Question :-(";}
disconnect($conn);

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
					<?php if($cnt>0){?>
					<a href="#" onclick="sendDataFile('#myft','SAVE');" class="btn btn-info pull-right"><i class="fa fa-save"></i> SAVE</a>
					<?php }?>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
								<form id="myft">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="<?php echo $pkid?>">
									<input type="hidden" name="cnt" id="cnt" value="<?php echo $cnt?>">
									<input type="hidden" name="uid" value="<?php echo $s_ID?>">
									
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Topic</th>
                                                <th>Question</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
	searching: false,
	serverSide: true,
	processing: true,
	ordering: true,
	lengthMenu: [[-1],["All"]],
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
        "srt" : {
            required : true
        },
		"g" : {
            required : true
        },
		"q" : {
            required : true
        },
		"score" : {
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
