<?php
//debug($feildexecutiveData);?>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-tools">
                	    <?php
                    echo $this->Html->link("Add Agent", [
                        'controller' => "Admin",
                        'action' => 'createfeildexecutive'
                    ], [
                        'class' => 'btn btn-block bg-gradient-primary'
                    ]);
                    ?>        
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
				<thead>
					<tr>
						<th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('username') ?></th>
                        <th><?= $this->Paginator->sort('password') ?></th>
						<th><?= $this->Paginator->sort('email') ?></th>
                        
						<th>Actions</th>
				
				</thead>
				<tbody>
                        <?php foreach ($feildexecutiveData as $agent): ?>
                        <tr>
						<td><?= h($agent->id) ?></td>
						<td><?= h($agent->username) ?></td>
						<td><?= h($agent->password) ?></td>
						<td><?= h($agent->email) ?></td>
						
						<td class="actions"></td>
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