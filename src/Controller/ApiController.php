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
            $this->loadModel("FeildExecution");
        }

        public function login(){
            
            if($this->request->is('post')){
                $data = $this->request->getdata();
                $addrT_Data = TableRegistry::get('FeildExecution');
                $adUpdr_Data= $this->FeildExecution->newEmptyEntity();
                $adUpdr_Data->name =  $data['name'];
                $adUpdr_Data->email = $data['email'];
                $hasher = new DefaultPasswordHasher();
                $adUpdr_Data->password =  $hasher->hash($data['password']);
                $adUpdr_Data->username = $data['username'];
                $addrT_Data->save($adUpdr_Data); 
                $result = 'The register Data has been saved.';
            }
            $this->set("result", $result);
        }
    }