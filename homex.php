<?php
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

$menu="home";
$title="Summary";
$icon="fa fa-tachometer";

include 'inc.head.php';

$conn=connect();
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
                    <li><a href="#">Home</a></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<!--a href="home.php" class="btn btn-success"><i class="fa fa-calendar"></i>Daily</a>
					<a href="home.php?p=week" class="btn btn-warning"><i class="fa fa-calendar"></i>Weekly</a>
					<a href="home.php?p=month" class="btn btn-danger"><i class="fa fa-calendar"></i>Monthly</a-->
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
<?php
include 'home.inci.php';
?>
                    <div class="row">
                        <div class="col-md-9">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Tanggal Terima</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-bar-example" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END BAR CHART -->

                        </div>
                        <div class="col-md-3">

                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Kondisi</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-example" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                        

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
		<script type="text/javascript" src="js/plugins/owl/owl.carousel.min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>
        <!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
		<!--script type="text/javascript" src="js/cdemo_charts_morris.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
	
<?php
include 'home.incc.php';
disconnect($conn);
?>
    </body>
</html>

