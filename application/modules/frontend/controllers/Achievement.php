<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************About.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : About
 * @description     : Manage application about text  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Achievement extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->data['schools'] = $this->schools;
        $this->load->model('Achievement_Model', 'achievement', true); 
        $this->load->model('About_Model', 'about', true);        
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "General About" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        //check_permission(VIEW); 
         
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
             $this->data['school'] = $this->about->get_single('schools', array('id' => $this->session->userdata('school_id')));
             $this->data['edit'] = TRUE;
        }else{
            $this->data['list'] = TRUE;
        }  

        $school_id= $this->session->userdata('school_id');
        $data['status'] = $this->input->post('status'); 
       // print_r($_POST);die();
        $data['school_id'] = $this->session->userdata('school_id'); 

/*if(isset($this->session->userdata('school_id'))
{
    echo 'ji';
}*/
       $result = $this->achievement->update_achievement_section($data);
       //if($_POST)
       //{
       $this->data['achievement']= $this->achievement->get_achievement_section($school_id);
        //}
       //print_r($this->data['achievement']);die();
         

        
        $this->layout->title($this->lang->line('general') . ' ' . $this->lang->line('about') . ' | ' . SMS);
        $this->layout->view('achievement/index', $this->data);
    }

     /*****************Function get_single_school**********************************
     * @type            : Function
     * @function name   : get_single_frontend
     * @description     : "Load single frontend information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_school(){
        
       $school_id = $this->input->post('school_id');       
       $this->data['school'] = $this->about->get_single('schools', array('id'=>$school_id));
       echo $this->load->view('about/get-single-school', $this->data);
    }



}