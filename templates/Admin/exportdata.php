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
                       'action' => 'exportdatabyparticipant',
                       
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
                        // debug($final);
                        //$mastermaind= "Null";
                        // debug($surveydataex);
                        foreach ($surveydataex as $survey): ?>
                       <?php //debug($survey);?>
                        <?php $mastermaind = $survey['option_data']?? "Null"; ?>
                        <tr>
                            <td><?php echo $survey['id'] ?></td>
						<td>
						<?php
						echo "<b>" . h ( $survey['section'] ) . "</b>";
																									?>
						
						</td>
						<td><?= h($survey['question']) ?></td>
						<td><?= h($mastermaind) ?></td>
						
                        
					   
					</tr>
                        <?php endforeach; ?>
                       
                    </tbody>
			</table>
			
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>