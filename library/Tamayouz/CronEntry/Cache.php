<?php

class Tamayouz_CronEntry_Cache
{
    public static function runCron()  
    {        
        $options = XenForo_Application::get('options');
        $ThModel = XenForo_Model::create('Tamayouz_Model_Tam');
        $userModel = XenForo_Visitor::getInstance();
        $ThCanSee = $ThModel->gtPermissions();

        $Threads = $ThModel->getTopth();
        $Tusr = $ThModel->getTopuser();
        $Tmod = $ThModel->getTopmod();
 
        $tamauouz = array(
            "Threads" => $Threads,
            "Tusr" => $Tusr,
            "Tmod" => $Tmod,
            "cansee" => $ThCanSee
        );
		
		XenForo_Model::create('XenForo_Model_DataRegistry')->set('tamayouz', $tamauouz);
		$ThModel = '';
		unset($ThModel);
    }   
}