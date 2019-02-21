<?php if (!defined('BASEPATH')) 
exit('No direct script access allowed');  ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		<?php echo $title;?>
	</title>

	 <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url()?>assets/themes/custom/styles.css" />
	<!-- <script src="main.js"></script> -->
</head>

<body>

	<div class="container-fluid" >

		<?php
            echo form_open('backoffice/Manage_users/execute_search');
            
            echo form_input(array('name' => 'search'));
            
            echo form_submit('search_submit', 'Submit');
            

			echo form_close();
			?>
		<h2>Registered users</h2>
		<?php echo anchor ("backoffice/Manage_users/new_user/", "add user"); ?>
		<table class="table table-sm">
			<tr>
				<th>Count
				</th>
				<th>First Name
				</th>
				<th>Last Name
				</th>
				<th>Phone No.
				</th>
				<th>Username
				</th>
				<th>Email
				</th>
				<th>Image
				</th>
				<th>Status
				</th>
			</tr>
			<?php
            
            if($all_users->num_rows() > 0){
                $count=$page;
                foreach($all_users->result()
                 as $row){
                    {
                        $count++;
                        $id=$row->user_id;
                        $first_name=$row->first_name;
                        $last_name=$row->last_name;
                        $phone_number=$row->phone_number;
                        $username=$row->username;
                        $user_email=$row->user_email;
                        $profile_icon=$row->profile_icon;
						$check=$row->user_status;
                       
                        ?>
			<tr>
				<td>
					<?php echo $count;?>
				</td>
				<td>
					<?php echo $first_name;?>
				</td>
				<td>
					<?php echo $last_name;?>
				</td>
				<td>
					<?php echo $phone_number;?>
				</td>
				<td>
					<?php echo $username;?>
				</td>
				<td>
					<?php echo $user_email;?>
				</td>
				
				<td><img class="thumbnail" style="height: 100px; width: 100px;" src="<?php echo base_url(); ?>assets/uploads/<?php echo $row->profile_icon; ?>" /></td>
				<td>
					<?php if($check==0)
					{
						echo "<button class='badge badge-danger'> deactivated</button>";
					}
					else
					{
						echo "<button class= 'badge badge-success'>active</button>";
					}
					?>
				</td>
				<td>
				
				
					<a href="#individualUser<?php echo $id?>"  class="btn btn-primary" data-toggle="modal" data-target="#individualUser<?php echo $id?>">View</a>
					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="individualUser<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					 aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">
										<?php echo $username;?>
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="table">
										<tr>
										<th>Count
										</th>
										<th>First Name
										</th>
										<th>Last Name
										</th>
										<th>Phone No.
										</th>
										<th>Username
										</th>
										<th>Email
										</th>
										<th>Image
										</th>
										
										</tr>
	
										<tr>
											<td>
												<?php echo $count;?>
											</td>
											<td>
												<?php echo $first_name;?>
											</td>
											<td>
												<?php echo $last_name;?>
											</td>
											<td>
												<?php echo $phone_number;?>
											</td>
											<td>
												<?php echo $username;?>
											</td>
											<td>
												<?php echo $user_email;?>
											</td>

											<td><img class="thumbnail" style="height: 100px; width: 100px;" src="<?php echo base_url(); ?>uploads/images/<?php echo $row->profile_icon; ?>" /></td>
											<td>

												
                    <button class="btn btn-warning"><?php echo anchor("backoffice/Manage_users/edit_update/".$id,"Edit");?></button>
					<?php
					 if($check==0){
						echo anchor("backoffice/Manage_users/activate/".$id,"Activate", array("onclick"=>"return confirm('Are you sure to activate?')", "class"=>"btn btn-success"));
					
					 }
					 else
					 {
						echo anchor("backoffice/Manage_users/deactivate/".$id,"Deactivate", array("onclick"=>"return confirm('Are you sure to deactivate?')","class"=>"btn btn-danger"));
					 }
					 
					 ?>
                    <button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')"> <?php echo anchor("backoffice/Manage_users/delete/".$id,"Delete");?></button> </td> </tr>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</div>
					</div>
						
					
                    <button class="btn btn-warning"><?php echo anchor("backoffice/Manage_users/edit_update/".$id,"Edit");?></button>
					 <?php
					 if($check==0){
						echo anchor("backoffice/Manage_users/activate/".$id,"Activate", array("onclick"=>"return confirm('Are you sure to activate?')", "class"=>"btn btn-success"));
					
					 }
					 else
					 {
						echo anchor("backoffice/Manage_users/deactivate/".$id,"Deactivate", array("onclick"=>"return confirm('Are you sure to deactivate?')","class"=>"btn btn-danger"));
					 }
					 
					 ?>
                    <button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')"> <?php echo anchor("backoffice/Manage_users/delete/".$id,"Delete");?></button>
                     </td> </tr> <?php }}} ?>
		</table>
		<!-- <//?php echo ('<div id="pagination">'. $this->pagination->create_links().'</div>');?> -->
	</div>
</body>

</html>
