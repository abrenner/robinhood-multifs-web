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
	    
	    /*
	    $data['filesystem']  = $filesystem;
	    $data['fs_list']     = $this->stats->fileSystemList();
	    $data['fs_usage']    = $this->stats->fileSystemUsage($filesystem);
	    
	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"filesystem"));
	    $this->load->view('filesystem/display_tabs',$data);
        if($filesystem == FALSE)
	        $this->load->view('filesystem/display',$data);
	    else
	        $this->load->view('filesystem/display_fs',$data);
	    $this->load->view("footer");
	    */
	}
}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */