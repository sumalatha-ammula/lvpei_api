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
                $ld->token = $this->generatetoken();
                $ld->deviceid = isset($data['deviceid']) ? $data['deviceid'] : '';
                $ld->deviceinfo = isset($data['deviceinfo']) ? $data['deviceinfo'] : '';
                $fielddata[0]->token = $ld->token;
                $lt->save($ld);
                $result = [
                    'error' => 0,'member' => $fielddata[0],'status' => 200
                ];

                }                 
            }
            $this->set("result", $result);
        }
        public function survey() { 
            $result=[];
            $result['error'] = 1;
            if($this->request->is('post')){
                $data = $this->request->getdata();  
          
                $Surveydat = $this->Survey->find ( 'all' )
                ->contain(['Partcipants'])
               
                ->toArray();   
                
                $result = [
                    'error' => 0,'status' => 200, 'Surveydata'=> $Surveydat
                ];          
            
            }
            $this->set ("result",   $result);           
            }

          public function participantupdate(){
            $result['error'] = 0;
            $data = $this->request->getdata();
        
            $pid= $this->Partcipants->find('all')
            ->select(['id'])
            ->where(['id'=>$data['pid']])
            ->toArray();
            if($pid != 0){
                $partcipantsRecord = $this->Partcipants->get($pid[0]->id);
                $partcipantsRecord->status = 'Examined';
                $partcipantsRecord->is_examine = 1;
                $this->Partcipants->save($partcipantsRecord);
                $result = ['error' => 0,'status' => 200,];
            }
            $this->set ("result",   $result);
          }


//     public function surveyquestions(){
//         $result=[];
//         $result['error'] = 1;
//         if($this->request->is('post')){
//             $data = $this->request->getdata();        
//             $sqs =[];
//             $sqs = $this->SurveyQuestions->find('all')
//             // ->select(['SurveyQuestions.section'])
//            ->contain(['MasterMain','MasterMain.MasterOptions','survey'])
//            ->group(['SurveyQuestions.section','SurveyQuestions.id'])
//            ->where(['SurveyQuestions.survey_id'=> $data['id']])->toArray();
//            $final=[];
//            foreach($sqs as $question){
//             // print_r($question);die;
//             $tmpArray = [
//                 'master_main_name' => @$question['master_main']['name'], 
//                 'options' =>@$question['master_main']['master_options'],
//                 //'section'=>@$question['section'] ,
//                 'question'=>@$question['question'] ,
//                 'question_id'=> $question['id'],
//                 'survey_id' => $question['survey_id'],
//                 //'survey'=>$question['survey']
//             ];    
//             $final[$question['section']][] = $tmpArray;
//             $final[$question['section']]['section'] = $question['section'];
//            }
//            $formattedArray = [];
//             foreach($final  as $secname =>$items){
//                 $formattedArray[] =$items;

                
                
//             }
//        }
//        $formattedArray['survey'][] = 'sectionA';



//        $this->set ("result", array_values($formattedArray));
// }


// public function surveyquestions(){
//     $result=[];
//     $result['error'] = 1;
//     if($this->request->is('post')){
//         $data = $this->request->getdata();        
//         $sqs =[];
//         $sqs = $this->SurveyQuestions->find('all')
//         // ->select(['SurveyQuestions.section'])
//        ->contain(['MasterMain','MasterMain.MasterOptions','survey'])->
//        group(['SurveyQuestions.section','SurveyQuestions.id'])->
//        where(['SurveyQuestions.survey_id'=> $data['id']])->toArray();
//        $surveydata = $this->Survey->find('all')
//        ->where(['id'=>$data['id']])->toArray();
       
//         foreach ($surveydata as $survey){
//         // debug($survey->name);
//         $surveyname = $survey->name;
//         $surveyvillage = $survey->village;
//         $surveycountry = $survey->country;
//                 }
//                 // debug($surveydata);
//        $final=[];
//        foreach($sqs as $question){
//         // print_r($question);die;
//         $tmpArray = [
//             'master_main_name' => @$question['master_main']['name'], 
//             'options' =>@$question['master_main']['master_options'],
//             'section'=>@$question['section'] ,
//             'question'=>@$question['question'] ,
//             'question_id'=> $question['id'],
//             'survey_id' => $question['survey_id'],
//             // 'survey'=>$question['survey']
//         ];    
//         $final[$question['section']][] = $tmpArray;
//     }
//     $result = [
//         'error' => 0,'status' => 200, array_values($final), 'name'=>$surveyname, 'village'=>$surveyvillage, 'surveycountry'=>$surveycountry
//     ];
//    }
//    $this->set ("result",   $result);

