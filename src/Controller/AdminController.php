<?php
declare(strict_types = 1)
	;

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc.
 * (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link https://cakephp.org CakePHP(tm) Project
 * @since 0.2.9
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Utility\Text;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class AdminController extends AppController {
	public function initialize(): void {
		parent::initialize ();
		$this->loadModel ( 'Admin' );
		$this->loadModel( 'MasterMain' );
		$this->loadModel( 'MasterOptions');
		$this->loadModel("FieldExecutive");
		$this->loadModel("Survey");
		$this->loadModel("SurveyQuestions");
		$this->loadModel("Partcipants");
		$this->loadModel("SurveyData");
		$this->loadModel("Userdata");
		
		$this->loadComponent ( 'Auth', array (
				'loginAction' => array (
						'controller' => 'Admin',
						'action' => 'index' 
				),
				'unauthorizedRedirect' => array (
						'controller' => 'Admin',
						'action' => 'index' 
				),
				'logoutRedirect' => array (
						'controller' => 'Admin',
						'action' => 'index' 
				),
				'loginRedirect' => array (
						'controller' => 'Admin',
						'action' => 'dashboard' 
				),
				'authError' => 'Please log in to view your account.',
				'authenticate' => array (
						'Form' => array (
								'userModel' => 'Userdata',
								'fields' => [ 
										'username' => 'email',
										'password' => 'password' 
								] 
						) 
				),
				'unauthorizedRedirect' => true 
		) );
		$this->admindata = $this->Auth->user ();
		$this->userdt = $this->Auth->user ();
		$actionname = $this->request->getParam ( 'action' );
		$this->set ( "action", $actionname );
		$this->set ( "user", $this->userdt );
	}
	public function logout() {
		return $this->redirect ( $this->Auth->logout () );
	}
	public function index() {
		$this->viewBuilder ()->disableAutoLayout ();
		
		//   $pwd = "Raviapp@123";
		//   $hasher = new DefaultPasswordHasher ();
		//   $hashedpwd = $hasher->hash ( $pwd );
		//   echo $hashedpwd;
		 
		//   die;
		 
		if ($this->request->is ( 'post' )) {
			$user = $this->Auth->identify ();
			// debug($user);
			// die;
			if ($user) {
				$this->Auth->setUser ( $user );
				$redirecturl = [ 
						"controller" => "Admin",
						"action" => "dashboard" 
				];
				return $this->redirect ( $redirecturl );
			} else {
				$this->Flash->error ( __ ( 'Invalid username or password, try again' ) );
				return $this->redirect ( array (
						"controller" => "Admin",
						"action" => "index" 
				) );
			}
		}
	}
	public function dashboard() {
	}
	public function agents() {
		$agentsdata = $this->Agent->find ( 'all' );
		$agents = $this->paginate ( $agentsdata );
		$this->set ( "agents", $agents );
	}
	public function createagent() {
		
		$agent = $this->Agent->newEmptyEntity ();
		if ($this->request->is ( 'post' )) {
			$agent = $this->Agent->patchEntity ( $agent, $this->request->getData () );
			$hasher = new DefaultPasswordHasher ();
			$agent->created_by = $this->admindata['id'];
			//$agent->password = $hasher->hash ( $agent->password );
			if ($this->Agent->save ( $agent )) {
				$this->Flash->success ( __ ( 'The Agent has been saved.' ) );
				return $this->redirect ( [
						'action' => 'agents'
				]);
			}
			$this->Flash->error(__('The agent could not be saved. Please, try again.'));
		}
		$this->set(compact ( 'agent' ) );
	}
	public function surveys() {
		$surveydata = $this->Survey->find ( 'all' );
		$surveys = $this->paginate ( $surveydata);
		$this->set ( "surveys", $surveys);
	}
	
	public function savesurveyquestionoptions(){
		$this->response->withHeader ( 'Access-Control-Allow-Origin', '*' );
		$this->response->withType ( 'json' );
		$this->request->allowMethod ( [
				'post',
				'put',
				'get'
		] );
		$result = [];
		$this->viewBuilder ()->setLayout ( "ajax" );
		if ($this->request->is ( 'post' )) {
			$data=$this->request->getData();
			
			$sq = $this->SurveyQuestions->newEmptyEntity ();
			$sq = $this->SurveyQuestions->patchEntity ( $sq, $data);
			$sq->created_by = $this->admindata['id'];
			if ($sqinsert = $this->SurveyQuestions->save ( $sq)) {
				foreach($data['answers'] as $ans){
					$so = $this->SurveyOptions->newEmptyEntity ();
					$sodata = [];
					$sodata['survey_questions_id'] = $sqinsert->id;
					$sodata['answer'] = $ans;
					$sop = $this->SurveyOptions->patchEntity ( $so, $sodata);
					if(!$this->SurveyOptions->save ( $sop)){
						debug($so->getErrors()); 
					}
				}
			}
			$result = $data;
		}
	
		$this->set("result", $result);
	}
	
	public function viewsurveyquestionoptions(){
		$this->response->withHeader ( 'Access-Control-Allow-Origin', '*' );
		$this->response->withType ( 'json' );
		$this->request->allowMethod ( [
				'post',
				'put',
				'get'
		] );
		$result = [];
		$this->viewBuilder ()->setLayout ( "ajax" );
		if ($this->request->is ( 'post' )) {
			$data=$this->request->getData();
			$surveyquestions = $this->SurveyQuestions->find('all')
			->where(['SurveyQuestions.id' => $data['survey_id']])
			->contain(['SurveyOptions'])
			->toArray();
			$result['surveyquestions'] = $surveyquestions;
		}
		$this->set("result", $result);
	}
	
	public function createsurvey() {
		$survey = $this->Survey->newEmptyEntity ();
		if ($this->request->is ( 'post' )) {
			$survey= $this->Survey->patchEntity ( $survey, $this->request->getData () );
			$survey->created_by = $this->admindata['id'];
			$survey->category_id = 1;
			if ($this->Survey->save ( $survey)) {
				$this->Flash->success ( __ ( 'The Survey has been saved.' ) );
				return $this->redirect ( [
						'action' => 'surveys'
				]);
			}
			$this->Flash->error(__('The Survey could not be saved. Please, try again.'));
		}
		$this->set(compact ( 'survey' ) );
	}
	public function createsurveyquestion() {
	}
	public function surveydata() {
	    $surveydata = $this->SurveyReport->find ( 'all' )
		->contain(['SurveyQuestions', 'SurveyReportData']);
		debug($surveydata->toArray());die;
	}
// newdata

    public function rvappsurveydata(){
		$surveydata = $this->Survey->find ( 'all' );
		$surveys = $this->paginate ( $surveydata);
		// $fieldexecutive = $this->FieldExecutive->find(
        //     'list',
        //     [
        //         'keyField' => 'id',
        //         'valueField' => 'username'
        //     ]
        // )
        //     ->toArray();
		$this->set ( "surveys", $surveys);
		// $this->set ( "fieldexecutive", $fieldexecutive);
	}
    
	public function surveyparticipants($id = null){
		$surveydata = $this->Partcipants->find ( 'all' )
		->contain(["Survey"])
		->where(['survey_id'=>$id]);
		$surveys = $this->paginate ( $surveydata);
		$this->set ( "surveys", $surveys);
		$this->set('id', $id);
		
	}

	public function surveyparticipantsdata($id1 = null, $id2=null){
		$surveydata = $this->SurveyData->find ( 'all' )
		->contain(["Survey","SurveyQuestions", "FieldExecutive","Partcipants" ])
		->where(['SurveyData.partcipants_id'=>$id1,'SurveyData.survey_id'=>$id2 ]);
		$surveys = $this->paginate ( $surveydata);
		// debug($surveys);
		$this->set ( "surveys", $surveys);
	}

	public function createsurveyrvapp(){
		if($this->request->is('post')){
			$data = $this->request->getdata();
			// debug($data);
			if (!empty($data['Name'])) {
				$adsurveyT = TableRegistry::get('Survey');
				$adsurveyQuUpdData = $this->Survey->newEmptyEntity();
				$adsurveyQuUpdData->name = $data['Name'];
				// $adsurveyQuUpdData->field_executive_id = $data['Field_Executive'];
				$adsurveyQuUpdData->country = $data['Selected_Country'];
				$adsurveyQuUpdData->village = $data['Village_Name'];
				$adsurveyQuUpdData->created_by = $this->userdt['id'];
				//$adsurveyQuUpdData->created_on = date("Y-m-d");
				//$adsurveyQuUpdData->status = 1;
				$adsurveyT->save($adsurveyQuUpdData);
				$this->Flash->success(__('The Master_main data has been saved.'));
			}else {
				$this->Flash->error(__('The data could not be saved. Please, try again.'));
			}
			return $this->redirect(["controller" => "Admin", 'action' => 'rvappsurveydata']);

		}
		
	}
    
    public function addqutionsurveyrvapp(){
		if($this->request->is('post')){
			$data = $this->request->getdata();
			// debug($data);
			// die;
			if($data['Option_Type'] === 'Text Box'){
				$masterID= 0;

			}else{
				$masterID = $data['Select_Survey_Question'];
			}
			
			if (!empty($data['Question'])) {
				$adsurveyQuT = TableRegistry::get('SurveyQuestions');
				$adsurveyQuUpdData = $this->SurveyQuestions->newEmptyEntity();
				$adsurveyQuUpdData->section = $data['Section'];
				$adsurveyQuUpdData->question = $data['Question'];
				$adsurveyQuUpdData->option_type = $data['Option_Type'];
				$adsurveyQuUpdData->master_main_id= $masterID;
				$adsurveyQuUpdData->survey_id = $data['id'];
				$adsurveyQuUpdData->created_by = $this->userdt['id'];
				$adsurveyQuUpdData->created_on = date("Y-m-d");
				$adsurveyQuUpdData->is_clinical = $data['is_clinical'];
				$adsurveyQuT->save($adsurveyQuUpdData);
				$this->Flash->success(__('The Survey Question data has been saved.'));
			}else {
				$this->Flash->error(__('The data could not be saved. Please, try again.'));
			}
			$lastsurveyid = $data['id'];
			return $this->redirect(["controller" => "Admin", 'action' => 'addsurveyqution', $lastsurveyid]);

		}
	}

	public function editsurveyqution($id = null, $ids = null)
		{
			$surveyedit = $this->SurveyQuestions->get($id);
			$othersurveyquestions = $this->SurveyQuestions->find('list', [
				'keyField' => 'id',
				'valueField' => 'question',
			])
			->where(['survey_id' => $surveyedit->survey_id, 'option_type' => 'Dropdown'])->toArray();
			

			if ($this->request->is(['post', 'put'])) {
				$data = $this->request->getdata();
                if($data['option_type'] === 'Text Box'){
					$masterID= 0;
	
				}else{
					$masterID = $data['master_main_id'];
				}
				// debug($data);
				$masterdata['section'] = $data['section'];
				$masterdata['question'] = $data['question'];
				$masterdata['option_type'] = $data['option_type'];
				$masterdata['master_main_id'] = $masterID;
				$masterdata['is_clinical'] = $data['is_clinical'];
				$masterdata['parent_id'] = $data['parent_id'];
				$masterdata['show_if'] = $data['show_if'];
                // debug($masterdata);
				$surveyedit = $this->SurveyQuestions->patchEntity($surveyedit,$masterdata);
				// debug($surveyedit);
			  if ($this->SurveyQuestions->save($surveyedit)) {
					$this->Flash->success(__('The data has been saved.')); 
					
					return $this->redirect(['action' => 'addsurveyqution', $ids]);
				}
				$this->Flash->error(__('The data could not be saved. Please, try again.'));
			}
			$masterOptionData = $this->MasterMain->find('list',[
				'keyField' => 'id',
				'valueField' => 'name',
			])->toArray();

			$this->set(compact('surveyedit'));
			$this->set(compact('masterOptionData'));
			$this->set(compact('othersurveyquestions'));
			$this->set("active", "bbpsappsedit");
	}

	public function deletesurveyqution($id = null, $ids = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $data = $this->SurveyQuestions->get($id);
        // debug($data);
		// die;
        if ($this->SurveyQuestions->delete($data)) {
            $this->Flash->success(__('The record has been deleted.'));
        } else {
            $this->Flash->error(__('The record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'addsurveyqution',$ids]);
    }

	public function addsurveyqution($id = null){
		
		// debug($id);
		// echo "hello";
		
		$surveyquestiondata = $this->SurveyQuestions->find ( 'all' )
		->order(['sort'=>'DESC', 'SurveyQuestions.id'])
		->contain(['MasterMain'])
		->where(['survey_id' => $id]);
		$surveys = $this->paginate ( $surveyquestiondata);
		$masterOptionData = $this->MasterMain->find(
            'list',
            [
                'keyField' => 'id',
                'valueField' => 'name',
			
            ])
            ->toArray();
			// debug($masterOptionData);die;
			$this->set(compact('masterOptionData'));
			$this->set ( "surveys", $surveys);
			$this->set('id', $id);
	}
	
    public function fieldexecutive() {
		$feilddata = $this->FieldExecutive->find('all');
		$feildexecutiveData = $this->paginate($feilddata);
		$this->set ("feildexecutiveData", $feildexecutiveData);
       }

    public function createfeildexecutive(){
            
            if($this->request->is('post')){
                $data = $this->request->getdata();
				// debug($data);
                $addrT_Data = TableRegistry::get('FieldExecutive');
                $adUpdr_Data= $this->FieldExecutive->newEmptyEntity();
                // $adUpdr_Data->name =  $data['Mobilenumber'];
                $adUpdr_Data->email = $data['email'];
                $adUpdr_Data->password =  $data['password'];
                $adUpdr_Data->username = $data['username'];
                $addrT_Data->save($adUpdr_Data); 
                $result = 'The register Data has been saved.';
				return $this->redirect ( [
					'action' => 'fieldexecutive'
			]);
            }
		return null;
        }

	public function mastermain(){
		$masterdata = $this->MasterMain->find('all')
          
		->contain(["Userdata"]);
		$master = $this->paginate($masterdata);
		// debug($master);
		
		$this->set ( "master", $master);

	}
	public function editmastermain(){
		
	}

	public function addmastermain(){
		$data = $this->request->getData();
		
		if (!empty($data['Name'])) {
            $admasterT = TableRegistry::get('MasterMain');
            $adsurveyQuUpdData = $this->MasterMain->newEmptyEntity();
            $adsurveyQuUpdData->name = $data['Name'];
            $adsurveyQuUpdData->created_by = $this->userdt['id'];
            //$adsurveyQuUpdData->created_on = date("Y-m-d");
            $adsurveyQuUpdData->status = 1;
			$admasterT->save($adsurveyQuUpdData);
            $this->Flash->success(__('The Master_main data has been saved.'));
        } else {
            $this->Flash->error(__('The data could not be saved. Please, try again.'));
        }
		return $this->redirect(["controller" => "Admin", 'action' => 'mastermain']);
	}
    
	public function masteroptionsdata($id=null){
		$masterOp_Data = $this->MasterOptions->find('all')
		->contain(["MasterMain"])
		->where(['master_main_id'=>$id])
		->toArray();
		// debug($masterOp_Data);
		$this->set ( "masterOp_Data", $masterOp_Data);

	}
    public function masteroptions(){
		$result = [];
		$data = $this->request->getData();
		
		if(!empty($data['master_main_id'])){
			// echo "hello";
			$masterOp_Data = $data["option_value"];
			$mastersort_Data = $data["sort"];
			// debug($masterOp_Data);
			foreach ($masterOp_Data as $index => $masterOp) {
				// Check if the index exists in the second array
				if (isset($mastersort_Data[$index])) {
					$mastersort = $mastersort_Data[$index];
			
					$admasterOpUpdData = $this->MasterOptions->newEmptyEntity();
					$admasterOpUpdData->created_by = $this->userdt['id'];
					$admasterOpUpdData->status = 1;
					$admasterOpUpdData->created_on = date("Y-m-d");
					$admasterOpUpdData->master_main_id = $data['master_main_id'];
					$admasterOpUpdData->option_value = $masterOp;
					$admasterOpUpdData->sort = $mastersort;
			
					// Save the record
					$this->MasterOptions->save($admasterOpUpdData);
				
					$result= "The Master_option data has been saved.";
				} else {
				
					$result='The data could not be saved. Please, try again.';
				}
			}
			
		
			$result = $data;
		}
		$this->set("result", $result);
	}

}
