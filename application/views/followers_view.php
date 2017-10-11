<html>
<head>
	<title>Followers List</title>
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  <!-- Compiled and minified JavaScript -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>
          
</head>
<script type="text/javascript">
	$(document).ready(function(){
		$('.name').click(function(){
			var base_url = '<?php echo base_url() ?>';
			var id = $(this).attr('idvalue');
			data = $('#'+id).attr('res');
			dataJson = JSON.parse(data);
			$.ajax({
				type: "get",
				url: base_url+"index.php/Followers/twubric",
				cache: false,    
				data: {
					data : dataJson	
				},
				success: function(json){
					jsonData = JSON.parse(json);
					$('#json').text(JSON.stringify(jsonData,null,4));
					
				}      
				
			});

		});
	});
</script>
<body>
	<div class="container">
		<div class="row">	
			<div class="col s12 m6 offset-m3 l6 offset-l3">
				<?php 
				if($this->session->userdata('sess_logged_in')==1){?>
					<a href="<?=base_url()?>index.php/auth/logout" class="waves-effect waves-light btn blue darken-1"><i class="fa fa-twitter left"></i>Twitter logout</a>
				<?php }?>
				
			</div>
		</div>
		<div class="row">	

			<?php  if(isset($_SESSION['username'])) {?>
				<div class="col s12 m6 l4">
					<div class="card ">
			            <div class="card-image">
			              <img src="<?=$_SESSION['profile_pic']?>">
			            </div>
			            <div class="card-action">
			              <a href="#"><?=$_SESSION['name']?></a>
			            </div>
			        </div>
				</div>
			<?php }?>
		</div>
	</div>
	<div align="center">
		<h2>Followers List</h2>
	</div>
	<div align="center">
		<h4>Click on followers name link to get Twubric score</h4>
	</div>
	<div class="container">
		<div class="row">	
			<table>
				<tr>
					<td>
						<?php foreach($resultData as $res){?>
							<a style="cursor: pointer;" class="name" idvalue ="<?=$res['id']?>"><?=$res['name']?></a><br>
							<input type="hidden" id="<?=$res['id']?>" res='<?=json_encode($res)?>' />
						<?php }
						?>
					</td>
					<td>
						<span class="display"><pre id = "json"></span>
					</td>
						
				</tr>
			</table>
		</div>
	</div>

</body>
</html>