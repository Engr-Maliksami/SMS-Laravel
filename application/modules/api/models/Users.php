<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Model 
{


    function __construct() {
        parent::__construct();      
        
       // $this->load->model('../../student/Student_Model', 'student', true);            
    }

    protected $user_table = 'users';
    protected $student_table = 'students';

    /**
     * Use Registration
     * @param: {array} User Data
     */
    public function insert_user(array $data) {
        $this->db->insert($this->user_table, $data);
        return $this->db->insert_id();
    }

    /**
     * User Login
     * ----------------------------------
     * @param: username or email address
     * @param: password
     */
    public function user_login($username, $password)
    {
        $this->db->select('users.*,students.id as user_id,students.photo,students.name,students.email');
        $this->db->where('username', $username);
        $this->db->join($this->student_table, 'users.id = students.user_id');
        $q = $this->db->get($this->user_table);

        if( $q->num_rows() ) 
        {
            $user_pass = $q->row('password');
            if(md5($password) === $user_pass) {
                return $q->row();
            }
            return FALSE;
        }else{
            return FALSE;
        }
    }

    public function user_detail($id)
    {
        $this->db->select('students.*,users.username,users.last_logged_in,users.status');
        $this->db->where('users.id', $id);
        $this->db->join($this->student_table, 'users.id = students.user_id');
        $q = $this->db->get($this->user_table);

        if( $q->num_rows() ) 
        {
            return $q->row();
        }else{
            return FALSE;
        }
    }

    public function get_single_student($id,  $academic_year_id){
        
        $this->db->select('S.*,  SC.school_name, T.type, D.amount, D.title AS discount_title, SC.school_name, G.name as guardian, E.academic_year_id, E.roll_no, E.class_id, E.section_id, U.username, U.role_id, R.name AS role,  C.name AS class_name, SE.name AS section');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('roles AS R', 'R.id = U.role_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left');
        $this->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
        $this->db->join('student_types AS T', 'T.id = S.type_id', 'left');
        $this->db->where('S.id', $id);
        $this->db->where('E.academic_year_id', $academic_year_id);
        
        return $this->db->get()->row();  
        //echo $this->db->last_query();     
    }

    public function get_school_by_id($school_id){
       
        if(!$school_id){
            return array();
        }
        return $this->db->get_where('schools', array('id'=>$school_id))->row();
    }

    public function get_student_list($school_id, $class_id, $section_id, $student_id, $academic_year_id){
            
        if(!$class_id){
            return;
        }
        
        $this->db->select('S.*, SC.school_name, E.roll_no, E.class_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
        $this->db->from('enrollments AS E');
        $this->db->join('students AS S', 'S.id = E.student_id', 'left');
        $this->db->join('users AS U', 'U.id = S.user_id', 'left');
        $this->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('E.academic_year_id', $academic_year_id); 
        }
        if($class_id){
            $this->db->where('E.class_id', $class_id);
        }
            
        if($school_id){
            $this->db->where('S.school_id', $school_id); 
        } 
        $this->db->where('E.student_id', $student_id); 
        $this->db->where('E.section_id', $section_id); 
        $this->db->order_by('E.roll_no', 'ASC');
        //$this->db->get();
        
        // echo $this->db->last_query();die();
        return $this->db->get()->result();
        
    }
    public function get_schedule_list($school_id = null,$class_id,$academic_year_id = null,$exam_id ){
        
        $this->db->select('ES.*, SC.school_name, E.title, C.name AS class_name, S.name AS subject, AY.session_year');
        $this->db->from('exam_schedules AS ES');
        $this->db->join('classes AS C', 'C.id = ES.class_id', 'left');
        $this->db->join('subjects AS S', 'S.id = ES.subject_id', 'left');
        $this->db->join('exams AS E', 'E.id = ES.exam_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = ES.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = ES.school_id', 'left');
        
        if($academic_year_id){
            $this->db->where('ES.academic_year_id', $academic_year_id);
        }        
                
        if($class_id > 0){
            $this->db->where('ES.class_id', $class_id);            
        }
        if($school_id){
            $this->db->where('ES.school_id', $school_id); 
        }         
        if($exam_id){
            $this->db->where('ES.exam_id', $exam_id); 
        }
        $this->db->order_by('ES.id', 'DESC');
        return $this->db->get()->result();
        
    }

    public function get_invoice_amount($invoice_id){
        $this->db->select('I.*, SUM(T.amount) AS paid_amount');
        $this->db->from('invoices AS I');        
        $this->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $this->db->where('I.id', $invoice_id);         
        return $this->db->get()->row(); 
    }

    public function get_single_invoice($school_id,$academic_year_id,$class_id,$student_id, $invoice_id){
        
        $this->db->select('I.*,  IH.title AS head, I.discount AS inv_discount, I.id AS inv_id , S.*, AY.session_year, C.name AS class_name');
        $this->db->from('invoices AS I');        
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.student_id', 'left');
        $this->db->join('income_heads AS IH', 'IH.id = I.income_head_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->where('I.invoice_type !=', 'income');  
        $this->db->where('I.id', $invoice_id); 
        $this->db->where('I.academic_year_id', $academic_year_id);
        $this->db->where('I.class_id', $class_id);
        $this->db->where('I.student_id', $student_id);
        $this->db->where('I.school_id', $school_id);
         // $this->db->get();
         //echo $this->db->last_query();die();
        return $this->db->get()->row();        
    }
}
