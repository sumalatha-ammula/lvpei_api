
<?php 
//debug($surveys);?>
<style>
.ra_input{
    margin-bottom: 20px;
}
.ra_inputW{
	width: 40% !important;
	display: inline-block !important;
}
a.fas.fa-poll-h {
 color: #007bff;;
}

a.fas.fa-users {
    color: #007bff;
}
a.fas.fa-edit {
    color: #007bff;
}
a.fas.fa-trash{
    color: #007bff;
}
.ra_inputl{
    margin-left: 130px;
}
</style>


<div class="modal fade" id="surveyquestionsModel" tabindex="-1" role="dialog" aria-labelledby="surveyquestionsModel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Survey Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<div class="form-group">
						<!-- <label for="inputName">Question</label> <input type="text" name="questions" id="question" class="form-control"> -->
                        <?php
                             $AnswerType=[
                            'Select'=>'Select',
                            'Dropdown'=>'Dropdown',
                            'Multiple'=> 'Multiple Select',
                            'Text Box'=>'Text Box',
                            'Heading'=>'Heading'
                            ];
                           
                            echo $this->Form->create(null, array(
                            'url' => array(
                                'controller' => 'Admin', 'action' => 'addqutionsurveyrvapp'
                            ),
                            ));
                            echo $this->Form->control('Section', [
                            'type' => "text",
                            //   'readonly' => true,
                            'id' => 'edit_section',
                            'class' => "form-control ra_input",
                            ]);
                            echo $this->Form->control('Question', [
                            'type' => "text",
                            //   'readonly' => true,
                            'id' => 'edit_section',
                            'class' => "form-control ra_input",
                            ]);
                            echo $this->Form->control('Is Non Clinical', [
                                'type' => 'checkbox', // Set the type to checkbox
                                'id' => 'edit_section',
                                'name' => 'is_clinical', 
                                'hiddenField' => '1', // Specify the value when the checkbox is unchecked
                                'value' => '0', // Set the value to '0' when the checkbox is checked
                                'class' => 'form-check-input ra_inputl', // Add form-check-input class for proper styling
                            ]);
                            
                           
                            echo $this->Form->control('Option Type', [
                            'type' => 'select',
                            'options' => $AnswerType,
                            'id' => 'answer_type',
                            'class' => 'form-control people', // Add any additional classes as needed
                            ]);
                             ?>
                            </div>
                            <div id="dropdown_field" style="display: none;">
                            <?php
                            echo $this->Form->control('Select Survey Question', [
                              'type' => 'select',
                              'options' =>  $masterOptionData, 
                              'class' => 'form-control people',
                               ]);
                                ?>
                                </div>

                                <div id="text_field" style="display: none;">
                                <?php
                                 // Code for text field here
                                //  echo $this->Form->control('Text Field', [
                                //     'type' => 'text',
                                //     'class' => 'form-control people',
                                //    ]);
                                   ?>
                                 </div>
                               <?php echo $this->Form->control('id', [
                                'type' => 'hidden',
                                'id' => 'updateadreqid',
                                'class' => 'form-control',
                                'value' => $id, // Replace $id with the actual value you want to send
                               ]); ?>
                   
					         <div class="surveyoptions" id="surveyoptions"></div>
				             </div>
                             <div class="rv_app_space" style="margin-left: 20px;">
                             <?= $this->Form->button(__('Submit'), ['class' => "btn  bg-gradient-primary  btncompany"]) ?>
                             <a class="btn btn-danger" data-dismiss="modal">Cancel</a>
                             </div>
                             <?= $this->Form->end() ?>

			          </div>
		            </div>
	            </div>
            </div>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
            <a href="#" class="btn btn-block bg-gradient-primary  btncompany addsurveyquestions" data-question="<?php //echo $survey->id;?>" id="id">Create Survey Question</a>     
                	</div>
                    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for Question...">

		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table id="surveyTable" class="table table-hover">
				<thead>
					<tr>
                        <th>Id</th>
						<th>Section</th>
                        <th>Question</th>
                        <th>Option Type</th>
                        <th>Master Main ID</th>
                        <th>Created On</th>
                        <th>Action</th>
				</thead>
				<tbody>
                        <?php 
                        //$mastermaind= "Null";
                        foreach ($surveys as $survey): ?>
                        <?php $mastermaind = $survey->master_main->name?? "Null"; ?>
                        <tr>
                            <td><?php echo $survey->id ?></td>
						<td>
						<?php
						echo "<b>" . h ( $survey->section ) . "</b>";
																									?>
						
						</td>
						<td><?= h($survey->question) ?></td>
						<td><?= h($survey->option_type) ?></td>
						<td><?= h($mastermaind) ?></td>
						<td><?= h($survey->created_on); ?></td>
                        <td> 
                            <?php echo $this->Html->link("", [
                                    'controller' => "Admin",
                                    'action' => 'editsurveyqution',
                                    $survey->id,$id
                                ], [
                                    'class' => 'fas fa-edit'
                                ]);?>| 
                                <?= $this->Form->postLink(__(''), ['action' => 'deletesurveyqution', 
                                 $survey->id,$id
                                ], ['class' => 'fas fa-trash','confirm' => __('Are you sure you want to delete # {0}?', 
                                 $survey->id
                                )]) ?>
					
                                </td>
					   
					</tr>
                        <?php endforeach; ?>
                       
                    </tbody>
			</table>
			<div class="paginator">
				<ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
				<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
			</div>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>
<script>
function searchTable() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("surveyTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those that don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    let found = false;
    for (let j = 1; j <= 5; j++) {
      let columnContent = td[j]; // Index 2 represents the Question column, 3 represents Option Type, 4 represents Master Main ID, 5 represents Created On
      if (columnContent) {
        txtValue = columnContent.textContent || columnContent.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break; // If found in any of the columns, break the loop
        }
      }
    }
    tr[i].style.display = found ? "" : "none";
  }
}
</script>




<script>
var selectedQuestion = 0;
var csrfToken = $('meta[name="csrfToken"]').attr('content');
$(".addsurveyquestions").on("click", function(e){
	e.preventDefault();
	resetpopup(0);
	selectedQuestion = $(this).attr("data-question");
	$('#surveyquestionsModel').modal('show');
$('#surveys_id').val(selectedQuestion);
});

function resetpopup(sQ){
	selectedQuestion = sQ;
	$("#question").val("");
	$("#q_type").val("radio");
	$("#noans").val("");
	$("#surveyoptions").html("");
}
</script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
            // Add other Select2 options as needed
        });
    });
</script>


<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
});
</script>

<script>
$(document).ready(function() {
    $('#answer_type').change(function() {
        var selectedOption = $(this).val();

        // Hide both fields initially
        $('#dropdown_field').hide();
        $('#text_field').hide();

        if (selectedOption === 'Dropdown' || selectedOption === 'Multiple') {
            $('#dropdown_field').show(); // Show the dropdown field if 'Dropdown' is selected
        } else if (selectedOption === 'Text Box' || selectedOption === 'Heading' ) {
            $('#text_field').show(); // Show the text field if 'Text Box' is selected
        }
    });
});
</script>