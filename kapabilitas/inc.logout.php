        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->
		
		<div class="modal" id="modal_delete" tabindex="-3" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="smallModalHead">Delete</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete this record?
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" onclick="sendDataFile('#myf','DEL');">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>  
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
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="mmCloseClick('<?php echo $menu?>');">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->               
		
		<script type="text/javascript" src="js/push.min.js"></script>
<script>
function mmCloseClick(m){
	if($('#processing_msgs').text()=='Data has been saved'){
		$("#modal_large").modal('hide');
	}
	if((m=='ticketbaru'||m=='forumd')&&$('#processing_msgs').text()=='Data has been saved'){
		parent.$.fancybox.close();
		//if(typeof(parent.tblupdate)==='function') parent.tblupdate();
		//if(typeof(parent.getLatest)==='function') parent.getLatest();
	}
	return;
}
function openDelete(id){
	$("#id").val(id);
}
function openBatch(id){
	$('#'+id).find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
}
function openForm(id){
	jvalidate.resetForm();
	$(".error").removeClass("error");
	$(".valid").removeClass("valid");
	$('#id').val(id);
	$('#myf').find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
	$('#myf').find("input[type=checkbox]").prop('checked',false);
	
	//console.log($('#id').val());
	if(id==0){
		$('#bdel').hide();
		if($('.selectpicker').length){	$('.selectpicker').selectpicker('refresh'); }
		//$("#preview").attr("src",'img/nopic.png');
		//$("#preview2").attr("src",'img/nopic.png');
	}else{
		$('#bdel').show();
		getData(id);
	}
}

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

		function sendDataFile(f,svt){
			manage_msgs('start');
			$("#modal_no_head").modal('show');
			$("#svt").val(svt);
			
			var url='datasave.php';
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
					if('<?php echo $menu?>'!='surveydeu'){
						tblupdate();
					}
					//$("#modal_large").modal('hide');
				},
				error: function(xhr){
					$("#processing_msgs").html(xhr);
					manage_msgs('end');
				},
				cache: false,
				contentType: false,
				processData: false
			});
			
		};

		function getData(id){	
			
			manage_msgs('start');
			$("#modal_no_head").modal('show');
			
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'<?php echo $menu?>',id:id};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					var json=JSON.parse(data);
					//console.log(json);
					var pict="img/nopic.png";
					var pict2=pict;
					$.each(json[0],function (key,val){
						$('#'+key).val(val);
						if (typeof multiSelect === 'function') { multiSelect(key,val); }
						/*if(val=='Y'){$('#'+key+'x')[0].checked=true;}
						if((key=='pict'||key=='img'||key=='pic')&&val!=''){
							pict=val;
						}
						if((key=='cover')&&val!=''){
							pict2=val;
						}
						if(key=="sqlstr"){
							$('#sqlstrx').val(atob(val));
						}*/
					});
					//$("#preview").attr("src",pict);
					//$("#preview2").attr("src",pict2);
					$("#modal_no_head").modal('hide');
				},
				error: function(xhr){
					$("#processing_msgs").html(xhr);
					manage_msgs('end');
				}
			});
			
		};

		var thePopup=[];
		var popupbody="";
		function getNotif(){	
			
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'notif',id:0};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					thePopup = []; popupbody = "";
					var json=JSON.parse(data);
					var a=0, n=0, msg="", s="";
					for(var i=0;i<json.length;i++){
						a++;
						s=json[i]['s'];
						if(s=='new'){
							n++;
							s='online';
							thePopup.push(json[i]);
							popupbody += json[i]['h']+'-'+json[i]['s']+'\n';
						}else{
							if(s=='solved'){
								thePopup.push(json[i]);
								popupbody += json[i]['h']+'-'+json[i]['s']+'\n';
							}
							//if(s=='open'){
							//	s='away';
							//}else{
								s='offline';
							//}
						}
						msg+=  '<a target="_blank" href="ticket<?php echo $env;?>?g=1&id='+json[i]['rowid']+'" class="list-group-item fancy">'+
                                    '<div class="list-group-status status-'+s+'"></div>'+
                                    '<span class="contacts-title">'+json[i]['h']+'</span>'+
                                    '<p>'+json[i]['tglj']+'</p>'+
                                '</a>';
					}
					//console.log(json[0]['alert']);
					if(a>=4){
						//console.log('lebih 4');
						$("#txtmsg").css('height','200px');
					}else{
						$("#txtmsg").css('height','100%');
					}
					$("#alert").text(a);
					$("#nalert").text(n);
					$("#txtmsg").html(msg);
					if(typeof $(".fancy").fancybox==='function'){
						$(".fancy").fancybox({'type':'iframe'});
					}
					if(a==0){
						$("#txtlnk").css('display','none');
					}else{
						$("#txtlnk").css('display','inline');
					}
					//pushThis();
					//if (typeof tblPupdate === 'function') { tblPupdate(); }
				},
				error: function(xhr){
					console.log(xhr);
				}
			});
			setTimeout(getNotif,1*60*1000);
		};
		<?php if($menuloaded){?>
		setTimeout(getNotif,3*1000);
		<?php }?>
		function pushThis(){
			var fromnotif = "<?php echo isset($_GET['fromnotif'])?"1":"";?>";
			if(thePopup.length>0 && fromnotif==""){
				var lnk = "";
				var body= "";
				var fancyx = false;
				if(thePopup.length>1){
					lnk = 'tickets<?php echo $env;?>?fromnotif=1';
					body = popupbody;
				}else{
					lnk = 'ticket<?php echo $env;?>?g=1&fromnotif=1&id='+thePopup[0]['rowid'];
					body = thePopup[0]['h']+'-'+thePopup[0]['s'];
					fancyx = true;
				}
				Push.create("Ticket(s) need attention",{
					body: body,
					timeout: 10000,
					onClick: function () {
						this.close();
						window.focus();
						if(fancyx){
							if(typeof $(".fancy").fancybox==='function'){
								$.fancybox.open({type:'iframe',src: lnk});
							}else{
								window.open(lnk);
							}
						}else{
							document.location.href = lnk;
						}
					}
				});
			}
			
		}
</script>