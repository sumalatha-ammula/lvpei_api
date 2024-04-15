<?php
    namespace App\Controller;

    use App\Controller\AppController;

    use Cake\Core\Configure;
    use Cake\Http\Exception\ForbiddenException;
    use Cake\Http\Exception\NotFoundException;

    use Cake\Datasource\ConnectionManager;
    use Cake\Database\Query;
    use Cake\Http\Response;
    use Cake\View\Exception\MissingTemplateException;
    use Cake\Auth\DefaultPasswordHasher;
    use Cake\Utility\Text;
    use Cake\ORM\TableRegistry;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use Cake\I18n\FrozenTime;
    use CakePdf\Pdf;

    class ApiController extends AppController
    {
        public function initialize(): void

        {
            parent::initialize();
        $this->response->withHeader('Access-Control-Allow-Origin', '*');
        $this->response->withType('json');
        $this->request->allowMethod([
            'post','put','get','delete'
        ]);
        $this->loadComponent('RequestHandler');
        $this->viewBuilder()->setLayout('ajax');
        $this->viewBuilder()->settemplate("response");
            
            // $this->loadComponent("Media");
            $this->loadModel("FieldExecutive");
            $this->loadModel("Survey");
            $this->loadModel("SurveyQuestions");
            $this->loadModel("MasterMain");
            $this->loadModel("Partcipants");
            $this->loadModel("SurveyData");
            $this->loadModel("Onetimepassword");
            $this->loadModel('MasterOptions');
            $this->loadComponent("Email");
        }        
        private function generatetoken() {
            $token = bin2hex(random_bytes(16));
            return $token;
         }

        public function login(){
            $result=[];
            $result['error'] = 1;
            if($this->request->is('post')){
                $data = $this->request->getdata();                 
                $fielddata = $this->FieldExecutive->find('all')
                ->where([
                    'password' => $data['password'], 'username' => $data['username']
            ])
                ->toArray();                
                if (count($fielddata) == 0) {
                    $result = 'The User Login Not Done.';
                    $result=[
                        'error'=>1
                    ];
                }else{
                $lt = TableRegistry::get('FieldExecutive');
                $ld = $lt->get($fielddata[0]->id);
                $loggedUserId = $fielddata[0]->id; // Get the logged-in user's ID
                $this->request->getSession()->write('Auth.User.id', $loggedUserId); // Save it in the session

                $ld->token = $this->generatetoken();
                $ld->deviceid = isset($data['deviceid']) ? $data['deviceid'] : '';
                $ld->deviceinfo = isset($data['deviceinfo']) ? $data['deviceinfo'] : '';
                $fielddata[0]->token = $ld->token;
                $lt->save($ld);
                $Surveydat = $this->surveydata();
                $result = [
                    'error' => 0,
                    'member' => $fielddata[0],
                    'status' => 200,
                    'survey' => $Surveydat
                ];

                }                 
            }
            $this->set("result", $result);
        }
        public function getsurvey(){
            
           $this->surveydata();
            die;
        }
        private function surveydata(){
        //    $userId  = $this->Auth->user ();
        //    print_r($this->userdt['id']);
            $userId=$this->request->getSession()->read('Auth.User.id'); // Save it in the session
  
            // print_r($userId);

            $Surveydata = $this->Survey->find ( 'all' )
                ->contain(['Partcipants' ,'Partcipants.SurveyData' => function($q) {return $q->contain(['SurveyQuestions']);} , 'ClinicalSurveyQuestions' => 
                function($q){return $q->contain(['MasterMain','MasterMain.MasterOptions'])
                    ->where(['is_clinical' => 1])->group(['section','ClinicalSurveyQuestions.id']);}, 
                    'NonClinicalSurveyQuestions' => function($q){return $q->contain(['MasterMain','MasterMain.MasterOptions'])
                        ->where(['is_clinical' => 0])->group(['section','NonClinicalSurveyQuestions.id']);}]) 
                ->toArray(); 

                

                $Surveydat = [];
                
           

            foreach($Surveydata as $data){
                $Surveydat[$data->id] =$data;
                
            }

                
                //$Surveydat->partcipants = array_values($Surveydat->partcipants);
                
                foreach($Surveydat as $data){
                   
                    foreach($data->partcipants as $participantsk => $participantsv){
                        $Surveydat[$data->id]['partcipants'][$participantsk]['additionalData'] = [];
                        $tmpArray = [];
                        foreach($participantsv->survey_data as $par){
                            $opval = $par->option_value;
                            $opans = $par->answer;
                            if($par->survey_question->option_type == 'Multiple'){
                                $opval = explode(',', $par->option_value);
                            }
                            if($par->survey_question->option_type == 'Dropdown'){
                                $opans = (int)$par->answer;
                            }
                            $tmpArray['id'] = $par->id;
                            $tmpArray['survey_id'] = $par->survey_id;
                            $tmpArray['question_id'] = $par->question_id;
                            $tmpArray['field_executive_id'] = $par->field_executive_id;
                            $tmpArray['datetime'] = $par->datetime;
                            $tmpArray['geo_location'] = $par->geo_location;
                            $tmpArray['question'] = $par->question;
                            $tmpArray['option_data'] = $par->option_data;
                            $tmpArray['answer'] = $opans;
                            $tmpArray['option_value'] = $opval;
                            $tmpArray['sync_time'] = $par->sync_time;
                            $tmpArray['partcipants_id'] = $par->partcipants_id;
                            $tmpArray['option_type'] = $par->survey_question->option_type;
                            $tmpArray['unid'] = $par->unid;
                            $tmpArray['is_clinical'] = $par->is_clinical;
                            $tmpArray['section_id'] = $par->section_id;
                            $tmpArray['section'] = $par->section;
                            
                            

                            if(!isset($Surveydat[$data->id]['partcipants'][$participantsk]['additionalData'][$par->is_clinical. '_' . $par->section_id])){
                                $Surveydat[$data->id]['partcipants'][$participantsk]['additionalData'][$par->is_clinical. '_' . $par->section_id] = [];
                            }

                            $Surveydat[$data->id]['partcipants'][$participantsk]['additionalData'][$par->is_clinical. '_' . $par->section_id][$par->question_id] = $tmpArray;
                            
                        }

                    }
                    


                }
               
                foreach($Surveydat as $data){
                    $tmpArray = [];
                    $final=[];
                    foreach($data['clinical_survey_questions'] as $question){
                        $tmpArray = [
                        'master_main_name' => @$question['master_main']['name'], 
                        'options' =>@$question['master_main']['master_options'],
                        'option_type' => @$question['option_type'], 
                        'section'=>@$question['section'] ,
                        'question'=>@$question['question'] ,
                        'question_id'=> $question['id'],
                        'survey_id' => $question['survey_id'],
                        'parent_id'=> @$question['parent_id'],
                        'show_if'=> @$question['show_if'],
                        'survey'=>$question['survey'],
                        ];    
                        $final[$question['section']][] = $tmpArray;

                    }
                    $Surveydat[$data->id]['clinical_survey_questions'] =array_values($final);
               }

             foreach($Surveydat as $data){
                $tmpArray = [];
                $final=[];
                foreach($data['non_clinical_survey_questions'] as $question){
                    $tmpArray = [
                        'master_main_name' => @$question['master_main']['name'], 
                        'options' =>@$question['master_main']['master_options'],
                        'option_type' => @$question['option_type'], 
                        'section'=>@$question['section'] ,
                        'question'=>@$question['question'] ,
                        'question_id'=> $question['id'],
                        'survey_id' => $question['survey_id'],
                        'parent_id'=> @$question['parent_id'],
                        'show_if'=> @$question['show_if'],
                        'survey'=>$question['survey']
                    ];    
                    $final[$question['section']][] = $tmpArray;
                }
                $data['non_clinical_survey_questions'] = array_values($final);

                $defaultvalues = [];             
                $defaultvalues['78'] = [];
                $defaultvalues['78'][220] = [];
                $defaultvalues['78'][220][80] = 28;
                $defaultvalues['78'][220][84] = 28;
                $defaultvalues['78'][220][88] = 28;
                $defaultvalues['78'][220][92] = 28;
                $defaultvalues['78'][220][96] = 28;
                $defaultvalues['79'][220] = [];
                $defaultvalues['79'][220][81] = 28;
                $defaultvalues['79'][220][85] = 28;
                $defaultvalues['79'][220][89] = 28;
                $defaultvalues['79'][220][93] = 28;
                $defaultvalues['79'][220][97] = 28;
                $data['defaultvalues'] = ($defaultvalues);
            }
          $Surveydat = (object)$Surveydat;
          return $Surveydat;
        }
        public function survey() { 
                  
            $result = [];
            $result['error'] = 1; 
            $data = $this->request->getdata();
            if ($this->request->is ( 'post' ) and isset($data['appdata']) ) {
             
            
             $appdata = json_decode($data['appdata']);
            //  debug($appdata);
            //  die;
             
             foreach($appdata as $apdata){
                $surveryid = $apdata->id;
                
                foreach($apdata->partcipants as $lapdata){

                    
                    $isuser = 0;
                    if(isset($lapdata->id)){
                        $isuser = 1;
                        $checkuser = $this->Partcipants->find('all')
                        ->where(['id' => $lapdata->id,'field_executive_id' => $lapdata->field_executive_id,'survey_id'=> $lapdata->survey_id])
                        ->count();
                        if($checkuser == 0){
                            $isuser = 0;
                        }
                    }
                    

                        $uniqID = $lapdata->idcode . $lapdata->clustercode . $lapdata->indiviadualcode;
                        $patientdata = TableRegistry::get('Partcipants');
                        $patientdetails = $this->Partcipants->newEmptyEntity();
    
                        if($isuser == 1){
                            $patientdetails = $patientdata->get($lapdata->id);
                        }else{
                            $patientdetails->created_on = date("Y-m-d");
                        }
                        
    
                        
                        $patientdetails->name =$lapdata->name;
                        $patientdetails->survey_id =$lapdata->survey_id;
                        
                        $patientdetails->age =$lapdata->age;
                        $patientdetails->mobile =$lapdata->mobile;
                        $patientdetails->adharnumber =$lapdata->adharnumber;
                        $patientdetails->occupation =$lapdata->occupation;
                        $patientdetails->education =$lapdata->education;
                        $patientdetails->gender =$lapdata->gender;
                        $patientdetails->status =$lapdata->status;
                        $patientdetails->is_survey = $lapdata->is_survey;
                        $patientdetails->monthlyincome =$lapdata->monthlyincome;
                        $patientdetails->country = $lapdata->country;
                        $patientdetails->state = $lapdata->state;
                        $patientdetails->district = $lapdata->district;
                        $patientdetails->field_executive_id = $lapdata->field_executive_id;
                        $patientdetails->idcode = $lapdata->idcode;
                        $patientdetails->clustercode = $lapdata->clustercode;
                        $patientdetails->indiviadualcode = $lapdata->indiviadualcode;
                        $patientdetails->landmark = $lapdata->landmark;                        
                        $patientdetails->unid =  intval($uniqID);
                        $patientdetails->created_by = 1;                        
                        if($psave = $patientdata->save($patientdetails)){
                            $pid = $psave->id;
                            
                            if(isset($lapdata->additionalData)){
                                
                                foreach($lapdata->additionalData as $ds){
                                    foreach($ds as $d){
                                        
                                        $sdetailsdata = '';
                                        if(isset($d->answer)){
                                            $punid = 82528;

                                            $isp = 0;
                                            $sdetailsdata =  $this->SurveyData->find('all')
                                                ->where(['survey_id' => $d->survey_id, 'question_id' => $d->question_id, 'partcipants_id' => $pid])
                                                ;
                                            
                                            
                                            if($sdetailsdata->count() > 0){
                                                $isp = 1;
                                                $sdetailsdata = $sdetailsdata->toArray();
                                                $sdetailsdata = $sdetailsdata[0];
                                            }
                                            
                                            
                                            $qstype = $this->SurveyQuestions->find('all')
                                            ->where(['id' => $d->question_id])
                                            ->toArray();
                                            $answer = '';
                                            $option_data = "";
                                            $option_value = '';
                                            
                                            if(count($qstype) > 0){
                                                $qstype = $qstype[0];
                                               
                                                if($qstype->option_type == "Text Box" ){
                                                    $answer = $d->answer;
                                                    $option_data = $d->answer;
                                                    $option_value = $d->answer;
                                                    
                                                    
                                                }else if($qstype->option_type == "Dropdown" ){
                                                    $answer = $d->answer;
                                                    $moval = '';
                                                    if($answer != '' and $answer != 0){
                                                        $modata = $this->MasterOptions->find('all')
                                                        ->where(['id' => $d->answer])
                                                        ->toArray();
                                                        if(count($modata) == 1){
                                                            $moval =  $modata[0]->option_value;
                                                        }
                                                    }
                                                   

                                                    $option_data = $moval;
                                                    $option_value = $moval;

                                                    
                                                }else if($qstype->option_type == "Multiple" ){
                                                    if(is_array($d->answer)){
                                                        $answer = implode(',',$d->answer);
                                                        $option_data = implode(',',$d->answer);
                                                        $option_value = implode(',',$d->answer);
                                                    }else{

                                                        $answer = '';
                                                        $option_data = '';
                                                        $option_value = '';
                                                        if(isset($d->answer)){
                                                            $answer = $d->answer;
                                                            $option_data = $d->answer;
                                                            $option_value = $d->answer;
                                                        }
                                                        
                                                    }

                                                }
                                            }
                                            
                                            
                                            if($isp == 1){
                                                $lt = TableRegistry::get('SurveyData');
                                               
                                                $sdata = $lt->get($sdetailsdata->id);
                                                $sdata->question_id = isset($d->question_id)?$d->question_id:0;
                                                $sdata->unid = $punid;
                                                $sdata->survey_id = $d->survey_id;
                                                $sdata->field_executive_id = isset($d->field_executive_id)?$d->field_executive_id:0;
                                                $sdata->partcipants_id = $pid;
                                                $sdata->geo_location = '23.23,34,8';
                                                $sdata->question = $d->question;
                                                $sdata->is_clinical = $d->is_clinical;
                                                $sdata->section_id = $d->section_id;
                                                $sdata->option_value = $option_value;
                                                $sdata->answer = $answer;
                                                $sdata->option_data = $option_data;
                                                $sdata->section = $d->section;                                                
                                                $lt->save($sdata);
                                                
                                               
                                            }else{
                                                $nsurveydetails = $this->SurveyData->newEmptyEntity();
                                                $sdata = [];
                                                $sdata['question_id'] = isset($d->question_id)?$d->question_id:0;
                                                $sdata['unid'] = $punid;
                                                $sdata['survey_id'] = $d->survey_id;
                                                $sdata['field_executive_id'] = isset($d->field_executive_id)?$d->field_executive_id:0;
                                                $sdata['partcipants_id'] = $pid;
                                                $sdata['geo_location'] = '23.23,34,8';
                                                $sdata['question'] = $d->question;
                                                $sdata['section_id'] = $d->section_id;
                                                $sdata['is_clinical'] = $d->is_clinical;
                                                $sdata['section']= $d->section;                                                ;
                                                $sdata['option_value'] = $option_value;
                                                $sdata['answer'] = $answer;
                                                $sdata['option_data'] = $option_data;

                                                $sppatch = $this->SurveyData->patchEntity($nsurveydetails, $sdata);
                                                
                                                if(!$this->SurveyData->save($sppatch)){
                                                    debug($nsurveydetails->getErrors());die;
                                                }
                                                
                                            }
                                            
                                            
                                            

                                            
                                            
                                            
                                        }
                                    }
                                   
                                    
                                    
                                }
                            }
                        } else{
                            debug($patientdata->getErrors());
                           // die;
                        }
                    
                                       
                }
             }     
            }  
             
            $Surveydat = $this->surveydata();
            $result = [
                    'error' => 0,'status' => 200, 
                    'survey' => $Surveydat, 
                    
                ];          
            
        
            $this->set ("result",   $result);           
    }

          
              

        public function participantupdate(){
            $result=[];
            $result['error'] = 0;
            
                $data = $this->request->getdata(); 
                // debug($data); 
                // die;             
        
            $pid= $this->Partcipants->find('all')
            ->select(['id'])
            ->where(['id'=>$data['pid']])
            ->toArray();
            if($pid != 0){
                $partcipantsRecord = $this->Partcipants->get($pid[0]->id);
                $partcipantsRecord->status = $data['status'];
                $partcipantsRecord->is_examine = 1;
                $this->Partcipants->save($partcipantsRecord);
                $result = ['error' => 0,'status' => 200,];          
           
            }
           
            
         
          $this->set ("result",   $result);
        }

        public function surveyquestions(){
          $result=[];
          $result['error'] = 1;
         if($this->request->is('post')){
        $data = $this->request->getdata();        
        $sqs =[];
        $sqs = $this->SurveyQuestions->find('all')
        // ->select(['SurveyQuestions.section'])
       ->contain(['MasterMain','MasterMain.MasterOptions','survey'])->
       group(['SurveyQuestions.section','SurveyQuestions.id'])->
       where(['SurveyQuestions.survey_id'=> $data['id'], 'SurveyQuestions.is_clinical'=> $data['is_clinical'] ])->toArray();
       $final=[];
       foreach($sqs as $question){
        // print_r($question);die;
        $tmpArray = [
            'master_main_name' => @$question['master_main']['name'], 
            'options' =>@$question['master_main']['master_options'],
            'option_type' => @$question['option_type'], 
            'section'=>@$question['section'] ,
            'question'=>@$question['question'] ,
            'question_id'=> $question['id'],
            'survey_id' => $question['survey_id'],
            'parent_id'=> @$question['parent_id'],
            'show_if'=> @$question['show_if'],
            'survey'=>$question['survey']
        ];    
        $final[$question['section']][] = $tmpArray;
    
    }

   }
   $this->set ("result",   array_values($final));
}

public function getmasteroptions(){
    $result=[];
    $result['error'] = 0;
    $data = $this->request->getdata();  
    
    $d = $this->SurveyQuestions->find('all')
    ->contain(['MasterMain', 'MasterMain.MasterOptions'])
    ->where(['SurveyQuestions.id' => $data['id']])
    ->toArray();
    $result['data'] = $d[0] ;
    $this->set ("result", $result); 
    
}

public function surveyquestionsc(){
    $result=[];
    $result['error'] = 1;
    if($this->request->is('post')){
        $data = $this->request->getdata();        
        $sqs =[];
        $sqs = $this->SurveyQuestions->find('all')
        // ->select(['SurveyQuestions.section'])
       ->contain(['MasterMain','MasterMain.MasterOptions','survey'])
       ->group(['SurveyQuestions.section','SurveyQuestions.id'])
       ->order(['sort', 'SurveyQuestions.id'])
       ->where(['SurveyQuestions.survey_id'=> $data['id'], 'SurveyQuestions.is_clinical'=> '1' ])->toArray();
       $final=[];
       foreach($sqs as $question){
        // debug($question);
        // die;
        $tmpArray = [
            'master_main_name' => @$question['master_main']['name'],
            'options' =>@$question['master_main']['master_options'],
            'option_type' => @$question['option_type'], 
            'section'=>@$question['section'] ,
            'question'=>@$question['question'] ,
            'question_id'=> $question['id'],
            'survey_id' => $question['survey_id'],
            'parent_id'=> @$question['parent_id'],
            'show_if'=> @$question['show_if'],
            'survey'=>$question['survey']
        ];    
        $final[$question['section']][] = $tmpArray;
    
    }

   }
   $this->set ("result",   array_values($final));
}



      

public function surveyparticipantsdatarvapp(){
    $result=[];
    if($this->request->is('post')){
    $data = $this->request->getData();
    // debug($data);
    $sps = $this->SurveyData->find( 'all' )
    ->contain(["Survey","SurveyQuestions", "FieldExecutive","Partcipants", "MasterOptions"])
    ->where(['SurveyData.partcipants_id'=>$data['id'], 'SurveyData.survey_id' => $data['sid']] );

    $final=[];
    foreach($sps as $question){
    //  debug($question);
    //  die;
    $Partcipants =  @$question['partcipant' ];
    if(@$question['survey_question']['option_type'] === "Dropdown"){
        $optionData = @$question['master_option']['option_value'];
    }else{
        $optionData = @$question['option_data'];
    }

     $tmpArray = [
         'master_main_name' => @$question['survey_question']['master_main']['name'],
        //  'options' =>@$question['survey_question']['master_main']['master_options'][0]['option_value'],
         'options'=>@$question['survey_question']['master_main']['master_options'],
         'option_type' => @$question['survey_question']['option_type'], 
         'section'=>@$question['survey_question']['section'] ,
         'question'=>@$question['survey_question']['question'] ,
         'question_id'=> $question['survey_question']['id'],
         'survey_id' => $question['survey_id'],
         'survey'=>$question['survey'],

         'unid'=>$question['unid'],
         'option_data'=> $optionData,
         'Partcipants'=> $Partcipants,
        //  'option_value'=> $optionData,
         'surveydataid'=>  @$question['id']
     ];    
     $final[$question['survey_question']['section']][] = $tmpArray;


  }

    }
  
    $this->set ("result",   array_values($final));
}

public function editsurveyquestions(){
    if($this->request->is('post')){
        $data = $this->request->getData();
        $sps = $this->SurveyData->find ( 'all' )
        ->contain(["Survey","SurveyQuestions", "FieldExecutive","Partcipants","SurveyQuestions.MasterMain.MasterOptions","SurveyQuestions.MasterMain","MasterOptions" ])
        ->where(['SurveyData.partcipants_id'=>$data['id'], 'SurveyData.survey_id' => $data['sid'], ])->toArray();
       
        $final=[];
        foreach($sps as $question){
        //  debug($question);
        //  die;
        $Partcipants =  @$question['partcipant' ];
        if(@$question['survey_question']['option_type'] === "Dropdown"){
            $optionData = @$question['master_option']['option_value'];
        }else{
            $optionData = @$question['option_data'];
        }

         $tmpArray = [
             'master_main_name' => @$question['survey_question']['master_main']['name'],
            //  'options' =>@$question['survey_question']['master_main']['master_options'][0]['option_value'],
             'options'=>@$question['survey_question']['master_main']['master_options'],
             'option_type' => @$question['survey_question']['option_type'], 
             'section'=>@$question['survey_question']['section'] ,
             'question'=>@$question['survey_question']['question'] ,
             'question_id'=> $question['survey_question']['id'],
             'survey_id' => $question['survey_id'],
             'survey'=>$question['survey'],

             'unid'=>$question['unid'],
             'option_data'=> $optionData,
             'Partcipants'=> $Partcipants,
            //  'option_value'=> $optionData,
             'surveydataid'=>  @$question['id']
         ];    
         $final[$question['survey_question']['section']][] = $tmpArray;
    
    
      }
    }

   $this->set ("result",   array_values($final));
}

public function editsavesurveydata(){
    $result=[];   
    if($this->request->is('post')){
        $data = $this->request->getdata();
        // debug($data); 
        // die;                    
        $pid=$data["pid"];        
        $punid = $data['punid'];
        $data = json_decode($data['fdata']);
        // debug($data); 
        // die;   
        foreach($data as $d){
            // debug($d->surveyid);
            // die;
            $results = $this->SurveyData->get($d->surveyid);            
            $surveydetails = [];
            $surveydetails['survey_id'] = $d->survey_id;
            $surveydetails['question_id'] = $d->question_id;
            $surveydetails['field_executive_id'] = $d->field_executive_id;
            $surveydetails['geo_location'] = '23.23,34,8';
            $surveydetails['question'] = $d->question;
            // $surveydetails['option_data'] = $d->answer;
            // $surveydetails['option_data'] = json_encode($d->answer);
            $surveydetails['option_data'] = is_array($d->answer) ? implode(',',$d->answer) : $d->answer ;
            // $surveydetails['partcipants_id'] = $pid;
            // $surveydetails['unid'] = $punid;
            // debug( $surveydetails);
            $sdata = $this->SurveyData->patchEntity($results, $surveydetails);
            // debug( $sdata);
            $this->SurveyData->save($sdata);

            $result = [
                'error' => 0,'status' => 200
            ]; 

        }
        
    }
    $this->set ("result", $result); 


}

public function savesurveydata(){
    $result=[];
    $result['error'] = 1;
    if($this->request->is('post')){
        $data = $this->request->getdata(); 
        $pid=$data["pid"];
        $punid =$data['punid'];
        $data = json_decode($data['fdata']);
        // debug($data);
        foreach($data as $d){
            
            $surveydata = $this->SurveyData->newEmptyEntity();
            $surveydetails = [];
            $surveydetails['survey_id'] = $d->survey_id;
            $surveydetails['question_id'] = $d->question_id;
            $surveydetails['field_executive_id'] = $d->field_executive_id;
            $surveydetails['geo_location'] = '23.23,34,8';
            $surveydetails['question'] = $d->question;
            // $surveydetails['option_data'] = $d->answer;           
            $surveydetails['option_data'] = is_array($d->answer) ? implode(',',$d->answer) : $d->answer ;
            $surveydetails['partcipants_id'] = $pid;
            $surveydetails['unid'] = $punid;
            $sdata = $this->SurveyData->patchEntity($surveydata, $surveydetails);
            $this->SurveyData->save($sdata);
            $result = [
                'error' => 0,'status' => 200
            ]; 
        }
        
       // debug($data);
    }else{
        $result = [
            'error' => 1,
        ];
    }
    $this->set ("result", $result); 
}

public function patientdetails(){

    $result = [];
    if($this->request->is('post')){ 
        $data = $this->request->getData();  
        $uniqID = $data["idcode"] . $data["clustercode"] . $data["indiviadualcode"];
       $patientdata = TableRegistry::get('Partcipants');
       $patientdetails = $this->Partcipants->newEmptyEntity();
       $patientdetails->name =$data["name"];
       $patientdetails->survey_id =$data["survey_id"];
       $patientdetails->created_on = date("Y-m-d");
       $patientdetails->age =$data["age"];
       $patientdetails->mobile =$data["mobile"];
       $patientdetails->adharnumber =$data["adharnumber"];
       $patientdetails->occupation =$data["occupation"];
       $patientdetails->education =$data["education"];
       $patientdetails->gender =$data["gender"];
       $patientdetails->status =$data["status"];
       $patientdetails->is_survey = $data["is_survey"];
       $patientdetails->monthlyincome =$data["monthlyincome"];
       $patientdetails->country = $data["country"];
       $patientdetails->state = $data["state"];
       $patientdetails->district = $data["district"];
       $patientdetails->idcode = $data["idcode"];
       $patientdetails->clustercode = $data["clustercode"];
       $patientdetails->indiviadualcode = $data["indiviadualcode"];
       $patientdetails->landmark = $data["landmark"];
       $patientdetails->education_others = $data["othersed"];
       $patientdetails->occupation_others = $data["othersoc"];
       $patientdetails->unid =  intval($uniqID);
       $patientdetails->created_by = 1;
       $patientdata->save($patientdetails);
       $lastParticipant = $this->Partcipants->find('all')->last();
       $lastRecordId = $lastParticipant->id;

       $result = [
        'error' => 0,'status' => 200, 'id'=>$lastRecordId, 'name'=>$data["name"], 'age'=>$data["age"], "unid"=>  intval($uniqID)
    ];

    }else{
        $result = [
            'error' => 1,
        ];
    }
    $this->set ("result",   $result);
}
     
    public function participantList(){ 
        $result = [];
        $result = ['error' => 1,];
        $this->request->is('post');
        $data = $this->request->getData();  
              
        $results = $this->Partcipants->find ( 'all' )
         ->where(['survey_id' => $data['id']])->toArray(); 

        
        $surveys = $this->Survey->find ( 'all' )
        ->where(['id' => $data['id']])->toArray(); 
        foreach ($surveys as $survey){
        $surveyname = $survey->name;
        $surveyvillage = $survey->village;
        $surveycountry = $survey->country;
        }
         $result = [
            'error' => 0, 'status' => 200, 'PartcipantsData' => $results, 'surveyname'=> $surveyname, 'surveycountry'=>$surveycountry, 'surveyvillage'=>$surveyvillage
        ];
        $this->set ("result",   $result);  
    }


    public function sectiondata(){
        $result = [];
        $result = ['error' => 1,];
        $result = $this->SurveyQuestions->find ( 'all' )->group(['section']); 
        // $result = [
        //     'error' => 0, 'Surveyquestion' => $results,'status' => 200
        // ];       
        $this->set ("result",$result);
    }

    public function surveyupdate(){
        $result['error'] = 1;
        $result_data = '';
        if($this->request->is('post')){ 
            $data = $this->request->getData(); 
            // debug($data);
            // die;
            $results = $this->Partcipants->get($data['id']);

            if (!empty($data['name'])){
                $Partcipantedit ['name'] = $data['name'];
                $Partcipantedit ['age'] = $data['age'];
                $Partcipantedit ['mobile'] = $data['mobile'];
                $Partcipantedit ['status'] = $data['status'];
                $Partcipantedit ['gender'] = $data['gender'];
                $Partcipantedit ['nameeducation'] = $data['education'];
                $Partcipantedit ['adharnumber'] = $data['adharnumber'];
                $Partcipantedit ['occupation'] = $data['occupation'];
                $Partcipantedit ['monthlyincome'] = $data['monthlyincome'];
                $Partcipantedit ['country'] = $data['country'];
                $Partcipantedit ['state'] = $data['state'];
                $Partcipantedit ['district'] = $data['district'];
                $Partcipantedit ['idcode'] = $data['idcode'];
                $Partcipantedit ['clustercode'] = $data['clustercode'];
                $Partcipantedit ['indiviadualcode'] = $data['indiviadualcode'];
                $Partcipantedit ['landmark'] = $data['landmark'];

                $surveyPartcipantedit = $this->Partcipants->patchEntity($results,$Partcipantedit);
                $this->Partcipants->save( $surveyPartcipantedit);
                $result_data='Data added';

            }

        }
        $result = [
            'Surveyquestion' => $results, $result_data, 'error'=>0, 'status'=> 200
        ];
        $this->set ("result",$result);
    }

   
    public function editprofile(){
        $result = [];
        $result = ['error' => 1,];
        $this->request->is('post');
        $data = $this->request->getData(); 
        // debug($data);
        $results = $this->FieldExecutive->get($data['id']); 
        if (!empty($data['username'])){
            $fielddata ['username'] = $data['username'];
            $fielddata ['email'] = $data['email'];
            $fielddata ['mobile'] = $data['phone'];
            $profiledata = $this->FieldExecutive->patchEntity($results,$fielddata);
            $this->FieldExecutive->save( $profiledata);
        }
        $result = [
            'error'=>0, 'status'=> 200, 'fieldexecutive'=> $results
       ];

        // $result = $this->FieldExecutive->find ( 'all' )
        // ->where(['id' => $data['id']])->toArray();
        // debug($data['id']) ;
        // debug($result) ;
        $this->set ("result",$result);
    }
    public function changepassword(){
        $result = [];
        $result = ['error' => 1,];
        $this->request->is('post');
        $data = $this->request->getData(); 
        // debug($data);
        if($data['newpassword'] === $data['confirmpwd']){
            $participants = $this->FieldExecutive->find('all')
            ->select(['id'])
            ->where(['password' => $data['curpassword'] ])
            ->toArray();
          
            $fielddataRecord = $this->FieldExecutive->get( $participants[0]['id']);
            $fielddataRecord->password = $data['newpassword'];
            $this->FieldExecutive->save($fielddataRecord);
            $result = [
                'error'=>0, 'status'=> 200,
           ];
            
        }
        $this->set ("result",$result);
    }
    public function sendotpresetpwd(){
        $result = [];
        $data = $this->request->getData();
        
        $useremail = $this->FieldExecutive->find('all')
        ->select(['email','id'])
        ->where(['email'=>$data['email'] ])->toArray();
       if(count($useremail) == 1){
            $otp = random_int(000001,999999);
            $currentTime = FrozenTime::now();
           $newOtpEntity = $this->Onetimepassword->newEmptyEntity();
           $newOtpEntity->email = $useremail[0]['email'];
           $newOtpEntity->otp = $otp;
           $newOtpEntity->createdon = date("Y-m-d");
           if ($this->Onetimepassword->save($newOtpEntity)) {
             $result['message'] = "OTP saved successfully";
           } 
       } 
    
        $conf=[];
        $conf['host'] = 'ssl://smtp.gmail.com';
        $conf['port'] = 465;
        $conf['username'] = 'yenibhavya0508@gmail.com';
        $conf['password'] = 'tpqujcgroydpzloc';
        $conf['fromemail'] = "yenibhavya0508@gmail.com";
        $conf['sender'] = "Raviapp";
        if(!empty($useremail)){
        $emailsend['email'] = $useremail[0]->email;
        $mailtext['otp'] = $otp;
        $this->Email->sendotpmail($conf, $emailsend['email'], " Your OTP for reset password",$mailtext);
        $result = [
            'error'=>0, 'status'=> 200, 'OTP' => $mailtext, 'email' =>$emailsend ? $emailsend['email'] : null
       ];
        }else{
            
            $result = [
                'error'=>1, 
           ];
        }
        $this->set ("result",$result);

    }
    public function sendingresetotp(){
        $result = [];
        $result ['error'] = 1;
        $data = $this->request->getData();
        $sendOtp = $this->Onetimepassword->find('all')
        ->select(['otp'])
        ->where(['otp'=>$data['otp'] ])->toArray();
        // debug( $sendOtp);
        if(isset($sendOtp[0]['otp'])){
            $value = $sendOtp[0]['otp'];
        $result = ['error'=>0, 'status'=> 200,'otp'=>$value ];
       }else{
        $value = null;
        $result ['error'] = 1;
       }
        $this->set ("result",$result);

    }

    public function resetpassword(){
        $result = [];
        $result ['error'] = 1;
        $data = $this->request->getData();
        // debug($data);
        $useremail = $this->FieldExecutive->find('all')
        ->select(['id'])
        ->where(['email'=>$data['email'] ])->toArray();
        // debug($useremail);
        if($useremail!=0){
        $fielddataRecord = $this->FieldExecutive->get( $useremail[0]['id']);
        $fielddataRecord->password = $data['newpassword'];
        $this->FieldExecutive->save($fielddataRecord);
        $result = [
            'error'=>0, 'status'=> 200,
       ];
    }
    $this->set ("result",$result);
    }
}

