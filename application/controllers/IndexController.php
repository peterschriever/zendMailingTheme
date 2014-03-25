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
    }

    public function newMailAction()
    {
        /*$form = new Application_Form_Content();
        $form->submit->setLabel('Toevoegen');
        $this->view->form = $form;
        if($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData)) {
                $title = $form->getValue('title');
                $content = $form->getValue('content');
                $created = $form->getValue('created');
                $updated = $form->getValue('updated');

                $courses = new Application_Model_dbTable_Content();
                $courses->addContent($title, $content, $created, $updated);
                $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }*/
        $form = new Application_Form_Mail();
        //$this->view->form

    }


}



