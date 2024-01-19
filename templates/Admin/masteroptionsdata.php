<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var baseURL = "<?php echo $this->Url->build('/', array('fullBase'=>true)); ?>";
  </script>
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Add Executive</h3>
					
				</div>
				  <?php debug($masterOp_Data);
						echo $this->Flash->render ();
						echo $this->Form->create ( null, array (
								'url' => array (
										'controller' => 'Admin',
										'action' => 'createfeildexecutive' 
								),
								'enctype' => 'multipart/form-data',
								'id' => 'login' 
						) );
						?>

				<div class="card-body">
					<!-- <div class="form-group">
						<label for="inputName">Name</label> <input type="text" name="name" class="form-control">
					</div> -->
					
					<!-- <div class="form-group">
						<label for="inputStatus">Phone</label> <input type="text" name="Mobilenumber" class="form-control">
					</div> -->
					<div class="form-group">
						<label for="inputStatus">option</label>
					<?php	
					
					echo $this->Form->control('Selected Country', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' =>$masterOp_Data,
                        'id' => 'branch_id',
                        'class' => 'form-control people ra_input', // Add any additional classes as needed
                    ]);?>
					</div>
					<div class="form-group">
						<label for="inputClientCompany">Username</label> <input name="username" id="inputClientCompany" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="inputClientCompany">Password</label> <input type="password" name="password" id="inputClientCompany" class="form-control">
					</div>
					<!-- <div class="form-group">
						<label for="inputClientCompany">Re-Enter Password</label> <input type="password" name="reenterpassword" id="inputClientCompany" class="form-control">
					</div> -->
					<input type="submit" value="Add new Executive" class="btn btn-success  bg-gradient-primary  btncompany""> <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
				</div>
				<?php echo $this->Form->end ();?>
			</div>
		</div>
	</div>
</section>