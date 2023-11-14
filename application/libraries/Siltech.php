<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Siltech {

	public $api_key, $sender_id, $campain_id, $route_id;

	function __construct() {

		$ci = & get_instance();
		$school_id = '';
		if ($ci->session->userdata('school_id')) {
			$school_id = $ci->session->userdata('school_id');
		} else {
			$school_id = $ci->input->post('school_id');
		}

		$ci->db->select('S.*');
		$ci->db->from('sms_settings AS S');
		$ci->db->where('S.school_id', $school_id);
		$setting = $ci->db->get()->row();

		$this->api_key = $setting->siltech_api_key;
		$this->sender_id = $setting->siltech_sender_id;
		$this->campain_id = $setting->siltech_campaign_id;
		$this->route_id = $setting->siltech_route_id;
	}

	function sendSMS($numbers, $message) {

		$api_key = $this->api_key;
		$from = $this->sender_id;
		$campain = $this->campain_id;
		$routeid = $this->route_id;

		$contacts = implode(',', $numbers);

		$sms_text = urlencode($message);

		//Submit to server

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, "https://siltechtz.com/app/smsapi/index.php");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=".$campain."&routeid=".$routeid."&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
		$response = curl_exec($ch);
		curl_close($ch);
    // echo $response; die();
		return $response;
	}
}

?>
