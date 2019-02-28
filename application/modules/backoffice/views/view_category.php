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

	<div class="container-fluid" style="margin-top:50px;margin-left:50px;">

		<?php
            echo form_open('backoffice/Manage_category/execute_search');
            
            echo form_input(array('name' => 'search'));
            
            echo form_submit('search_submit', 'Submit');
            

			echo form_close();
			?>
		<h1>Categories</h1>
		<?php echo anchor ("backoffice/Manage_category/add_category/", "add category"); ?>
		<table class="table table-sm">
			<tr>
				<th>#
				</th>
				<th>Category Name
				</th>
				<th>Parent
				</th>
				<th>Image
				</th>
				<th>Status
				</th>
				<th>Actions
				</th>
			</tr>
			<?php
            
            if($all_categories->num_rows() > 0){
                $count=0;
                foreach($all_categories->result()
                 as $row){
                    {
                        $count++;
                        $id=$row->category_id;
                        $category_name=$row->category_name;
                        $category_parent=$row->category_parent;                        
						$category_image=$row->category_image;
						$check=$row->category_status;
                       
                        ?>
			<tr>
				<td>
					<?php echo $count;?>
				</td>
				<td>
					<?php echo $category_name;?>
				</td>
				<td>
					<?php echo $category_parent;?>
				</td>

				<td><img class="thumbnail" style="height: 100px; width: 100px;" src="<?php echo base_url(); ?>assets/uploads/<?php echo $row->category_image; ?>" /></td>
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


					<a href="#category<?php echo $id?>" class="btn btn-primary" data-toggle="modal" data-target="#category<?php echo $id?>"><i
						 class="fas fa-eye"></i></a>
					<!-- Button trigger modal -->


					<!-- Modal -->
					<div class="modal fade" id="category<?php echo $id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
					 aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">
										<?php echo $category_name;?>
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="table">
										<tr>
											<th>#
											</th>
											<th>Category Parent
											</th>
											<th>Category Name
											</th>
											<th>Image
											</th>

											<th>Actions
											</th>
										</tr>

										<tr>
											<td>
												<?php echo $count;?>
											</td>
											<td>
												<?php echo $category_parent;?>
											</td>
											<td>
												<?php echo $category_name;?>
											</td>
											<td><img class="thumbnail" style="height: 100px; width: 100px;" src="<?php echo base_url(); ?>assets/uploads/<?php echo $row->category_image; ?>" /></td>
											<td>


												<button class="btn btn-warning">
													<?php echo anchor("backoffice/Manage_users/edit_update/".$id,"<i class='fas fa-edit'></i>");?></button>
												<?php
					 if($check==1){
						echo anchor("backoffice/Manage_category/deactivate/".$id,'<i class="far fa-thumbs-down"></i>', array("onclick"=>"return confirm('Are you sure to deactivate?')", "class"=>"btn btn-danger"));
					
					 }
					 else
					 {
						echo anchor("backoffice/Manage_category/activate/".$id,'<i class="far fa-thumbs-up"></i>', array("onclick"=>"return confirm('Are you sure to activate?')","class"=>"btn btn-success"));
					 }
					 
					 ?>
												<button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">
													<?php echo anchor("backoffice/Manage_category/delete/".$id,"<i class='fas fa-trash-alt'></i>");?></button>
											</td>
										</tr>
									</table>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</div>
					</div>


					<button class="btn btn-warning">
						<?php echo anchor("backoffice/Manage_category/edit_update/".$id,"<i class='fas fa-edit'></i>");?></button>
					<?php
					 if($check==1){
						echo anchor("backoffice/Manage_category/deactivate/".$id,'<i class="far fa-thumbs-down"></i>', array("onclick"=>"return confirm('Are you sure to deactivate?')", "class"=>"btn btn-danger"));
					
					 }
					 else
					 {
						echo anchor("backoffice/Manage_category/activate/".$id,'<i class="far fa-thumbs-up"></i>', array("onclick"=>"return confirm('Are you sure to activate?')","class"=>"btn btn-success"));
					 }
					 
					 ?></button>
					<button class="btn btn-danger" onclick="return confirm('Are you sure to delete?')">
						<?php echo anchor("backoffice/Manage_category/delete/".$id,"<i class='fas fa-trash-alt'></i>");?></button>
				</td>
			</tr>
			<?php }}} ?>
		</table>

	</div>
</body>

</html>
