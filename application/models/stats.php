<?php
class Stats extends CI_Model {

    function __construct()
    {
        parent::__construct();
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
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) AS count, usage.filesystem, fsDescriptions.label, fsDescriptions.description FROM `usage` LEFT JOIN fsDescriptions ON fsDescriptions.filesystem = usage.filesystem WHERE user = ? AND count > 1 GROUP BY filesystem', array($username));
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
        $this->db->select('filesystem')->from('usage')->where('group',$groupname)->group_by('filesystem');
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
            return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) AS count, usage.filesystem, fsDescriptions.label, fsDescriptions.description FROM `usage` LEFT JOIN fsDescriptions ON fsDescriptions.filesystem = usage.filesystem WHERE `group` = ? GROUP BY filesystem ORDER BY blocks DESC',array($groupname));
        
        # Get Group and User Information on a Specific Filesystem
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, count, filesystem FROM `usage` WHERE filesystem = ? AND `group` = ? GROUP BY user ORDER BY blocks DESC',array("/$filesystem",$groupname));
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
        $this->db->select('filesystem')->from('usage')->distinct();
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
            return $this->db->query('SELECT SUM(blocks)*512 AS blocks, SUM(count) AS count, usage.filesystem, label, description FROM `usage` LEFT JOIN fsDescriptions ON fsDescriptions.filesystem = usage.filesystem GROUP BY filesystem ORDER BY blocks DESC');
        
        # Get User Information on a Specific Filesystem
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, count, filesystem FROM `usage` WHERE filesystem = ? GROUP BY user ORDER BY blocks DESC',array("/$filesystem"));
    }
}