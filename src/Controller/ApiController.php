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
            $this->loadModel("FeildExecutive");
            $this->loadModel("Survey");
            $this->loadModel("SurveyQuestions");
            $this->loadModel("MasterMain");
            $this->loadModel("Partcipants");
        }        
        public function login(){
            $result=[];
            $result['error'] = 1;
            if($this->request->is('post')){
                $data = $this->request->getdata();                 
                $feilddata = $this->FeildExecutive->find('all')
                ->where([
                    'password' => $data['password'], 'username' => $data['username']
            ])
                ->toArray();
                if (count($feilddata) == 0) {
                    $result = 'The User Login Not Done.';
                }else{
                    $result = [
                        'error' => 0,'status' => 200
                    ];
                                }                 
            }
            $this->set("result", $result);
        }

        public function survey() {  
            $result =[];         
            $result = $this->Survey->find ( 'all' )->toArray();              
        $this->set ("result",   $result); 
}

public function surveyquestions(){
    $result =[];
   $result = $this->SurveyQuestions->find('all')
   ->contain(['MasterMain','MasterMain.MasterOptions'])->toArray();
   $this->set ("result",   $result); 
}

public function patientdetails(){
    $data = $this->request->getData();
    debug($data);
   $patientdata = TableRegistry::get('Partcipants');
   $patientdetails = $this->Partcipants->newEmptyEntity();
   $patientdetails->name =$data["name"];
   $patientdetails->created_on = date("Y-m-d");
   $patientdetails->age =$data["age"];
   $patientdetails->mobile =$data["mobile"];
   $patientdetails->adharnumber =$data["adharnumber"];
   $patientdetails->occupation =$data["occupation"];
   $patientdetails->gender =$data["gender"];
   $patientdetails->status =$data["status"];
   $patientdetails->monthlyincome =$data["monthlyincome"];
   $patientdata->save($patientdetails);










}

    }