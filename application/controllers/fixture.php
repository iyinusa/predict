<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixture extends CI_Controller {
	
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
		$get_id = $this->input->get('edit');
		if($get_id != ''){
			$gq = $this->mfixture->query_fixture_id($get_id);
			foreach($gq as $item){
				$data['e_id'] = $item->id;
				$data['e_home_team'] = $item->home_team;
				$data['e_away_team'] = $item->away_team;
				$data['e_match_date'] = $item->match_date;
				$data['e_home_score'] = $item->home_score;
				$data['e_away_score'] = $item->away_score;
				$data['e_winner'] = $item->winner;
			}
		}
		
		//check record delete
		$del_id = $this->input->get('del');
		if($del_id != ''){
			if($this->mfixture->delete_fixture($del_id) > 0){
				$data['err_msg'] = '<div class="alert alert-info"><h5>Deleted</h5></div>';
			} else {
				$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
			}
		}
		
		//check if ready for post
		if($_POST){
			$fixture_id = $_POST['fixture_id'];
			$home_team = $_POST['home_team'];
			$away_team = $_POST['away_team'];
			$match_date = $_POST['match_date'];
			$home_score = $_POST['home_score'];
			$away_score = $_POST['away_score'];
			$stamp = time();
			
			if($home_score > 0 && $away_score > 0){
				if($home_score == $away_score){
					$winner = 0;
				} else {
					if($home_score > $away_score){$winner = $home_team;} else {$winner = $away_team;}
				}
			} else {$winner = 0;}
			
			//check for update
			if($fixture_id != ''){
				$upd_data = array(
					'home_team' => $home_team,
					'away_team' => $away_team,
					'match_date' => $match_date,
					'home_score' => $home_score,
					'away_score' => $away_score,
					'winner' => $winner,
					'played' => 1,
				);
				
				if($this->mfixture->update_fixture($fixture_id, $upd_data) > 0){
					$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>No Changes Made</h5></div>';
				}
			} else {
				$reg_data = array(
					'home_team' => $home_team,
					'away_team' => $away_team,
					'match_date' => $match_date,
					'home_score' => $home_score,
					'away_score' => $away_score,
					'winner' => $winner,
					'reg_date' => date('j M Y H:ma')
				);
				
				if($this->mfixture->reg_insert($reg_data) > 0){
					$data['err_msg'] = '<div class="alert alert-info"><h5>Successfully</h5></div>';
				} else {
					$data['err_msg'] = '<div class="alert alert-info"><h5>There is problem this time. Try later</h5></div>';
				}
			}
		}
		
		//query uploads
		$data['allup'] = $this->mfixture->query_fixture();
		$data['allclub'] = $this->mclub->query_club();
		
		$data['log_username'] = $this->session->userdata('log_username');
	  
	  	$data['title'] = 'Fixture | Prediction';
		$data['page_act'] = 'fixture';

	  	$this->load->view('designs/header', $data);
		$this->load->view('designs/leftmenu', $data);
	  	$this->load->view('fixture', $data);
	  	$this->load->view('designs/footer', $data);
	}
	
	function do_upload($htmlFieldName, $path)
    {
        $config['file_name'] = time();
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|tif';
        $config['max_size'] = '10000';
        $config['max_width'] = '6000';
        $config['max_height'] = '6000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        unset($config);
        if (!$this->upload->do_upload($htmlFieldName))
        {
            return array('error' => $this->upload->display_errors(), 'status' => 0);
        } else
        {
            $up_data = $this->upload->data();
			return array('status' => 1, 'upload_data' => $this->upload->data(), 'image_width' => $up_data['image_width'], 'image_height' => $up_data['image_height']);
        }
    }
	
	function resize_image($sourcePath, $desPath, $width = '500', $height = '500', $real_width, $real_height)
    {
        $this->image_lib->clear();
		$config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['thumb_marker'] = '';
		$config['width'] = $width;
        $config['height'] = $height;
		
		$dim = (intval($real_width) / intval($real_height)) - ($config['width'] / $config['height']);
		$config['master_dim'] = ($dim > 0)? "height" : "width";
		
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->resize())
            return true;
        return false;
    }
	
	function crop_image($sourcePath, $desPath, $width = '320', $height = '320')
    {
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $sourcePath;
        $config['new_image'] = $desPath;
        $config['quality'] = '100%';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $width;
        $config['height'] = $height;
		$config['x_axis'] = '20';
		$config['y_axis'] = '20';
        
		$this->image_lib->initialize($config);
 
        if ($this->image_lib->crop())
            return true;
        return false;
    }
}