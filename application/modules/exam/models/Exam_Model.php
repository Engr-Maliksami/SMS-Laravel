<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_exam_list($school_id = null, $academic_year_id = null){
        
        $this->db->select('E.*, S.school_name, AY.session_year');
        $this->db->from('exams AS E');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');
        $this->db->join('schools AS S', 'S.id = E.school_id', 'left');
                
         
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
        }
        
        if($school_id){
            $this->db->where('E.school_id', $school_id);
        }
        
        if($academic_year_id){        
            $this->db->where('E.academic_year_id', $academic_year_id);
        }       
        $res = $this->db->get();
        //print_r($this->db->last_query());    die();

        return $res->result();
        
    }
    
     public function get_single_exam($id){
        
        $this->db->select('E.*, AY.session_year');
        $this->db->from('exams AS E');
        $this->db->join('academic_years AS AY', 'AY.id = E.academic_year_id', 'left');        
        $this->db->where('E.id', $id);
        return $this->db->get()->row();
        
    }
    
     function duplicate_check($school_id, $academic_year_id, $title, $id = null ){           
                 
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('title', $title);
        $this->db->where('academic_year_id', $academic_year_id);
                
        return $this->db->get('exams')->num_rows();            
    }
 
    public function get_all_classes(){
        
        $this->db->select('ETM.class_id');
        $this->db->from('exam_type_mapping AS ETM');
        $this->db->where('ETM.exam_id', $id);
        return $this->db->get()->row();
        
    }

    public function get_single_class_id($id){
        
        $this->db->select('ETM.class_id');
        $this->db->from('exam_type_mapping AS ETM');
        $this->db->where('ETM.exam_id', $id);
        return $this->db->get()->row();
        
    }

    function save_exam_mapping_list($exam_id,$max_marks,$exam_type_id,$subject_id,$class_id,$academic_year_id){           
                 
        
        $data['exam_id']           = $exam_id;
        $data['exam_type_id']      = $exam_type_id;
        $data['max_marks']         = $max_marks;
        $data['subject_id']        = $subject_id;
        $data['class_id']          = $class_id;
        $data['academic_year_id']  = $academic_year_id; 

        $mapping = $this->db->insert('exam_type_mapping', $data);
       
        return $mapping;            
    }

    function get_running_academic_id($school_id){
        $this->db->select('A.id');
        $this->db->from('academic_years AS A');
        $this->db->where('A.school_id', $school_id);
        $this->db->where('A.is_running', '1');
        //$this->db->where('A.status', '1');
        //$res = $this->db->get();
        //print_r($this->db->last_query());    die();
        return $this->db->get()->row();
    }

        

}
