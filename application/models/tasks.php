<?php
class Tasks extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    /**
	 * Pull Stats
	 *
	 * Copies and Merges the stats table from RBH database.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-20
	 */
    function pullStats($db_group_name)
    {
       $rbh = $this->load->database($db_group_name, TRUE);
       $sts = $this->load->database("default", TRUE);
       
       // SELECT * FROM ACCT_STAT;       
       foreach($rbh->get('ACCT_STAT')->result() as $row) {
           unset($escape);
           $escape[] = $row->owner;
           $escape[] = $row->gr_name;
           $escape[] = $row->type;
           $escape[] = $row->size;
           $escape[] = $row->blocks;
           $escape[] = $row->count;
           $escape[] = "/$db_group_name";
           $escape[] = $row->sz0;
           $escape[] = $row->sz1;
           $escape[] = $row->sz32;
           $escape[] = $row->sz1K;
           $escape[] = $row->sz32K;
           $escape[] = $row->sz1M;
           $escape[] = $row->sz32M;
           $escape[] = $row->sz1G;
           $escape[] = $row->sz32G;
           $escape[] = $row->sz1T;
           $escape[] = $row->size;
           $escape[] = $row->blocks;
           $escape[] = $row->count;
           $escape[] = $row->sz0;
           $escape[] = $row->sz1;
           $escape[] = $row->sz32;
           $escape[] = $row->sz1K;
           $escape[] = $row->sz32K;
           $escape[] = $row->sz1M;
           $escape[] = $row->sz32M;
           $escape[] = $row->sz1G;
           $escape[] = $row->sz32G;
           $escape[] = $row->sz1T;
           
           echo "<pre>";
           print_r($escape);
           echo "</pre>";
           // 10
           // No AR record exists for ON DUPLICATE (yet).
           $sts->query('INSERT INTO stats (user, grp, type, size, blocks, count, filesystem, size0, size1, size32, size1K, size32K, size1M, size32M, size1G, size32G, size1T) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE size = ?, blocks = ?, count = ?, size0 = ?, size1 = ?, size32 = ?, size1K = ?, size32K = ?, size1M = ?, size32M = ?, size1G = ?, size32G = ?, size1T = ?',$escape);
       }
       
    }
}