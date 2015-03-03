<?php
class Tamayouz_Listen {
    
 public static function loclass($class, array &$extend)
    {        
            $extend[] = 'Tamayouz_ControllerPublic_Index';
    }
	
 public static function template_create($templateName, array &$params, XenForo_Template_Abstract $template){
         $options = XenForo_Application::get('options');
         $tampos = $options->tam_pos;
		 switch ($tampos)
         {
			case 10: $tmpl = 'bestA';    break;
			case 20: $tmpl = 'bestB';   break;
			case 25: $tmpl = 'bestC';   break;
         }
			if ($templateName == 'forum_list'){
            $template->preloadTemplate($tmpl);
        }
    }
 
 public static function template_tamayouz($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
    {
        $options = XenForo_Application::get('options');
         $tampos = $options->tam_pos;
		 switch ($tampos)
         {
			case 10: $tamp = 'bestA';    break;
			case 20: $tamp = 'bestB';   break;
			case 25: $tamp = 'bestC';   break;
         }
         if ($hookName=='forum_list_nodes'){            
            $templ = $template->create($tamp, $template->getparams());
            $htm = $templ->render();
            $contents = $htm . $contents;
            
       }
    }
}  