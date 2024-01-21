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
					<h3 class="card-title">Master Options</h3>
					
				</div>
				  <?php //debug($masterOp_Data);?>

				<div class="card-body">
					
					<div class="form-group">
					<?php foreach ($masterOp_Data as $index => $survey): ?>
						<?php $masterdata = $survey->master_main->name;?>

					<?php endforeach; ?>
					<label for="formGroupExampleInput" style="font-weight:bold;font-size:16px"><?php echo $masterdata ?></label><br>

					<?php 
					foreach ($masterOp_Data as $index => $survey): ?>
					<br>
					<input class="form-control" type="text" placeholder="<?= h($survey->option_value) ?>" readonly>
					<?php endforeach; ?>
					<?php 
					// echo $this->Form->control('Master Option', [
                    //     'type' => 'select',
                    //     //  'multiple' => 'checkbox',
                    //     'options' =>$masterOp_Data,
                    //     'id' => 'branch_id',
                    //     'class' => 'form-control people ra_input', // Add any additional classes as needed
                    // ]);
					?>
					</div>
					
					<a href="javascript:history.back()" class="btn btn-secondary">Back</a> 
				</div>
				<?php echo $this->Form->end ();?>
			</div>
		</div>
	</div>
</section>