<?php

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Controller\ComponentRegistry;

class EmailComponent extends Component
{
    public $components = ['Email'];
    public $email;
    public $attachments = [];



    public function __construct()
    {
        $this->email = new Email('default');
    }


    public function confOtpEmail($c, $mailtext)
    {
        TransportFactory::setConfig('gmail', [
            'host' => $c['host'],
            'port' => $c['port'],
            'timeout' => 30,
            'log' => true,
            'username' => $c['username'],
            'password' => $c['password'],
            'className' => 'Smtp'
        ]);

        $this->email->setTransport("gmail");
        $this->email->setFrom($c['fromemail'], $c['sender']);
        $this->email->setReturnPath($c['fromemail']);
        $this->email->setEmailFormat('html');
        $this->email->viewBuilder()->setTemplate('sendotpemail');
        $this->email->setViewVars(['mailtext' => $mailtext]);
    }


    public function sendotpmail($conf, $emailsend, $subject, $mailtext)
    {


        $conf['template'] = 'sendotpmail';

        $this->confOtpEmail($conf, $mailtext);

        $res = $this->email->setTo($emailsend)
            ->setSubject($subject)
            ->send();

        // debug($res);
        return $res;
    }
}
