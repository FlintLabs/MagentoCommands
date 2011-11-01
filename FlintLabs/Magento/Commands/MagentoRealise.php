<?php
/*
 * Copyright Cameron Manderson (c) 2011 All rights reserved.
 * Date: 1/11/11
 */

/**
 *
 * @author camm (camm@flintinteractive.com.au)
 */
class FlintLabs_Magento_Commands_MagentoRealise extends Zend_Tool_Framework_Provider_Abstract
{
    protected function init()
    {
	    $this->respond('========================= Magento Class Realisation ==========================' . "\n");

        include 'app/Mage.php';
	    Mage::app();
    }

    public function model()
    {
	    $this->init();
        $this->respond('Model Class Realisation'  . "\n\n");
        $classResponse = $this->_registry->getClient()->promptInteractiveInput('Enter the path to resolve (e.g. catalog/product):');

        $class = Mage::getModel($classResponse->getContent());

        $this->showClass($classResponse->getContent(), $class);
    }

    public function resourceModel()
    {
        $this->init();
        $this->respond('Resource Model Class Realisation' . "\n\n");
        $classResponse = $this->_registry->getClient()->promptInteractiveInput('Enter the path to resolve (e.g. catalog/product):');

        $class = Mage::getResourceModel($classResponse->getContent());

        $this->showClass($classResponse->getContent(), $class);
    }



    public function helper()
    {
        $this->init();
        $this->respond('Helper Class Realisation' . "\n\n");
        $classResponse = $this->_registry->getClient()->promptInteractiveInput('Enter the path to resolve (e.g. sales):');

        $class = Mage::getModel($classResponse->getContent());

        $this->showClass($classResponse->getContent(), $class);

    }

    public function block()
    {
        $this->init();
        $this->respond('Block Class Realisation' . "\n\n");
        $classResponse = $this->_registry->getClient()->promptInteractiveInput('Enter the path to resolve (e.g. core/template):');

        $class = Mage::app()->getLayout()->createBlock($classResponse->getContent());

        $this->showClass($classResponse->getContent(), $class);
    }

    private function showClass($input, $obj)
    {
        if(empty($obj)) $this->respond('Could not find the class: ' . $input);
        else {
            $this->respond('Magento mapped this to: ' . "\n" . '"' . get_class($obj) . '"');
            $this->respond('Location:' . "\n" . $this->locateClass(get_class($obj)));

            if(method_exists($obj, 'debug')) {
                Zend_Debug::dump($obj->debug());
            }
        }
    }

    private function locateClass($class)
    {
        $modulePath = str_replace('_', '/', $class) . '.php';
        $paths = array('app/code/local', 'app/code/community', 'app/code/core');
        foreach($paths as $path) {
            if(file_exists(getcwd() . '/' . $path . '/' . $modulePath)) {
                return $path . '/' . $modulePath;
            }
        }
    }

    private function respond($str)
    {
        // TODO: Move to parent class
        $this->_registry->getResponse()->appendContent($str);
    }
}
