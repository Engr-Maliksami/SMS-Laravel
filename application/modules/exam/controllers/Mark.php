<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Mark.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Mark
 * @description     : Manage exam mark for student whose are attend in the exam.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Academic_year_missing extends Exception {};


class Mark extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mark_Model', 'mark', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam Mark List" user interface                 
    *                    with filter option  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');

            $school = $this->mark->get_school_by_id($school_id);
            $academic_year_id = $school->academic_year_id;
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/mark');
            }
            
            $this->data['students'] = $this->mark->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id, $school->academic_year_id);
           //echo '<pre>';print_r($this->data['students']);

            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            $this->data['exam_types'] = $this->mark->get_exam($school_id, $exam_id, $class_id, $academic_year_id,$subject_id);
            //echo '<pre>';print_r($this->data['exam_types']);die();

            $this->data['marks_details'] = $this->mark->get_marks_detail($school_id, $exam_id, $class_id, $academic_year_id,$subject_id);
            // echo '<pre>';print_r($this->data['marks_details']);die();


            if (!empty($this->data['students'])) {
                $this->data['marks_obtained'] = array(); 
                $i=0;
                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->student_id;
                    $mark = $this->mark->get_single('marks', $condition);
                    $this->data['marks_obtained'][$i] = $mark->obtain_total_mark;
                    if (empty($mark)) {
                        
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->student_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->mark->insert('marks', $data);
                        $insert_id = $this->db->insert_id();

                        foreach ($this->data['exam_types'] as $exam) {
                            $marks_data['exam_type_id']= $exam->exam_type_id;
                            $marks_data['marks_id']= $insert_id;
                            $marks_data['marks_obtained']= '0';
                            $this->mark->insert('marks_details', $marks_data);
                        }
                    }
                    
                    $i++;
                }
            }

            $this->data['grades'] = $this->mark->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['subject_id'] = $subject_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
                        
            $class = $this->mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam mark for class: '. $class->name);
            $total = 0;
            foreach ($this->data['exam_types'] as $key=>$exam) {
                 
                $total += $exam->max_marks;
            }
             $this->data['total'] = $total;
             //echo '<pre>';print_r($this->data);die();
        }
        
        
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school = $this->mark->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }  
        
        $this->data['exam_details'] = $this->mark->get_exam_details($school_id, $exam_id, $class_id, $academic_year_id,$subject_id);
     
        $exam_details = $this->data['exam_details']; 
        // echo '<pre>';print_r($exam_details); die(); 
	
                    $j=0;
                    $j_next=0;
                    $marks=array();
                    $total_obtain = 0;
			        for ($i=0 ; $i<count($exam_details); $i++) {   
                        if($j==$j_next){
                            $total_obtain = $exam_details[$i]->marks_obtained; 
                            $j_next = $j+1;
                        }                    
                        
                        $marks[$exam_details[$i]->student_id]=$total_obtain;
                       
			            if($exam_details[$i]->student_id == $exam_details[$i+1]->student_id)
			                { 
                                $total_obtain += $exam_details[$i+1]->marks_obtained;
			                }else{
                                $j++;
                                $total_obtain = 0;
                            }

                            
			                
                    }
                   // echo '<pre>';print_r($marks);die(); 
                    
                    
                    $this->data['marks'] = $marks;
                    //echo '<pre>';print_r($marks);die();
			       
        $this->layout->title($this->lang->line('manage_mark') . ' | ' . SMS);
        $this->layout->view('mark/index', $this->data);
    }



 

