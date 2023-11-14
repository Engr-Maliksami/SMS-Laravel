<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * ***************Ajax.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Ajax
 * @description     : This class used to handle ajax call from view file 
 *                    of whole application.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Ajax extends My_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('Ajax_Model', 'ajax', true);
    }

    /**     * *************Function get_user_by_role**********************************
     * @type            : Function
     * @function name   : get_user_by_role
     * @description     : this function used to manage user role list for user interface   
     * @param           : null 
     * @return          : $str string value with user role list 
     * ********************************************************** */
    public function get_user_by_role() {

        $role_id = $this->input->post('role_id');
        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $user_id = $this->input->post('user_id');
        $message = $this->input->post('message');

        $school = $this->ajax->get_school_by_id($school_id);
         
        $users = array();
        if ($role_id == SUPER_ADMIN) {
            $users = $this->ajax->get_list('system_admin', array('status' => 1), '', '', '', 'id', 'ASC');
        }elseif ($role_id == TEACHER) {
            $users = $this->ajax->get_list('teachers', array('status' => 1,'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        } elseif ($role_id == GUARDIAN) {
            $users = $this->ajax->get_list('guardians', array('status' => 1,'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        } elseif ($role_id == STUDENT) {
            
            if ($class_id) {
                $users = $this->ajax->get_student_list($class_id, $school_id, $school->academic_year_id);
            } else {
                $users = $this->ajax->get_list('students', array('status' => 1,'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            }
            
        } else {

            $this->db->select('E.*');
            $this->db->from('employees AS E');
            $this->db->join('users AS U', 'U.id = E.user_id', 'left');
            $this->db->where('U.role_id', $role_id);
            $this->db->where('E.school_id', $school_id);
            $users = $this->db->get()->result();            
        }

        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if (!$message && !empty($users)) {
            $str .= '<option value="0">' . $this->lang->line('all') . '</option>';
        }

        $select = 'selected="selected"';
        if (!empty($users)) {
            foreach ($users as $obj) {
                
                //if(logged_in_user_id() == $obj->user_id){continue;}
                
                $selected = $user_id == $obj->user_id ? $select : '';
                $str .= '<option value="' . $obj->user_id . '" ' . $selected . '>' . $obj->name . '(' . $obj->id . ')</option>';
            }
        }

        echo $str;
    }

    /*     * **************Function get_tag_by_role**********************************
     * @type            : Function
     * @function name   : get_tag_by_role
     * @description     : this function used to manage user role tag list for user interface   
     * @param           : null 
     * @return          : $str string value with user role tag list 
     * ********************************************************** */

    public function get_tag_by_role() {

        $role_id = $this->input->post('role_id');
        $tags = get_template_tags($role_id);
        $str = '';
        foreach ($tags as $value) {
            $str .= '<span> ' . $value . ' </span>';
        }

        echo $str;
    }

    /**     * *************Function update_user_status**********************************
     * @type            : Function
     * @function name   : update_user_status
     * @description     : this function used to update user status   
     * @param           : null 
     * @return          : boolean true/false 
     * ********************************************************** */
    public function update_user_status() {

        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        if ($this->ajax->update('users', array('status' => $status), array('id' => $user_id))) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

    /**     * *************Function get_student_by_class**********************************
     * @type            : Function
     * @function name   : get_student_by_class
     * @description     : this function used to populate student list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with student list
     * ********************************************************** */
    public function get_student_by_class() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $student_id = $this->input->post('student_id');
        $is_bulk = $this->input->post('is_bulk');
         
        $school = $this->ajax->get_school_by_id($school_id);
        $students = $this->ajax->get_student_list($class_id, $school_id, $school->academic_year_id);

        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if($is_bulk){
             $str .= '<option value="all">' . $this->lang->line('all') . '</option>';
        }
        
        $select = 'selected="selected"';
        if (!empty($students)) {
            foreach ($students as $obj) {
                $selected = $student_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . ' [' . $obj->roll_no . ']</option>';
            }
        }

        echo $str;
    }

    
    
    /**     * *************Function get_section_by_class**********************************
     * @type            : Function
     * @function name   : get_section_by_class
     * @description     : this function used to populate section list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with section list
     * ********************************************************** */
      public function get_section_by_class() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        
        $sections = $this->ajax->get_list('sections', array('status' => 1, 'school_id'=>$school_id, 'class_id' => $class_id), '', '', '', 'id', 'ASC');
        
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
    
        $guardian_section_data = get_guardian_access_data('section');
        
        $select = 'selected="selected"';
        if (!empty($sections)) {
            foreach ($sections as $obj) {
                
               if ($this->session->userdata('role_id') == GUARDIAN && !in_array($obj->id, $guardian_section_data)) { continue; } 
               elseif ($this->session->userdata('role_id') == TEACHER && $obj->teacher_id != $this->session->userdata('profile_id')) { continue; } 
               
                $selected = $section_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
            }
        }

        echo $str;
    }

    /*     * **************Function get_student_by_section**********************************
     * @type            : Function
     * @function name   : get_student_by_section
     * @description     : this function used to populate student list by section 
      for user interface
     * @param           : null 
     * @return          : $str string  value with student list
     * ********************************************************** */

    public function get_student_by_section() {

        $student_id = $this->input->post('student_id');
        $section_id = $this->input->post('section_id');
        $school_id = $this->input->post('school_id');
        $is_all = $this->input->post('is_all');

        $students = $this->ajax->get_student_list_by_section($school_id, $section_id);
        
        if($is_all){
            $str = '<option value="0">' . $this->lang->line('all'). ' ' .$this->lang->line('student') . '</option>';    
        }else{
            $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
        }
        
        $select = 'selected="selected"';
        if (!empty($students)) {
            foreach ($students as $obj) {
                $selected = $student_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . ' [' . $obj->roll_no . ']</option>';
            }
        }

        echo $str;
    }

    /**     * *************Function get_subject_by_class**********************************
     * @type            : Function
     * @function name   : get_subject_by_class
     * @description     : this function used to populate subject list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with subject list
     * ********************************************************** */
    public function get_subject_by_class() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
       
        if($this->session->userdata('role_id') == TEACHER){
            $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id,  'teacher_id'=>$this->session->userdata('profile_id')), '', '', '', 'id', 'ASC');
        }else{
            $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }
       
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
       
        $select = 'selected="selected"';
        if(!empty($subjects)) {
            foreach ($subjects as $obj) {
                $selected = $subject_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
            }
        }

        echo $str;
    }

    /**     * *************Function get_subject_by_class_school**********************************
     * @type            : Function
     * @function name   : get_subject_by_class_school
     * @description     : this function used to populate subject list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with subject list
     * ********************************************************** */
    public function get_subject_by_class_school() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $exam_id = $this->input->post('exam_id');
        
        if($this->session->userdata('role_id') == TEACHER){
            $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id,  'teacher_id'=>$this->session->userdata('profile_id')), '', '', '', 'id', 'ASC');
        }else{
            $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }
       
           $exam_types = $this->ajax->get_exam_types();
           if($exam_id){
               $edit_exam_types = $this->ajax->get_edit_exam_types($exam_id);
           }
           
            //echo $exam_id;die();
           //echo '<pre>';print_r($edit_exam_types); die();
           //echo '<pre>';print_r($subjects); die();
  
            $str .=     '<div class="container">';
            $str .= '<div class="row ">';
            $str .='    <div class="col-md-12 col-sm-12 col-xs-12">';
            $str .='        <div id="treeview-checkbox-demo">';
                       if(!empty($subjects)) {
                          foreach ($subjects as $obj) {
        if($exam_id){
            $str .='        <div class="parent-check">';
                    foreach ($edit_exam_types as $edit) { 
                        if($edit->subject_id===$obj->id){
                            $j=1;break;
                        }else{

                            $j=0;
                        }

                    }
            $error_div = '<div class="help-block">'.form_error('note').'</div>';        
            if($j==1){
                $str .='<input class="switch-parent" type="checkbox" checked value="'.$obj->id.'"  name="subjects[]" id="'.$obj->id.'">'.$obj->name;
            }else{
                $str .='<input class="switch-parent" type="checkbox" value="'.$obj->id.'"  name="subjects[]" id="'.$obj->id.'">'.$obj->name;
            }
             
        }else{
            $str .='        <div class="parent-check">';
            $str .='<input class="switch-parent" type="checkbox" value="'.$obj->id.'"  name="subjects[]" id="'.$obj->id.'">'.$obj->name;
        }
            $str.=$error_div;
            if(!empty($exam_types)) {
                            foreach ($exam_types as $mark) {
                        if($exam_id){   
                                $i=0;$max_marks=0;
                                foreach ($edit_exam_types as $edit) {  
                                         if($edit->subject_id===$obj->id && $edit->exam_type_id==$mark->id){
                                             $i=1;
                                             $max_marks = $edit->max_marks; 
                                             break;
                                         }else{
                                            $i=0;
                                         }
                                }
                                if($j==1){
                                    $str .='               <div class="child-check active table-display" >';
                                }else{
                                    $str .='               <div class="child-check table-display" >';
                                }    
                               if($i==1){
                                $str  .='<label class="switch"><input type="checkbox" value="'.$obj->id.'-'.$mark->id.'" name="exam_types[]" checked id="'.$mark->id.'"/><span class="slider"></span></label><span class="mark-span">'.$mark->name.'</span> <input type="number" placeholder="Max Marks" name="marks[]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" min="0" value="'.$max_marks.'"  />';
                               }else{
                                $str  .='<label class="switch"><input type="checkbox" value="'.$obj->id.'-'.$mark->id.'" name="exam_types[]" id="'.$mark->id.'"/><span class="slider"></span></label><span class="mark-span">'.$mark->name.'</span> <input type="number" placeholder="Max Marks" name="marks[]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" min="0" value="0" disabled />';      
                               }
                        }else{

                            $str .='               <div class="child-check table-display" >';
                            $str  .='<label class="switch"><input type="checkbox" value="'.$obj->id.'-'.$mark->id.'" name="exam_types[]" id="'.$mark->id.'"/><span class="slider"></span></label><span class="mark-span">'.$mark->name.'</span> <input type="number" placeholder="Max Marks1" name="marks[]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" min="0" value="0" disabled />';

                        }   
                               
            $str .='              </div>';
                            } 
                           }
            $str .='        </div>';
                    }
                }
                
            $str .='    </div>';
            $str .='    </div>';
            $str .='    </div>';
                
            $str .='</div><br>';


            $script = "<script>var checks = document.querySelectorAll(\"input[type=checkbox]\");for(var i = 0; i < checks.length; i++){
                checks[i].addEventListener( 'change', function() { 
                  if(this.checked) {
                     showChildrenChecks(this);
                     console.log(this);
                     console.log(this.name);
                     if(this.name=='exam_types[]'){
                        $(this).closest('div').find('input[type=number]').prop('disabled', false);
                     }
                  } else {
                     hideChildrenChecks(this);
                     if(this.name=='exam_types[]'){
                        $(this).closest('div').find('input[type=number]').prop('disabled', true);
                     }
                    }
                });
               }function showChildrenChecks(elm) {
                 var pN = elm.parentNode;
                 var childCheks = pN.children;  for(var i = 0; i < childCheks.length; i++){
                    if(hasClass(childCheks[i], 'child-check')){
                        childCheks[i].classList.add(\"active\");
                                                //
                    }
                }}function hideChildrenChecks(elm) {
                 var pN = elm.parentNode;
                 var childCheks = pN.children;  for(var i = 0; i < childCheks.length; i++){
                    if(hasClass(childCheks[i], 'child-check')){
                        childCheks[i].classList.remove(\"active\");
                        
                        //
                    }
                }}function hasClass(elem, className) {
                  return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
               }</script>"; 

        echo $str.$script;
    }
    // public function get_subject_by_class_school() {

    //     $school_id = $this->input->post('school_id');
    //     $class_id = $this->input->post('class_id');
    //     $subject_id = $this->input->post('subject_id');
       
    //     if($this->session->userdata('role_id') == TEACHER){
    //         $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id,  'teacher_id'=>$this->session->userdata('profile_id')), '', '', '', 'id', 'ASC');
    //     }else{
    //         $subjects = $this->ajax->get_list('subjects', array('status' => 1, 'class_id' => $class_id, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
    //     }
       
    //        $exam_types = $this->ajax->get_exam_types();
    //        //echo '<pre>';print_r($exam_types); die();
    //        //echo '<pre>';print_r($subjects); die();
  
    //         $str .='<div class="container">';
    //         $str .='    <div class="row">';
    //         $str .='    <div class="col-md-6">';
    //         $str .='        <div id="treeview-checkbox-demo">';
    //                    if(!empty($subjects)) {
    //                       foreach ($subjects as $obj) {
    //         $str .='        <div class="parent-check">';
    //         $str .='<input type="checkbox" value="'.$obj->id.'" name="subjects[]" id="'.$obj->id.'"/>'.$obj->name;
             
    //                       if(!empty($exam_types)) {
    //                         foreach ($exam_types as $mark) {
    //         $str .='               <div class="child-check">';
    
    //                            $str  .='<input type="checkbox" value="'.$obj->id.'-'.$mark->id.'" name="exam_types[]" id="'.$mark->id.'"/>'.$mark->name.' <input type="number" placeholder="Max Marks" name="marks[]" class="form-control form-mark col-md-7 col-xs-12 fn_mark_total" min="0" max="100" value="100" disabled />';
    //         $str .='              </div>';
    //                         } 
    //                        }
    //         $str .='        </div>';
    //                 }
    //             }
    //             // name=marks_'.$obj->id.'-'.$mark->id.'  
    //         $str .='    </div>';
    //         $str .='    </div>';
    //         $str .='    </div>';
                
    //         $str .='</div><br>';


    //         $script = "<script>var checks = document.querySelectorAll(\"input[type=checkbox]\");for(var i = 0; i < checks.length; i++){
    //             checks[i].addEventListener( 'change', function() { 
    //               if(this.checked) {
    //                  showChildrenChecks(this);
    //                  console.log(this);
    //                  console.log(this.name);
    //                  if(this.name=='exam_types[]'){
    //                     $(this).closest('div').find('input[type=number]').prop('disabled', false);
    //                  }
    //               } else {
    //                  hideChildrenChecks(this);
    //                  if(this.name=='exam_types[]'){
    //                     $(this).closest('div').find('input[type=number]').prop('disabled', true);
    //                  }
    //                 }
    //             });
    //            }function showChildrenChecks(elm) {
    //              var pN = elm.parentNode;
    //              var childCheks = pN.children;  for(var i = 0; i < childCheks.length; i++){
    //                 if(hasClass(childCheks[i], 'child-check')){
    //                     childCheks[i].classList.add(\"active\");
    //                                             //
    //                 }
    //             }}function hideChildrenChecks(elm) {
    //              var pN = elm.parentNode;
    //              var childCheks = pN.children;  for(var i = 0; i < childCheks.length; i++){
    //                 if(hasClass(childCheks[i], 'child-check')){
    //                     childCheks[i].classList.remove(\"active\");
                        
    //                     //
    //                 }
    //             }}function hasClass(elem, className) {
    //               return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    //            }</script>"; 

        
    //     echo $str.$script;
    // }
    


    /**     * *************Function get_assignment_by_subject**********************************
     * @type            : Function
     * @function name   : get_assignment_by_subject
     * @description     : this function used to populate assignment list by subject 
      for user interface
     * @param           : null 
     * @return          : $str string  value with assignment list
     * ********************************************************** */
    /*public function get_assignment_by_subject() {

        $subject_id = $this->input->post('subject_id');
        echo $assignment_id = $this->input->post('assignment_id');

        $assignments = $this->ajax->get_list('assignments', array('status' => 1, 'subject_id' => $subject_id, 'academic_year_id' => $this->academic_year_id), '', '', '', 'id', 'ASC');
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($assignments)) {
            foreach ($assignments as $obj) {
                $selected = $assignment_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
            }
        }

        echo $str;
    }*/

    /**     * *************Function get_guardian_by_id**********************************
     * @type            : Function
     * @function name   : get_guardian_by_id
     * @description     : this function used to populate guardian information/value by id 
      for user interface
     * @param           : null 
     * @return          : $guardina json  value
     * ********************************************************** */
    public function get_guardian_by_id() {

        header('Content-Type: application/json');
        $guardian_id = $this->input->post('guardian_id');

        $guardian = $this->ajax->get_single('guardians', array('id' => $guardian_id));
        echo json_encode($guardian);
        //die();
    }

    /**     * *************Function get_room_by_hostel**********************************
     * @type            : Function
     * @function name   : get_room_by_hostel
     * @description     : this function used to populate room list by hostel  
      for user interface
     * @param           : null 
     * @return          : $str string value with room list 
     * ********************************************************** */
    public function get_room_by_hostel() {

        $hostel_id = $this->input->post('hostel_id');

        $hostels = $this->ajax->get_list('rooms', array('status' => 1, 'hostel_id' => $hostel_id), '', '', '', 'id', 'ASC');
        $str = '<option value="">--.' . $this->lang->line('select') . ' ' . $this->lang->line('room_no') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($hostels)) {
            foreach ($hostels as $obj) {
                $selected = $subject_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->room_no . ' [' . $this->lang->line($obj->room_type) . '] [ ' . $obj->cost . ' ]</option>';
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_user_list_by_type**********************************
     * @type            : Function
     * @function name   : get_user_list_by_type
     * @description     : Load "Employee or Teacher Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_user_list_by_type() {
        
         $school_id  = $this->input->post('school_id');
         $payment_to  = $this->input->post('payment_to');
         $user_id  = $this->input->post('user_id');
         
         $users = $this->ajax->get_user_list($school_id, $payment_to );
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($users)) {
            foreach ($users as $obj) {   
                $selected = $user_id == $obj->user_id ? $select : '';
                $str .= '<option value="' . $obj->user_id . '" ' . $selected . '>' . $obj->name .' [ '. $obj->designation . ' ]</option>';
            }
        }

        echo $str;
    }
    
  
    /*--------------START -------------------------*/
    
    /*****************Function get_designation_by_school**********************************
     * @type            : Function
     * @function name   : get_designation_by_school
     * @description     : Load "Designation Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_designation_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $designation_id  = $this->input->post('designation_id');
         
        $designations = $this->ajax->get_list('designations', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($designations)) {
            foreach ($designations as $obj) {   
                
                $selected = $designation_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name .' </option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_salary_grade_by_school**********************************
     * @type            : Function
     * @function name   : get_salary_grade_by_school
     * @description     : Load "Salary grade Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_salary_grade_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $salary_grade_id  = $this->input->post('salary_grade_id');
         
        $salary_grades = $this->ajax->get_list('salary_grades', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($salary_grades)) {
            foreach ($salary_grades as $obj) {   
                
                $selected = $salary_grade_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->grade_name .' </option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_teacher_by_school**********************************
     * @type            : Function
     * @function name   : get_teacher_by_school
     * @description     : Load "Teacher Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_teacher_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $teacher_id  = $this->input->post('teacher_id');
         $is_all  = $this->input->post('is_all');
         
        $teachers = $this->ajax->get_list('teachers', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        if($is_all){
            $str = '<option value="0">' . $this->lang->line('all'). ' ' .$this->lang->line('teacher') . '</option>';    
        }else{
            $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
        }
        
        $select = 'selected="selected"';
        if (!empty($teachers)) {
            foreach ($teachers as $obj) {   
                
                $selected = $teacher_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name .' [ '. $obj->responsibility . ' ]</option>';
                
            }
        }

        echo $str;
    }
    
    /*****************Function get_employee_by_school**********************************
     * @type            : Function
     * @function name   : get_employee_by_school
     * @description     : Load "Employee Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_employee_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $employee_id  = $this->input->post('employee_id');
         $is_all  = $this->input->post('is_all');
         
        $employees = $this->ajax->get_list('employees', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
         if($is_all){
            $str = '<option value="0">' . $this->lang->line('all'). ' ' .$this->lang->line('employee') . '</option>';    
        }else{
            $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
        }
        
        $select = 'selected="selected"';
        if (!empty($employees)) {
            foreach ($employees as $obj) {   
                
                $selected = $employee_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name .'</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_guardian_by_school**********************************
     * @type            : Function
     * @function name   : get_guardian_by_school
     * @description     : Load "Guardian Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_guardian_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $guardian_id  = $this->input->post('guardian_id');
         
        $guardinas = $this->ajax->get_list('guardians', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($guardinas)) {
            foreach ($guardinas as $obj) {   
                
                $selected = $guardian_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_discount_by_school**********************************
     * @type            : Function
     * @function name   : get_discount_by_school
     * @description     : Load "Discount Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_discount_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $discount_id  = $this->input->post('discount_id');
         
        $discounts = $this->ajax->get_list('discounts', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($discounts)) {
            foreach ($discounts as $obj) {   
                
                $selected = $discount_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    
    /*****************Function get_student_type_by_school**********************************
     * @type            : Function
     * @function name   : get_student_type_by_school
     * @description     : Load "Student type Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_student_type_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $type_id  = $this->input->post('type_id');
         
        $types = $this->ajax->get_list('student_types', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($types)) {
            foreach ($types as $obj) {   
                
                $selected = $type_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->type . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_class_by_school**********************************
     * @type            : Function
     * @function name   : get_class_by_school
     * @description     : Load "Class Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_class_by_school() {
         $school_id  = $this->input->post('school_id');
         $class_id  = $this->input->post('class_id');
         $type = $this->input->post('type');
         //echo 'class='.$school_id;die();
         $ci = & get_instance();
         if($type==$school_id){
            
            $ci->db->select('Distinct(ETM.class_id) as id,C.name');
            $ci->db->from('exam_type_mapping AS ETM');
            $ci->db->join('classes AS C', 'C.id = ETM.class_id');
            $ci->db->where('C.school_id', $school_id);
            
            $res = $ci->db->get();
            //print_r($ci->db->last_query());    die();
            
            //return $res->result();
            $classes = $res->result();
         }else{

            $classes = $this->ajax->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC');
         }


        //$classes = $this->ajax->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         //print_r($classes);die();
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($classes)) {
            foreach ($classes as $obj) {   
                
                $selected = $class_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
                
            }
        }

        echo $str;
    }
    
     /*****************Function get_exam_types_by_school**********************************
     * @type            : Function
     * @function name   : get_exam_types_by_school
     * @description     : Load "Class Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_exam_types_by_school() {
        
        $school_id  = $this->input->post('school_id');
        //$class_id  = $this->input->post('class_id');
        //echo $school_id;die();
       $classes = $this->ajax->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
        
       $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
       $select = 'selected="selected"';
       if (!empty($classes)) {
           foreach ($classes as $obj) {   
               
               $selected = $class_id == $obj->id ? $select : '';
               $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
               
           }
       }

       echo $str;
   }

    
    /*****************Function get_exam_by_school**********************************
     * @type            : Function
     * @function name   : get_exam_by_school
     * @description     : Load "Exam Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_exam_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $exam_id  = $this->input->post('exam_id');
         
        $exams = $this->ajax->get_list('exams', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($exams)) {
            foreach ($exams as $obj) {   
                
                $selected = $exam_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    
    
    /*****************Function get_certificate_type_by_school**********************************
     * @type            : Function
     * @function name   : get_certificate_type_by_school
     * @description     : Load "Certificate Type Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_certificate_type_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $certificate_id  = $this->input->post('certificate_id');
         
        $certificates = $this->ajax->get_list('certificates', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($certificates)) {
            foreach ($certificates as $obj) {   
                
                $selected = $certificate_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
                
            }
        }

        echo $str;
    }
    
    /*****************Function get_gallery_by_school**********************************
     * @type            : Function
     * @function name   : get_gallery_by_school
     * @description     : Load "Gallery Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_gallery_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $gallery_id  = $this->input->post('gallery_id');
         
        $galleries = $this->ajax->get_list('galleries', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($galleries)) {
            foreach ($galleries as $obj) {   
                
                $selected = $gallery_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->title . '</option>';
                
            }
        }

        echo $str;
    }
    
    /*****************Function get_leave_type_by_school**********************************
     * @type            : Function
     * @function name   : get_leave_type_by_school
     * @description     : Load "Leave type Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_leave_type_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $role_id  = $this->input->post('role_id');
         $type_id  = $this->input->post('type_id');
         
        $types = $this->ajax->get_list('leave_types', array('status'=>1, 'school_id'=>$school_id, 'role_id'=>$role_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($types)) {
            foreach ($types as $obj) {   
                
                $selected = $type_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->type . '</option>';
                
            }
        }

        echo $str;
    }
    
    /*****************Function get_visitor_purpose_by_school**********************************
     * @type            : Function
     * @function name   : get_visitor_purpose_by_school
     * @description     : Load "Visitor purpose Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_visitor_purpose_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $purpose_id  = $this->input->post('purpose_id');
         
        $purposes = $this->ajax->get_list('visitor_purposes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($purposes)) {
            foreach ($purposes as $obj) {   
                
                $selected = $purpose_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->purpose . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_complain_type_by_school**********************************
     * @type            : Function
     * @function name   : get_complain_type_by_school
     * @description     : Load "Complain type Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_complain_type_by_school() {
        
         $school_id  = $this->input->post('school_id');
         $type_id  = $this->input->post('type_id');
         
        $types = $this->ajax->get_list('complain_types', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($types)) {
            foreach ($types as $obj) {   
                
                $selected = $type_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->type . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_user_single_payment**********************************
     * @type            : Function
     * @function name   : get_user_single_payment
     * @description     : validate the paymeny to user already paid for selected month               
     *                    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_user_single_payment() {
        
         $payment_to  = $this->input->post('payment_to');
         $user_id  = $this->input->post('user_id');
         $salary_month  = $this->input->post('salary_month');
         
         $exist = $this->ajax->get_single('salary_payments',array('user_id'=>$user_id, 'salary_month'=>$salary_month, 'payment_to'=>$payment_to ));
         
         if($exist){
             echo 1;
         }else{
             echo 2;
         }         
    }
    
    /*****************Function get_school_info_by_id**********************************
     * @type            : Function
     * @function name   : get_school_info_by_id
     * @description     : validate the paymeny to user already paid for selected month               
     *                    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_school_info_by_id() {
        
         $school_id  = $this->input->post('school_id');
         
         $school = $this->ajax->get_single('schools',array('id'=>$school_id));         
         echo $school->final_result_type;        
    }
    
    /*****************Function get_sms_gateways**********************************
     * @type            : Function
     * @function name   : get_sms_gateways
     * @description     : Load "SMS Settings" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_sms_gateways() {
        
        $school_id  = $this->input->post('school_id');
         
        $gateways = get_sms_gateways($school_id);
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if (!empty($gateways)) {
            foreach ($gateways as $key=>$value) {   
                
                $str .= '<option value="' . $key . '" >' . $value . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    

    
    
    /*****************Function get_academic_year_by_school**********************************
     * @type            : Function
     * @function name   : get_academic_year_by_school
     * @description     : Load "SMS Settings" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_academic_year_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $academic_year_id  = $this->input->post('academic_year_id');
         
        $academic_years = $this->ajax->get_list('academic_years', array('school_id'=>$school_id), '','', '', 'id', 'ASC');
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
         $select = 'selected="selected"';
         
        if (!empty($academic_years)) {
            foreach($academic_years as $obj ){   
           
                $selected = $academic_year_id == $obj->id ? $select : '';                
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->session_year . '</option>';
            }
        }

        echo $str;
    }
    
    
        
    /** * *************Function get_email_template_by_role**********************************
     * @type            : Function
     * @function name   : get_email_template_by_role
     * @description     : this function used to populate template by role  
      for user interface
     * @param           : null 
     * @return          : $str string value with room list 
     * ********************************************************** */
    public function get_email_template_by_role() {

        $role_id = $this->input->post('role_id');
        $school_id = $this->input->post('school_id');

        $templates = $this->ajax->get_list('email_templates', array('status' => 1, 'role_id' => $role_id,'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        $str = '<option value="">-- ' . $this->lang->line('select') . ' ' . $this->lang->line('template') . ' --</option>';
        if (!empty($templates)) {
            foreach ($templates as $obj) {
                $str .= '<option itemid="'.$obj->id.'" value="' . $obj->template . '">' . $obj->title . '</option>';
            }
        }

        echo $str;
    }
   
    
        
    /** * *************Function get_sms_template_by_role**********************************
     * @type            : Function
     * @function name   : get_sms_template_by_role
     * @description     : this function used to populate template by role  
      for user interface
     * @param           : null 
     * @return          : $str string value with room list 
     * ********************************************************** */
    public function get_sms_template_by_role() {

        $role_id = $this->input->post('role_id');
        $school_id = $this->input->post('school_id');

        $templates = $this->ajax->get_list('sms_templates', array('status' => 1, 'role_id' => $role_id,'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        $str = '<option value="">-- ' . $this->lang->line('select') . ' ' . $this->lang->line('template') . ' --</option>';
        if (!empty($templates)) {
            foreach ($templates as $obj) {
                $str .= '<option itemid="'.$obj->id.'" value="' . $obj->template . '">' . $obj->title . '</option>';
            }
        }

        echo $str;
    }
    
    
    
        
    /** * *************Function get_current_session_by_school**********************************
     * @type            : Function
     * @function name   : get_current_session_by_school
     * @description     : this function used to populate template by role  
      for user interface
     * @param           : null 
     * @return          : $str string value with room list 
     * ********************************************************** */
    public function get_current_session_by_school() {

        $current_session_id = $this->input->post('current_session_id');
        $school_id = $this->input->post('school_id');
        
        $school = $this->ajax->get_school_by_id($school_id);
        
        $curr_session = $this->ajax->get_list('academic_years', array('id' => $school->academic_year_id, 'school_id'=>$school_id));
        $str = '<option value="">-- ' . $this->lang->line('select') . ' --</option>';
         $select = 'selected="selected"';
         
        if (!empty($curr_session)) {
            foreach ($curr_session as $obj) {
                $selected = $current_session_id == $obj->id ? $select : '';  
                $str .= '<option value="'.$obj->id.'" '.$selected.'>' . $obj->session_year . '</option>';
            }
        }

        echo $str;
    }
    
    
        
    /** * *************Function get_next_session_by_school**********************************
     * @type            : Function
     * @function name   : get_next_session_by_school
     * @description     : this function used to populate template by role  
      for user interface
     * @param           : null 
     * @return          : $str string value with room list 
     * ********************************************************** */
    public function get_next_session_by_school() {

        $academic_year_id = $this->input->post('academic_year_id');
        $school_id = $this->input->post('school_id');
        $school = $this->ajax->get_school_by_id($school_id);
        
        $next_session = $this->ajax->get_list('academic_years', array('id !=' => $school->academic_year_id, 'school_id'=>$school_id));
        $str = '<option value="">-- ' . $this->lang->line('select') . ' --</option>';
        $select = 'selected="selected"';        
        
        if (!empty($next_session)) {
            foreach ($next_session as $obj) {
                
                $selected = $academic_year_id == $obj->id ? $select : ''; 
                $str .= '<option value="'.$obj->id.'" ' . $selected . '>' . $obj->session_year . '</option>';
            }
        }

        echo $str;
    }
    

}
