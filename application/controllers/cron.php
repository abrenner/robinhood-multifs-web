<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	/**
	 * Get Stats
	 *
	 * Gather stats from all RBH database and merge them with our DB.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-19
	 */
	public function getStats()
	{
	    $this->load->model('tasks');
	    foreach($this->config->item('db_list') as $db)
	        $this->tasks->pullStats($db);
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
	 * @version     2013-09-24
	 */
	public function getStatsHierarchical()
	{
	    $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;
	    echo "<pre>";
	    $this->load->model('tasks');
	    $this->tasks->truncate('usage');
	    foreach($this->config->item('db_list') as $db) {
	        //$db = "w1";
	        $this->tasks->pullStatsHierarchical($db);
	    }
	    echo "</pre>";
	    $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);
        echo 'Page generated in '.$total_time.' seconds.';
	}

}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */