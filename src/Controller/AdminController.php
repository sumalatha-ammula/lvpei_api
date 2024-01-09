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
		$this->loadModel("FeildExecutive");
		$this->loadModel("Survey");
		$this->loadModel("SurveyQuestions");
		
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
		/*
		 * $pwd = "PoliticalLab2022";
		 * $hasher = new DefaultPasswordHasher ();
		 * $hashedpwd = $hasher->hash ( $pwd );
		 * echo $hashedpwd;
		 *
		 * die;
		 */
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
		
        $masterOptionData = $this->MasterMain->find(
            'list',
            [
                'keyField' => 'name',
                'valueField' => 'name',
			
            ])
            ->toArray();
			// debug($masterOptionData);die;
			$this->set(compact('masterOptionData'));
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
				$adsurveyQuUpdData->country = $data['Selected_Countrys'];
				$adsurveyQuUpdData->village = $data['Village_Name'];
				$adsurveyQuUpdData->createdby = (int)$this->userdt;
				$adsurveyQuUpdData->created_on = date("Y-m-d");
				$adsurveyQuUpdData->status = 1;
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
			$surveydata = $data['Survey_Question'];
			$masterId= $this->MasterMain->find ( 'all' )
			->select(['id'])
			->where(['name'=>$surveydata[0]])
			->toArray();
			// debug($masterId[0]->id);
			// die;
			if (!empty($data['Survey_Question'])) {
				$adsurveyQuT = TableRegistry::get('SurveyQuestions');
				$adsurveyQuUpdData = $this->SurveyQuestions->newEmptyEntity();
				$adsurveyQuUpdData->section = $data['Section'];
				$adsurveyQuUpdData->question = $data['Survey_Question'][0];
				$adsurveyQuUpdData->option_type = $data['Answer_Type'];
				$adsurveyQuUpdData->master_main_id= $masterId[0]->id;
				$adsurveyQuUpdData->survey_id = $data['id'];
				$adsurveyQuUpdData->createdby = (int)$this->userdt;
				$adsurveyQuUpdData->created_on = date("Y-m-d");
				// $adsurveyQuUpdData->status = 1;
                // debug($adsurveyQuUpdData);
				$adsurveyQuT->save($adsurveyQuUpdData);
				$this->Flash->success(__('The Survey Question data has been saved.'));
			}else {
				$this->Flash->error(__('The data could not be saved. Please, try again.'));
			}
			return $this->redirect(["controller" => "Admin", 'action' => 'rvappsurveydata']);

		}
	}

    public function feildexecutive() {
		$feilddata = $this->FeildExecutive->find('all');
		$feildexecutiveData = $this->paginate($feilddata);
		$this->set ("feildexecutiveData", $feildexecutiveData);
       }

    public function createfeildexecutive(){
            
            if($this->request->is('post')){
                $data = $this->request->getdata();
				// debug($data);
                $addrT_Data = TableRegistry::get('FeildExecutive');
                $adUpdr_Data= $this->FeildExecutive->newEmptyEntity();
                $adUpdr_Data->name =  $data['Mobilenumber'];
                $adUpdr_Data->email = $data['email'];
                $adUpdr_Data->password =  $data['password'];
                $adUpdr_Data->username = $data['username'];
                $addrT_Data->save($adUpdr_Data); 
                $result = 'The register Data has been saved.';
				return $this->redirect ( [
					'action' => 'feildexecutive'
			]);
            }
		return null;
        }

	public function mastermain(){
		$masterdata = $this->MasterMain->find ( 'all' );
		$master = $this->paginate ($masterdata);
		$this->set ( "master", $master);

	}

	public function addmastermain(){
		$data = $this->request->getData();
		if (!empty($data['Name'])) {
            $admasterT = TableRegistry::get('MasterMain');
            $adsurveyQuUpdData = $this->MasterMain->newEmptyEntity();
            $adsurveyQuUpdData->name = $data['Name'];
            $adsurveyQuUpdData->createdby = (int)$this->userdt;
            $adsurveyQuUpdData->created_on = date("Y-m-d");
            $adsurveyQuUpdData->status = 1;
			$admasterT->save($adsurveyQuUpdData);
            $this->Flash->success(__('The Master_main data has been saved.'));
        } else {
            $this->Flash->error(__('The data could not be saved. Please, try again.'));
        }
		return $this->redirect(["controller" => "Admin", 'action' => 'mastermain']);
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
					$admasterOpUpdData->created_by = (int)$this->userdt;
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
