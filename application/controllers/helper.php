<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Helper extends CI_Controller {

	/**
	 * Query String to Segment URI
	 *
	 * To achieve segment URI's but accept $_GET forms without the
	 * need for javascript, we will manual convert GET elements into
	 * URI segments and then redirect the user with the correct page.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-17
	 */
	public function queryToSegement()
	{
	    $segment = $this->input->post("url");
	    foreach($this->input->post() as $key => $value) {
	        if($key == "url")
	            continue;
	        $segment = "$segment/$value/";
	    }
	    
	    redirect($segment,'location');
	}

}

/* End of file helper.php */
/* Location: ./application/controllers/helper.php */