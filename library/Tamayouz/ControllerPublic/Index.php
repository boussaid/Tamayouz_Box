<?php
class Tamayouz_ControllerPublic_Index extends XFCP_Tamayouz_ControllerPublic_Index {
        
    public function actionIndex()
    {
        $response = parent::actionIndex();
		if ($response instanceof XenForo_ControllerResponse_View)
                {
 
        $options = XenForo_Application::get('options');
        $pest_all_perday_onoff = $options->pest_all_perday_onoff;
         if ($pest_all_perday_onoff){

        $ThModel = XenForo_Model::create('Tamayouz_Model_Tam');
        $ThCanSee = $ThModel->gtPermissions();
        if ($ThCanSee !=""){
            //$response->params['tamz'] = array();
			$myTamayouz = XenForo_Model::create('XenForo_Model_DataRegistry')->get('tamayouz');
				$response->params += array('tamz' => $myTamayouz);
			}
        }

        }
        return $response;
    }
}