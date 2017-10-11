<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_controller{

	public function __construct(){
		parent::__construct();
        $this->load->library('twitter');
        $this->load->helper('url');

	}

	public function index(){
		$data['twitter_login_url']=$this->twitter->get_login_url();
		$this->load->view('home_view',$data);
	}

	public function handle_twitter_response(){
		//returns an object
		$twitter_data=$this->twitter->validate();

		
		$session_data=array(
			'sess_username'=>$twitter_data->screen_name,
			'sess_name'=>$twitter_data->name,
			'sess_logged_in'=>1
			);
		$this->session->set_userdata($session_data);
		$data=array(
			'name'=>$twitter_data->name,
			'username'=>$twitter_data->screen_name,
			'source'=>'twitter',
			'profile_pic'=>"https://twitter.com/".$twitter_data->screen_name."/profile_image?size=original",
			'link'=>'https://twitter.com/'.$twitter_data->screen_name
		);
		$this->session->set_userdata($data);
		
		redirect(base_url().'index.php/Followers/');
		 
	}

	public function logout(){
		session_destroy();
		$session_data=array(
				'sess_logged_in'=>0
				);
		$this->session->set_userdata($session_data);
		redirect(base_url().'index.php/Auth/');
	}
}



/* End of file Auth.php */