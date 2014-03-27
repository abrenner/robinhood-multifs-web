<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	/**
	 * Get Stats
	 *
	 * Gather stats from all RBH database and merge them with our DB.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-12-15
	 */
	public function getStats()
	{
	    $this->load->model('tasks');
	    $this->tasks->truncate('stats');
	    $this->load->model('configuration');
	    $dbList = $this->configuration->getDBList();
	    foreach($dbList->result() as $db)
	        $this->tasks->pullStats($db->dbGroup,$db->friendlyName);

	     $this->_updateCronStats();
	}

	/**
	 * Get Stats Hierarchically
	 *
	 * Gather stats from all RBH database and merge them with our DB.
	 * This difference in this function is, ownership and groups are 
	 * treated by on a hierarchical structure. For example:
	 *       /gl/bio/aebrenne/someFile.txt
	 * The file, someFile.txt *should* be owned by the group bio and
	 * the user aebrenne -- regardless of what the actual ownership is
	 * of someFile.txt.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-12-15
	 */
	public function getStatsHierarchical()
	{
	    $this->load->model('tasks');
	    $this->tasks->truncate('stats');
	    echo "<pre>";
	    $this->load->model('configuration');
	    $dbList = $this->configuration->getDBList();
	    foreach($dbList->result() as $db) {
	        $this->tasks->pullStatsHierarchical($db->dbGroup,$db->friendlyName);
	    }
        	$this->_updateCronStats();
	}
    
	/**
	 * Get Zot Offenders
	 *
	 * ZOT (Zillions of Tiny Files) are problematic for a cluster. The purpose
	 * of this function is to locate ZOT files and inform the user of this.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2014-02-04
	 */
	public function getZotOffenders()
	{
	    $this->load->model('cleanup','',FALSE);
	    $this->load->model('configuration');
	    $dbList = $this->configuration->getDBList();
	    foreach($dbList->result() as $db) {
	    	echo "Starting ZOT For: ".$db->friendlyName;
	    	echo "<br />";
	      	$this->cleanup->getZotFiles($db->dbGroup,$db->fullpath,$db->fsInodeNumber,$db->friendlyName);
	      	echo "<hr /><br />";
	    }

	    $this->cleanup->sendNotices("zot");
	}

	/**
	 * Get Old File Offenders
	 *
	 * Old Files are problematic for a cluster as it takes up space. The purpose
	 * of this function is to locate old files and inform the user.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2014-02-04
	 */
	public function getOldFileOffenders()
	{
	    $this->load->model('cleanup','',FALSE);
	    $this->load->model('configuration');
	    $dbList = $this->configuration->getDBList();
	    foreach($dbList->result() as $db) {
	    	//if($db == "som") {
	    	echo "Starting Old File Detection For: ".$db->friendlyName;
	    	echo "<br />";
	      	$this->cleanup->getOldFiles($db->dbGroup,$db->fullpath,$db->fsInodeNumber,$db->friendlyName);
	      	echo "<hr /><br />";
	      //}
	    }
	    //$this->cleanup->sendNotices("oldfile");
	}

	/**
	 * Update Cron Stats
	 *
	 * Updates internal records 
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-11-18
	 */
	private function _updateCronStats()
	{
	    $this->load->model('tasks');
	    $this->tasks->updateCronStats();
	}

}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */