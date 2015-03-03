<?php
class Tamayouz_Model_Tam extends XenForo_Model
{
	public function getTopth()
	{
		//$db = XenForo_Application::get('db');
        $options = XenForo_Application::get('options');
        $pest_all_perday_fourms_out = $options->pest_all_perday_fourms_out;
        $pest_all_perday_how = $options->pest_all_perday_how;
        $pest_all_theard_time = $options->pest_all_theard_time;
       
        // Forums
        if($pest_all_perday_fourms_out!=''){
        $outfourmsm="AND node_id NOT 
        IN (".$pest_all_perday_fourms_out.")";
        }
        else {$outfourmsm="";}
        // Order
        if($pest_all_perday_how ==2){
        $how_best="ORDER BY view_count DESC ";
        }
        else {$how_best="ORDER BY reply_count DESC"; }
       
        /** Best Thread*/
        return $this->_getDb()->fetchAll("SELECT * 
        FROM xf_thread 
		LEFT JOIN xf_user AS user ON (xf_thread.user_id = user.user_id)
        WHERE discussion_state ='visible'
        AND discussion_open = 1
        ".$outfourmsm ."
        AND post_date >= UNIX_TIMESTAMP() - $pest_all_theard_time  $how_best LIMIT 1 ");
    }
    
    /** Best user */
    public function getTopuser()
    {      
        $options = XenForo_Application::get('options');
        $pest_all_perday_users = $options->pest_all_perday_users;
        $pest_all_theard_time = $options->pest_all_theard_time;
        
        return $this->_getDb()->fetchAll('SELECT *, COUNT( xp.post_id ) as total 
        FROM xf_user as xu
        LEFT JOIN xf_post as xp ON (xu.user_id = xp.user_id)
        LEFT JOIN xf_user_profile as xup ON (xu.user_id = xup.user_id)
        WHERE xu.user_id = xp.user_id
        AND xu.user_group_id = ?
        AND xu.is_banned = ?
        AND xp.post_date >= UNIX_TIMESTAMP() - ?
        GROUP BY xp.user_id
        ORDER BY total DESC 
        LIMIT ? ', array($pest_all_perday_users, 0, $pest_all_theard_time, 1));
    }
    
    /** Best Staff */
    public function getTopmod()
    {
        
        $options = XenForo_Application::get('options');
        $pest_all_theard_time = $options->pest_all_theard_time;
        
        return $this->_getDb()->fetchAll('SELECT *, COUNT( xp.post_id ) as total 
        FROM xf_user as xu
        LEFT JOIN xf_post as xp ON (xu.user_id = xp.user_id)
        LEFT JOIN xf_user_profile as xup ON (xu.user_id = xup.user_id)
        WHERE xu.user_id = xp.user_id
        AND xu.is_staff = ? OR xu.is_moderator = ? OR xu.is_admin = ?
        AND xp.post_date >= UNIX_TIMESTAMP() - ?
        GROUP BY xp.user_id
        ORDER BY total DESC 
        LIMIT ? ', array(1, 1, 1, $pest_all_theard_time, 1));
    }
    
    public function gtPermissions()
    {
        return XenForo_Visitor::getInstance()->hasPermission( 'general', 'tmz_cansee' ) ? true : false;
    }
}  