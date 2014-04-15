<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $mail_form = new Application_Form_Mail();
        $this->view->mail_form = $mail_form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($mail_form->isValid($formData)) {
                // TODO: functie schrijven om mails uiteindelijk te versturen
                // mailing form is valid => send mail function parameters are in $form->getValue('paramname')
            } else {
                $mail_form->populate($formData);
            }
        }
        
        // To add a new subscriber to the list
        $list_form = new Application_Form_List();
        $this->view->list_form = $list_form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($list_form->isValid($formData)) {
                // TODO: functie schrijven om mails uiteindelijk te versturen
                // mailing form is valid => send mail function parameters are in $form->getValue('paramname')
            } else {
                $list_form->populate($formData);
            }
        }
    }

    public function newmailAction()
    {
        $form = new Application_Form_Mail();
        $this->view->form = $form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                // TODO: functie schrijven om mails uiteindelijk te versturen
                Zend_Debug::dump($formData);
                $mail = new Zend_Mail();
                //$mail->setBodyText();
                $mail->setBodyHtml($formData["message"]); // get theme html
                $mail->setFrom('zendtheme@gmail.com', $formData["name"]);
                $mail->addTo('zendtheme@gmail.com'); // add recipient list here
                $mail->setSubject($formData["subject"]);
                $mail->send();
                $form->populate($formData);
            } else {
                $form->populate($formData);
            }
        }

    }
    
    public function showlistAction()
    {
        // Show the e-maillist
    }
    
    public function newsubscriberAction()
    {
        // To add a new subscriber to the list
        $form = new Application_Form_List();
        $this->view->form = $form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                // TODO: functie schrijven om mails uiteindelijk te versturen
                // mailing form is valid => send mail function parameters are in $form->getValue('paramname')
            } else {
                $form->populate($formData);
            }
        }
    }




}







