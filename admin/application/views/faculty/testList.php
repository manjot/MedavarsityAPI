<?php $this->load->view('includes/headerfaculty');?>
<?php $this->load->view('includes/sidebarfaculty')?>
		<div class="page-content-wrapper">
			<div class="page-content">
				<h3 class="page-title">
				Dashboard</h3>
                <?php print $this->session->flashdata('url_sussess'); ?>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo base_url('Faculty');?>">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="<?php echo base_url('Faculty/Lecturesss');?>">Lectures</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
						
			<a href="<?php echo base_url('Faculty/addtest/'.$result['getLectureVideo']->id)?>" class="btn btn-circle btn-default"><i class="fa fa-plus"></i><span class="hidden-480">Add Question </span>
			</a>
													<br><br>
			<span id="input_num_error" style="color:red;"></span>
				<div class="portlet light">
					<div class="portlet-body">
						<div class="row">

					<div class="col-md-9">
					<div class="tab-content">
					<div id="tab_1" class="tab-pane active">
					<div id="accordion1" class="panel-group">
					<?php if(!empty($result['testQust'])) {?>
					<?php $i=1;  
					foreach ($result['testQust'] as $value) { $i++; ?> 
					<div class="panel panel-default">
					<div class="panel-heading">
					<h4 class="panel-title">
					<a class="accordion-toggle" onclick="getALLanswer(<?php echo $value['id'];?>);" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_<?php echo $i?>">
					<?php echo $value['test_question'];?> 
				    </a>
					</h4>
					<div align="right"><a onclick="deletetestquestion(<?php echo $value['id'];?>)" href="javascript:;"><i style="color:red" class="fa fa-trash" aria-hidden="true"></i></a></div>
					</div>
					<div id="accordion1_<?php echo $i?>" class="panel-collapse collapse">
					<div class="panel-body" id="allAns2">							 
					</div>
					</div>
					</div>
					<?php }?>
					<?php }else{?>	
					<div><p>No Questions for the test added yet. Please enter questions for the test</p></div>			<?php } ?>	
					</div>
					</div>
					</div>
					</div>



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	
<?php $this->load->view('includes/footer');?>

<script type="text/javascript">
function allQuest(){
       var questid = $("#questid").val(); 
       //alert(questid);
   $.ajax({
			url: "<?php echo site_url();?>Faculty/allAnswer",
			method: "POST",
			data: {'questid':questid},
			dataType: "html",
			success: function(data)
			{
			jQuery('div#allAns').html(data);
			}
			
		});
   
}
allQuest(); // This will run on page load
setInterval(function(){
    allQuest() // this will run after every 5 seconds
}, 2000);

function getALLanswer(id)
{
var questid = id; 
   $.ajax({
			url: "<?php echo site_url();?>Faculty/allAnswer2",
			method: "POST",
			data: {'questid':questid},
			dataType: "html",
			success: function(data)
			{
			jQuery('div#allAns2').html(data);
			}
			
		});
}
</script>
<script>
		var url = '<?php echo base_url();?>';
		function deletetestquestion(id) {
			var x = confirm("Are you sure you want to delete?");
			if(x){
				jQuery.ajax({
				url: url + 'Faculty/deletetestquestion',
				type: 'post',
				data: {id: id},
				dataType: 'json',
				success: function (json) {
					if(json.msg == 'success')
					{
						 jQuery('span#input_num_error').html('<p>Test question deleted successfully</p>');	
						 setTimeout(function(){
						 window.location.reload();
						}, 3000);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
				});
			}	
		}
</script>