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
				<?php
						echo $this->Flash->render ();
						echo $this->Form->create ( null, array (
								'url' => array (
										'controller' => 'Admin',
										'action' => 'editmasteroption' 
								),
								'enctype' => 'multipart/form-data',
								'id' => 'login' 
						) );
						?>

				<div class="card-body">
					
				<div class="form-group">
				<?php foreach ($masterOp_Data as $index => $survey): ?>
					<?php $masterdata = $survey->master_main->name; ?>
					 <?php endforeach; ?>
                     <label for="<?= 'option_' . $survey->id ?>" style="font-weight:bold; font-size:16px"><?= $masterdata ?></label><br>

                     <?php foreach ($masterOp_Data as $index => $survey): ?>
                               <br>
                     <input class="form-control" type="text" id="<?= 'option_' . $survey->id ?>" name="survey_option[<?= $survey->id ?>]" value="<?= htmlspecialchars($survey->option_value) ?>">
					
                     <?php endforeach; ?>
					 <input class="form-control" type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

					 <?php// debug($id);?>
                     </div>
					<?= $this->Form->button(__('Submit'), ['class' => "btn  bg-gradient-primary  btncompany"]) ?>
					<a href="javascript:history.back()" class="btn btn-secondary">Back</a> 
				</div>
				<?php echo $this->Form->end ();?>
			</div>
		</div>
	</div>
</section>