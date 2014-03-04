<?php
class Stats extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /**
	 * Last Run Time
	 *
	 * Return the last time the cronjob was ran.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-12-15
	 */
    function getLastRunTime()
    {
        $value = "Never!";
        $this->db->select('value');
        $query = $this->db->get_where('info',array('key'=>"lastRun"));
        // Produces SELECT value FROM info WHERE key = lastRun;
        
        if($query->num_rows() == 1) {
            $this->load->helper('date');
            $value = timespan($query->row()->value,time()) . " ago";
        }
        
        return $value;
    }
    
    /**
	 * User Stats
	 *
	 * Query for user specific stats across all filesystems.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-17
	 */
    function user($username)
    {
        # Some queries do not translate nicely to active records
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) AS count, stats.filesystem, config.label, config.description FROM `stats` LEFT JOIN config ON config.friendlyName = stats.filesystem WHERE user = ? AND count > 1 GROUP BY filesystem', array($username));
    }

    /**
	 * Group FileSystem List
	 *
	 * Generate a list of all filesystem(s) that the group has data on.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
    function groupFileSystemList($groupname)
    {
        $this->db->select('filesystem')->from('stats')->where('grp',$groupname)->group_by('filesystem');
        return $this->db->get();
    }

    /**
	 * Group FileSystem List
	 *
	 * Generate a list of all filesystem(s) that the group has data on.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
    function groupFileSystemUsage($groupname,$filesystem)
    {
        # Get Group Summary Instead
        if($filesystem == FALSE)
            return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) AS count, stats.filesystem, config.label, config.description FROM `stats` LEFT JOIN config ON config.friendlyName = stats.filesystem WHERE `grp` = ? GROUP BY filesystem ORDER BY blocks DESC',array($groupname));
        
        # Get Group and User Information on a Specific Filesystem
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, count, filesystem FROM `stats` WHERE filesystem = ? AND `grp` = ? GROUP BY user ORDER BY blocks DESC',array("/$filesystem",$groupname));
    }
    
    /**
	 * FileSystem List
	 *
	 * Generate a list of all filesystem(s).
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
    function fileSystemList()
    {
        $this->db->select('filesystem')->from('stats')->distinct();
        return $this->db->get();
    }

    /**
	 * FileSystem List
	 *
	 * Generate a list of all filesystem(s) that has data on.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
    function fileSystemUsage($filesystem)
    {
        # Get FileSystem Summary Instead
        if($filesystem == FALSE)
            //return $this->db->query('SELECT SUM(blocks)*512 AS blocks, SUM(count) AS count, stats.filesystem, label, description FROM stats, fsDescriptions WHERE fsDescriptions.filesystem = stats.filesystem GROUP BY filesystem ORDER BY blocks DESC');
            return $this->db->query('SELECT SUM(blocks)*512 AS blocks, SUM(count) AS count, stats.filesystem, config.label, config.description FROM `stats` LEFT JOIN config ON config.friendlyName = stats.filesystem GROUP BY filesystem ORDER BY blocks DESC');
        
        # Get User Information on a Specific Filesystem
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) as count, filesystem FROM `stats` WHERE filesystem = ? GROUP BY user ORDER BY blocks DESC',array("/$filesystem"));
    }
}