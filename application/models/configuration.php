<?php
class Configuration extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->_sts = $this->load->database("default", TRUE);
    }
    
    /**
	 * Get DB List
	 *
	 * Get  a list of all DBs and the FS assoicated with them.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2014-03-04
	 */
    function getDBList()
    {
        return $this->_sts->query("SELECT * FROM config");
    }
    
}