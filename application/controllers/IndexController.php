<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Show the list with e-mailaddresses
        $this->showMailListAction();

        // Show the list with messages
        $this->showMessageListAction();
    }

    public function newmailAction()
    {
        $form = new Application_Form_Mail();
        $this->view->form = $form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                // create model objects
                $dtMails = new Application_Model_DbTable_Mail();
                $dtList = new Application_Model_DbTable_List();

                // get all activated mail addresses
                $rows = $dtList->fetchAll($dtList->select()->where("`status` = 1"));

                // find out what id the new mail should have in the db
                $mail_id = $dtMails->getNextId();

                // loop through mail addresses
                foreach($rows as $row) {
                    // Create Zend_Mail object
                    $mail = new Zend_Mail();
                    // generate HTML
                    $html = $this->generateMailHtml($formData["message"], $formData["name"], $formData["slogan"], $formData["theme"], $mail_id);
                    $html = str_replace('$unsubscribeURL$', 'localhost/school/zendMailingTheme/public/index/unsubscribe?id='.$row['id'].'&auth='.$row['auth_code'], $html);
                    $mail->setBodyHtml($html);
                    // sender info
                    $mail->setFrom('zendtheme@gmail.com', $formData["name"]);
                    // mail subject
                    $mail->setSubject($formData['subject']);
                    // recipient info
                    $mail->addTo($row['email']);
                    // finally send it away
                    $mail->send();
                }

                // save mail in database for viewing in browser later on
                $dtMails->insert(array('id' => $mail_id,'message' => $formData["message"], 'name' => $formData["name"], 'slogan' => $formData["slogan"], 'subject' => $formData['subject'],'theme_id' => $formData["theme"], 'date' => date("y-m-d")));
                // redirect back to homepage
                //$this->redirect("/");
                // keep formData in form
                $form->populate($formData);
            } else {
                // keep formData in form
                $form->populate($formData);
            }
        }
    }

    private function generateMailHtml($message, $name, $slogan, $idTheme, $mail_id)
    {
        // load theme
        if($idTheme == null) {
            // set default theme
            $idTheme = 2;
        }
        $themes = new Application_Model_DbTable_Themes();
        $theme = $themes->fetchRow($themes->select()->where("id = $idTheme"));
        $strTheme = $theme["name"];
        // load theme template file and data
        $themeHtml = file_get_contents("./themes/".$strTheme."/index.html");
        $themeHtml = str_replace('$currentDay$', date("d"), $themeHtml);
        $themeHtml = str_replace('$currentMonth$', date("m"), $themeHtml);
        $themeHtml = str_replace('$currentYear$', date("y"), $themeHtml);
        $themeHtml = str_replace('$companyName$', $name, $themeHtml);
        $themeHtml = str_replace('$companySlogan$', $slogan, $themeHtml);
        $themeHtml = str_replace('$message$', $message, $themeHtml);
        $themeHtml = str_replace('$webVerURL$', 'localhost/school/zendMailingTheme/public/index/loadwebversion?id='.$mail_id, $themeHtml);

        return $themeHtml;
    }

    public function loadwebversionAction()
    {
        (!empty($_GET['id'])?$mail_id = $_GET['id']:$mail_id = 1);
        $dtMails = new Application_Model_DbTable_Mail();
        $info = $dtMails->fetchRow($dtMails->select()->where('id = '.$mail_id));
        $html = $this->generateMailHtml($info["message"], $info["name"], $info["slogan"], $info["theme_id"], $mail_id);
        $this->view->html = $html;
    }

    public function showmaillistAction()
    {
        // Show the mail addresses list
        $list = new Application_Model_DbTable_List();
        $email_list = $list->getList();
        $this->view->email_list = $email_list;
    }

    public function showmessagelistAction()
    {
        // Show the messages list
        $dtMails = new Application_Model_DbTable_Mail();
        $allmails = $dtMails->fetchAll();
        $this->view->allmails = $allmails;
    }

    public function newsubscriberAction()
    {
        // To add a new subscriber to the list
        $form = new Application_Form_List();
        $this->view->form = $form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                // mailing form is valid => send mail + insert new row into list table
                $mail = new Zend_Mail();
                $dtList = new Application_Model_DbTable_List();
                $id = $dtList->getNextId();
                $auth = $this->incrementalHash();
                $mail->setBodyHtml('U have just been subscribed to this mailing list, the only thing left to do from here is to confirm you are the person that actually subscribed. </br></br> <a href="http://localhost/school/zendMailingTheme/public/index/confirmlist?id='.$id.'&auth='.$auth.'">Click here to confirm</a>.');
                // sender info
                $mail->setFrom('zendtheme@gmail.com', $formData["name"]);
                // recipient info
                $mail->addTo($formData["email"]);
                $mail->setSubject("Subscription confirmation required.");
                $mail->send();
                $dtList->insert(array('id' => $id, 'email' => $formData["email"], 'auth_code' => $auth, 'status' => 0));
                $this->redirect("/");
            } else {
                $form->populate($formData);
            }
        }
    }

    public function confirmlistAction()
    {
        // attain list id from the GET
        (!empty($_GET['id'])?$id = $_GET['id']:$id = 1);
        (!empty($_GET['auth'])?$auth = $_GET['auth']:$auth = 1);
        $dtList = new Application_Model_DbTable_List();
        // find corresponding row
        $row = $dtList->fetchRow($dtList->select()->where("`id` = $id AND `auth_code` = '$auth'"));
        if(!empty($row)) {
            // id and auth_code align! add status = true to the row
            $this->view->authCheck = "Success! You are now on the mailing list!";
            $dtList->update(array('status' => 1), "id = $id");
        } else {
            // id or auth_code could not be found in the db
            $this->view->authCheck = "Failure! You have not been added to the mailing list!";
        }

    }

    private function incrementalHash()
    {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -5);
    }

    public function unsubscribeAction()
    {
        // attain list id from GET
        (!empty($_GET['id'])?$id = $_GET['id']:$id = false);
        (!empty($_GET['auth'])?$auth = $_GET['auth']:$auth = false);
        if($id != false && $auth != false) {
            $dtList = new Application_Model_DbTable_List();
            $result = $dtList->delete("`id` = $id AND `auth_code` = '$auth'");
            if($result) {
                $this->view->delCheck = "Mail address with id: $id has successfully been deleted from our database.";
            } else {
                $this->view->delCheck = "Could not find id/auth_code combo in database!";
            }
        } else {
            $this->view->delCheck = "Could not find the correct GET parameters!";
        }
    }


}











