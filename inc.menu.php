<?php $menuloaded=true; ?>
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal">
                    <li class="xn-logo">
                        <a href="home.php"><img width="200px" height="50px" style="position:absolute;left:0px;top:0px;" src="img/logo-menubar-200x50-new.png"></a>
						<a href="#" class="x-navigation-control"></a>
                    </li>
					<?php
						if(($s_LVL==0||$s_LVL==1)&&$s_GRP==""){
						?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-database"></span> <span class="xn-text">Master</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="kanwils<?php echo $env?>"><span class="fa fa-map-o"></span> Gedung</a></li>
							<li><a href="outlets<?php echo $env?>"><span class="fa fa-map-marker"></span> Lokasi</a></li>
							<!--li><a href="outletips<?php echo $env?>"><span class="fa fa-tty"></span> IP</a></li>
							<li><a href="problems<?php echo $env?>"><span class="fa fa-warning"></span> Filters</a></li>
							<li><a href="timers<?php echo $env?>"><span class="fa fa-clock-o"></span> Notify</a></li>
							<li><a href="kanwilusers<?php echo $env?>"><span class="fa fa-user-circle-o"></span> User Polda</a></li-->
                        </ul>
                    </li>
						<?php }
						?>
                    <li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-check-square-o"></span> <span class="xn-text">Tickets</span></a>
                        <ul class="animated zoomIn">
							<li><a href="tickets<?php echo $env?>"><span class="fa fa-ticket"></span>Tickets</a></li>
							<li><a href="tickets<?php echo $env?>?pic=1&grp=1"><span class="fa fa-ticket"></span>Open</a></li>
					<?php
						if($s_LVL==4&&false){
						?>
							<li><a href="tickets<?php echo $env?>?grp=1"><span class="fa fa-ticket"></span>My Group</a></li>
						<?php } ?>
						</ul>
                    </li>
					<?php 
					if($s_LVL!=4&&$s_LVL!=6){
					?>
                    <li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Reports</span></a>                        
                        <ul class="animated zoomIn">
							<li><a href="r_summary<?php echo $env?>"><span class="fa fa-pie-chart"></span> Summary</a></li>
							<li><a href="r_tickets<?php echo $env?>"><span class="fa fa-file-text"></span> Tickets</a></li>
							<li><a href="r_outlets<?php echo $env?>"><span class="fa fa-file-text"></span> Lokasi</a></li>
							<!--li><a href="r_customs<?php echo $env?>"><span class="fa fa-file-text"></span> Customs</a></li-->
						</ul>
                    </li>
					<?php 
						}
					if($media){
						if($s_LVL<5){?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-newspaper-o"></span> <span class="xn-text">Media</span></a>                        
                        <ul class="animated zoomIn">
						<?php if($forum){?>
							<li><a href="f_forums<?php echo $env?>"><span class="fa fa-comments-o"></span> Forum</a></li>
						<?php }?>
						<?php if($survey){?>
							<li><a href="f_surveys<?php echo $env?>"><span class="fa fa-binoculars"></span> Survey</a></li>
						<?php }?>
						<?php if($feedback){?>
							<li><a href="f_comments<?php echo $env?>"><span class="fa fa-comments"></span> Feedbacks</a></li>
							<li><a href="fr_feedbacks<?php echo $env?>"><span class="fa fa-file-text"></span> Reports</a></li>
						<?php }?>
						</ul>
                    </li>
					<?php }
					}?>
					<li class="xn-openable pull-right">
                        <a href="#"><span class="fa fa-user"></span><span class="xn-text"><?php echo $s_NAME;?></span></a>
                        <ul class="animated zoomIn xn-drop-left">
						<?php
						if($s_LVL==0&&$s_GRP==""){
						?>
                            <li <?php if($menu=="users"){?> class="active"<?php }?>><a href="cmsusers<?php echo $env?>"><span class="fa fa-users"></span> Users</a></li>
							<li class="divider"></li>
						<?php } ?>
							<!--li><a target="_blank" href="../chat/"><span class="fa fa-comments"></span> Chats</a></li-->
							<li <?php if($menu=="cpwd"){?> class="active"<?php }?>><a href="cpwd.php"><span class="fa fa-magic"></span> Change Profile</a></li>
							<li><a title="Logout" href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Logout</a></li>
                        </ul>
                    </li>
					<li class="xn-icon-button pull-right" <?php if($s_LVL==9) echo 'style="display:none"'?>>
						<!--a href="tickets<?php echo $env?>?pic=1&a=1"><span class="fa fa-bell-o"></span></a-->
						<a href="#"><span class="fa fa-bell-o"></span></a>
						<div id="alert" class="informer informer-danger">0</div>
						<div class="panel panel-primary animated zoomIn xn-drop-left">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-comments"></span> New Tickets</h3>                                
                                <div class="pull-right">
                                    <span class="label label-success"><span id="nalert">0</span></span>
                                </div>
                            </div>
                            <div id="txtmsg" class="panel-body list-group list-group-contacts scroll"></div>     
                            <div id="txtlnk" class="panel-footer text-center">
                                <a href="tickets<?php echo $env?>?pic=1&a=1&grp=1">Show all</a>
                            </div>                            
                        </div>
					</li>
					<li class="xn-openable pull-right" style="cursor: default;">
						<a href="#"><span class="fa fa-headphones"></span><span class="xn-text">Helpdesk</span></a>
						<ul class="animated zoomIn xn-drop-left">
							<li><a href="whatsapp://send?phone=6287886297626"><span class="fa fa-whatsapp"></span> Almer (+62-878-8629-7626)</a></li>
							<li><a href="whatsapp://send?phone=6281318098840"><span class="fa fa-whatsapp"></span> Azhar (+62-813-1809-8840)</a></li>
							<li><a href="whatsapp://send?phone=6281317447160"><span class="fa fa-whatsapp"></span> Alif (+62-813-1744-7160)</a></li>
						</ul>
					</li>
					<?php if(false){?>
					<li class="xn-icon-button pull-right">
						<a href="#"><span class="fa fa-comments-o"></span></a>
						<div id="infolog" class="informer informer-info">0</div>
						<div class="panel panel-primary animated zoomIn xn-drop-left">
                            <div id="txtlog" class="panel-body list-group list-group-contacts scroll"></div>
                        </div>
					</li>
					<?php }?>
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->