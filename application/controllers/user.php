<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * User Search
	 *
	 * Search form for users. Data processing and output is done in the
	 * private function.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-17
	 */
	public function index()
	{
        $this->load->model('stats');
	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"user"));
	    $this->load->view('user/index',array("last_run"=>$this->stats->getLastRunTime()));
	    $this->load->view("footer");
	}

	/**
	 * Show Results
	 *
	 * Show results based on the provided information from the callee.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-17
	 */
	public function show()
	{
	    # Input can exist from our form, or external systems via $_GET
	    # or in CI, segments. We therefor use this method for input
	    # validation.
	    $user = $this->uri->segment(2);
	    if($user == FALSE) {
	        $this->index();
	        return;
	    }
	    
	    $this->load->model('stats');
	    $this->load->helper('number');

	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"user"));
	    $this->load->view('user/display',array("user_info"=>$this->stats->user($user),"user"=>$user));
	    $this->load->view("footer");
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */