<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
class Academic_year_missing extends Exception {};
class Token_missing extends Exception {};
class Page_param_missing extends Exception {};
class No_record_found extends Exception {};    
class Post_params_missing extends Exception {};
class Api_key_missing extends Exception {};
class Api_key_mismatch extends Exception {};      
    
   
class User_Api extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('users', 'UserModel');
        $this->load->model('Auth_Model', 'auth', true);
        $this->load->library('Authorization_Token');
    }

    /**
     * User Login API
     * --------------------
     * @param: username or email
     * @param: password
     * --------------------------
     * @method : POST
     * @link: api/user/login
     */

    /*     * ***************Function login_post **********************************
     * @type            : Function
     * @function name   : login_post
     * @description     : this function used to do login
     * @param           : username,password 
     * @method          : POST
     * @link            : api/user_Api/login
     * Author           : Dharmendra Kukreja
     * **************************************************************************** */     
    public function login_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $output = $this->UserModel->user_login($this->input->post('username'), $this->input->post('password'));
        $school = $this->UserModel->get_school_by_id($output->school_id);
        $details = $this->UserModel->get_single_student($output->user_id, $school->academic_year_id);
        try{   
            if(empty($this->input->post('username'))){
                // Login Error
                $message = [
                    'status' => FALSE,
                    'message' => "Please enter Username"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }

            if(empty($this->input->post('password'))){
                // Login Error
                $message = [
                    'status' => FALSE,
                    'message' => "Please enter Password"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }

            if(empty($this->input->post('username')) || empty($this->input->post('password'))){ 
                throw new Post_params_missing();
            }

        if (!empty($output) AND $output != FALSE)
        {
            if(!empty($output->photo))
            {
                $image = base_url().'assets/uploads/student-photo/'.$output->photo;
            }
            else
            {
                $image = base_url().'assets/images/default-user.png';
            }
            $token_data['id'] = $output->id;
            $token_data['school_id'] = $output->school_id;
            $token_data['username'] = $output->username;
            $token_data['class_id'] = $details->class_id;
            $token_data['academic_year_id'] = $details->academic_year_id;
            $token_data['student_id'] = $details->id;
            $token_data['role'] = $details->role;
            $token_data['section_id'] = $details->section_id;
            $token_data['created_at'] = $output->created_at;
            $token_data['role_id'] = $details->role_id;
            $token_data['modified_at'] = $output->modified_at;
            $token_data['time'] = time();
            
            $user_token = $this->authorization_token->generateToken($token_data);
            $return_data = [
                'user_id' => $output->id,
                'name' => $output->name,
                'email' => $output->email,
                'username' => $output->username,
                'user_type' => $details->role,
                'photo' => $image,
                'created_at' => $output->created_at,
                'token' => $user_token,
                'section' => $details->section,
                'class' => $details->class_name,
                'academic_year_id' => $details->academic_year_id,
                'section_id' => $details->section_id
            ];

            // Login Success
            $message = [
                'status' => true,
                'data' => $return_data,
                'message' => "User login successful"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
    }

   /*     * ***************Function login_post **********************************
     * @type            : Function
     * @function name   : user_detail
     * @description     : this function used to get user details
     * @param           : 
     * @method          : GET
     * @link            : api/user_Api/user_detail
     * **************************************************************************** */     
    public function user_detail_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        //echo '<pre>';print_r($token);die();
        $id = $token->id;
        try{   
            if(empty($token->id) ||empty($token->school_id) ||empty($token->student_id) || empty($token->section_id)){ 
                throw new Token_missing();
            }
           
        $output = $this->UserModel->user_detail($id);

        if (!empty($output) AND $output != FALSE)
        {
            if(!empty($output->photo))
            {
                $photo = base_url().'/assets/uploads/student-photo/'.$output->photo;
            }
            else
            {
                $photo = base_url().'/assets/images/default-user.png';
            }
            if(!empty($output->father_photo))
            {
                $father_photo = base_url().'/assets/uploads/father-photo/'.$output->father_photo;
            }
            else
            {
                $father_photo = base_url().'/assets/images/default-user.png';
            }
            if(!empty($output->mother_photo))
            {
                $mother_photo = base_url().'/assets/uploads/mother-photo/'.$output->mother_photo;
            }
            else
            {
                $mother_photo = base_url().'/assets/images/default-user.png';
            }
            
            $return_data = array(
                array(
                    'name' => 'Student Information',
                    'photo' => $photo,
                    'data' => array(
                        array(
                            'key' => 'Name',
                            'value' => $output->name,
                        ),
                        array(
                            'key' => 'Email',
                            'value' => $output->email,
                        ),
                        array(
                            'key' => 'Phone',
                            'value' => $output->phone,
                        ),
                        array(
                            'key' => 'Present Address',
                            'value' => $output->present_address,
                        ),
                        array(
                            'key' => 'User Id',
                            'value' => $output->user_id,
                        ),
                        array(
                            'key' => 'Admission No',
                            'value' => $output->admission_no,
                        ),
                        array(
                            'key' => 'Admission Date',
                            'value' => $output->admission_date,
                        ),
                        array(
                            'key' => 'Registration No',
                            'value' => $output->registration_no,
                        ),
                        array(
                            'key' => 'Group',
                            'value' => $output->group,
                        ),
                        array(
                            'key' => 'Gender',
                            'value' => $output->gender,
                        ),
                        array(
                            'key' => 'Blood Group',
                            'value' => $output->blood_group,
                        ),
                        array(
                            'key' => 'Religion',
                            'value' => $output->religion,
                        ),
                        array(
                            'key' => 'Caste',
                            'value' => $output->caste,
                        ),
                        array(
                            'key' => 'Date of Birth',
                            'value' => $output->dob,
                        ),
                        array(
                            'key' => 'Age',
                            'value' => $output->age,
                        ),
                        
                        array(
                            'key' => 'Other Info',
                            'value' => $output->other_info,
                        ),
                        array(
                            'key' => 'Library Member',
                            'value' => $output->is_library_member,
                        ),
                        array(
                            'key' => 'Hostel Member',
                            'value' => $output->is_hostel_member,
                        ),
                        array(
                            'key' => 'Transport Member',
                            'value' => $output->is_transport_member,
                        ),
                        array(
                            'key' => 'Discount Id',
                            'value' => $output->discount_id,
                        ),
                        array(
                            'key' => 'Previous School',
                            'value' => $output->previous_school,
                        ),
                        array(
                            'key' => 'Previous Class',
                            'value' => $output->previous_class,
                        ),
                        array(
                            'key' => 'Transfer Certificate',
                            'value' => $output->transfer_certificate,
                        ),
                        array(
                            'key' => 'National Id',
                            'value' => $output->national_id,
                        ),
                        array(
                            'key' => 'Second Language',
                            'value' => $output->second_language,
                        ),
                        array(
                            'key' => 'Username',
                            'value' => $output->username,
                        ),
                        array(
                            'key' => 'Status',
                            'value' => $output->status,
                        ),
                        array(
                            'key' => 'Last Logged In',
                            'value' => $output->last_logged_in,
                        ),
                    ),
                ),
                array(
                    'name' => 'Father Information',

                    'photo' => $father_photo,

                    'data' => array(
                        array(
                            'key' => 'Father Name',
                            'value' => $output->father_name,
                        ),
                        array(
                            'key' => 'Father Phone',
                            'value' => $output->father_phone,
                        ),
                        array(
                            'key' => 'Father Education',
                            'value' => $output->father_education,
                        ),
                        array(
                            'key' => 'Father Profession',
                            'value' => $output->father_profession,
                        ),
                        array(
                            'key' => 'Father Designation',
                            'value' => $output->father_designation,
                        ),
                        
                    ),
                ),
                array(
                    'name' => 'Mother Information',
                    'photo' => $mother_photo,
                    'data' => array(
                        array(
                            'key' => 'Mother Name',
                            'value' => $output->mother_name,
                        ),
                        array(
                            'key' => 'Mother Phone',
                            'value' => $output->mother_phone,
                        ),
                        array(
                            'key' => 'Mother Education',
                            'value' => $output->mother_education,
                        ),
                        array(
                            'key' => 'Mother Profession',
                            'value' => $output->mother_profession,
                        ),
                        array(
                            'key' => 'Mother Pesignation',
                            'value' => $output->mother_designation,
                        ),
                        
                    ),
                ),
            );

            // Login Success
            $message = [
                'status' => true,
                'data' => $return_data,
                'message' => "User details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid token"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }


    /*     * ***************Function marksheet_list **********************************
     * @type            : Function
     * @function name   : marksheet_list
     * @description     : this function used to get student marsheet details
     * @param           : academic_year_id
     * @method          : POST
     * @link            : api/user_Api/marksheet_list
     * **************************************************************************** */      
    public function marksheet_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $student_id = $token->student_id;
        $section_id = $token->section_id;
        // Note - Academic year will be passed as POST
        $academic_year_id = $this->input->post('academic_year_id');
        try{   
            if(empty($token->id) ||empty($token->school_id) ||empty($token->student_id) || empty($token->section_id)){ 
                throw new Token_missing();
            }
            
            if((empty($academic_year_id))){ 
                throw new Post_params_missing();
            }
        $all_exams = api_get_all_exam_results($school_id, $class_id, $academic_year_id,$section_id,$student_id);
        if(empty($all_exams)){ 
            throw new No_record_found();
        }
        $output = array();
             foreach($all_exams as $exam){
                $all_subjects = $this->UserModel->get_list('subjects', array('school_id'=>$school_id, 'status' => 1,'class_id' =>$class_id), '', '', '', 'id', 'ASC');
                 
                foreach($all_subjects as $sub){
                    $marks_data['sub_id'] = $sub->id;
                    $marks_data['class_id'] = $sub->class_id; 
                    $marks_data['teacher_id'] = $sub->teacher_id;
                    $marks_data['subject'] = $sub->name;
                    
                    $lowest =  api_get_lowest_mark($school_id, $academic_year_id, $exam->id, $class_id, $section_id, $sub->id );
                    
                    $marks_data['lowest'] =  $lowest->lowest;

                    $highest =  api_get_highest_mark($school_id, $academic_year_id, $exam->id, $class_id, $section_id, $sub->id );
          
                    $marks_data['highest'] = $highest->height;
                    
                    $obtained_marks = api_get_exam_details_by_subject($school_id, $exam->id, $class_id, $academic_year_id,$sub->id,$student_id);
                    $obtain = '';
                    $max = ''; 
                    if(!empty($obtained_marks)){
                      foreach($obtained_marks as $subjectDetails){
                        $obtain += $subjectDetails->obtain;
                      }
                    } else{
                        $obtain ='0';
                    } 
                    if(!empty($obtained_marks)){
                      foreach($obtained_marks as $subjectDetails){
                        $max += $subjectDetails->max;
                      } 
                    }else{
                        $max ='0';
                      }  
                      $marks_data['total_obtain'] = $obtain;
                      $marks_data['total_max'] = $max; 
                      $all = api_get_subject_list($school_id, $academic_year_id, $exam->id, $class_id, $section_id, $student_id,$sub->id);
                      $marks_data['grade'] = $all->name;
                      $marks_data['point'] = $all->point;   
                      $marks_data['position'] = get_position_in_subject($school_id, $academic_year_id, $exam->id, $class_id, $section_id, $sub->id , $obtain);
                     
                      $obtained_marks = api_get_exam_details_by_subject($school_id, $exam->id, $class_id, $academic_year_id,$sub->id,$student_id);

                      
                      $marks_data['mark'] = [];
                      foreach($obtained_marks as $marks){ 
                        $mark['name'] = $marks->name;
                        $mark['type_id'] = $marks->type_id;
                        $mark['obtain'] = $marks->obtain;
                        $mark['max'] = $marks->max;
                        $mark['exam_id'] = $marks->exam_id;
                        $marks_data['mark'][] = $mark; 
                        
                      }
                    $exam->marks_data[] = $marks_data;
                }
                $data[] = $exam;
            }   
            
            $jsonData =   $data;
        if (!empty($jsonData) AND $jsonData != FALSE)
        {
           $message = [
                "status" => true,
                "message" => "User details",  
                "data" =>$jsonData 
    ];
            
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Marksheet Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid user details"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }


    /*     * ***************Function student_teacher_list **********************************
     * @type            : Function
     * @function name   : student_teacher_list
     * @description     : this function used to get teacher list of that student
     * @param           : page,search is optional
     * @method          : POST
     * @link            : api/user_Api/student_teacher_list_post
     * **************************************************************************** */     
    public function student_teacher_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $student_id = $token->student_id;
        $section_id = $token->section_id;
        $academic_year_id =  $token->academic_year_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) ||empty($token->school_id) ||empty($token->class_id) ||empty($token->student_id) || empty($token->section_id) || empty($token->academic_year_id) ){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            
            if((empty($page))){ 
                throw new Post_params_missing();
            }
        $count = api_get_all_teacher_count($school_id, $class_id,$section_id,$search);
        if(count($count)!=0){ 
            $count  = count($count); 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        $limit = 10;
      
        $all_teachers = api_get_student_all_teacher_list($school_id, $class_id,$section_id,$limit,$page,$search);
        if(empty($all_teachers)){ 
            throw new No_record_found();
        }
        foreach($all_teachers as $obj){
            $teacher['id'] = $obj->teacher_id;
            $teacher['name'] = $obj->teacher_name;
            if($obj->image!=''){
                $teacher['image'] = base_url().'assets/uploads/teacher-photo/'.$obj->image;
            }else{
                $teacher['image'] = base_url().'assets/uploads/teacher-photo/default-user.png';
            }

            $teacher_id = $obj->teacher_id;
            $subs =  api_get_teacher_subject($school_id, $class_id,$section_id,$obj->teacher_id);
            $data ='';
            foreach($subs as $sub){
                $data .=$sub->name.','; 
            }
             $data = rtrim($data, ", ");
             $teacher['subject'] = $data; 
             $teacher['user_id'] = $obj->user_id;
             $details[] = $teacher;     
        }

        if (!empty($details) AND $details != FALSE)
        {
            // Teacher Details Success
            $message = [
                'status' => true,
                'data' => $details,
                'page_count' => $record_page,
                'message' => "Teacher Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }


      /*     * ***************Function student_routine_list **********************************
     * @type            : Function
     * @function name   : student_routine_list
     * @description     : this function used to get the student's daily routine
     * @param           : 
     * @method          : GET
     * @link            : api/user_Api/student_routine_list
     * **************************************************************************** */     
    public function student_routine_list_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $student_id = $token->student_id;
        $section_id = $token->section_id;
        $academic_year_id =  $token->academic_year_id;
        try{   
            if(empty($token->id) ||empty($token->school_id) ||empty($token->class_id) ||empty($token->student_id) || empty($token->section_id) ||empty($token->academic_year_id) ){ 
                throw new Token_missing();
            }
          
        $time_table = api_get_student_routine_list($school_id, $class_id,$section_id);
        if(empty($time_table)){ 
            throw new No_record_found();
        }
        $data= array();
        foreach($time_table as $table){
                $day['subject'] =  $table->name;
                $day['teacher'] =  $table->teacher_name;
                $day['room_no'] =  $table->room_no;
                $day['time'] =  $table->start_time.'-'.$table->end_time;
                if (array_key_exists($table->day,$data)){
         
                    $data[$table->day][] =  $day;
                }
               else{
                    $data[$table->day][] =   $day;
                }     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Student Routine Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Student Routine  Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }


      /*     * ***************Function student_study_material *******************
     * @type            : Function
     * @function name   : student_study_material_post
     * @description     : this function used to get the student's study material
     * @param           : page, search is optional
     * @method          : POST
     * @link            : api/user_Api/student_study_material
     * **************************************************************************** */   
    public function student_study_material_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            
            if((empty($page))){ 
                throw new Post_params_missing();
            }
        $count = api_get_student_study_material_count($school_id, $class_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        $limit = 10;


        $material = api_get_student_study_material($school_id, $class_id,$limit,$page,$search);
        if(empty($material)){ 
            throw new No_record_found();
        }
        foreach($material as $study){
                $study_data['id'] =  $study->id;
                $study_data['title'] =  $study->title;
                $study_data['class'] =  $study->class_name;
                $study_data['subject'] =  $study->subject_name;
                $study_data['description'] =  $study->description;
                $study_data['url'] =base_url().'assets/uploads/material/'.$study->material;
                if ($study->modified_at > 0) { 
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->modified_at));    
                }else{
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->created_at));
                } 
                
                $data[] =$study_data;     
        }
        if (!empty($data) AND $data != FALSE)
        {
            // Student Study Material Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Student Study Material Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }



       /*     * ***************Function student_syllabus *******************
     * @type            : Function
     * @function name   : student_syllabus
     * @description     : this function used to get the student's syllabus
     * @param           : page, search is optional
     * @method          : POST
     * @link            : api/user_Api/student_syllabus
     * **************************************************************************** */    
    public function student_syllabus_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            
            if((empty($page))){ 
                throw new Post_params_missing();
            }
        $count = api_get_student_syllabus_count($school_id, $class_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        
        $limit = 10;
        
        $syllabus = api_get_student_syllabus($school_id, $class_id,$limit,$page,$search);
        if(empty($syllabus)){ 
            throw new No_record_found();
        }
        foreach($syllabus as $study){
                $study_data['id'] =  $study->id;
                $study_data['class'] =  $study->class_name;
                $study_data['title'] =  $study->title;
                $study_data['subject'] =  $study->subject_name;
                $study_data['note'] =  strip_tags($study->note);
                $study_data['url'] =base_url().'assets/uploads/syllabus/'.$study->syllabus;
                if ($study->modified_at > 0) { 
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->modified_at));    
                }else{
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->created_at));
                } 
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Student Syllabus Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Syllabus Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }


       /*     * ***************Function student_notice *******************
     * @type            : Function
     * @function name   : student_notice
     * @description     : this function used to get the student's notice
     * @param           : page, search is optional
     * @method          : POST
     * @link            : api/user_Api/student_notice
     * ******************************************************************* */    
    public function student_notice_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $role_name = $token->role;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->role) ){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            
            if((empty($page))){ 
                throw new Post_params_missing();
            }
        $count = api_get_student_notice_count($school_id, $role_name,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
       
        $limit = 10;
        
        $notice = api_get_student_notice($school_id, $role_name,$limit,$page,$search);
        if(empty($notice)){ 
            throw new No_record_found();
        }
        foreach($notice as $study){
                $study_data['title'] =  $study->title;
                $study_data['date'] =  date("d-m-Y", strtotime($study->date)); 
                $study_data['notice'] =  strip_tags($study->notice);
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Notice Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Notice Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }


        /*     * ***************Function student_assignments *******************
     * @type            : Function
     * @function name   : student_assignments
     * @description     : this function used to get the student's assignment
     * @param           : page, search is optional
     * @method          : POST
     * @link            : api/user_Api/student_assignments
     * ******************************************************************* */    
    public function student_assignments_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $section_id =  $token->section_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ||empty($token->section_id) ){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            
            if((empty($page))){ 
                throw new Post_params_missing();
            }
        $count = api_get_student_assignment_count($school_id, $class_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }

        $limit = 10;
        $assignments = api_get_student_assignment($school_id, $class_id,$limit,$page,$search);

        if(empty($assignments)){ 
            throw new No_record_found();
        }

        foreach($assignments as $study){
                $study_data['id'] =  $study->id;
                $study_data['class'] =  $study->class_name;
                $study_data['title'] =  $study->title;
                $study_data['subject'] =  $study->subject_name;
                $study_data['note'] =  strip_tags($study->note);
                $study_data['url'] =base_url().'assets/uploads/assignment/'.$study->assignment;
                if ($study->modified_at > 0) { 
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->modified_at));    
                }else{
                    $study_data['upload_date'] =  date("d-m-Y", strtotime($study->created_at));
                } 
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Assignments Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Assignments Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

        /*     * ***************Function student_attendance *******************
     * @type            : Function
     * @function name   : student_attendance
     * @description     : this function used to get the student's daily attendance
     * @param           : page, search is optional
     * @method          : GET
     * @link            : api/user_Api/student_attendance
     * ******************************************************************* */         
    public function student_attendance_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        $class_id =  $token->class_id;
        $student_id =  $token->student_id;
        $section_id=  $token->section_id;
        try{   
            if(empty($token->id) ||empty($token->school_id) ||empty($token->academic_year_id) ||empty($token->class_id) || empty($token->student_id) ||empty($token->section_id)){ 
                throw new Token_missing();
            }
        $attendance = api_get_student_attendance($school_id, $class_id,$student_id,$section_id);
        if(empty($attendance)){ 
            throw new No_record_found();
        }
                 foreach($attendance as $att){
                    $days = cal_days_in_month(CAL_GREGORIAN, $att->month, $att->year);//die();
                    $total_days = api_get_student_monthly_attendance($school_id, $student_id, $academic_year_id, $class_id, $section_id, $att->month, $days);
                    $holidays = api_get_student_holidays($school_id,$att->month);
                    $i=1;$datewise=array();
                    foreach($total_days as $s){
 
                        if($s['day_'.$i]=='P'){
                            $p += 1; 
                       }elseif($s['day_'.$i]=='A'){
                            $a +=1;
                       }elseif($s['day_'.$i]=='L'){
                           $l +=1;
                       }else{
                           if($s['day_'.$i]!=NULL){
                            $h +=1;   
                           }
                       }
                         
                        $date['date'] = $i.'-'.$att->month.'-'.$att->year;
                        if(is_numeric($s['day_'.$i])){
                            $id = $s['day_'.$i];
                            $holiday_name = api_get_holiday_name($school_id,$id);
                            $date['status'] = $holiday_name->title;
                        }else{
                            $date['status'] = $s['day_'.$i];
                        }
                        
                        $datewise[] =  $date; 
                        $i++;
                    }
                $total_days = $days - $h;
                $att_data['attendance_id']  =  $att->id;
                $att_data['month_name']  =  date("F", mktime(0, 0, 0, $att->month, 10)).'-'.$att->year; 
                $att_data['present']  =  $p;
                $att_data['absent']  =  $a;
                $att_data['late']  =  $l;
                $att_data['holiday']  =  $h;
                $att_data['total']  =  $total_days;
                $att_data['datewise']  =  $datewise;

                $data[] =$att_data;     
        } 

        if (!empty($data) AND $data != FALSE)
        {
            // Student Attendance Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Student Attendance Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
   
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }  
    }

         /*     * ***************Function student_subjects *******************
     * @type            : Function
     * @function name   : student_subjects
     * @description     : this function used to get the student's daily attendance
     * @param           : 
     * @method          : GET
     * @link            : api/user_Api/student_subjects
     * ******************************************************************* */  
    public function student_subjects_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id = $token->class_id;
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id)){ 
                throw new Token_missing();
            }
        $subjects = api_get_student_subjects($school_id, $class_id);
        if(empty($subjects)){ 
            throw new No_record_found();
        }
        foreach($subjects as $study){
                $study_data['name'] =  $study->name;
                $study_data['code'] =  $study->code;
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Subject Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Subject Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
   
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }


          /*     * ***************Function student_exams *******************
     * @type            : Function
     * @function name   : student_exams
     * @description     : this function used to get the student's exam details
     * @param           : 
     * @method          : GET
     * @link            : api/user_Api/student_exams
     * ******************************************************************* */  
    public function student_exams_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id = $token->class_id;
        $academic_year_id =  $token->academic_year_id;
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ||empty($token->academic_year_id) ){ 
                throw new Token_missing();
            }

        $exams = api_get_student_exams($school_id, $class_id,$academic_year_id);
        if(empty($exams)){ 
            throw new No_record_found();
        }
        foreach($exams as $study){
                $study_data['title'] =  $study->title;
                $study_data['start_date'] =  date("d-m-Y", strtotime($study->start_date));
                $study_data['note'] =  strip_tags($study->note);
                $study_data['id'] =  $study->id;
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Exam Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Exam Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
     }  
     catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
   
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

    /*     * ***************Function student_exams_terms *******************
     * @type            : Function
     * @function name   : student_exams_terms
     * @description     : this function used to get the student's exam terms details
     * @param           : exam_id
     * @method          : POST
     * @link            : api/user_Api/student_exams_terms
     * ******************************************************************* */  
   public function student_exams_terms_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id = $token->class_id;
        $academic_year_id =  $token->academic_year_id;
        $exam_id = $this->input->post('exam_id');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ||empty($token->academic_year_id) ){ 
                throw new Token_missing();
            }
            
            if((empty($exam_id))){ 
                throw new Post_params_missing();
            }
        $exams = $this->UserModel->get_schedule_list($school_id = null,$class_id, $academic_year_id = null ,$exam_id);

        if(empty($exams)){ 
            throw new No_record_found();
        }

        foreach($exams as $study){
                $study_data['exam_date'] =  date("d-m-Y", strtotime($study->exam_date));
                $study_data['start_time'] =  $study->start_time;
                $study_data['end_time'] =  $study->end_time;
                $study_data['room_no'] =  $study->room_no;
                $study_data['note'] =  strip_tags($study->note);
                $study_data['title'] =  $study->title;
                $study_data['class_name'] =  $study->class_name;
                $study_data['subject'] =  $study->subject;
                
                $data[] =$study_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Exam TERM Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Exam Term Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
       catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

    }

     /*     * ***************Function student_message_to_teacher *******************
     * @type            : Function
     * @function name   : student_message_to_teacher
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : 
     * @method          : POST
     * @link            : api/user_Api/student_message_to_teacher
     * ******************************************************************* */  

    public function student_message_to_teacher_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;
        $class_id = $token->class_id;
        $academic_year_id =  $token->academic_year_id;
        $role = $token->role;
        $student_id = $token->student_id;
        $teacher_id = $this->input->post('teacher_id');
        $subject = $this->input->post('subject');
        $body = $this->input->post('body');
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ||empty($token->academic_year_id) || empty($token->role) ||empty($token->student_id) ){ 
                throw new Token_missing();
            }
            
            if((!isset($teacher_id)) || (!isset($subject)) || (!isset($body)) ){ 
                throw new Post_params_missing();
            }
           
        $teacher_id = api_get_teacher_id($teacher_id);
        if((!isset($teacher_id->user_id))){
            $message = [
                'status' => FALSE,
                'message' => "Teacher not found"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
        $data = array();
            $data['school_id'] = $school_id;
            $data['subject'] = $subject;
            $data['body'] = nl2br($body);
            $data['academic_year_id'] = $academic_year_id;
            $data['attachment'] = '';
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $id; // updated by student 
            $insert_id = $this->UserModel->insert('messages', $data);
            
            // default value for relation table
            $relation_data = array();
            $relation_data['school_id'] = $data['school_id'] ;
            $relation_data['sender_id'] = $id;
            $relation_data['receiver_id'] = $teacher_id->user_id;
            $relation_data['is_trash'] = 0;
            $relation_data['is_draft'] = 0;
            $relation_data['is_favorite'] = 0;
            $relation_data['is_read'] = 0;
            $relation_data['status'] = 1;
            $relation_data['message_id'] = $insert_id;
            $relation_data['created_at'] = date('Y-m-d H:i:s');
            $relation_data['created_by'] = $id; // updated by student user
            $relation_data['owner_id'] = $id; // updated by student user
            $role_id = $this->UserModel->get_list('roles', array('name'=>$role), '', '', '', 'id', 'ASC'); 
            $relation_data['role_id'] = $role_id[0]->id;
            // save message relationships  for sender
            $this->UserModel->insert('message_relationships', $relation_data);
                
            // save message relationships  for receiver
            $relation_data['owner_id'] = $teacher_id->user_id;
            $relation_data['role_id'] = $teacher_id->role_id;
            $this->UserModel->insert('message_relationships', $relation_data);

       if (!empty($data) AND $data != FALSE)
        {
            // Message sent Success
            $message = [
                'status' => true,
                'message' => "Message Sent to Teacher Successfully"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

    }

      /*     * ***************Function school_all_vehical_routes *******************
     * @type            : Function
     * @function name   : school_all_vehical_routes
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : page
     * @method          : POST
     * @link            : api/user_Api/school_all_vehical_routes
     * ******************************************************************* */  

   
    public function school_all_vehical_routes_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if( empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_get_all_vehical_routes_count($school_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        
        $limit = 10;
        $routes = api_get_all_vehical_routes($school_id,$limit,$page,$search);
        if(empty($routes)){ 
            throw new No_record_found();
        }
        foreach($routes as $route){
                $route_data['id'] =  $route->id;
                $route_data['title'] =  $route->title;
                $route_data['model'] =  $route->model;
                $route_data['number'] =  $route->number;
                $route_data['route_start'] =  $route->route_start;
                $route_data['driver'] =  $route->driver;
                $route_data['contact'] =  $route->contact;
                $route_data['route_end'] =  $route->route_end;
                $route->note =  preg_replace("/[\n\r]/","",$route->note);
                $route_data['note'] =  strip_tags($route->note);
                
                $data[] = $route_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            //  List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "All Vehicle Routes Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }


      /*     * ***************Function school_particular_vehical_routes *******************
     * @type            : Function
     * @function name   : school_particular_vehical_routes
     * @description     : this function used to get the school particular vehical routes
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/school_particular_vehical_routes
     * ******************************************************************* */  
    
    public function school_particular_vehical_routes_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $route_id = $this->input->post('route_id');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)){ 
                throw new Token_missing();
            }
            
            if(empty($route_id)){ 
                throw new Post_params_missing();
            }
        $count = api_get_routes_details_count($school_id,$route_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page > $record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
       
        $limit = 10;
        $routes_details = api_get_routes_details($school_id,$route_id,$limit,$search);
        if(empty($routes_details)){ 
            throw new No_record_found();
        }
        foreach($routes_details as $route){
                //$route_data['id'] =  $route->id;
                $route_data['title'] =  $route->title;
                $route_data['route_start'] =  $route->route_start;
                $route_data['route_end'] =  $route->route_end;
                $route_data['stop_name'] =  $route->stop_name;
                $route_data['stop_km'] =  $route->stop_km;
                // $route_data['stop_fare'] =  $route->stop_fare;
                $route_data['stop_lat'] =  $route->stop_lat;
                $route_data['stop_long'] =  $route->stop_long;
                $route->note =  preg_replace("/[\n\r]/","",$route->note);
                $route_data['note'] =  strip_tags($route->note);
                
                $data[] = $route_data;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Particular Route Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }


      /*     * ***************Function school_holidays_list *******************
     * @type            : Function
     * @function name   : school_holidays_list
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : GET
     * @link            : api/user_Api/school_holidays_list
     * ******************************************************************* */     

    public function school_holidays_list_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        try{   
            if(empty($token->id) || empty($token->school_id)|| empty($token->academic_year_id)){ 
                throw new Token_missing();
            }
           
        $holiday_details = api_get_holiday_details($school_id,$academic_year_id);
        if(empty($holiday_details)){ 
            throw new No_record_found();
        }
        foreach($holiday_details as $route){
                //$route_data['id'] =  $route->id;
                $holiday['title'] =  $route->title;
                $holiday['date_from'] =  date("d-m-Y", strtotime($route->date_from));
                $holiday['date_to'] =  date("d-m-Y", strtotime($route->date_to));
                $route->note =  preg_replace("/[\n\r]/","",$route->note);
                $holiday['note'] =  strip_tags($route->note);
                
                $data[] = $holiday;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Holiday List Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }  catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
      
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
 
    }

      /*     * ***************Function library_books_list_issued_by_student *******************
     * @type            : Function
     * @function name   : library_books_list_issued_by_student
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/library_books_list_issued_by_student
     * ******************************************************************* */   

    public function library_books_list_issued_by_student_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $user_id =  $token->id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if( empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_library_books_list_issued_by_student_count($school_id,$user_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        
        $limit = 10;
        $book_details = api_library_books_list_issued_by_student($school_id,$user_id,$limit,$page,$search);
        if(empty($book_details)){ 
            throw new No_record_found();
        }
        foreach($book_details as $book){
                $book_detail['title'] =  $book->title;
                $book_detail['book_id'] =  $book->book_id;
                $book_detail['language'] =  $book->language;
                $book_detail['price'] =  $book->price;
                $book_detail['book_id'] =  $book->book_id;
                $book_detail['issue_date'] =  date("d-m-Y", strtotime($book->issue_date));
                $book_detail['due_date'] =  date("d-m-Y", strtotime($book->due_date));
                $date = date('d-m-Y');
                $book_detail['cover'] =  base_url().'/assets/uploads/book-cover/'.$book->cover;
                $diff = strtotime($date) - strtotime($book->due_date); 
                $days =  round($diff / 86400); 
                if($days>0){
                $book_detail['overdue_days'] =  $days;
                }else{
                    $book_detail['overdue_days'] =  '0';    
                }
                $data[] = $book_detail;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Student Library Book Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    } 
        catch (Token_missing $ex){ 
            $message = [
                 'status' => FALSE,
                 'message' => "Token parameters missing",
             ];
             return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
           catch (Post_params_missing $ex){ 
            $message = [
                 'status' => FALSE,
                 'message' => "Post parameters are missing",
             ];
             return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
        
           catch (No_record_found $ex){ 
            $message = [
                 'status' => FALSE,
                 'message' => "No record found",
             ];
             return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           } 
    
           catch (Page_param_missing $ex){ 
            $message = [
                 'status' => FALSE,
                 'message' => "Please provide page parameter",
             ];
             return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           } 
    }


      /*     * ***************Function library_books_history_student *******************
     * @type            : Function
     * @function name   : library_books_history_student
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/library_books_history_student
     * ******************************************************************* */   
    public function library_books_history_student_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $user_id =  $token->id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if( empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_library_books_history_student_count($school_id,$user_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        
        $limit = 10;
        $book_details = api_library_books_history_student($school_id,$user_id,$limit,$page,$search);
        if(empty($book_details)){ 
            throw new No_record_found();
        }
        foreach($book_details as $book){
                $book_detail['title'] =  $book->title;
                $book_detail['book_id'] =  $book->book_id;
                $book_detail['language'] =  $book->language;
                $book_detail['price'] =  $book->price;
                $book_detail['book_id'] =  $book->book_id;
                $book_detail['issue_date'] =  date("d-m-Y", strtotime($book->issue_date));
                $book_detail['due_date'] =  date("d-m-Y", strtotime($book->due_date));
                $book_detail['return_date'] =  date("d-m-Y", strtotime($book->return_date));
                $date = date('d-m-Y');
                $book_detail['cover'] =  base_url().'/assets/uploads/book-cover/'.$book->cover;
               
                $data[] = $book_detail;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Student History Library Book Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

      /*     * ***************Function library_all_books_list *******************
     * @type            : Function
     * @function name   : library_all_books_list
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/library_all_books_list
     * ******************************************************************* */    
    public function library_all_books_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        
        $school_id = $token->school_id;
        $user_id =  $token->id;
        
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)||empty($token->id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if( empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_library_all_books_count($school_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        
        $limit = 10;
 
        $book_details = api_library_all_books_list($school_id,$limit,$page,$search);
        if(empty($book_details)){ 
            throw new No_record_found();
        }
        foreach($book_details as $book){
                $book_detail['title'] =  $book->title;
                $book_detail['custom_id'] =  $book->custom_id;
                $book_detail['isbn_no'] =  $book->isbn_no;
                $book_detail['edition'] =  $book->edition;
                $book_detail['author'] =  $book->author;
                $book_detail['language'] =  $book->language;
                $book_detail['price'] =  $book->price;
                $book_detail['qty'] =  $book->qty;
                $book_detail['rack_no'] =  $book->rack_no;
                
                $book_detail['cover'] =  base_url().'/assets/uploads/book-cover/'.$book->cover;
               
                $data[] = $book_detail;     
        }

        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "Student Library Book Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

      /*     * ***************Function all_route_list *******************
     * @type            : Function
     * @function name   : all_route_list
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/all_route_list
     * ******************************************************************* */      
    public function all_route_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try{   
            if(empty($token->id) || empty($token->school_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if( empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_all_route_count($school_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        $limit = 10;
        $route_details = api_all_route_details($school_id,$limit,$page,$search);
        if(empty($route_details)){ 
            throw new No_record_found();
        }
        foreach($route_details as $route){
                $routes['stop_name'] =  $route->stop_name;
                $data[] = $routes;
        }
          
        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'page_count' => $record_page,
                'data' => $data,
                'message' => "All Distinct Route Lists"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

      /*     * ***************Function all_messages_list *******************
     * @type            : Function
     * @function name   : all_messages_list
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/all_messages_list
     * ******************************************************************* */       

    public function all_messages_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        $id = $token->id;
        $teacher_id = $this->input->post('teacher_id');
        $page = $this->input->post('page');
        $teacher_id = api_get_teacher_id($teacher_id);
        if(empty($teacher_id)){    
            $message = [
                'status' => FALSE,
                'message' => "Teacher not found"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
        try{   
            if(empty($token->id) || empty($token->school_id) || empty($token->academic_year_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if(empty($teacher_id)|| empty($page)){ 
                throw new Post_params_missing();
            }
        $count = api_all_messages_count($school_id,$academic_year_id,$id,$teacher_id->user_id);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
      
        $limit = 10;
        $messages_details = api_all_messages_details($school_id,$academic_year_id,$id,$teacher_id->user_id);
        if(empty($messages_details)){ 
            throw new No_record_found();
        }
        foreach($messages_details as $detail){
                $messages['id'] =  $detail->id;
                $messages['subject'] =  $detail->subject;
                $messages['body'] =  $detail->body;
                $messages['msg_created_at'] =  date("d-m-Y h:i A", strtotime($detail->msg_created_at));
                $messages['sender_id'] =  $detail->sender_id;
                $messages['receiver_id'] =  $detail->receiver_id;
                $messages['owner_id'] =  $detail->owner_id;
                $messages['is_favorite'] =  $detail->is_favorite;
                $messages['is_read'] =  $detail->is_read;
                $messages['sender'] =  $detail->sender;
                $messages['receiver'] =  $detail->receiver;

                $data[] = $messages;
        }
          
        if (!empty($data) AND $data != FALSE)
        {
            // List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "All Messages List"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }

      /*     * ***************Function all_replies_on_message *******************
     * @type            : Function
     * @function name   : all_replies_on_message
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/all_replies_on_message
     * ******************************************************************* */      
    public function all_replies_on_message_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        $id = $token->id;
        $teacher_id = $this->input->post('teacher_id');
        $message_id = $this->input->post('message_id');
        $page = $this->input->post('page');
        try{   
            if(empty($token->id) || empty($token->school_id) || empty($token->academic_year_id)){ 
                throw new Token_missing();
            }
            if(empty($page)){ 
                throw new Page_param_missing();
            }
            if(empty($teacher_id)|| empty($message_id) || empty($page)){ 
                throw new Post_params_missing();
            }
            
        $teacher_id = api_get_teacher_id($teacher_id);
           if(empty($teacher_id)){    
                $message = [
                    'status' => FALSE,
                    'message' => "Teacher not found"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        $count =api_all_replies_on_message_count($id,$teacher_id->user_id,$message_id,$search);
        if($count->count!=0){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10);
            if(($page>$record_page) ){
              $message = [
                  'status' => FALSE,
                  'message' => "Please provide valid page number"
              ];
              return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
           }
          }
        // update the is_read in message relation 
        $update_data = array( 
            'is_read'      => 1
        );
        $condition = array('message_id' => $this->input->post('message_id'), 'owner_id' => $id);
        $res = $this->UserModel->update('message_relationships', $update_data, $condition);

        $limit = 10;
        $messages_details = api_all_replies_on_message_details($id,$teacher_id->user_id,$message_id,$limit,$page,$search);
        if(empty($messages_details)){ 
            throw new No_record_found();
        }
        foreach($messages_details as $detail){
                $messages['body'] =  $detail->body;
                $messages['receiver_id'] =  $detail->receiver_id;
                $messages['sender_id'] =  $detail->sender_id;
                $messages['message_id'] =  $detail->message_id;
                $messages['created_at'] =  date("d-m-Y h:i A", strtotime($detail->created_at));
                $messages['id'] =  $detail->id;
                $messages['sender'] =  $detail->sender;
                $messages['receiver'] =  $detail->receiver;
               
                $data[] = $messages;
        }

        
        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' => $record_page,
                'message' => "All Messages List"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 

       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    }

      /*     * ***************Function replies_on_particular_message_post *******************
     * @type            : Function
     * @function name   : replies_on_particular_message_post
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/replies_on_particular_message_post
     * ******************************************************************* */ 
    public function replies_on_particular_message_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        $id = $token->id;
        $teacher_id = $this->input->post('teacher_id');
        $message_id = $this->input->post('message_id');
        $body = nl2br($this->input->post('body'));

        try
        {   
            if(empty($token->id) || empty($token->school_id) || empty($token->student_id)){ 
                throw new Token_missing();
            }
            if(empty($academic_year_id)){ 
                throw new Academic_year_missing();
            }
            if(empty($teacher_id)|| empty($message_id) || empty($body)){ 
                throw new Post_params_missing();
            }
           
                
        $teacher_id = api_get_teacher_id($teacher_id);
        $teacher_id = $teacher_id->user_id;
        $data =api_replies_on_particular_message($id,$teacher_id,$message_id,$body);
        if (!empty($data) AND $data != FALSE)
        {
            // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "Messages replied successfully"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {    
                        // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }  
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
    
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }    
       
    }

      /*     * ***************Function academic_year_get *******************
     * @type            : Function
     * @function name   : academic_year_get
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/academic_year_get
     * ******************************************************************* */  
    public function academic_year_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;
        try
        {   
            if(empty($token->id) || empty($token->school_id) || empty($token->id)){ 
                throw new Token_missing();
            }
            
            
            $output = api_get_year_list($school_id);
            if(empty($output)){ 
                throw new No_record_found();
            }
            if (!empty($output) AND $output != FALSE)
            {
                foreach ($output as $row) 
                {
                $session_array[] = array(
                    'id' => $row->id,
                    'session_year' => $row->session_year,
                    'start_year' => $row->start_year,
                    'end_year' => $row->end_year,
                    'note' => $row->note,
                    'is_running' => $row->is_running,
                    'status' => $row->status
                );
            }
            $return_data = [
                'academic_year_list' => $session_array
            ];
            // Login Success
            $message = [
                'status' => true,
                'data' => $return_data,
                'message' => "Academic Year details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else
        {
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid user details"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }  
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
   
    catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

      /*     * ***************Function ebook_details_list_post *******************
     * @type            : Function
     * @function name   : ebook_details_list_post
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/ebook_details_list_post
     * ******************************************************************* */   
    public function ebook_details_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $class_id =  $token->class_id;
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        try
    {   
        if(empty($token->id) || empty($token->school_id) || empty($token->class_id)){ 
            throw new Token_missing();
        }
        
        if(empty($page)){ 
            throw new Page_param_missing();
        }
        $count = api_get_ebook_list_count($school_id,$class_id,$search);
        if($count->count!=0){ 
          $count  = $count->count; 
          $record_page =  ceil($count/10);
          if(($page>$record_page) ){
            $message = [
                'status' => FALSE,
                'message' => "Please provide valid page number"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
         }
        }
          
        $limit = 10;
        $list =api_get_ebook_list($school_id,$class_id,$search);
        if(empty($list)){ 
            throw new No_record_found();
        }
        foreach($list as $detail){
            $messages['name'] =  $detail->name;
            $messages['author'] =  $detail->author;
            $messages['edition'] =  $detail->edition;
            $messages['language'] =  $detail->language;
            $messages['cover_image'] =  base_url().'assets/uploads/ebook/'.$detail->cover_image;
            $messages['file_name'] =  base_url().'assets/uploads/ebook/'.$detail->file_name;
            $messages['subject_name'] =  $detail->subject_name;
           
            $data[] = $messages;
        }
         if (!empty($data) AND $data != FALSE){
              // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' =>$record_page,
                'message' => "Ebook List Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
         }
       } 
       
     catch (Token_missing $ex){ 
         $message = [
              'status' => FALSE,
              'message' => "Token parameters missing",
          ];
          return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
     catch (Page_param_missing $ex){ 
         $message = [
              'status' => FALSE,
              'message' => "Please provide page parameter",
          ];
          return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
        catch (No_record_found $ex){ 
         $message = [
              'status' => FALSE,
              'message' => "No record found",
          ];
          return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }   
    }

      /*     * ***************Function student_fees_invoice_list *******************
     * @type            : Function
     * @function name   : student_fees_invoice_list
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/student_fees_invoice_list
     * ******************************************************************* */       
    public function student_fees_invoice_list_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $student_id = $token->student_id;
        $academic_year_id = $this->input->post('academic_year_id');
        $page = $this->input->post('page');
        $search = $this->input->post('search');
        $school  = $this->UserModel->get_school_by_id($school_id);
    try
    {   
        if(empty($token->id) || empty($token->school_id) || empty($token->student_id)){ 
            throw new Token_missing();
        }
        if(empty($academic_year_id)){ 
            throw new Academic_year_missing();
        }
        if(empty($page)){ 
            throw new Page_param_missing();
        }
        if(empty($academic_year_id)){ 
            throw new Post_params_missing();
        }
        $count = api_get_student_fees_list_count($school_id,$academic_year_id,$student_id,$search);
       
        if(!empty($count->count)){ 
            $count  = $count->count; 
            $record_page =  ceil($count/10); 
        }
        if(empty($record_page)){
            $message = [
                'status' => FALSE,
                'message' => "No record found"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
         }
        // Validation for no record
        if(empty($page) || ($page>$record_page) ){
            $message = [
                'status' => FALSE,
                'message' => "Please provide valid page number"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
         }
        $limit = 10;
        $list = api_get_student_fees_list_details($school_id,$academic_year_id,$student_id,$search);
        if(empty($list)){ 
            throw new No_record_found();
        }
 
        foreach($list as $detail){
            $fees['id'] =  $detail->id;
            $fees['custom_invoice_id'] =  $detail->custom_invoice_id;
            $month = explode('-',$detail->month);
            $fees['month'] =  date("F", mktime(0, 0, 0, $month[0], 10)).'-'.$month[1];
            $fees['gross_amount'] = $school->currency_symbol.$detail->gross_amount;
            $fees['net_amount'] =  $school->currency_symbol.$detail->net_amount;
            $fees['discount'] =  $detail->discount;
            $fees['paid_status'] =  $detail->paid_status;
            $fees['head'] =  $detail->head;
            $fees['session_year'] =  $detail->session_year;
            $fees['paid_amount'] =  $school->currency_symbol.$detail->paid_amount;
            $fees['created_at'] =  date("d-m-Y h:i A", strtotime($detail->created_at));
            
            $due = $detail->net_amount - $detail->paid_amount;
            if($due>0){
                $is_due = '1';
            }else{
                $is_due = '0';
            }
            $fees['due_amount'] =  $due; 
            $fees['is_due'] =  $is_due; 
            $data[] = $fees;
        }
         if(empty($list)){
            $message = [
                'status' => FALSE,
                'message' => "No data found"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
         }
         elseif (!empty($data) AND $data != FALSE){
              // Holiday List Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'page_count' =>$record_page,
                'message' => "Student Fees Detail"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
         }
    }
   
    catch (Academic_year_missing $ex){ 
       $message = [
            'status' => FALSE,
            'message' => "Please provide academic_year_id",
        ];
        return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
      }
    catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Page_param_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Please provide page parameter",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }    
  }

       /*     * ***************Function change_password *******************
     * @type            : Function
     * @function name   : change_password
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/change_password
     * ******************************************************************* */  
  public function change_password_post()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $username =  $token->username;
        $user_id =  $token->id;
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        try
    {   
        if(empty($token->id) || empty($token->school_id) ||  empty($token->id)){ 
            throw new Token_missing();
        }
        
        if(empty($old_password) || empty($new_password)){ 
            throw new Post_params_missing();
        }
        $list = api_change_check_password($school_id,$user_id,$username,$old_password,$new_password);
        if(empty($list)){ 
            throw new No_record_found();
        }
        $password = $list->password;
        if(md5($old_password) == $password){
            // If Password matches
            $data = array( 
                'password'      => md5($new_password)
            );
            $condition['id'] = $user_id;
            $res = $this->UserModel->update('users', $data, $condition);
            if($res==1){
                /** vipul start **/	
                $learn_db = $this->load->database('learn', TRUE);	
                $existing_user =  $this->db->get_where('users', array('id' => $user_id))->row();	
                $existing_username = $existing_user->username;	
    
                $learn_pass =  password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 10,]);	
                $learn_db->query("update users set password = '$learn_pass' where username = '$existing_username'");	
    
                $learn_db->close();	
               /** vipul end **/
                $message = [
                    'status' => true,
                    'message' => "Password Changed Successfully"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
             }
             else {
                $message = [
                    'status' => FALSE,
                    'message' => "New Password should not be same as Old Password"
                ];
                return $this->response($message, REST_Controller::HTTP_OK);
             }
        }else{
            $message = [
                'status' => FALSE,
                'message' => "Old Password does not matches"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
      }
      catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       
       catch (Post_params_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Post parameters are missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }    
    }
   
       /*     * ***************Function student_identity_card *******************
     * @type            : Function
     * @function name   : student_identity_card
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/student_identity_card
     * ******************************************************************* */ 
    public function student_identity_card_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
        $academic_year_id =  $token->academic_year_id;
        $class_id =  $token->class_id;
        $student_id =  $token->student_id;
        $section_id=  $token->section_id;
        $school = $this->UserModel->get_school_by_id($school_id);
        $global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();       

            try
            {   
                if(empty($token->id) || empty($token->school_id) || empty($token->id)){ 
                    throw new Token_missing();
                }

               $cards = $this->UserModel->get_student_list($school_id, $class_id, $section_id, $student_id, $academic_year_id);
              
               if(empty($cards)){ 
                throw new No_record_found();
               }

        
            $setting = $this->UserModel->get_single('id_card_settings', array('school_id'=>$school_id));
            if(empty($setting)){ 
                throw new No_record_found();
            }
 
            $data='';
            $data .= '<style>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/SMS/assets/css/card.css').'</style>';
            if(isset($cards) && !empty($cards)){ 
                    ob_start();
                    include $_SERVER['DOCUMENT_ROOT'].'/SMS/application/views/layout/api_card.php';
                    $string = ob_get_clean();
                    $data .=  $string;
                    $data .='<div class="tab-content admit-tab-content">';
            $data .='<div  class="tab-pane fade in active" id="tab_student_list">';
            $data .='<div class="x_content">';
                    
                $data .='<div class="row">';
                foreach($cards as $obj){  
                    $data .= '<div class="card-block" data-id="'.$obj->user_id.'">'; 
                    $data .= '    <div class="card-top">';
                    $data .= '        <div class="card-logo">';

                    if($setting->school_logo != ''){ 
                       $data .= '               <img width="55" height="31" src="'.UPLOAD_PATH.'logo/'.$setting->school_logo.'" alt="" />';

                                      }else if($school->logo){ 
                    $data .= '              <img  src="'.UPLOAD_PATH.'logo/'.$school->logo.'" alt="" />';
                                   }else if($school->frontend_logo){ 
                    $data .= '               <img src="'.UPLOAD_PATH.'logo/'.$school->frontend_logo.'" alt="" /> ';
                                 }else{                                                        
                    $data .= '               <img src="'.UPLOAD_PATH.'logo/'.$global_setting->brand_logo.'" alt=""  />';
                             }   
                             
                    $path = UPLOAD_PATH.'logo/'.$setting->school_logo;         
                    $data .= '        </div>';
                    $data .= '        <div class="card-school">';
                    $data .= '            <h2>';
                    if(isset($setting->school_name)){
                        $data .= $setting->school_name;
                    }else{
                        $data .= $school->school_name;
                    } 
                    $data .= '</h2>';
                    $data .= '  <p>';
                                if(isset($setting->school_address) && $setting->school_address != ''){
                                    $data .=        $setting->school_address;
                                }else{
                                    $data .= $school->address;
                                } 
                                $data .='</p>';
                    $data .= '<p>'.$this->lang->line('phone').': ';
                    
                    if(isset($setting->phone) && ($setting->phone != '')){
                        $data .= $setting->phone;
                    }else{
                        $data .= $school->phone;
                    }
                    '</p>';
                    $data .= '        </div>';
                    $data .= '    </div>';
                    $data .= '    <div class="std-id std_id_h3">';
                    $data .= '        <h3><span>'.$this->lang->line('student').' '.$this->lang->line('id').': '.$obj->user_id.'</span></h3>
                        </div>
                        <div class="card-main">
                            <div class="card-photo">';

                                if($obj->photo != ''){ 
                    $data .= '            <img src="'.UPLOAD_PATH.'student-photo/'.$obj->photo.'" alt="" />'; 
                             }else{ 
                    $data .= '            <img width="88" height="88" src="'.IMG_URL.'/default-user.png" alt=""  />'; 
                                 }
                    $data .= '        </div>';
                    $data .= '        <div class="card-info">
                                <p><span class="card-title">'.$this->lang->line('student').' '.$this->lang->line('name').'</span><span class="card-value">: '.$obj->name.'</span></p>';
                    $data .= '             <p><span class="card-title">'.$this->lang->line('class').'</span><span class="card-value">: '.$obj->class_name.'</span></p>';

                    $data .=' <p><span class="card-title">'.$this->lang->line('section').'</span><span class="card-value">: '.$obj->section.'</span></p>';

                    $data .='            <p><span class="card-title">'.$this->lang->line('roll_no').'</span><span class="card-value">: '.$obj->roll_no.'</span></p>';

                    $data .='<p><span class="card-title">'.$this->lang->line('blood_group').'</span><span class="card-value">: '.$this->lang->line($obj->blood_group).'</span></p>';

                    $data .='<p><span class="card-title">'.$this->lang->line('birth_date').'</span><span class="card-value">: '.date($global_setting->date_format, strtotime($obj->dob)).'</span></p>
                            </div>
                        </div>
                        <div class="card-bottom">';

                        $data .='    <p>';
                        $data .= isset($setting->bottom_text) ? $setting->bottom_text : '';
                        $data .='</p>
                        </div>
                    </div> ';

                    $student_id = $obj->user_id;   
             } 
           $data .='</div></div></div></div>';  
           //echo $data;die(); //  For Checking the HTML  
            } 
            if ($data) {
                $message = [
                    'status' => true,
                    'data' => $data,
                    'pdf_name' => 'Student_'.$student_id,
                    'message' => "Student Card Data"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
             }else{
                $message = [
                    'status' => FALSE,
                    'message' => "Unable to create HTML Something went wrong , please check HTML data"
                ];
                return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
            }
            

            }
       catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
     
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }   
  }
     
       /*     * ***************Function student_admit_card *******************
     * @type            : Function
     * @function name   : student_admit_card_post
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/student_admit_card
     * ******************************************************************* */ 
  public function student_admit_card_post()
  {
      $_POST = $this->security->xss_clean($_POST);
      $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
       $token = $token['data'];
      //$token = $this->authorization_token->userData();
      $school_id = $token->school_id;
      $academic_year_id =  $token->academic_year_id;
      $class_id =  $token->class_id;
      $student_id =  $token->student_id;
      $section_id=  $token->section_id;
      $exam_id = $this->input->post('exam_id');
      $global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();  
      $school = $this->UserModel->get_school_by_id($school_id);
      $exam = $this->UserModel->get_single('exams', array('id'=>$exam_id));
      $subjects = $this->UserModel->get_list('subjects', array('class_id'=>$class_id, 'school_id'=>$school_id));
    try
          {   
              if(empty($token->id) || empty($token->school_id) || empty($token->id)){ 
                  throw new Token_missing();
              }
            
              if(empty($exam_id)){ 
                throw new Post_params_missing();
              }

             $cards = $this->UserModel->get_student_list($school_id, $class_id, $section_id, $student_id, $academic_year_id);
          
             if(empty($cards)){ 
              throw new No_record_found();
              }

              $admit_setting= $this->UserModel->get_single('admit_card_settings', array('school_id'=>$school_id));

             if(empty($admit_setting)){ 
              throw new No_record_found();
             }
          // Starting creating the HTML
                  $data='';
                  $data .= '<style>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/SMS/assets/css/card.css').'</style>';
                  ob_start();
                  include $_SERVER['DOCUMENT_ROOT'].'/SMS/application/views/layout/api_card.php';
                  $string = ob_get_clean();
                  $data .=  $string;
                           
                 
                  $data .='<div class="tab-content admit-tab-content">';
                  $data .='<div  class="tab-pane fade in active" id="tab_student_list">';
                  $data .=    '<div class="x_content">';
                          
                  $data .=       '<div class="row">';
                             
                              if(isset($cards) && !empty($cards)){ 
                                   foreach($cards as $obj){   
                                    $data .=   '<div class="admit-card-block">';
                                    $data .=   '<div class="admit-card-top">';
                                    $data .=   '<div class="admit-card-logo admit_card_logo_img">';
                                                    if($admit_setting->school_logo != ''){ 
                                                    $data .=  '<img src="'.UPLOAD_PATH.'logo/'. $admit_setting->school_logo.'" alt="" /> ';
                                                   }else if($school->logo){ 
                                                    $data .='<img src="'.UPLOAD_PATH.'logo/'.$school->logo.'" alt="" />'; 
                                                   }else if($school->frontend_logo){ 
                                                    $data .='<img src="'.UPLOAD_PATH.'logo/'.$school->frontend_logo.'" alt="" />'; 
                                                   }else{                                                         
                                                    $data .='<img src="'.UPLOAD_PATH.'logo/'. $global_setting->brand_logo.'" alt=""  />';
                                                   }                                                         
                                                  $data .= '</div>';
                                                  $data .='<div class="admit-card-school">';
                                                  $data .=  '<h2>';
                                                  if(isset($admit_setting->school_name)){
                                                    $data .=  $admit_setting->school_name;
                                                  }else{
                                                       $school->school_name;
                                                  } 
                                                  $data .=  '</h2>';

                                                  $data .='<p>';
                                                  
                                                  if(isset($admit_setting->school_address) && $admit_setting->school_address != ''){
                                                    $data .= $admit_setting->school_address;
                                                  }else{
                                                    $data .= $school->address;
                                                  } 
                                                  $data .='</p>';
                                                  $data .=  '<p>'.$this->lang->line('phone').':';
                                                  if(isset($admit_setting->phone) && $admit_setting->phone != ''){
                                                    $data .=$admit_setting->phone;
                                                  }else{
                                                    $data .=$school->phone;
                                                  }
                                                  $data .='</p>';
                                                  $data .='</div>';
                                                  $data .='</div>';
                                                  $data .=' <div class="admit-card">';
                                                  $data .=  '<h3><span>'.$this->lang->line('student').' '.$this->lang->line('admit').' '.$this->lang->line('card').'</span></h3>';
                                                  $data .='</div>';
                                                  $data .= '<div class="admit-card-main">';                                                    
                                                  $data .='<div class="admit-card-photo">';
                                                   if($obj->photo != ''){ 
                                                    $data .='<img src="'.UPLOAD_PATH.'student-photo/'.$obj->photo.'" alt="" />'; 
                                                   }else{ 
                                                    $data .= '<img src="'.IMG_URL.'/default-user.png" alt=""  />'; 
                                                   } 
                                                  $data .='</div>';
                                                  $data .='<div class="admit-card-info">
                                                  <p><span class="admit-card-title">'.$this->lang->line('student').$this->lang->line('id').'</span><span class="admit-card-value">: '.$obj->roll_no.'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('student').$this->lang->line('name').'</span><span class="admit-card-value">: '.$obj->name.'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('class').'</span><span class="admit-card-value">: '.$obj->class_name.'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('section').'</span><span class="admit-card-value">: '.$obj->section.'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('roll_no').'</span><span class="admit-card-value">: '.$obj->roll_no.'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('blood_group').'</span><span class="admit-card-value">: '.$this->lang->line($obj->blood_group).'</span></p>
                                                  <p><span class="admit-card-title">'.$this->lang->line('birth_date').'</span><span class="admit-card-value">: '.date($global_setting->date_format, strtotime($obj->dob)).'</span></p>
                                              </div>';
                                              $data .='<div class="admit-card-subject">
                                                  <div class="admit-exam">'.$this->lang->line('exam').': '.$exam->title.'</div>
                                                  <div class="subject-heading card_subject-heading">'.$this->lang->line('exam').' '.$this->lang->line('subject').':</div>';

                                                  
                                                  $data .='<div class="exam-subjects">';
                                                       if(isset($subjects) && !empty($subjects)){                                                             
                                                        $data .= '<ol>';        
                                                           foreach($subjects as $sub){                                                                
                                                            $data .= '<li>'.$sub->name.'</li>';  
                                                            }  
                                                           $data .='</ol>';
                                                       }  
                                                      $data .='</div>';
                                                      $data .='</div>';
                                                      $data .='</div>';
                                                      $data .= '<div class="admit-card-bottom">';
                                                      $data .='<p>';
                                                      if(isset($admit_setting->bottom_text)){
                                                        $data .= $admit_setting->bottom_text;
                                                      }else{
                                                        $data .='';
                                                      }
                                                      $data .='</p>';
                                                      $data .='</div>';
                                                      $data .='</div>';

                             $data .='</div>';
                          
                             $data .=' </div>'; 
                             $data .='</div>';
                             $data .= '</div>';  

                $exam_title =  $exam->title;
                $student_id = $obj->user_id;   
                $card = 'Student_'.$student_id.'_'.$exam_title;
           } 
             //echo $data;die();  // To Check if HTML is created successfully  
     if ($data) {
        $message = [
            'status' => true,
            'data' => $data,
            'pdf_name' => $card,
            'message' => "File Data"
        ];
        return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
      }else{
        $message = [
            'status' => FALSE,
            'message' => "Unable to create HTML Something went wrong , please check HTML data"
        ];
        return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
    }
  
          } 
          
 
          }
     catch (Token_missing $ex){ 
      $message = [
           'status' => FALSE,
           'message' => "Token parameters missing",
       ];
       return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
     }
     
     catch (Post_params_missing $ex){ 
      $message = [
           'status' => FALSE,
           'message' => "Post parameters are missing",
       ];
       return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
     }

     catch (No_record_found $ex){ 
      $message = [
           'status' => FALSE,
           'message' => "No record found",
       ];
       return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
     }   
}

       /*     * ***************Function student_invoice_details *******************
     * @type            : Function
     * @function name   : student_invoice_details
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/student_invoice_details
     * ******************************************************************* */ 
public function student_invoice_details_post()
  {
      $_POST = $this->security->xss_clean($_POST);
      $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
      //$token = $this->authorization_token->userData();
      $school_id = $token->school_id;
      $academic_year_id =  $token->academic_year_id;
      $class_id =  $token->class_id;
      $student_id =  $token->student_id;
      $section_id=  $token->section_id;
      $invoice_id =  $this->input->post('invoice_id');
      try
      {   
          if(empty($token->id) || empty($token->school_id) || empty($token->id)){ 
              throw new Token_missing();
          }
        
          if(empty($invoice_id)){ 
            throw new Post_params_missing();
          }

         $cards = $this->UserModel->get_student_list($school_id, $class_id, $section_id, $student_id, $academic_year_id);
      
         if(empty($cards)){ 
          throw new No_record_found();
          }

        $global_setting = $this->db->get_where('global_setting', array('status'=>1))->row();       

        $invoice_next     = $this->UserModel->get_invoice_amount($invoice_id);  
        $paid_amount = $invoice_next->paid_amount;
        
        $invoice = $this->UserModel->get_single_invoice($school_id,$academic_year_id,$class_id,
        $student_id, $invoice_id);
        $due = $invoice->net_amount-$paid_amount;
        $school        = $this->UserModel->get_school_by_id($school_id);
        ob_start();
        $data .= '<style>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/SMS/assets/css/custom.css').'</style>';
        $data .= '<style>'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/SMS/assets/vendors/bootstrap/bootstrap.min.css').'</style>';

        
        $string = ob_get_clean();
        $data .= $string; 
        $data .= '<div class="x_content">';
        $data .= ' <section class="content invoice profile_img profile_img_invoice" style="text-align: center;
		/* background: #f7f7f7;*/
		margin-bottom: 20px;
		background-image: url('.base_url().'assets/images/banner-bg.png)!important;
		min-height: 200px;">';
        $data .= '    <div class="col-md-12 col-sm-12">';
        $data .= '          <div class="row">';
                 $data .= '<div class="col-md-6 col-sm-6 col-xs-6 invoice-header">';
                 $data .= '       <h1>'.$this->lang->line('invoice').'</h1>';
                 $data .= '    </div>';
                 $data .= '  <div class="col-md-6 col-sm-6 col-xs-6 invoice-header text-center">';
                          if($school->logo){ 
                            $data .= ' <img src="'.UPLOAD_PATH.'/logo/'.$school->logo.'" alt="" />'; 
                          }else if($school->frontend_logo){ 
                            $data .= '  <img src="'.UPLOAD_PATH.'logo/'.$school->frontend_logo.'" alt="" />'; 
                          }else{                                                         
                            $data .= '<img src="'.UPLOAD_PATH.'logo/'.$global_setting->brand_logo.'" alt=""  />';
                          }
                          $data .='    </div>';
                          $data .='</div>';
                 
                
                $data .= ' <div class="row invoice-info">';
                $data .= '      <div class="col-md-4 col-sm-4 col-xs-4 invoice-col text-left">';
                $data .= '         <strong>'.$this->lang->line('school').':</strong>';
                $data .= '        <address>'.$school->school_name;
         
                            $data .= '             <br>'.$school->address;
                 $data .= '           <br>'.$this->lang->line('phone').': '.$school->phone;
                 $data .= '             <br>'.$this->lang->line('email').': '.$school->email;
                 $data .= '         </address>';

                 $data .= '    </div>';
                    $data .= '   <div class="col-md-4 col-sm-4 col-xs-4 invoice-col text-left">';
                    $data .= '        <strong>'.$this->lang->line('student').':</strong>';
                    $data .= '     <address>'.$invoice->name;
                            
                            $data .= '        <br>'.$invoice->present_address;
                            $data .= '          <br>'.$this->lang->line('class').': '.$invoice->class_name;
                            $data .= '        <br>'.$this->lang->line('phone').': '. $invoice->phone;
                            $data .= '     </address>';
                            $data .= '     </div>';
                    $data .= '    <div class="col-md-4 col-sm-4 col-xs-4 invoice-col text-left">';
                    $data .= '        <b>'.$this->lang->line('invoice').' #'.$invoice->custom_invoice_id.'</b>';                                                     
                    $data .= '     <br>';
                    $data .= '        <b>'.$this->lang->line('payment').$this->lang->line('status').':</b> <span class="btn-success">'.get_paid_status($invoice->paid_status).'</span>';
                    $data .= '          <br>';
                    $data .= '       <b>'.$this->lang->line('date').':</b>'.date($global_setting->date_format, strtotime($invoice->date));
                    $data .= '     </div>';
                   
                    $data .= '   </div>';
                $data .= '     </div>';
                $data .= '   </section>';
                $data .= '  <section class="content invoice">';
            $data .= '   <div class="row">';
            $data .= '        <div class="col-xs-12 table">';
            $data .= '         <table class="table table-striped">';
            $data .= '               <thead>';
            $data .= '                  <tr>';
            $data .= '                        <th>'.$this->lang->line('sl_no').'</th>';
            $data .= '                     <th>'.$this->lang->line('fee_type').'</th>';
            $data .= '                  <th>'.$this->lang->line('note').'</th>';
            $data .= '                      <th>'.$this->lang->line('amount').'</th>';
            $data .= '               </tr>';
            $data .= '            </thead>';
            $data .= '           <tbody>    ';                               
            $data .= '                   <tr>';
            $data .= '                     <td  style="width:15%">1</td>';
            $data .= '                    <td  style="width:25%"> '.$invoice->head.'</td>';
            $data .= '                      <td  style="width:35%"> '.$invoice->note.'</td>';
            $data .= '                     <td>'.$school->currency_symbol.$invoice->net_amount.'</td>';
            $data .= '                  </tr>';                                          
            $data .= '               </tbody>';
            $data .= '         </table>';
            $data .= '      </div>';
                $data .= '    </div>';

            $data .= '   <div class="row">';
                $data .= '       <div class="col-xs-6">';
                $data .= '              <p class="lead">'.$this->lang->line('payment').$this->lang->line('method').':</p>';
                $data .= '             <img src="'.IMG_URL.'visa.png" alt="Visa">';
                $data .= '     <img src="'.IMG_URL.'mastercard.png" alt="Mastercard">';
                $data .= '           <img src="'.IMG_URL.'american-express.png" alt="American Express">';
                $data .= '          <img src="'.IMG_URL.'paypal.png" alt="Paypal">';                         
                $data .= '       </div>';
                $data .= '     <div class="col-xs-6">';
                $data .= '      <div class="table-responsive">';
                $data .= '           <table class="table">';
                $data .= '                <tbody>';
                $data .= '                      <tr>';
                $data .= '                   <th style="width:50%">'.$this->lang->line('subtotal').':</th>';
                $data .= '                     <td>'.$school->currency_symbol.$invoice->gross_amount.'</td>';
                $data .= '                    </tr>';
                $data .= '                 <tr>';
                $data .= '                        <th>'.$this->lang->line('discount').'</th>';
                $data .= '                         <td>'.$school->currency_symbol.$invoice->inv_discount.'</td>';
                $data .= '               </tr>';
                $data .= '                    <tr>';
                $data .= '                      <th>'.$this->lang->line('total').':</th>';
                $data .= '                     <td>'.$school->currency_symbol.$invoice->net_amount.'</td>';
                $data .= '                    </tr>';
                $data .= '                 <tr>';
                $data .= '                      <th>'.$this->lang->line('paid').' '.$this->lang->line('amount').':</th>';
                $data .= '                      <td>';
                
                  if($paid_amount > 0){
                  $data .= $school->currency_symbol;
                  $data .= $paid_amount;
                   }else{
                    $data .= '0.00';
                  }    
                      '</td>';
                $data .= '               </tr>';
                $data .= '                 <tr>';
                $data .= '                     <th>'.$this->lang->line('due_amount').':</th>';
                $data .= '                   <td><span class="btn-danger" style="padding: 5px">'.$school->currency_symbol.$due.'</span></td>';
                $data .= '                </tr>';
                 if($invoice->paid_status == 'paid'){ 
                $data .= '                    <tr>';
                $data .= '                        <th>'.$this->lang->line('paid').$this->lang->line('date').':</th>';
                $data .= '              <td>'.date($global_setting->date_format, strtotime($invoice->date)).'</td>';
                $data .= '          </tr>';
                       } 
                $data .= '  </tbody>';
                $data .= '        </table>';
                $data .= '    </div>';
                $data .= '</div>';
                $data .= '</div>';


                $data .= ' </section>';
                $data .= '</div>';
                //echo $data;die();  // Commeted to check the HTML
                if ($data) {
                    $message = [
                        'status' => true,
                        'data' => $data,
                        'pdf_name' => $invoice->custom_invoice_id,
                        'message' => "Student Invoice Details"
                    ];
                    return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                  }
                  else {
                    $message = [
                        'status' => FALSE,
                        'message' => "Something went wrong, please check html data"
                    ];
                    return $this->response($message, REST_Controller::HTTP_OK);
                  }

  }
   catch (Token_missing $ex){ 
    $message = [
         'status' => FALSE,
         'message' => "Token parameters missing",
     ];
     return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
   }
   
   catch (Post_params_missing $ex){ 
    $message = [
         'status' => FALSE,
         'message' => "Post parameters are missing",
     ];
     return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
   }

   catch (No_record_found $ex){ 
    $message = [
         'status' => FALSE,
         'message' => "No record found",
     ];
     return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
   }
  }

       /*     * ***************Function forget_password *******************
     * @type            : Function
     * @function name   : forget_password
     * @description     : this function used to get the send student's message to particular Teacher
     * @param           : route_id,page
     * @method          : POST
     * @link            : api/user_Api/forget_password
     * ******************************************************************* */ 
  public function forget_password_post()
  {
      $_POST = $this->security->xss_clean($_POST);
      $username = $this->input->post('username');
      $headerStringValue = $_SERVER['HTTP_X_API_KEY'];
      $encryption_key = $this->config->item('encryption_key');
    try
          {   
              if(empty($headerStringValue)){ 
                throw new Api_key_missing();
              }

              if(empty($headerStringValue==$encryption_key)){ 
                throw new Api_key_mismatch();
              }

              if($headerStringValue==$encryption_key){
                $data['username'] = $this->input->post('username');
                $data['status'] = 1;
                $login = $this->auth->get_single('users', $data);
                if(empty($login)){ 
                    throw new No_record_found();
                }
                if($this->_send_email($login)){
                        $message = [
                            'status' => true,
                            'message' => "Email send successfully to the user"
                        ];
                        return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }else{
                    $message = [
                        'status' => FALSE,
                        'message' => "Unable to send mail , please check mail settings and email id"
                    ];
                    return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
                }
              }
          }
     catch (Api_key_missing $ex){ 
      $message = [
           'status' => FALSE,
           'message' => "API key is missing in api request ",
       ];
       return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
     }
     
     catch (Api_key_mismatch $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "API key does not match ",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }

     catch (No_record_found $ex){ 
      $message = [
           'status' => FALSE,
           'message' => "No record found",
       ];
       return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
     }   
}

    /*     * ***************Function _send_email**********************************
     * @type            : Function
     * @function name   : _send_email
     * @description     : this function used to send recover forgot password email 
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */

    private function _send_email($data) {

        $profile = get_user_by_role($data->role_id, $data->id);
        if($profile->email){
            
            $from_email = FROM_EMAIL;
            $from_name = FROM_NAME;        
                  
            $school_id     = $data->school_id ? $data->school_id : 0;             
            if($school_id){       
                $school = $this->auth->get_single('schools', array('status' => 1, 'id'=>$school_id));
            }            
            
            $email_setting = $this->auth->get_single('email_settings', array('status' => 1, 'school_id'=>$school_id)); 
            
            if(!empty($email_setting)){
                $from_email = $email_setting->from_address;
                $from_name  = $email_setting->from_name;  
            }elseif(!empty($school)){
                $from_email = $school->email;
                $from_name  = $school->school_name;  
            }
                
            if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                $config['protocol']     = 'smtp';
                $config['smtp_host']    = $email_setting->smtp_host;
                $config['smtp_port']    = $email_setting->smtp_port;
                $config['smtp_timeout'] = $email_setting->smtp_timeout ? $email_setting->smtp_timeout  : 5;
                $config['smtp_user']    = $email_setting->smtp_user;
                $config['smtp_pass']    = $email_setting->smtp_pass;
                $config['smtp_crypto']  = $email_setting->smtp_crypto ? $email_setting->smtp_crypto  : 'tls';
                $config['mailtype'] = isset($email_setting) && $email_setting->mail_type ? $email_setting->mail_type  : 'html';
                $config['charset']  = isset($email_setting) && $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
                $config['priority']  = isset($email_setting) && $email_setting->priority ? $email_setting->priority  : '3';
                
            }elseif(!empty($email_setting) && $email_setting->mail_protocol != 'smtp'){
                $config['protocol'] = $email_setting->mail_protocol;
                $config['mailpath'] = '/usr/sbin/'.$email_setting->mail_protocol; 
                $config['mailtype'] = isset($email_setting) && $email_setting->mail_type ? $email_setting->mail_type  : 'html';
                $config['charset']  = isset($email_setting) && $email_setting->char_set ? $email_setting->char_set  : 'iso-8859-1';
                $config['priority']  = isset($email_setting) && $email_setting->priority ? $email_setting->priority  : '3';
                
            }else{// default    
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail'; 
            }                             
            
            
            $config['wordwrap'] = TRUE;            
            $config['newline']  = "\r\n";            
            
            
            $this->load->library('email');
            $this->email->initialize($config);
            

            $this->email->from($from_email, $from_name);
            $this->email->to($profile->email);
            $subject = 'Password reset Email from : '. $from_name;
            $this->email->subject($subject);
            $key = uniqid();
            $this->auth->update('users', array('reset_key' => $key), array('id' => $data->id));

            $message = 'You have requested to reset your ' . $from_name . ' web Application login password.<br/>';
            $message .= 'To reset you password plese click following url<br/><br/>';
            $message .= site_url('auth/reset/' . $key);
            $message .= '<br/><br/>';
            $message .= 'If you did not request to reset your password, Plesae ignore this email.<br/><br/>';
            $message .= 'Thank you<br/>';
            $message .= $from_name;

            $this->email->message($message);
                       
            if(!empty($email_setting) && $email_setting->mail_protocol == 'smtp'){
                 $this->email->send(); 
            }else{
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From:  $from_name < $from_email >\r\n";
                $headers .= "Reply-To:  $from_name < $from_email >\r\n"; 
                mail($profile->email, $subject, $message, $headers);
            } 
            
            return TRUE;
        }else{

            return FALSE; $message = [
           'status' => FALSE,
           'message' => "User email not found, please set the email id to reset the password",
          ];
          return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /*     * ***************Function school_details_get**********************************
     * @type            : Function
     * @function name   : school_details_get
     * @description     : this function used to get all school informations
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */
    public function school_details_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $verify_api_key = authenticate_api_key($this);
        if ($verify_api_key['status'] == false) {
            return $this->response($verify_api_key, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $this->authorization_token->validateToken();

        if ($token['status'] == false) {
            return $this->response($token, REST_Controller::HTTP_NOT_FOUND);
        }
        $token = $token['data'];
        //$token = $this->authorization_token->userData();
        $school_id = $token->school_id;
       
        try{   
            if(empty($token->id) || empty($token->school_id) ||empty($token->class_id) ||empty($token->academic_year_id) ){ 
                throw new Token_missing();
            }

        $schools = api_get_school_details($school_id);    
        if(empty($schools)){ 
            throw new No_record_found();
        }
       
                $study_data['school_name'] =  $schools->school_name;
                $study_data['address'] =  $schools->address;
                $study_data['phone'] =  $schools->phone;
                $study_data['email'] =  $schools->email;
                $study_data['currency'] =  $schools->currency;
                $study_data['currency_symbol'] =  $schools->currency_symbol;
                $study_data['logo'] =  base_url().'/assets/uploads/logo/'.$schools->logo;
                $mother_photo = base_url().'/assets/uploads/logo/'.$schools->frontend_logo;
                $study_data['frontend_logo'] =  base_url().'/assets/uploads/logo/'.$schools->frontend_logo;
                $study_data['academic_year_id'] =  $schools->academic_year_id;
                $study_data['academic_year'] =  $schools->academic_year;
                $study_data['school_fax'] =  $schools->school_fax;
                $study_data['facebook_url'] =  $schools->facebook_url;
                $study_data['twitter_url'] =  $schools->twitter_url;
                $study_data['linkedin_url'] =  $schools->linkedin_url;
                $study_data['youtube_url'] =  $schools->youtube_url;
                $study_data['instagram_url'] =  $schools->instagram_url;

                $data[] =$study_data;     
     

        if (!empty($data) AND $data != FALSE)
        {
            // Exam Details Success
            $message = [
                'status' => true,
                'data' => $data,
                'message' => "School Details"
            ];
            return $this->response($message, REST_Controller::HTTP_OK);
        } 
        else{
            // Login Error
            $message = [
                'status' => FALSE,
                'message' => "Invalid Username or Password"
            ];
            return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
        }
     }  
     catch (Token_missing $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "Token parameters missing",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       }
   
       catch (No_record_found $ex){ 
        $message = [
             'status' => FALSE,
             'message' => "No record found",
         ];
         return $this->response($message, REST_Controller::HTTP_NOT_FOUND);
       } 
    }

}


/*

*/