public function bulk() {

    check_permission(VIEW);

    if ($_POST) {
 
        $school_id = $this->input->post('school_id');

        $exam_id = $this->input->post('exam_id');

        $class_id = $this->input->post('class_id');

        $section_id = $this->input->post('section_id');

        $subject_id = $this->input->post('subject_id');

        $school = $this->mark->get_school_by_id($school_id);

        $this->data['exam_type'] = $this->mark->get_exam($school_id,$exam_id,$class_id,$school->academic_year_id,$subject_id);

        //echo '<pre>'; print_r($this->data['exam_type']); die;

        

        if(!$school->academic_year_id){

            error($this->lang->line('set_academic_year_for_school'));

            redirect('exam/mark');

        }

        

        $this->data['students'] = $this->mark->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id, $school->academic_year_id);

        $condition = array(

            'school_id' => $school_id,

            'exam_id' => $exam_id,

            'class_id' => $class_id,

            'academic_year_id' => $school->academic_year_id,

            'subject_id' => $subject_id

        );

        

        if($section_id){

            $condition['section_id'] = $section_id;

        }

        $data = $condition;

        

        if (!empty($this->data['students'])) {

            foreach ($this->data['students'] as $obj) {

                $condition['student_id'] = $obj->student_id;

                $mark = $this->mark->get_single('marks', $condition);

                // if (empty($mark)) {

                    

                //     $data['section_id'] = $obj->section_id;

                //     $data['student_id'] = $obj->student_id;

                //     $data['status'] = 1;

                //     $data['created_at'] = date('Y-m-d H:i:s');

                //     $data['created_by'] = logged_in_user_id();

                //     $this->mark->insert('marks', $data);

                // }

            }

        }

        $this->data['grades'] = $this->mark->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');

        

        $this->data['school_id'] = $school_id;

        $this->data['exam_id'] = $exam_id;

        $this->data['class_id'] = $class_id;

        $this->data['section_id'] = $section_id;

        $this->data['subject_id'] = $subject_id;

        $this->data['academic_year_id'] = $school->academic_year_id;

                    

        $class = $this->mark->get_single('classes', array('id'=>$class_id));

        create_log('Has been process exam mark for class: '. $class->name);

        

    }

    

    

    $condition = array();

    $condition['status'] = 1;  

    

    if($this->session->userdata('role_id') != SUPER_ADMIN){

        $school = $this->mark->get_school_by_id($this->session->userdata('school_id'));

        $condition['school_id'] = $this->session->userdata('school_id');

        $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');

        $condition['academic_year_id'] = $school->academic_year_id;

        $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');

    }  

    //echo '<pre>'; print_r($this->data); die;

    $this->layout->title($this->lang->line('manage_mark') . ' | ' . SMS);

    $this->layout->view('exam/mark/bulk', $this->data);

}






    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Process to store "Exam Mark" into database                
    *                     
    * @param           : null
    * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            //echo '<pre>';print_r($_POST);die(); 
            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');

            $school = $this->mark->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/mark');
            }
            
            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }            

            $data = $condition;
            
            if (!empty($_POST['students'])) {
                $i=0;
                foreach ($_POST['students'] as $key => $value) {

                    $condition['student_id'] = $value;
                    
                    $data['exam_total_mark'] = $_POST['exam_total_mark'][$value];
                    $data['obtain_total_mark'] = $_POST['obtain_total_mark'][$value];
                    
                    $data['grade_id'] = $_POST['grade_id'][$value];                    
                    $data['remark'] = $_POST['remark'][$value];
                    
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    $this->mark->update('marks', $data, $condition);

                   
                    foreach ($_POST['exam'] as $key2 => $val) {
                        $exam_type_all['exam_type_id'] =  $_POST['exam_type_id'][$key2];
                        $exam_type_all['marks_id'] =  $_POST['marks_id'][$key];
                        $exam_type_all[ 'marks_obtained'] =  $_POST[$val][$value];
                        $marks_id_condition['id'] = $_POST['marks_details'][$i];        
                        
                        $this->mark->update('marks_details', $exam_type_all,$marks_id_condition);
                        $i++; 
                  }

                   
                } 
            }
            
            $class = $this->mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam mark and save for class: '. $class->name);
            
            success($this->lang->line('insert_success'));
            redirect('exam/mark');
        }

        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('mark') . ' | ' . SMS);
        $this->layout->view('mark/index', $this->data);
    }

    //adding bulk marks
    public function bulk_add() {        
        check_permission(ADD);
        if ($_POST) {
            $status = $this->_get_posted_student_data();
            if ($status['status']) {                
                create_log('Has been added Bulk Marks');
                success($this->lang->line('insert_success'));
                $this->session->set_userdata('errors',$status['error_message']);
                redirect('exam/mark/bulk');
            } else {
                error($this->lang->line('insert_failed'));
                redirect('exam/mark/bulk/');
            }
        }        if($this->session->userdata('role_id') != SUPER_ADMIN){
             $school_id = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }else{
            $this->data['classes'] = array();
        }        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('student') . ' | ' . SMS);
        $this->layout->view('bulk', $this->data);
    }
    
    
    /*****************Function _get_posted_student_data**********************************
    * @type            : Function
    * @function name   : _get_posted_student_data
    * @description     : Prepare "Student" user input data to save into database
    *
    * @param           : null
    * @return          : $data array(); value
    * ********************************************************** */
    private function _get_posted_student_data() {        
        $this->_upload_file();        
        $destination = 'assets/csv/bulk_uploaded_marks.csv';	
        if (($handle = fopen($destination, "r")) !== FALSE) {            
            $school_id  = $this->input->post('final_school_id');
            $exam_id  = $this->input->post('final_exam_id');            
            $class_id  = $this->input->post('final_class_id');            
            $subject_id  = $this->input->post('final_subject_id');            
            $section_id  = $this->input->post('final_section_id');            
            $school = $this->mark->get_school_by_id($school_id);            
            if(!$school->academic_year_id){	
                error($this->lang->line('set_academic_year_for_school'));	
                redirect('exam/mark/bulk');	
            }            
            
            $handle_count = fgetcsv($handle);
            $error_message = array();	
            $q=0;            
            while (($arr = fgetcsv($handle)) !== false) {                
                $marks = $arr;	
                $roll_no = $arr[0];	
                $student_name = $arr[1];                
                //check if data is empty	
                foreach($arr as $data_check){
                    if( $data_check == '' )	{	
                     $empty_check = 1;	
                     $error_message[$q] = 'Empty field for the Student with name - '.$arr[1].' and roll number - '.$arr[0];	
                     $q++;                     
                     break;	
                    }	
                    else	
                    {	
                        $empty_check = 0;	
                        continue;	
                    }	
                }                
                
                if($empty_check == 1)	
                {	
                    continue;	
                }                
                //check if student exists or not	
                $student_check = $this->mark->get_student_by_roll($school_id, $exam_id, $class_id, $section_id, $subject_id, $school->academic_year_id, $roll_no,$student_name);            if(!$student_check){	
                    $error_message[$q] = 'Student does not exists with name - '.$arr[1].' and roll number - '.$arr[0];	
                    $q++;                    
                    continue;	
                }                
                
                $count = 0;	
                $exam_type = array();	
                $marks_obtained = array();                
                for($j=2;$j<count($handle_count);$j++){                  
                  $name[$count] = explode("*",$handle_count[$j]);	
                  $name[$count] = explode("_",$name[$count][1]);	
                  $marks_obtained[$count] = $marks[$j];                  
                  
                  $this->db->select('id,name');	
                  $this->db->from('master_exam_types');	
                  $this->db->where('name',$name[$count][0]);	
                  $exam_type[$count] = $this->db->get()->result();        

                  $this->db->select('id,max_marks');	
                  $this->db->from('exam_type_mapping');	
                  $this->db->where('exam_id',$exam_id);	
                  $this->db->where('exam_type_id',$exam_type[$count][0]->id);	
                  $this->db->where('subject_id',$subject_id);	
                  $this->db->where('class_id',$class_id);	
                  $this->db->where('academic_year_id',$school->academic_year_id);                  
                  $exam_type_max_marks[$count] = $this->db->get()->result();                  
                  
                  $count++;	
                }                
                //checking marks_obtained is less than or equal to max_obtained_marks	
                $marks_total = 0;	
                $marks_obtained_total = 0;                
                foreach($marks_obtained as $key => $marks){                    
                    if($marks > ($exam_type_max_marks[$key][0]->max_marks))	
                    {	
                      $error_message[$q] = 'Marks obtained is greater than maximum obtain marks for the Student with name - '.$arr[1].' and roll number - '.$arr[0].' for exam - '.$exam_type[$key][0]->name;	
                      $q++;	
                      $empty_check = 0;	
                      break;	
                    }	
                    else	
                    {	
                        $empty_check = 1;	
                        $marks_total += $exam_type_max_marks[$key][0]->max_marks;	
                        $marks_obtained_total += $marks;	
                    }	
                }                
                if($empty_check == 0){ 
                    continue; 
                }                
                
                $student = $this->mark->get_student_by_roll($school_id, $exam_id, $class_id, $section_id,$subject_id, $school->academic_year_id, $roll_no, $student_name);                $student_id = $student[0]->student_id;                
                $this->db->select('id, status');	
                $this->db->from('marks');	
                $this->db->where('school_id', $school_id);	
                $this->db->where('class_id', $class_id);	
                $this->db->where('exam_id',$exam_id);	
                $this->db->where('section_id',$section_id);	
                $this->db->where('subject_id',$subject_id);	
                $this->db->where('academic_year_id',$school->academic_year_id);	
                $this->db->where('student_id',$student_id);                
                $student_mark_check = $this->db->get()->result();                
                if($student_mark_check){                    
                    $error_message[$q] = 'Marks already exists for the Student with name - '.$arr[1].' and roll number - '.$arr[0];	
                    $q++;                    
                    continue;	
                }	
                else{                
                    //grade is static here, needs to be changed according to marks   
                    $this->db->select('id');	
                    $this->db->from('grades');	
                    $this->db->where('school_id', $school_id);	
                    $this->db->where(''.$marks_obtained_total.' BETWEEN mark_to and mark_from');  
                    //$this->db->get();
                    //SELECT id FROM `grades` WHERE 89 between mark_to and mark_from 
      
                    //echo $this->db->last_query();//die();         
                    $grade_id = $this->db->get()->row();
                    $grade_id =  $grade_id->id;
                    $data_array = array(	
                    'school_id' => $school_id,	
                    'exam_id' => $exam_id,	
                    'class_id' => $class_id,	
                    'section_id' => $section_id,	
                    'subject_id' => $subject_id,	
                    'academic_year_id' => $school->academic_year_id,	
                    'student_id' => $student_id,	
                    'exam_total_mark' => $marks_total,	
                    'obtain_total_mark' => $marks_obtained_total,	
                    'grade_id' => $grade_id,	
                    'status' => '1',	
                    'created_at' => date('Y-m-d H:i:s'),	
                    'created_by' => logged_in_user_id(),	
                    'modified_at' => date('Y-m-d H:i:s'),	
                    'modified_by' => logged_in_user_id());                
                    $this->db->insert('marks', $data_array);	
    
    
                $insert_id = $this->db->insert_id();                
                for($i=0;$i<count($exam_type);$i++) {                    
                    $data_array_details = array(	
                        'exam_type_id' => $exam_type[$i][0]->id,	
                        'marks_id' => $insert_id,	
                        'marks_obtained' => $marks_obtained[$i],	
                    );	
                    $this->db->insert('marks_details', $data_array_details);	
    
                }	
              }	
            }	
        }	

        $return_data = array(	 
            'status'        => TRUE,	
            'error_message' => $error_message);	
        return $return_data;	
    }    
    
    private function _upload_file() {        
        $file = $_FILES['bulk_marks']['name'];        
        if ($file != "") {            
            $destination = 'assets/csv/bulk_uploaded_marks.csv';
            $ext = strtolower(end(explode('.', $file)));
            if ($ext == 'csv') {
                move_uploaded_file($_FILES['bulk_marks']['tmp_name'], $destination);
            }
        } else {
            error($this->lang->line('insert_failed_insert_failed'));
            redirect('exam/mark');
        }
    }

}
