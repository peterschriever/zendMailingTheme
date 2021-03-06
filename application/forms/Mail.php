<?php

class Application_Form_Mail extends Zend_Form
{

    public function init()
    {
        $this->setName("mail");

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Naam: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $slogan = new Zend_Form_Element_Text('slogan');
        $slogan->setLabel('Slogan: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setLabel('Onderwerp: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $theme = new Application_Form_Element_ThemeSelect('theme');
        $theme->setLabel('Thema: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $newsletter = new Zend_Form_Element_Checkbox('newsletter');
        $newsletter->setLabel('Nieuwsbrief: ')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim');

        $content = new Zend_Form_Element_Textarea('message');
        $content->setLabel('Voer uw bericht hier in:')
            ->setRequired(true)
            ->setAttrib('cols','30')
            ->setAttrib('rows', '5')
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'sendMail')
            ->setAttrib('class', 'button expand');

        $this->addElements(array($name, $slogan, $subject, $theme, $content, $submit));
    }


}

