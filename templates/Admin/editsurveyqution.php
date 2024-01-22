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
					<h3 class="card-title">Edit Survey Question</h3>
					
				</div>
                <?= $this->Form->create($surveyedit) ?>

				<div class="card-body">
				
					<div class="form-group">
                    <?php echo $this->Form->control('section', [
                    'type' => "text",
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ],
                    'class' => 'form-control'
                    ]);?>
					</div>
					<div class="form-group">
                    <?php echo $this->Form->control('question', [
                    'type' => "text",
                    'templates' => [
                        'inputContainer' => '<div class="form-group">{{content}}</div>'
                    ],
                    'class' => 'form-control'
                    ]);?>

					</div>
					
					<div class="form-group">
                    <?php 
                    $AnswerType=[
                        'Select'=>'Select',
                        'Dropdown'=>'Dropdown',
                        'Text Box'=>'Text Box',
                        ];

                    echo $this->Form->control('option_type', [
                        'type' => 'select',
                        'options' => $AnswerType,
                        'id' => 'answer_type',
                        'class' => 'form-control people', // Add any additional classes as needed
                        ]);
                    ?>
					</div>
                    <div class="form-group">
                    <?php 
                    echo $this->Form->control('master_main_id', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' => $masterOptionData,
                        'id' => 'branch_id',
                        'class' => 'form-control people ra_input', // Add any additional classes as needed
                    ]);
                    ?>					</div>
                
					
					<input type="submit" value="Submit" class="btn btn-success  bg-gradient-primary  btncompany""> <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
				</div>
				<?php echo $this->Form->end ();?>
			</div>
		</div>
	</div>
</section>
<script>
$(document).ready(function() {
    $('#answer_type').change(function() {
        var selectedOption = $(this).val();

        // Hide both fields initially
        $('#dropdown_field').hide();
        $('#text_field').hide();

        if (selectedOption === 'Dropdown') {
            $('#dropdown_field').show(); // Show the dropdown field if 'Dropdown' is selected
        } else if (selectedOption === 'Text Box') {
            $('#text_field').show(); // Show the text field if 'Text Box' is selected
        }
    });
});
</script>