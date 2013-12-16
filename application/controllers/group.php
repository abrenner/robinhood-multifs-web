<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {

	/**
	 * Group Search
	 *
	 * Search form for groups. Data processing and output is done in the
	 * private function.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
	public function index()
	{
        $this->load->model('stats');
	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"group"));
	    $this->load->view('group/index',array("last_run"=>$this->stats->getLastRunTime()));
	    $this->load->view("footer");
	}

	/**
	 * Show Results
	 *
	 * Show results based on the provided information from the callee.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-18
	 */
	public function show()
	{
	    # Input can exist from our form, or external systems via $_GET
	    # or in CI, segments. We therefor use this method for input
	    # validation.
	    $group = $this->uri->segment(2);
	    if($group == FALSE) {
	        $this->index();
	        return;
	    }
	    
	    # Returns FALSE if not set which will show the group Summary
	    $filesystem = $this->uri->segment(3);
	    
	    $this->load->model('stats');
	    $this->load->helper('number');
	    
	    $data['group']          = $group;
	    $data['filesystem']     = $filesystem;
	    $data['group_fs_list']  = $this->stats->groupFileSystemList($group);
	    $data['group_fs_usage'] = $this->stats->groupFileSystemUsage($group,$filesystem);

	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"group"));
	    $this->load->view('group/display_tabs',$data);
	    if($filesystem == FALSE)
	        $this->load->view('group/display_group',$data);
	    else
	        $this->load->view('group/display_fs',$data);
	    $this->load->view("footer");
	}
}

/* End of file group.php */
/* Location: ./application/controllers/group.php */