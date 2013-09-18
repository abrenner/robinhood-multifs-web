<?php
class Stats extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function user($username)
    {
        return $this->db->query('SELECT user, SUM(blocks)*512 AS blocks, SUM(count) AS count, filesystem FROM stats WHERE user = ? AND count > 1 GROUP BY filesystem', array($username));
    }
}