<?php
class Usage extends CI_Model {


    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
	 * Get Old File Reports
	 *
	 * Returns a list of old files for a given user and timestamp
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2014-03-06
	 */
    function getOldFileReports(&$user, &$timestamp)
    {
        return $this->db->query("SELECT user, last_mod, filesystem, value, `path` FROM offenders WHERE `timestamp` = ? AND user = ? AND noticeType = 'oldfile' ORDER BY value DESC",array($timestamp,$user));

    }
    
    
}