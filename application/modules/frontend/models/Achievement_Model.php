<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Achievement_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    } 
    	 public function update_achievement_section($data){
				 $this->db->where('id', 1);
				 $result = $this->db->update('achievement_section', $data);
				 return $result;
	 }
	 public function get_achievement_section($school_id){
	 $this->db->select('*');
        $this->db->from('achievement_section');
        $this->db->where('school_id', $school_id);
       return $this->db->get()->row();
   }
}
