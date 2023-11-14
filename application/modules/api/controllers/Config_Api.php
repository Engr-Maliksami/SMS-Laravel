<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
 
class Config_Api extends \Restserver\Libraries\REST_Controller
{
    public function __construct() {
        parent::__construct();
        // Load User Model
        $this->load->model('users', 'UserModel');
        $this->load->model('Year_Model', 'year');
        $this->load->library('Authorization_Token');
    }
    
    /**
     * academic year list
     * --------------------
     * @param: token in header
     * --------------------------
     * @method : GET
     * @link: api/user/user_detail
     */
    public function academic_year_get()
    {
        $_POST = $this->security->xss_clean($_POST);
        $token = $this->authorization_token->userData();
        $id = $token->id;
        $school_id = $token->school_id;

        $output = $this->year->get_year_list($school_id);

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
                'message' => "User details"
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

}