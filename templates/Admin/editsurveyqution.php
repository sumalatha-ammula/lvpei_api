<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var baseURL = "<?php echo $this->Url->build('/', array('fullBase'=>true)); ?>";
  </script>
  <style>.ra_inputl{
    margin-left: 130px;
}
</style>
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">Edit Survey Question</h3>
					
				</div>
               <?php //debug($surveyedit);?>
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
                        'Multiple'=> 'Multiple Select',
                        'Text Box'=>'Text Box',
                        ];
                    
                        if($surveyedit->is_clinical === false){
                            $is_clinical = true;
                        }else{
                            $is_clinical = false;
                        }
                        echo $this->Form->control('is Non clinical', [
                            'type' => 'checkbox', // Set the type to checkbox
                            'id' => 'edit_section',
                            'name' => 'is_clinical', 
                            'hiddenField' => '1', // Specify the value when the checkbox is unchecked
                            'value' => '0', // Set the value to '0' when the checkbox is c
                            'class' => 'form-check-input ra_inputl', // Add form-check-input class for proper styling
                            'checked' => $is_clinical // Set the 'checked' attribute based on the value of 'is_clinical'
                        ]);
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

<div class="form-group">
                    <?php 
                    echo $this->Form->control('parent_id', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' => $othersurveyquestions,
                        'id' => 'parent_id',
                        'class' => 'form-control', // Add any additional classes as needed
                    ]);
                    ?>					</div>
                
                <div class="form-group">
                    <?php 
                    echo $this->Form->control('show_if', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' => $othersurveyquestions,
                        'id' => 'show_if',
                        'class' => 'form-control', // Add any additional classes as needed
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
    var baseurl = "<?php echo $this->Url->build('/'); ?>";
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
    $("#parent_id").on('change', function(){
        var selectedOption = $(this).val();
        var url = baseurl+'api/getmasteroptions';
        var s = this;
        $.ajax( {
             url: url,
            //  headers: {'X-CSRF-TOKEN': csrfToken},
            
             method:'post',
             data: {
                id:selectedOption
                },
             success: function( data ) {
                 	 console.log( data );
                     var dt = jQuery.parseJSON(data);
                     console.log(dt);
                     var no='';
                     
                     $.each(dt.data.master_main.master_options, function(i, op){
                        
                        no += '<option value="'+op.master_main_id+'">'+op.option_value+'</option>';
                     });
                      $("#show_if").find('option')
                        .remove()
                        .end()
                        .append(no);
    
;


             }   

            });
    });
});
</script>