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

    /**
	 * Truncate Table
	 *
	 * Truncate a given table.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-27
	 */
    function truncate($table)
    {
        // The purpose of this is to avoid setting timestamps per record. In the event where
        // a user is deleted, those user stats should be deleted. Truncate will take care of
        // this.
        $this->db->truncate($table);
    }

    /**
	 * Pull Stats Hierarchical
	 *
	 * Copies and Merges the stats table from RBH database via the
	 * hierarchical structure.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-24
	 */
    function pullStatsHierarchical($db_group_name)
    {
       $rbh = $this->load->database($db_group_name, TRUE);
       $sts = $this->load->database("default", TRUE);
       
       // get array of groups
       // sql query for top level dirs
       // use two vars: usr, grp; assigned correct value, array or top level dirs
       // grab / query stats for them -- via LIKE
       
       $groups   = $this->_getGroups($db_group_name); // array - groups table
       print_r($groups);
       echo "<hr />";
       
       $this->_doHierarchicalStats($db_group_name, $groups, $groups['filesystem']['fullpath']);
    }

    /**
	 * Perform Hierarchical Stats
	 *
	 * Given a filesystem and database, perform the Hierarchical stats
	 * and record to database.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-25
	 */
    private function _doHierarchicalStats($db_group_name,$groups,$fullpath)
    {
       
       $topLevel = $this->_topLevel($db_group_name,$fullpath);
       print_r($topLevel);
       foreach($topLevel as $key => $value) {
           $real_group = $groups['filesystem']['grp'];
           $real_user  = $value['user'];
           
           if(array_key_exists($value['fullpath'], $groups)) {
               // The case where we need to remap the user and group
               // of the directory because it can not be picked up by
               // the fullpath.
               if(!$groups[$value['fullpath']]['ignoreHrchy'] && !$groups[$value['fullpath']]['calcTopLevel']) {
                   $real_group = $groups[$value['fullpath']]['grp'];
                   $real_user  = $groups[$value['fullpath']]['user'];
                   echo "REMAP:\t $real_group && $real_user\n";
               } else if ($groups[$value['fullpath']]['ignoreHrchy']) {
                   $result = $this->_ignoreHrchy($db_group_name,$real_group,$value['fullpath']);
                   //print_r($result->result_array());
                   $this->_insertHrchy($db_group_name,$result->result_array());
                   echo "IGNORE HIERARCHY:\t ".$value['fullpath']."\n";
                   echo "<hr />";
                   continue;
               } else if ($groups[$value['fullpath']]['calcTopLevel']) {
                   echo "CALC TOPLEVEL:\t ".$value['fullpath']."\n";
                   $this->_doHierarchicalStats($db_group_name,$groups,$value['fullpath']);
                   echo "<hr />";
                   continue;
               }
           }
           
           $result = $this->_hrchyStats($db_group_name,$value['fullpath'],$real_user,$real_group);
           //print_r($result->result_array());
           $this->_insertHrchy($db_group_name,$result->result_array());
           echo "CASE:\t ".$value['fullpath']." -- DBUSR: ".$value['user']." -- REALUSER: $real_user\n";
           
       }
    }

    /**
	 * Get FileSystem Groups
	 *
	 * Given a filesystem, get all groups.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-24
	 */
    private function _getGroups($db_group_name)
    {
       $sts = $this->load->database("default", TRUE);
       $result = array();
       foreach($sts->get_where('groups', array('filesystem' => "/$db_group_name"))->result() as $row) {
           if($row->type == "filesystem") {
               $result['filesystem']['type']       = $row->type;
               $result['filesystem']['grp']        = $row->grp;
               $result['filesystem']['user']       = $row->user;
               $result['filesystem']['filesystem'] = $row->filesystem;
               $result['filesystem']['fullpath']   = $row->fullpath;
               $result['filesystem']['calcTopLevel'] = $row->calcTopLevel;
               continue;
           }
           $result["$row->fullpath"]['type']       = $row->type;
           $result["$row->fullpath"]['grp']        = $row->grp;
           $result["$row->fullpath"]['user']       = $row->user;
           $result["$row->fullpath"]['filesystem'] = $row->filesystem;
           $result["$row->fullpath"]['fullpath']   = $row->fullpath;
           $result["$row->fullpath"]['ignoreHrchy']  = $row->ignoreHrchy;
           $result["$row->fullpath"]['calcTopLevel'] = $row->calcTopLevel;
       }

       return $result;
    }

    /**
	 * Top Level Folders
	 *
	 * Given a filesystem, get all top level folders.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-24
	 */
    private function _topLevel($db_group_name,$parent)
    {
       $result = array();
       $rbh = $this->load->database($db_group_name, TRUE);
       foreach($rbh->query("SELECT usr.id, usr.fullpath AS fullpath FROM ENTRIES AS grp LEFT JOIN ENTRIES AS usr ON usr.parent_id = grp.id WHERE grp.fullpath = ?",array($parent))->result() as $row) {
           $result["$row->id"]["fullpath"] = $row->fullpath;
           $result["$row->id"]["user"]     = end(explode("/", $row->fullpath));
       }
       
       return $result;
    }

    /**
	 * Ignore Hierarchy
	 *
	 * Given a fullpath, ignore the hierarchy system and assume
	 * ownership is correct by filesystem scan.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-25
	 */
    private function _ignoreHrchy($db_group_name,$group,$fullpath)
    {
       $rbh = $this->load->database($db_group_name, TRUE);
       return $rbh->query("SELECT owner AS user, ? AS `group`, SUM(blocks) AS blocks, SUM(size) AS size, COUNT(id) AS count, `type` FROM ENTRIES WHERE fullpath LIKE ? GROUP BY `type`, owner",array($group,"$fullpath%"));
    }

    /**
	 * Hierarchy Stats
	 *
	 * Given a fullpath, get the stats of the hierarchy
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-25
	 */
    private function _hrchyStats($db_group_name,$fullpath,$user,$group)
    {
       $rbh = $this->load->database($db_group_name, TRUE);
       return $rbh->query("SELECT ? AS user, ? AS `group`, SUM(blocks) AS blocks, SUM(size) AS size, COUNT(id) AS count, `type` FROM ENTRIES WHERE fullpath LIKE ? GROUP BY `type`",array($user, $group, "$fullpath/%"));
    }

    /**
	 * Insert Hierarchy
	 *
	 * Insert function for the hierarchy stats from RBH.
	 *
	 * @author      Adam Brenner <aebrenne@uci.edu>
	 * @version     2013-09-25
	 */
    private function _insertHrchy($db_group_name,$data)
    {
       $sts = $this->load->database("default", TRUE);
       
       foreach($data as $row) {
           $query_result = $sts->get_where('usage',array('filesystem' => "/$db_group_name", 'user' => $row['user'], 'group' => $row['group'], 'type' => $row['type']));

           if($query_result->num_rows() == 1) {
               $query_result = $query_result->row();
               $size = $query_result->size + $row['size'];
               $blocks = $query_result->blocks + $row['blocks'];
               $count = $query_result->count + $row['count'];

               $result = array("size" => $size,"blocks" => $blocks, "count" => $count);
               $sts->where('filesystem',"/$db_group_name");
               $sts->where('user',$row['user']);
               $sts->where('group',$row['group']);
               $sts->where('type',$row['type']);
               $sts->update('usage',$result);
               echo "---- \t UPDATE RAN --- \t\n";
               
           } else {
               $result = array("user" => $row['user'], "group" => $row['group'], "type" => $row['type'], "size" => $row['size'], "blocks" => $row['blocks'], "count" => $row['count'], "filesystem" => "/$db_group_name");
               $sts->insert('usage',$result);
               echo " ---- \t INSERT RAN --- \t\n";
           }
       }
       
    }

}