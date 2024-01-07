<!-- <?php //echo $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?> -->
<!-- Modal -->
<!-- <div class="modal fade" id="viewsurveyquestionsModel" tabindex="-1" role="dialog" aria-labelledby="viewsurveyquestionsModel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Survey Questions</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					<table class="table table-hover">
				<thead>
					<tr>
						<th>Question</th>
						<th>Type</th>
						<th>No. of Options</th>
						<th>Date Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody></tbody>
				</table>
				</div>
			</div>
			
		</div>
	</div>
</div> -->



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
						<label for="inputName">Question</label> <input type="text" name="questions" id="question" class="form-control">
					</div>
					<div class="form-group">
						<label for="inputStatus">Answer Type</label> <select class="form-control" id="q_type"><option value="radio">Radio</option>
							<option value="check">Check Box</option></select>
					</div>
					<div class="form-group">
						<label for="inputStatus">No. of Answers</label> <input type="number" id="noans" class="noans  form-control">
					</div>
					<div class="surveyoptions" id="surveyoptions"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" data-option="save-close" class="btn btn-primary savequestion">Save & Close</button>
				<button type="button" data-option="save-next" class="btn btn-primary savequestion">Save & Next Question</button>
			</div>
		</div>
	</div>
</div>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
                	    <?php
			echo $this->Html->link ( "Create Master Main", [ 
									'controller' => "Admin",
									'action' => 'createsurvey' 
										], [ 
								'class' => 'btn btn-block bg-gradient-primary' 
													] );
												?>        
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Created_by</th>
						<th>Status</th>
						<th>created_on</th>
						<th>Actions</th>
				
				</thead>
				<tbody>
                        <?php //debug($master);
                        foreach ($master as $masterdata): ?>
                        <tr>
						<td>
						<?php
						 echo "<b>" . h ( $masterdata->name ) . "</b>";
						// echo "<br/>";
						// echo "<p style='font-size:14px;'>" . h ( $survey->description ) . "</p>";
																									?>
						
						</td>
						<td><?= h( $masterdata->created_by); ?></td>
						<td><?= h( $masterdata->status); ?></td>
						<td><?= h( $masterdata->created_on); ?></td>
						<td class="actions"><a href="#" data-question="<?php echo $masterdata->id;?>" class="addsurveyquestions"><i class="fas fa-cogs"></i></a> |
						 <?php
                                // echo $this->Html->link("", [
                                //     'controller' => "Admin",
                                //     'action' => 'surveysreport',
                                //     $survey->id
                                // ], [
                                //     'class' => 'fas fa-eye'
                                // ]);
                                ?> 
						</td>
					</tr>
                        <?php endforeach; ?>
                       
                    </tbody>
			</table>
			
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>