// }
public function surveyquestionsnc(){
    $result=[];
    $result['error'] = 1;
    if($this->request->is('post')){
        $data = $this->request->getdata();        
        $sqs =[];
        $sqs = $this->SurveyQuestions->find('all')
        // ->select(['SurveyQuestions.section'])
       ->contain(['MasterMain','MasterMain.MasterOptions','survey'])->
       group(['SurveyQuestions.section','SurveyQuestions.id'])->
       where(['SurveyQuestions.survey_id'=> $data['id'], 'SurveyQuestions.is_clinical'=> '0' ])->toArray();
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
            'survey'=>$question['survey']
        ];    
        $final[$question['section']][] = $tmpArray;
    
    }

   }
   $this->set ("result",   array_values($final));
}

public function surveyquestionsc(){
    $result=[];
    $result['error'] = 1;
    if($this->request->is('post')){
        $data = $this->request->getdata();        
        $sqs =[];
        $sqs = $this->SurveyQuestions->find('all')
        // ->select(['SurveyQuestions.section'])
       ->contain(['MasterMain','MasterMain.MasterOptions','survey'])->
       group(['SurveyQuestions.section','SurveyQuestions.id'])->
       where(['SurveyQuestions.survey_id'=> $data['id'], 'SurveyQuestions.is_clinical'=> '1' ])->toArray();
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
            'survey'=>$question['survey']
        ];    
        $final[$question['section']][] = $tmpArray;
    
    }

   }
   $this->set ("result",   array_values($final));
}



      

public function surveyparticipantsdatarvapp(){
    if($this->request->is('post')){
    $data = $this->request->getData();
    $result = $this->SurveyData->find ( 'all' )
    ->contain(["Survey","SurveyQuestions", "FieldExecutive","Partcipants" ])
    ->where(['SurveyData.partcipants_id'=>$data['id'], 'SurveyData.survey_id' => $data['sid']]);
    }
    $this->set ("result", $result); 
}

public function editsavesurveydata(){
    if($this->request->is('post')){
        $data = $this->request->getdata(); 
        $pid=$data["pid"];
        $data = json_decode($data['fdata']);
        // debug( $data);
        
        foreach($data as $d){
            $results = $this->SurveyData->get($d->question_id);            
            $surveydetails = [];
            $surveydetails['survey_id'] = $d->survey_id;
            $surveydetails['survey_questions_id'] = $d->question_id;
            $surveydetails['field_executive_id'] = $d->executive_id;
            $surveydetails['geo_location'] = '23.23,34,8';
            $surveydetails['question'] = $d->question;
            // $surveydetails['option_data'] = $d->answer;
            $surveydetails['option_data'] = json_encode($d->answer);
            $surveydetails['partcipants_id'] = $pid;
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
        $data = json_decode($data['fdata']);
        foreach($data as $d){
            
            $surveydata = $this->SurveyData->newEmptyEntity();
            $surveydetails = [];
            $surveydetails['survey_id'] = $d->survey_id;
            $surveydetails['survey_questions_id'] = $d->question_id;
            $surveydetails['field_executive_id'] = $d->executive_id;
            $surveydetails['geo_location'] = '23.23,34,8';
            $surveydetails['question'] = $d->question;
            // $surveydetails['option_data'] = $d->answer;
            $surveydetails['option_data'] = json_encode($d->answer);
            $surveydetails['partcipants_id'] = $pid;
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
       $patientdetails->unid =  intval($uniqID);
       $patientdetails->created_by = 1;
       $patientdata->save($patientdetails);
       $lastParticipant = $this->Partcipants->find('all')->last();
       $lastRecordId = $lastParticipant->id;

       $result = [
        'error' => 0,'status' => 200, 'id'=>$lastRecordId, 'name'=>$data["name"], 'mobile'=>$data["mobile"], "unid"=>  intval($uniqID)
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

    public function editsurveyquestions(){
        if($this->request->is('post')){
            $data = $this->request->getData();
            $sps = $this->SurveyData->find ( 'all' )
            ->contain(["Survey","SurveyQuestions", "FieldExecutive","Partcipants","SurveyQuestions.MasterMain.MasterOptions","SurveyQuestions.MasterMain" ])
            ->where(['SurveyData.partcipants_id'=>$data['id'], 'SurveyData.survey_id' => $data['sid']])->toArray();
            // debug($sps);
            $final=[];
            foreach($sps as $question){
            //  debug($question);
             // die;
           
           
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
                 'option_data'=>$question['option_data'],
             ];    
             $final[$question['survey_question']['section']][] = $tmpArray;
        
        
          }
        }

       $this->set ("result",   array_values($final));
    }
    
}

   