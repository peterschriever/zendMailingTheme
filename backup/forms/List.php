<?php

class Application_Form_List extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setName("list");

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Naam: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mailadres: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add new subscriber')
            ->setAttrib('id', 'list')
            ->setAttrib('class', 'button expand');

        $this->addElements(array($name, $email, $submit));
    }


}

