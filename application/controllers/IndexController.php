<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
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
        
        // Show the list with e-mailaddresses
		$list = new Application_Model_DbTable_List();
        $email_list = $list->getList();
		$this->view->email_list = $email_list;
        
        // To add a new subscriber to the list
        $list_form = new Application_Form_List();
        $this->view->list_form = $list_form;
        if($this->getRequest()->isPost()) {
            $form_data = $this->getRequest()->getPost();
            if($list_form->isValid($form_data)) {
                // Todo: nieuw e-mailadres moet worden toegevoegd aan de lijst
            } else {
                $list_form->populate($form_data);
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
                // $mail->setBodyText();
                // get html
                $html = $this->generateMailHtml($formData["message"], $formData["name"], $formData["slogan"], $formData["theme"]);
                $mail->setBodyHtml($html);
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

    private function generateMailHtml($message, $name, $slogan, $idTheme) {
        $themes = new Application_Model_DbTable_Themes();
        $theme = $themes->fetchRow(array('id'=>$idTheme));
        $strTheme = $theme["name"];
        Zend_Debug::dump(scandir("./themes/$strTheme"));
        $themeHtml = file_get_contents("./themes/".$strTheme."/index.php");
        $themeHtml = str_replace('$currentDay$', date("d"), $themeHtml);
        $themeHtml = str_replace('$currentMonth$', date("m"), $themeHtml);
        $themeHtml = str_replace('$currentYear$', date("y"), $themeHtml);
        $themeHtml = str_replace('$companyName$', $name, $themeHtml);
        $themeHtml = str_replace('$companySlogan$', $slogan, $themeHtml);
        $themeHtml = str_replace('$message$', $message, $themeHtml);
        return $themeHtml;
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







