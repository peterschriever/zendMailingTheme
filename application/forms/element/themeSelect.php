<?php

class Application_Form_Element_ThemeSelect extends Zend_Form_Element_Select {
    public function init() {
        /*$themes = new Application_Model_Themes);  // insert themes model or query db here
        $this->addMultiOption(0, 'Please select...');
        foreach ($themes->fetchAll() as $theme) {
            $this->addMultiOption($theme['id'], $theme['name']);
        }*/
    }
}