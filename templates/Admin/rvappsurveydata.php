
<?php 
// debug($surveys);
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
                            'Radio'=>'Radio',
                            'Text Box'=>'Text Box',
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

                         echo $this->Form->control('Survey Question', [
                         'type' => 'select',
                         'multiple' => true,
                         'options' => $masterOptionData,
                         'id' => 'noans',
                         'class' => 'select2 noans', // Add any additional classes as needed
                          ]);
                          echo $this->Form->control('Answer Type', [
                            'type' => 'select',
                            // 'multiple' => 'checkbox',
                            'options' => $AnswerType,
                            'id' => 'branch_id',
                            'class' => 'form-control people', // Add any additional classes as needed
                        ]);
                        ?>
                    </div>
					<!-- <div class="form-group">
						<label for="inputStatus">Answer Type</label> <select class="form-control" id="q_type"><option value="radio">Radio</option>
							<option value="check">Text Box</option></select>
					</div> -->
                    <input type="hidden" name="id" id="master_main_id">
                   
					<div class="surveyoptions" id="surveyoptions"></div>
				</div>
                <?= $this->Form->button(__('Submit'), ['class' => "btn btn-dark"]) ?>
                    <a class="btn btn-danger" data-dismiss="modal">Cancel</a>
                    <?= $this->Form->end() ?>
			</div>

		</div>
	</div>
</div>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
            <a href="#" class="btn btn-block bg-gradient-primary  btncompany" id="company">Create Survey</a>     
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover">
				<thead>
					<tr>
						<th style="max-width: 250px"><?= $this->Paginator->sort('name') ?></th>
                        <th style="max-width: 250px"><?= $this->Paginator->sort('country') ?></th>
                        <th style="max-width: 250px"><?= $this->Paginator->sort('village') ?></th>
                        <th style="max-width: 250px"><?= $this->Paginator->sort('status') ?></th>
                        <th style="max-width: 250px"><?= $this->Paginator->sort('created_on') ?></th>
						<th>Actions</th>
				
				</thead>
				<tbody>
                        <?php foreach ($surveys as $survey): ?>
                        <tr>
						<td>
						<?php
						echo "<b>" . h ( $survey->name ) . "</b>";
																									?>
						
						</td>
						<td><?= h($survey->country) ?></td>
						<td><?= h($survey->village) ?></td>
						<td><?= h($survey->status) ?></td>
						<td><?= h($survey->created_on); ?></td>
						<td class="actions"><a href="#"><i class="far fa-edit"></i></a> | <a href="#" data-question="<?php echo $survey->id;?>" class="addsurveyquestions"><i class="fas fa-poll-h"></i></a> |
						 <?php
                                echo $this->Html->link("", [
                                    'controller' => "Admin",
                                    'action' => 'surveysreport',
                                    $survey->id
                                ], [
                                    'class' => 'fas fa-eye'
                                ]);
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
                        Company <span id="memberaddrequests_id"></span>
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
                    echo $this->Form->control('Selected Countrys', [
                        'type' => 'select',
                        // 'multiple' => 'checkbox',
                        'options' => $surveyd,
                        'id' => 'branch_id',
                        'class' => 'form-control people', // Add any additional classes as needed
                    ]);

                    echo $this->Form->control('Village Name', [
                        'type' => "text",
                        //   'readonly' => true,
                        'id' => 'edit_companyname',
                        'class' => "form-control ra_input",
                    ]);

                    ?>
                    <?= $this->Form->button(__('Submit'), ['class' => "btn btn-dark"]) ?>
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