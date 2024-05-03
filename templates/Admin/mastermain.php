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
a.fas.fa-edit {
    color: #007bff;
}
a.fas.fa-eye{
	color: #007bff;
}
</style>
<div class="col-12">
	<div class="card">
		<div class="card-header" style="background-color: #fff !important;">
			<div class="card-tools" style="
    margin: 10px;
">
			<a href="#" class="btn btn-block bg-gradient-primary  btncompany" id="company">Create Master Main</a>
                	    <?php
			// echo $this->Html->link ( "Create Master Main", [ 
			// 						'controller' => "",
			// 						'action' => '' 
			// 							], [ 
			// 					 'id'=> 'company',
			// 					'class' => 'btn btn-block bg-gradient-primary' 
			// 										] );
												?>        
                	</div>
		</div>
		<!-- /card-header -->
		<div class="card-body table-responsive p-0">
			<table class="table table-hover" id="membersTable">
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
						<td><?= h( $masterdata->userdata->name); ?></td>
						<td><?= h( $masterdata->status); ?></td>
						<td><?= h( $masterdata->created_on); ?></td>
						<td class="actions"><a href="#" data-question="<?php echo $masterdata->id;?>" class="addsurveyquestions"><i class="fas fa-cogs" style="color: #1A89FF;"></i></a> |
						 <?php
                                echo $this->Html->link("", [
                                    'controller' => "Admin",
                                    'action' => 'masteroptionsdata',
                                    $masterdata->id
                                ], [
                                    'class' => 'fas fa-eye'
                                ]);
                                ?> | <a href="#"  class="preview" data_id="<?php echo $masterdata->id;?>"><i class="fas fa-edit" style="color: #1A89FF;"></i></a>

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

<!-- option_value -->


<div class="modal fade" id="surveyquestionsModel" tabindex="-1" role="dialog" aria-labelledby="surveyquestionsModel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Master Options</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card-body">
					
					<div class="form-group" style="padding-top: 10px;">
						<label for="inputStatus">Option Count</label> <input type="number" id="noans" class="noans  form-control">
					</div>
					<div class="surveyoptions" id="surveyoptions"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-option="save-close" class="btn btn-dark savequestion bg-gradient-primary  btncompany">Save & Close</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<!-- <button type="button" data-option="save-next" class="btn btn-primary savequestion">Save & Next Question</button> -->
			</div>
		</div>
	</div>
</div>
<!---popup-->

