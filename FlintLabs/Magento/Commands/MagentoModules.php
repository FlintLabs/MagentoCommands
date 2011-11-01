<?php
/*
 * Copyright Cameron Manderson (c) 2011 All rights reserved.
 * Date: 1/11/11
 */

/**
 *
 * @author camm (camm@flintinteractive.com.au)
 */
class FlintLabs_Magento_Commands_MagentoModules extends Zend_Tool_Framework_Provider_Abstract
{
    public function show()
    {
        $files = glob('app/etc/modules/*.xml');
        $this->respond('Modules');
        foreach($files as $file) {
            $xml = new SimpleXMLElement(file_get_contents($file));
            $results = $xml->xpath('/config/modules/*');
            foreach($results as $result) {
                $active = (string)current($result->xpath('active'));

                $configFile = $this->getConfigFile($result->getName());
                $this->respond('- ' . $result->getName() . ' Active: ' . ($active == 'true' ? 'Y' : 'N') . ' Config: ' . (empty($configFile) ? 'Not found' : $configFile));
            }
        }
    }

    public function debug()
    {
        $moduleNameResponse = $this->_registry->getClient()->promptInteractiveInput('Enter module name:');
        $module = $moduleNameResponse->getContent();
        $moduleEtcConfig = getcwd() . '/app/etc/modules/' . $module . '.xml';
        if(!file_exists($moduleEtcConfig)) {
            $this->respond('Could not locate the app/etc/modules XML file (Maybe sitting inside another config?)');
            $this->respond('Create ' . $moduleEtcConfig);
        } else {
            $this->respond('Found module config in app/etc/modules: ' . $moduleEtcConfig);
        }

        $config = $this->getConfigFile($module);
        if(empty($config)) {
            $this->respond('Unable to find configuration for supplied module');
        } else {
            $this->respond('Config File exists in the module: ' . $module);
            $this->respond($config);
            $this->respond(file_get_contents($config));    
        }
    }

    private function getConfigFile($module)
    {
        $modulePath = str_replace('_', '/', $module) . '/etc/config.xml';
        $paths = array('app/code/local', 'app/code/community', 'app/code/core');
        foreach($paths as $path) {
            if(file_exists(getcwd() . '/' . $path . '/' . $modulePath)) {
                return $path . '/' . $modulePath;
            }
        }
    }

    public function moduleConfig()
    {
        // TODO
    }

    private function respond($str)
    {
        // TODO: Move to parent class
        $this->_registry->getResponse()->appendContent($str);
    }
}
