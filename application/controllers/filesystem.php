<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filesystem extends CI_Controller {

	/**
	 * Filesystem Search
	 *
	 * Display summary and specific usage for each filesystem.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
	public function index()
	{
	    # Returns FALSE if not set which will show the fs Summary
	    $filesystem = $this->uri->segment(2);
	    
	    $this->load->model('stats');
	    $this->load->helper('number');
	    
	    $data['filesystem']  = $filesystem;
	    $data['fs_list']     = $this->stats->fileSystemList();
	    $data['fs_usage']    = $this->stats->fileSystemUsage($filesystem);
        	    $data['last_run']    = $this->stats->getLastRunTime();
        	    //$data['fs_config'] = $this->config->item('fs_list');
	    
	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"filesystem"));
	    $this->load->view('filesystem/display_tabs',$data);
        if($filesystem == FALSE)
	        $this->load->view('filesystem/display',$data);
	    else
	        $this->load->view('filesystem/display_fs',$data);
	    $this->load->view("footer");
	}
}

/* End of file filesystem.php */
/* Location: ./application/controllers/filesystem.php */