<?php
class Tamayouz_Model_tam extends XenForo_Model
{
	public function getTopth()
	{
		//$db = XenForo_Application::get('db');
        $options = XenForo_Application::get('options');
        $pest_all_perday_fourms_out = $options->pest_all_perday_fourms_out;
        $pest_all_perday_how = $options->pest_all_perday_how;
        $pest_all_theard_time = $options->pest_all_theard_time;
       
        // الأقسام المستثناة
        if($pest_all_perday_fourms_out!=''){
        $outfourmsm="AND `node_id` NOT 
        IN (".$pest_all_perday_fourms_out.")";
        }
        else {$outfourmsm="";}
        // طريقة الفرز
        if($pest_all_perday_how ==2){
        $how_best="ORDER BY `xf_thread`.`view_count` DESC ";
        }
        else {$how_best="ORDER BY `xf_thread`.`reply_count` DESC  "; }
       
        // الاستعلام عن الموضوع المميز
        return $this->_getDb()->fetchAll("SELECT * 
        FROM xf_thread 
		LEFT JOIN xf_user AS user ON (xf_thread.user_id = user.user_id)
        WHERE discussion_state ='visible'
        AND discussion_open ='1' ".
        $outfourmsm ."
        AND post_date >= UNIX_TIMESTAMP() - $pest_all_theard_time  $how_best LIMIT 1 ");
    }
    
    public function getTopuser()
    {
        
        $options = XenForo_Application::get('options');
        $pest_all_perday_users = $options->pest_all_perday_users;
        $pest_all_theard_time = $options->pest_all_theard_time;
        $db = XenForo_Application::get('db');
        $userModel = new Xenforo_Model_User;
        // الاستعلام عن العضو
        return $this->_getDb()->fetchAll("SELECT *, COUNT( xp.post_id ) AS total 
FROM xf_user AS xu, xf_post AS xp, xf_user_group AS xg
WHERE xu.user_id = xp.user_id
AND xg.user_group_id= '" .$pest_all_perday_users."' AND xu.user_group_id = '" .$pest_all_perday_users."'
AND xu.is_banned ='0'
AND xp.post_date >= UNIX_TIMESTAMP() - $pest_all_theard_time
GROUP BY xp.user_id
ORDER BY total DESC 
LIMIT 1 ");
    }
    
    public function getTopmod()
    {
        
        $options = XenForo_Application::get('options');
        $pest_all_perday_modman = $options->pest_all_perday_modman;
        $pest_all_theard_time = $options->pest_all_theard_time;
        
        return $this->_getDb()->fetchAll("SELECT *, COUNT( * ) AS total 
FROM xf_user AS xf_user, xf_post AS xf_post, xf_user_group AS xf_user_group
WHERE xf_user.user_id = xf_post.user_id
AND xf_user_group.user_group_id='" .$pest_all_perday_modman."' AND `xf_user`.`user_group_id`='" .$pest_all_perday_modman."'
AND xf_post.post_date >= UNIX_TIMESTAMP() - $pest_all_theard_time
GROUP BY xf_post.user_id
ORDER BY total DESC 
LIMIT 1 ");
    }
    
    public function gtPermissions()
    {
        return XenForo_Visitor::getInstance()->hasPermission( 'general', 'tmz_cansee' ) ? true : false;
    }
}  