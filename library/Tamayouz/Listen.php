<?php
class Tamayouz_Listen {
    
 public static function loclass($class, array &$extend)
    {
        if ($class == 'XenForo_ControllerPublic_Index')
        {
            $extend[] = 'Tamayouz_ControllerPublic_Index';
        }
    }
	
 public static function template_create($templateName, array &$params, XenForo_Template_Abstract $template){
         $options = XenForo_Application::get('options');
         $tampos = $options->tam_pos;
		 switch ($tampos)
         {
			case 10: $tmpl = 'tama_box';    break;
			case 20: $tmpl = 'tama_boxx';   break;
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
			case 10: $tamp = 'tama_box';    break;
			case 20: $tamp = 'tama_boxx';   break;
         }
         if ($hookName=='forum_list_nodes'){            
            $templ = $template->create($tamp, $template->getparams());
            $htm = $templ->render();
            $contents = $htm . $contents;
            
       }
    }
}  