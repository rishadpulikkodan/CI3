<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		error_reporting(0);
		
		// $user = $this->session->userdata('user');
		// if($user && $user['privilage'] == array_keys(return_privilage())[1])  {
		// 	$this->load->model('Crm_model');
		// 	date_default_timezone_set("Asia/Kolkata");
		// }else{redirect('Crm/logout','refresh');} 

	}

	public function index()
	{
		$this->load->view('welcome_message');
	}
}
