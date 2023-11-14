<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Exam.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Exam
 * @description     : Manage exam term.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Exam extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Exam_Model', 'exam', true);     
    }

    
        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam term List" user interface                
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

	    check_permission(VIEW);

	    if(empty($school_id)) {
		    $school_id = $this->session->userdata('school_id');
	    }


	    $school = $this->exam->get_school_by_id($school_id);

	    $this->data['exams'] = $this->exam->get_exam_list($school_id, @$school->academic_year_id);

	    $this->data['filter_school_id'] = $school_id;        
	    $this->data['schools'] = $this->schools;

	    $this->data['list'] = TRUE;
	    $this->layout->title($this->lang->line('exam_term') . ' | ' . SMS);
	    $this->layout->view('exam/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Eaxm term" user interface                 
    *                    and process to store "Exam term" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function exam_type() {
			     
        check_permission(VIEW);
        $this->data['list'] = TRUE;
      
        $this->db->select('id, name');
        $this->db->from('master_exam_types');
        $this->data['exam_types'] = $this->db->get()->result();
    
        $this->layout->view('exam/exam_type', $this->data);
    }

    public function exam_type_add() { 
        check_permission(ADD);
    
        if ($_POST) {
            $name = $this->input->post('title');
            $data = array(
                'name' => $name );
            $this->db->insert('master_exam_types',$data);
            success($this->lang->line('insert_success'));
            redirect('exam/exam_type/');
        }

        $this->db->select('id, name');
        $this->db->from('master_exam_types');
        $this->data['exam_types'] = $this->db->get()->result();

        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/exam_type', $this->data);
    }

    public function exam_type_edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
         
            $data = array( 
                'name'      => $this->input->post('title')
            );

            $this->db->where('id', $id);

            $this->db->update('master_exam_types', $data);

            success($this->lang->line('update_success'));
            redirect('exam/exam_type');            
        }
      
        $this->db->select('id, name');
        $this->db->from('master_exam_types');
        $this->data['exam_types'] = $this->db->get()->result();

        $this->db->select('id , name');
        $this->db->from('master_exam_types');
        $this->db->where('id',$id);
        $this->data['edit_exam_type'] = $this->db->get()->result();
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/exam_type', $this->data);
    }

    public function add() {

        check_permission(ADD);
         $exam = array();
         $marks = array();
         $exam = $_POST['exam_types'];
         $marks = $_POST['marks']; 
         $school_id =  $_POST['school_id'];
         $school = $this->exam->get_school_by_id($school_id); 
         $academic_year_id = $school->academic_year_id; 
         $class_id = $_POST['class_id'];
        
        if ($_POST) {
            $this->_prepare_exam_validation();
            
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_exam_data();
                $insert_id = $this->exam->insert('exams', $data);
                //echo 'Mapp='.$insert_id;        
                for($i=0;$i<count($exam);$i++){
                      $vals = explode('-',$exam[$i]);
                      $subject_id =$vals[0];
                      $exam_type_id = $vals[1];
                      $max_marks = $marks[$i];
                      $exam_id = $insert_id;
                      $this->exam->save_exam_mapping_list($exam_id,$max_marks,$exam_type_id,$subject_id,$class_id,$academic_year_id);          
             } 
            

                if ($insert_id) {
                    
                    create_log('Has been created an Exam : '.$data['title']);  
                    
                    success($this->lang->line('insert_success'));
                    redirect('exam/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('exam/add');
                }
            } else {
                $this->data['post'] = $_POST;
               // echo 'SSS';die(); 
            }
        }

        $this->data['exams'] = $this->exam->get_exam_list();
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Exam term" user interface                 
    *                    with populate "Exam term" value 
    *                    and process to update "exam term" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/index');
        }
        
       
        if ($_POST) {
            $this->_prepare_exam_validation();
            if ($this->form_validation->run() === TRUE) {  
                $data = $this->_get_posted_exam_data();
                $updated = $this->exam->update('exams', $data, array('id' => $this->input->post('id')));
                $subjects = $_POST['subjects'];
                $exam_types = $_POST['exam_types'];
                $marks =$_POST['marks'];
                $school = $_POST['school_id'];
                $class_id = $_POST['class_id'];
                // Deleting the existing 
                $academic = $this->exam->get_running_academic_id($school); 
                $this->db->delete('exam_type_mapping', array('exam_id' => $id,'academic_year_id'=>$academic->id));
                
                
                     
                 for($i=0;$i<count($exam_types);$i++){
                       $vals = explode('-',$exam_types[$i]);
                       $subject_id =$vals[0];
                       $exam_type_id = $vals[1];
                       $max_marks = $marks[$i];
                       $exam_id = $id;
                       $mapping = $this->exam->save_exam_mapping_list($exam_id,$max_marks,$exam_type_id,$subject_id,$class_id,$academic->id);          
              } 
 
                 if ($mapping) {
                     
                     create_log('Has been created an Exam : '.$data['title']);  
                     
                     success($this->lang->line('update_success'));
                     redirect('exam/index/'.$data['school_id']);
                 } else {
                     error($this->lang->line('insert_failed'));
                     redirect('exam/index');
                 }

                
                if ($updated) {
                    
                    create_log('Has been udated an Exam : '.$data['title']);
                    
                    success($this->lang->line('update_success'));
                    redirect('exam/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('exam/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['post'] = $_POST;
                $this->data['exam'] = $this->exam->get_single('exams', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['edit_exam_type_name'] = $this->db->query("SELECT DISTINCT ETM.subject_id, S.name from exam_type_mapping as ETM left join subjects AS S on S.id = ETM.subject_id where exam_id = '".$id."'")->result();
			                
            
            $this->data['exam'] = $this->exam->get_single('exams', array('id' => $id));

            if (!$this->data['exam']) {
                redirect('exam/index');
            }
        }
        
        $id = $this->data['exam']->id;
        $class_id = $this->exam->get_single_class_id($id);
        
        $this->data['exams'] = $this->exam->get_exam_list($this->data['exam']->school_id, $this->data['exam']->academic_year_id);
        $this->data['school_id'] = $this->data['exam']->school_id;
        $this->data['filter_school_id'] = $this->data['exam']->school_id;
        $this->data['filter_class_id'] = $class_id->class_id;
        $this->data['schools'] = $this->schools;
        $classes = get_classes($this->data['exam']->school_id);
        $this->data['classes'] = $classes;
        $this->data['exam_id'] = $id;
        
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/index', $this->data);
    }

    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific exam term data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null) {

        check_permission(VIEW);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/index');
        }
        
        $this->data['exams'] = $this->exam->get_exam_list();
        $this->data['exam'] = $this->exam->get_single_exam($id);
        $this->data['detail'] = TRUE;
        $this->layout->title($this->lang->line('view') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/index', $this->data);
    }

    
    /*****************Function _prepare_exam_validation**********************************
    * @type            : Function
    * @function name   : _prepare_exam_validation
    * @description     : Process "exam term" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_exam_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('title', $this->lang->line('exam') . '' . $this->lang->line('title'), 'trim|required|callback_title');
        //$this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('start_date', $this->lang->line('start_date'), 'trim|required');
        $this->form_validation->set_rules('subjects[]','subjects', 'required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "Exam term title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function title() {
        
        $school_id = $this->input->post('school_id');
        $school = $this->exam->get_school_by_id($school_id); 
        
        if ($this->input->post('id') == '') {
            $exam = $this->exam->duplicate_check($school_id, $school->academic_year_id, $this->input->post('title'));
            if ($exam) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $exam = $this->exam->duplicate_check($school_id, $school->academic_year_id, $this->input->post('title'), $this->input->post('id'));
            if ($exam) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_exam_data**********************************
    * @type            : Function
    * @function name   : _get_posted_exam_data
    * @description     : Prepare "Exam term" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_exam_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'note';
        $items[] = 'class_id';
        $data = elements($items, $_POST);
         //echo '<pre>';print_r($data);die();   
        $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $school = $this->exam->get_school_by_id($data['school_id']);
            
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/index');
            }
        
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }
        
        return $data;
    }

    /*****************Function _get_exam_types **********************************
    * @type            : Function
    * @function name   : _get_exam_types
    * @description     : Prepare "Exam types" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_exam_types() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'note';
        $data = elements($items, $_POST);

        $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));

        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $school = $this->exam->get_school_by_id($data['school_id']);
            
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/index');
            }
        
            $data['academic_year_id'] = $school->academic_year_id;
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        return $data;
    }

    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Exam Term" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

         if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/index');
        }
        
        
        $exam = $this->exam->get_single('exams', array('id' => $id));
        
        if ($this->exam->delete('exams', array('id' => $id))) {            
            $this->exam->delete('exam_type_mapping', array('exam_id' => $id));
            create_log('Has been deleted an Exam : '.$exam->title); 
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('exam/index');
    }
   
    public function exam_type_delete($id = null) {
			
        check_permission(DELETE);

         if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('exam/exam_type');
        }
        
        $this->db->delete('master_exam_types', array('id' => $id));

            create_log('Has been deleted an Exam : '.$exam->title); 
            success($this->lang->line('delete_success'));
            redirect('exam/exam_type');
    }
}
