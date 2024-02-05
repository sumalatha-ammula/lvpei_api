<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
            <!-- <a href="#" class="btn btn-block bg-gradient-primary  btncompany addsurveyquestions"  id="id">Export</a>   -->
            <span>
                <?php
                       echo $this->Html->link(
                       'Export',
                       [
                       'controller' => 'Admin',
                       'action' => 'participantexportdata',
                       
                         ],
                       ['class' => 'btn btn-block bg-gradient-primary', // You can customize the button styles here
                        // 'escape' => false // Allows rendering HTML in link content
                         ]);?></span>   
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover">
				<thead>
					<tr>
                        <th>Id</th>
						<th>Section</th>
                        <th>Question</th>
                        <th>Answer</th>
                       
                        
				</thead>
				<tbody>
                        <?php 
                        //$mastermaind= "Null";
                        // debug($surveydataex);
                        foreach ($surveydataex as $survey): ?>
                        <?php //$mastermaind = $survey->master_main->name?? "Null"; ?>
                        <tr>
                            <td><?php echo $survey->id ?></td>
						<td>
						<?php
						echo "<b>" . h ( $survey->survey_question->section ) . "</b>";
																									?>
						
						</td>
						<td><?= h($survey->question) ?></td>
						<td><?= h($survey->master_option->option_value) ?></td>
						
                        
					   
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