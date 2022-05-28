<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Predict extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
		$this->load->model('user'); //load MODEL
		$this->load->model('mfixture'); //load MODEL
		$this->load->model('mclub'); //load MODEL
		$this->load->helper('text'); //for content limiter
		$this->load->library('form_validation'); //load form validate rules
		$this->load->library('image_lib'); //load image library
		
		//mail config settings
		$this->load->library('email'); //load email library
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['charset'] = 'iso-8859-1';
		//$config['wordwrap'] = TRUE;
		
		//$this->email->initialize($config);
    }
	
	public function index() {
		if($this->session->userdata('logged_in')==FALSE){ 
			redirect(base_url().'login/', 'location');
		}
		
		//check for update
		$get_id = $this->input->get('analyse');
		if($get_id != ''){
			$gq = $this->mfixture->query_fixture_id($get_id);
			foreach($gq as $item){
				$data['analyse'] = $get_id;
				
				//get home details
				$ghome = $this->mclub->query_club_id($item->home_team);
				if(!empty($ghome)){
					foreach($ghome as $home){
						$home_team_name = $home->name;
						$home_team_img = $home->pics_square;
					}
				}
				
				//get away details
				$gaway = $this->mclub->query_club_id($item->away_team);
				if(!empty($gaway)){
					foreach($gaway as $away){
						$away_team_name = $away->name;
						$away_team_img = $away->pics_square;
					}
				}
				
				$data['get_home_team_name'] = $home_team_name;
				$data['get_home_team_img'] = $home_team_img;
				$data['get_away_team_name'] = $away_team_name;
				$data['get_away_team_img'] = $away_team_img;
				$data['get_home_score'] = $item->home_score;
				$data['get_away_score'] = $item->away_score;
				
				//get history analysis
				$home_win = 0;
				$home_draw = 0;
				$home_lose = 0;
				$away_win = 0;
				$away_draw = 0;
				$away_lose = 0;
				$allfix = $this->mfixture->query_fixture();
				if(!empty($allfix)){
					foreach($allfix as $fix){
						//home team
						if($item->home_team == $fix->home_team){
							if($item->home_team == $fix->winner){
								$home_win += 1;
							} else {
								$home_lose += 1;
							}
						}
						if(($fix->home_team == $item->home_team) || ($fix->away_team == $item->home_team)){
							if(($fix->played == 1) && ($fix->winner == 0)){
								$home_draw += 1;
							}
						}
						
						//away team
						if($item->away_team == $fix->away_team){
							if($item->away_team == $fix->winner){
								$away_win += 1;
							} else {
								$away_lose += 1;
							}
						}
						if(($fix->home_team == $item->away_team) || ($fix->away_team == $item->away_team)){
							if(($fix->played == 1) && ($fix->winner == 0)){
								$away_draw += 1;
							}
						}
					}
					
					$data['home_win'] = $home_win;
					$data['home_draw'] = $home_draw;
					$data['home_lose'] = $home_lose;
					$data['away_win'] = $away_win;
					$data['away_draw'] = $away_draw;
					$data['away_lose'] = $away_lose;
					
					//computer prediction
					$home_value = ($home_win*3) + ($home_draw*1) - ($home_lose*3);
					$away_value = ($away_win*3) + ($away_draw*1) - ($away_lose*3);
					
					if($home_value > $away_value){
						$data['winner'] = $home_team_name;
					} else if($home_value < $away_value){
						$data['winner'] = $away_team_name;
					} else {
						$data['winner'] = 'None';
					}
				}
			}
		}
		
		//query uploads
		$data['allup'] = $this->mfixture->query_fixture();
		$data['allclub'] = $this->mclub->query_club();
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Predict | Prediction';
		$data['page_act'] = 'predict';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('predict', $data);
	  	$this->load->view('designs/footer', $data);
	}
}