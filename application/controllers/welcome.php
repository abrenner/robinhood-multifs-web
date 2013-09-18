<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Welcome / Index Page
	 *
	 * First page users access when visiting the application.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-17
	 */
	public function index()
	{
	    $this->load->view("header");
	    $this->load->view("menu",array("nav_active"=>"home"));
		$this->load->view('welcome/index');
		$this->load->view("footer");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */