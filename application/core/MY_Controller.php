<?php
	class MY_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			
			$this->load->model('User_model','usermodel');
			
			if (!$this->ion_auth->logged_in()) {
				redirect('auth/login');
			} 
			$session_id = $this->usermodel->get_session_id($this->ion_auth->user()->row()->username);
			if (!$this->ion_auth->is_admin() && $session_id == NULL){
				redirect('auth/login');
			}
			
		}
	}
?>

    