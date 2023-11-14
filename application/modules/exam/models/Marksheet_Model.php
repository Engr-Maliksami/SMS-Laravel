<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Marksheet_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_subject_list($school_id, $exam_id, $class_id, $section_id, $student_id,$academic_year_id)
    {
        $this->db->select('M.*,S.name AS subject, G.point, G.name');
        $this->db->from('marks AS M');        
        $this->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $this->db->join('grades AS G', 'G.id = M.grade_id', 'left');
   
        $this->db->where('M.academic_year_id', $academic_year_id); 
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.section_id', $section_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.school_id', $school_id);
   
        return $this->db->get()->result();     
    }

    public function get_exam($school_id, $exam_id, $class_id, $academic_year_id,$subject_id){
        $this->db->select('ET.name as exam_type_name,ET.id as exam_type_id, ETM.max_marks,E.title as exam, S.name AS subject');

        $this->db->from('exam_type_mapping AS ETM'); 
        $this->db->join('subjects AS S', 'S.id = ETM.subject_id', 'left');
        $this->db->join('master_exam_types AS ET', 'ET.id = ETM.exam_type_id', 'left');
        $this->db->join('exams AS E', 'E.id = ETM.exam_id', 'left');
        
        $this->db->where('E.school_id', $school_id);
        $this->db->where('ETM.exam_id', $exam_id);
        $this->db->where('S.class_id', $class_id);
        $this->db->where('E.academic_year_id', $academic_year_id);
        $this->db->where('ETM.subject_id', $subject_id);
         
        $res = $this->db->get();
   
        return $res->result();
    }
    
    public function get_marks_detail($school_id, $exam_id, $class_id, $academic_year_id,$subject_id){
        $this->db->select('MD.id');
        $this->db->from('marks AS M'); 
        $this->db->join('marks_details AS MD', 'M.id = MD.marks_id', 'left');
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.academic_year_id', $academic_year_id);
        $this->db->where('M.subject_id', $subject_id); 
        $res = $this->db->get();
   
        return $res->result();
         
    } 

    public function get_exam_details($school_id, $exam_id, $class_id, $academic_year_id,$subject_id){
        $this->db->select('MET.name as exam_type_name, M.student_id,M.subject_id,M.school_id, MD.marks_obtained,ETM.max_marks');

        $this->db->from('marks AS M'); 
        $this->db->join('marks_details AS MD', 'M.id = MD.marks_id', 'left');
        $this->db->join('master_exam_types AS MET', 'MET.id = MD.exam_type_id', 'left');
        $this->db->join('exam_type_mapping AS ETM', 'ETM.id = MD.exam_type_id', 'left');
        
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.exam_id', $exam_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.academic_year_id', $academic_year_id);
        $this->db->where('M.subject_id', $subject_id);
         
        $res = $this->db->get();
        //print_r($this->db->last_query());    die();

        return $res->result();
    }
    
    
}
