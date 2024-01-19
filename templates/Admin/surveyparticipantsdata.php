
<?php 
//debug($surveys);
// debug($results);
 //echo $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
<!-- Modal -->
<style>
.ra_input{
    margin-bottom: 20px;
}
.ra_inputW{
	width: 40% !important;
	display: inline-block !important;
}
a.fas.fa-poll-h {
    color: #007bff;
}

a.fas.fa-users {
    color: #007bff;
}
</style>



<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
                <h3>Survey Data </h3>
            <!-- <a href="#" class="btn btn-block bg-gradient-primary  btncompany" id="company">Create Survey</a>      -->
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Name</th>
                        <th>Survey</th>
                        <th>Section</th>
                        <th>Question</th>
                        <th>Option Data</th>
                        <!-- <th>Mobile</th>
						<th>Field Executive</th> -->
				
				</thead>
				<tbody>
                        <?php foreach ($surveys as $survey): ?>
                        <tr>
						<td>
						<?php
						echo "<b>" . h ( $survey->partcipant->name ) . "</b>";
																									?>
						
						</td>
						<td><?= h($survey->survey->name) ?></td>
                        <td><?= h($survey->survey_question->section) ?></td>
						<td><?= h($survey->survey_question->question) ?></td>
						<td><?= h($survey->option_data) ?></td>
						<!-- <td><?//=// h($survey->partcipant->mobile); ?></td>
                        <td><?//= //h($survey->field_executive->username); ?></td> -->
						<!-- <td class="actions"><a href="#"><i class="far fa-edit"></i></a> | <a href="Admin/addsurveyqution" data-question="<?php echo $survey->id;?>" class="addsurveyquestions"><i class="fas fa-poll-h"></i></a>  -->
						<td> <?php
                                // echo $this->Html->link("", [
                                //     'controller' => "Admin",
                                //     'action' => 'addsurveyqution',
                                //     $survey->id
                                // ], [
                                //     'class' => 'fas fa-poll-h'
                                // ]);
                                ?>  <?php
                                // echo $this->Html->link("", [
                                //     'controller' => "Admin",
                                //     'action' => 'surveyparticipantsdata',
                                //     // $survey->id
                                // ], [
                                //     'class' => 'fas fa-users'
                                // ]);
                                ?> 
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


<div class="row">
    <div class="modal fade" id="edDescModal" role="dialog">
        <div class="modal-dialog">
            <div style="width: 800px;" class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title">
                        Add Survey <span id="memberaddrequests_id"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalbody">
                    <?php
                     $surveyd =[
                        'India'=>'India',
                        'USA'=>'USA',
                        'UK'=>'UK',
                        ];
                    echo $this->Form->create(null, array(
                        'url' => array(
                            'controller' => 'Admin', 'action' => 'createsurveyrvapp'
                        ),
                    ));
                    echo $this->Form->control('Name', [
                        'type' => "text",
                        //   'readonly' => true,
                        'id' => 'edit_companyname',
                        'class' => "form-control ra_input",
                    ]);
                    echo $this->Form->control('Selected Country', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' => $surveyd,
                        'id' => 'branch_id',
                        'class' => 'form-control people ra_input', // Add any additional classes as needed
                    ]);

                    echo $this->Form->control('Village Name', [
                        'type' => "text",
                        //   'readonly' => true,
                        'id' => 'edit_companyname',
                        'class' => "form-control ra_input",
                    ]);

                    ?>
                    <?= $this->Form->button(__('Submit'), ['class' => "btn btn-primary bg-gradient-primary  btncompany"]) ?>
                    <a class="btn btn-danger" data-dismiss="modal">Cancel</a>
                    <?= $this->Form->end() ?>
                </div>
                <div class="modal-footer">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>


<script>
    // $(document).ready(function() {
       
        // var dataTable = $('#membersTable').DataTable({});
        $('#company').on('click', function(event) {
            event.preventDefault();

            $('#edDescModal').modal('show');
            $('#edit_companyname').val();
            $('#updateadreqid').attr("value", '');
            $('#edit_countryname1').val();
        });


    // });
</script>


<script>
var selectedQuestion = 0;
var csrfToken = $('meta[name="csrfToken"]').attr('content');
$(".addsurveyquestions").on("click", function(e){
	e.preventDefault();
	resetpopup(0);
	selectedQuestion = $(this).attr("data-question");
	$('#surveyquestionsModel').modal('show');
$('#master_main_id').val(selectedQuestion);
});

function resetpopup(sQ){
	selectedQuestion = sQ;
	$("#question").val("");
	$("#q_type").val("radio");
	$("#noans").val("");
	$("#surveyoptions").html("");
}
</script>



