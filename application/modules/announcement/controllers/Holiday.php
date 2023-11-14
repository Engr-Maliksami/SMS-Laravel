<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Holiday.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Holiday
 * @description     : Manage school holiday.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Holiday extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Holiday_Model', 'holiday', true);
            
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Holiday List" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null, $id = null) {
        
         check_permission(VIEW);
      
        $this->data['holidays'] = $this->holiday->get_holiday_list($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title( $this->lang->line('manage_holiday'). ' | ' . SMS);
        $this->layout->view('holiday/index', $this->data);            
       
    }
    
    

    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Holiday" user interface                 
    *                    and store "Holiday" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {
        
         check_permission(ADD);

        if ($_POST) {
            $this->_prepare_holiday_validation();
            if ($this->form_validation->run() === TRUE) {
                $total_data = $this->_get_posted_holiday_data();
                $data = $total_data['data'];
                $dates = $total_data['dates'];

                $insert_id = $this->holiday->insert('holidays', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a holiday : '.$data['title']); 
                    foreach($dates as $date){
                        $dates_data['holidays_id'] = $insert_id;
                        $dates_data['date'] = $date;
                        $types = explode('-',$date);
                        $dates_data['month'] = $types[1];
                        $dates_data['year'] = $types[0];
                        $dates_data['title'] = $data['title'];  
                        $holiday_insert_id = $this->holiday->insert('holidays_dates', $dates_data);
                    }
                    
                    success($this->lang->line('insert_success'));
                    redirect('announcement/holiday/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('announcement/holiday/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['holidays'] = $this->holiday->get_holiday_list(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' ' . $this->lang->line('holiday'). ' | ' . SMS);
        $this->layout->view('holiday/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Holiday" user interface                 
    *                    with populated "Holiday" value 
    *                    and update "Holiday" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */ 
    public function edit($id = null) {       
       
         check_permission(EDIT);
        
         if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
           redirect('announcement/holiday/index'); 
        }
        
        if ($_POST) {
            $this->_prepare_holiday_validation();
            if ($this->form_validation->run() === TRUE) {
                $total_data = $this->_get_posted_holiday_data();
                $data = $total_data['data'];
                $dates = $total_data['dates'];
                $updated = $this->holiday->update('holidays', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    $this->holiday->delete('holidays_dates', array('holidays_id' => $this->input->post('id')));
                    foreach($dates as $date){
                        $dates_data['holidays_id'] = $this->input->post('id');
                        $dates_data['date'] = $date;
                        $types = explode('-',$date);
                        $dates_data['month'] = $types[1];
                        $dates_data['year'] = $types[0];
                        $dates_data['title'] = $data['title'];  
                        $holiday_insert_id = $this->holiday->insert('holidays_dates', $dates_data);
                    }
                    create_log('Has been updated a holiday : '.$data['title']);  
                     
                    success($this->lang->line('update_success'));
                    redirect('announcement/holiday/index/'.$data['school_id']);                   
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('announcement/holiday/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['holiday'] = $this->holiday->get_single('holidays', array('id' => $this->input->post('id')));
            }
        }
        
        if ($id) {
            $this->data['holiday'] = $this->holiday->get_single('holidays', array('id' => $id));

            if (!$this->data['holiday']) {
                 redirect('announcement/holiday/index');
            }
        }

        $this->data['holidays'] = $this->holiday->get_holiday_list($this->data['holiday']->school_id);
        $this->data['school_id'] = $this->data['holiday']->school_id;
        $this->data['filter_school_id'] = $this->data['holiday']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' ' . $this->lang->line('holiday'). ' | ' . SMS);
        $this->layout->view('holiday/index', $this->data);
    }
    
    
    
    /*****************Function view**********************************
    * @type            : Function
    * @function name   : view
    * @description     : Load user interface with specific holiday data                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function view($id = null){
        
         check_permission(VIEW);
         
         if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
           redirect('announcement/holiday/index'); 
        }
        
        $this->data['holidays'] = $this->holiday->get_holiday_list();
        
        $this->data['holiday'] = $this->holiday->get_single('holidays', array('id' => $id));
        
        $this->data['detail'] = TRUE;       
        $this->layout->title($this->lang->line('view'). ' ' . $this->lang->line('holiday'). ' | ' . SMS);
        $this->layout->view('holiday/index', $this->data);
    }

    
         /*****************Function get_single_holiday**********************************
     * @type            : Function
     * @function name   : get_single_holiday
     * @description     : "Load single holiday information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_holiday(){
        
       $holiday_id = $this->input->post('holiday_id');
       
       $this->data['holiday'] = $this->holiday->get_single_holiday($holiday_id);
       echo $this->load->view('holiday/get-single-holiday', $this->data);
    }
    
       
    /*****************Function _prepare_holiday_validation**********************************
    * @type            : Function
    * @function name   : _prepare_holiday_validation
    * @description     : Process "holiday" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */ 
    private function _prepare_holiday_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');   
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');   
        $this->form_validation->set_rules('date_from', $this->lang->line('from_date'), 'trim|required');   
        $this->form_validation->set_rules('date_to', $this->lang->line('to_date'), 'trim|required');   
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');   
    }
    

    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "Holiday title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
   public function title()
   {             
      if($this->input->post('id') == '')
      {   
          $holiday = $this->holiday->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('date_from')); 
          if($holiday){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $holiday = $this->holiday->duplicate_check($this->input->post('school_id'), $this->input->post('title'),$this->input->post('date_from'), $this->input->post('id')); 
          if($holiday){
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }   
   }

   

    /*****************Function _get_posted_holiday_data**********************************
    * @type            : Function
    * @function name   : _get_posted_holiday_data
    * @description     : Prepare "Holiday" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_holiday_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'date_from';    
        $items[] = 'note';
        $items[] = 'is_view_on_web';
        $data = elements($items, $_POST);  
      
        $data['date_from'] = date('Y-m-d', strtotime($this->input->post('date_from')));
        $data['date_to'] = date('Y-m-d', strtotime($this->input->post('date_to')));
        
        $from_date = strtotime($this->input->post('date_from'));
        $to_date =   strtotime($this->input->post('date_to'));

        $month =explode('-',$data['date_to']);
        $data['month']= $month[1];
        $days =  $to_date- $from_date;
        $days = round($days / (60 * 60 * 24));
        
        if($days ==0){
        $dates[0] =date('Y-m-d', strtotime($this->input->post('date_to')));
        }

        if($days >=1){
            $dates = $this->createDateRange($this->input->post('date_from'),$this->input->post('date_to'));
            array_push($dates,date('Y-m-d', strtotime($this->input->post('date_to'))));
        }


        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();                       
        }
        return array('dates' => $dates,'data' => $data);
        //return $data;
    }

   
 public function createDateRange($startDate, $endDate, $format = "Y-m-d")
{
    $begin = new DateTime($startDate);
    $end = new DateTime($endDate);

    $interval = new DateInterval('P1D'); // 1 Day
    $dateRange = new DatePeriod($begin, $interval, $end);

    $range = [];
    foreach ($dateRange as $date) {
        $range[] = $date->format($format);
    }

    return $range;
}
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Holiday" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
         check_permission(DELETE);
        
         if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
           redirect('announcement/holiday/index'); 
        }
        
        $holiday = $this->holiday->get_single('holidays', array('id' => $id));
        
        if ($this->holiday->delete('holidays', array('id' => $id))) {               
            
            create_log('Has been deleted a holiday : '.$holiday->title);  
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('announcement/holiday/index/'.$holiday->school_id);
    }

}