<div class="row">
    <div class="modal fade" id="edDescModal" role="dialog">
        <div class="modal-dialog">
            <div style="width: 800px;" class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title">
					Add Master Main <span id="memberaddrequests_id"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalbody">
                    <?php
                    echo $this->Form->create(null, array(
                        'url' => array(
                            'controller' => 'Admin', 'action' => 'addmastermain'
                        ),
                    ));
                   
                    echo $this->Form->control('Name', [
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
<!-- edit -->
<div class="row">
    <div class="modal fade" id="DescModal" role="dialog">
        <div class="modal-dialog">
            <div style="width: 800px;" class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title">
					Add Master Main <span id="memberaddrequests_id"></span>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalbody">
                    <?php
                    echo $this->Form->create(null, array(
                        'url' => array(
                            'controller' => 'Admin', 'action' => 'editmastermain'
                        ),
                    ));
					echo $this->Form->control('id', [
						'type' => "hidden",'id' => 'id', 'class' => "form-control",
						 ]);
                    echo $this->Form->control('Name', [
                        'type' => "text",
                        //   'readonly' => true,
                        'id' => 'name',
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
	var selectedQuestion = 0;
// var csrfToken = $('meta[name="csrfToken"]').attr('content');
$(".addsurveyquestions").on("click", function(e){
	e.preventDefault();
	resetpopup(0);
	selectedQuestion = $(this).attr("data-question");
	$('#surveyquestionsModel').modal('show');
});

function resetpopup(sQ){
	selectedQuestion = sQ;
	$("#question").val("");
	$("#q_type").val("radio");
	$("#noans").val("");
	$("#surveyoptions").html("");
}

$(".viewsurveyquestions").on("click", function(e){
	e.preventDefault();
	var surveyid = $(this).attr("data-survey");
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken // this is defined in app.php as a js variable
        }
    });
	$.ajax( {
         url: baseURL+"admin/viewsurveyquestionoptions",
         headers: {'X-CSRF-TOKEN': csrfToken},
         dataType: "json",
         method:'post',
         data: {
           survey_id:surveyid
         },
         success: function( data ) {
         	 	
         }
       } );
	
});
	$(".savequestion").on("click", function(e){
		var err = 0;
		var errmsg = '';
	 	var action = $(this).attr("data-option");
		
	// 	//var csrfToken = $('meta[name="_csrfToken"]').val()
	 	var qcount = $("#noans").val();
	 	var options = new Array();
		var option_sort = new Array();
		
		 for(var i=0; i<qcount; i++){
			var opvalue = $("#soptions-"+i).val();
			var opvalue_sort = $("#soptionssort-"+i).val();
			if(opvalue == ""){
		 		err = 1;
		 		errmsg = "Options can't be empty";
				}
			options[i]=opvalue;
			option_sort[i]=opvalue_sort;
		}
		
		// if(qcount == "" || qcount <= 1 ){
		// 	err = 1;
		// 	errmsg = "Should have atleast two option"; 
		// 	}
		if($("#question").val() == ""){
			err = 1;
			errmsg = "Question can't be empty"; 
			}
		
		
		if(err == 0){
				
		 $.ajax( {
             url: "../admin/masteroptions",
            //  headers: {'X-CSRF-TOKEN': csrfToken},
             dataType: "json",
             method:'post',
             data: {
            //    questions:$("#question").val(),
            //    q_type:$("#q_type").val(),
			master_main_id:selectedQuestion,
            option_value:options,
			sort:option_sort,
             },
             success: function( data ) {
                 	 console.log( data );
                 	
                 	 if(action == "save-close"){
                 		resetpopup(0);
                 		$('#surveyquestionsModel').modal('hide');
                    }else if(action == "save-next"){
                    	resetpopup(selectedQuestion);
                    }
             }
           } );
		}else{
			alert(errmsg);
		}
		console.log(options);

		
	});
	$(".noans").on("keyup", function(e){
		$(".surveyoptions").html("");
		var c = $(this).val();
		if($(this).val() > 0){
			var temp="<h5>Options</h5>";
			for(var i=0; i<c; i++){
				temp = temp + "<div class='form-group'style='padding-top: 10px;'><input type='text' placeholder='Option' class='form-control ra_inputW' id='soptions-"+i+"' /> - <input type='text' placeholder='Sort Order' class='form-control ra_inputW' id='soptionssort-"+i+"' /></div>";
			}
			
			$(".surveyoptions").html(temp);
		}
	});
</script>
<script>
    // $(document).ready(function() {
       
    //     var dataTable = $('#membersTable').DataTable({});
        $('#company').on('click', function(event) {
            event.preventDefault();

            $('#edDescModal').modal('show');
            $('#edit_companyname').val();
            $('#updateadreqid').attr("value", '');
            $('#edit_countryname1').val();
        });

		$('.preview').on('click', function(e) {
            e.preventDefault();

            var rowid = $(this).attr("data_id");
			console.log(rowid);
            
            // $('#DescModal').modal('show');
            $.ajax({
                url: "getmastermain",
                data: {
                    rowid: rowid
                },
                context: document.body,
                success: function(response) {
					console.log(response);
                  

                    $('#name').val(response.data[0].name);
                    $('#id').attr("value", response.data[0].id);
                 
                    $('#DescModal').modal('show');
                    
                
                    
                }
            });
            
        });
       

        



    // });
</script>
