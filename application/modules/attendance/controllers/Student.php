<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Student.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Student
 * @description     : Manage student daily attendance.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Student extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        
        $this->load->helper('report');
        $this->load->model('Student_Model', 'student', true);
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Student Attendance" user interface                 
    *                    and Process to manage daily Student attendance    
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function index() {

        check_permission(VIEW);
        if ($_POST) {

            $school_id  = $this->input->post('school_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $date = $this->input->post('date');
            
            $month = date('m', strtotime($this->input->post('date')));
            $year = date('Y', strtotime($this->input->post('date')));
            
            $school = $this->student->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('attendance/student/index');
            }

            $this->data['students'] = $this->student->get_student_list($school_id, $class_id, $section_id, $school->academic_year_id);

            $condition = array(
                'school_id' => $school_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'month' => $month,
                'year' => $year
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->id;
                    $attendance = $this->student->get_single('student_attendances', $condition);

                    if (empty($attendance)) {  
                        
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->student->insert('student_attendances', $data);
                    }
                }
            }

            $this->data['academic_year_id'] = $school->academic_year_id;
            $this->data['day'] = date('d', strtotime($this->input->post('date')));
            $this->data['month'] = date('m', strtotime($this->input->post('date')));
            $this->data['year'] = date('Y', strtotime($this->input->post('date')));
            $this->data['school_id'] = $school_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['date'] = $date;
            
            create_log('Has been process student attendance'); 
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->layout->title($this->lang->line('student') . ' ' . $this->lang->line('attendance') . ' | ' . SMS);
        $this->layout->view('student/index', $this->data);
    }

   
        
    /*****************Function guardian**********************************
    * @type            : Function
    * @function name   : guardian
    * @description     : Load "Student Attendance for guardian" user interface                 
    *                    and Process to manage daily Student attendance    
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function guardian() {

        check_permission(VIEW);

        $this->data['month_number'] = 1;
        $this->data['days'] = 31;
        
        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $academic_year_id = $this->input->post('academic_year_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $month = $this->input->post('month');


            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['month'] = $month;
            $this->data['month_number'] = date('m', strtotime($this->data['month']));
            $session = $this->student->get_single('academic_years', array('id' => $academic_year_id));
            $this->data['students'] = $this->student->get_student_attendance_list($school_id, $academic_year_id, $class_id, $section_id);
           
            $this->data['year'] = substr($session->session_year, -4);
            //echo date('t', mktime(0, 0, 0, $month, 1, $year)); die();
            //$this->data['days'] = cal_days_in_month(CAL_GREGORIAN, $this->data['month_number'], $this->data['year']);
            $this->data['days'] =  date('t', mktime(0, 0, 0, $this->data['month_number'], 1, $this->data['year'])); 
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){  
            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->student->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['academic_years'] = $this->student->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('student') . ' ' . $this->lang->line('attendance') . ' ' . $this->lang->line('report') . ' | ' . SMS);
        $this->layout->view('student/attendance', $this->data);
    }


    /*****************Function update_single_attendance**********************************
    * @type            : Function
    * @function name   : update_single_attendance
    * @description     : Process to update single student attendance status               
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    public function update_single_attendance() {

        
        $status = $this->input->post('status');
        $condition['school_id'] = $this->input->post('school_id');
        $condition['student_id'] = $this->input->post('student_id');
        $condition['class_id'] = $this->input->post('class_id');
        
        if($this->input->post('section_id')){
           $condition['section_id'] = $this->input->post('section_id');
        }
        
        $condition['month'] = date('m', strtotime($this->input->post('date')));
        $condition['year'] = date('Y', strtotime($this->input->post('date')));
        
        $school = $this->student->get_school_by_id($condition['school_id']); 
        if(!$school->academic_year_id){
          
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $field = 'day_' . abs(date('d', strtotime($this->input->post('date'))));
        if ($this->student->update('student_attendances', array($field => $status, 'modified_at'=>date('Y-m-d H:i:s')), $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    
    /*****************Function update_all_attendance**********************************
    * @type            : Function
    * @function name   : update_all_attendance
    * @description     : Process to update all student attendance status                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function update_all_attendance() {

        $status = $this->input->post('status');

        $condition['school_id'] = $this->input->post('school_id');
        $condition['class_id'] = $this->input->post('class_id');
        
        if($this->input->post('section_id')){
           $condition['section_id'] = $this->input->post('section_id');
        }
        
        $condition['month'] = date('m', strtotime($this->input->post('date')));
        $condition['year'] = date('Y', strtotime($this->input->post('date')));
        
        $school = $this->student->get_school_by_id($condition['school_id']);   
        if(!$school->academic_year_id){
          
        }
        
        $condition['academic_year_id'] = $school->academic_year_id;

        $field = 'day_' . abs(date('d', strtotime($this->input->post('date'))));
        if ($this->student->update('student_attendances', array($field => $status, 'modified_at'=>date('Y-m-d H:i:s')), $condition)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    public function bulk(){

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $month_no = $this->input->post('month_no');

            //check if month is februrary and also year is leap year or not
            if($month_no == '02')
            {
                $year = date("Y");
                $is_leap = (date('L', strtotime("$year-01-01")) ? 'Yes' : 'No');
                if ($is_leap == 'Yes' )
                {
                    $days = '29';
                }
                else
                {
                    $days = '28';
                }

            }
            elseif($month_no == '01' || $month_no == '03' || $month_no == '05' || $month_no == '07' || $month_no == '08' || $month_no == '10' || $month_no == '12')
            {
                $days = '31';
            }
            elseif($month_no == '04' || $month_no == '06' || $month_no == '09' || $month_no == '11')
            {
                $days = '30';
            }
           
            $file = fopen('assets/csv/bulk_attendance.csv', 'w');
            $data[0] = '*Roll No';
            $data[1] = '*Student Name';
            $j=2;

            for($i=1;$i<=$days;$i++)
            {
               $data[$j] = "*Day-".$i;
               $j ++;    
            }
           
            fputcsv($file, $data);
            fclose($file);

            $this->data['school_id'] = $school_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['month_no'] = $month_no;
            $this->data['days'] = $days;
        }

        $this->layout->title($this->lang->line('student') . ' ' . $this->lang->line('attendance') . ' | ' . SMS);
        $this->layout->view('student/bulk', $this->data);
    }

    //adding bulk marks
    public function add_bulk_attendance() {

        if ($_POST) {  
                     
            $status = $this->_get_posted_student_data();
             
            if ($status['status']) {                  

                create_log('Has been added Bulk Marks');
                success($this->lang->line('insert_success'));
                $this->session->set_userdata('errors',$status['error_message']);
                redirect('attendance/student/bulk', $status['error_message']);
            } else {
                error($this->lang->line('insert_failed'));
                redirect('attendance/student/bulk');
            }            
        }
    }

    private function _get_posted_student_data() { 

        $this->_upload_file();

        $destination = 'assets/csv/bulk_uploaded_attendance.csv';

        if (($handle = fopen($destination, "r")) !== FALSE) {

            $school_id  = $this->input->post('final_school_id');
             
            $class_id  = $this->input->post('final_class_id');
           
            $section_id  = $this->input->post('final_section_id');

            $month_no  = $this->input->post('final_month_no');
            $year = date("Y");

            $days  = $this->input->post('final_days');

            $school = $this->student->get_school_by_id($school_id);
           
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('attendance/student/bulk');
            }
           
            $handle_count = fgetcsv($handle);

            $error_message = array();
            $q=0;

            //echo '<pre>';print_r($arr);die(); 
            while (($arr = fgetcsv($handle)) !== false) {

                //check if data is empty and check for holidays
                $count=0;
                foreach($arr as $key => $data_check){
   
                     if($count >= '2' || $data_check == ''){
                        $empty_day = $count - 1 ;
                        $date = $year."-".$month_no."-".$empty_day;

                        $day = date('l', strtotime($date));

                        if($data_check == '')
                        {
                            $empty_check = 1;
                            $error_message[$q] = 'Empty field for the Student with name - '.$arr[1].' and roll number - '.$arr[0];
                            $q++;
                            break;  
                        }
                        elseif($day == 'Saturday')
                        {

                            $data['day_'.$empty_day] = 'Saturday Holiday';
                        }
                        elseif($day == 'Sunday')
                        {
                            $data['day_'.$empty_day] = 'Sunday Holiday';
                        }
                        else
                        {
                            $this->db->select();
                            $this->db->from('holidays_dates');
                            $this->db->where('date',$date);
                            $res = $this->db->get()->result();
                            if(!$res)
                            {
                                $data['day_'.$empty_day] = $arr[$count];  
                            }
                            else
                            {
                                $data['day_'.$empty_day] = $res[0]->holidays_id;  
                            }
                           
                        }
                        $count++;
                     }
                     
                    elseif ($count <= '1')
                    {      
                        $count++;
                    }
                }

                if($empty_check == 1)
                    {   continue;   }
               
                $attendance = $arr;
                $roll_no = $arr[0];
                $student_name = $arr[1];

                //check if student exists or not and fetch 'student id' if student exists
                $student_check = $this->student->check_student_by_roll($school_id, $class_id, $section_id, $school->academic_year_id, $roll_no, $student_name);

                if(!$student_check){
                   
                    $error_message[$q] = "Student does not exists with name : ".$student_name." and roll number : ".$roll_no;                    
                    $q++;
                    continue;
                }

                //saving student id
                $student_id = $student_check[0]->student_id;

                //check if data already exists
                $this->db->select('*');
                $this->db->from('student_attendances');
                $this->db->where('school_id',$school_id);
                $this->db->where('student_id',$student_id);
                $this->db->where('academic_year_id',$school->academic_year_id);
                $this->db->where('class_id',$class_id);
                $this->db->where('section_id',$section_id);
                $this->db->where('month',$month_no);

                $res = $this->db->get()->result();
               
                if($res)
                {
                   $error_message[$q] = 'Student attendance already exists with name - '.$arr[1].' and roll number - '.$arr[0].' for the current month, please check ';
                    $q++;
             
                    continue;
                }

                //inserting student attendance
                $data['school_id'] = $school_id;
                $data['student_id'] = $student_id;
                $data['academic_year_id'] =$school->academic_year_id;
                $data['class_id'] = $class_id;
                $data['section_id']=$section_id;
                $data['month']  = $month_no;
                $data['year']   = $year;                
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
               
                $this->db->insert('student_attendances',$data);

               
            }
        }
        $return_data = array(
            'status'        => TRUE,
            'error_message' => $error_message);
        return $return_data;
    }

    private function _upload_file() {

        $file = $_FILES['bulk_attendance']['name'];
       
        if ($file != "") {

            $destination = 'assets/csv/bulk_uploaded_attendance.csv';      

            $ext = strtolower(end(explode('.', $file)));
            if ($ext == 'csv') {                
                move_uploaded_file($_FILES['bulk_attendance']['tmp_name'], $destination);  
            }
        } else {
            error($this->lang->line('insert_failed_insert_failed'));
            redirect('exam/mark');
        }      
    }

    public function getSundays($y,$m){
        $date = "$y-$m-01";
        $first_day = date('N',strtotime($date));
        $first_day = 7 - $first_day + 1;
        $last_day =  date('t',strtotime($date));
        $days = array();
        for($i=$first_day; $i<=$last_day; $i=$i+7 ){
            $days[] = $i;
        }
        return  $days;
    }

}
