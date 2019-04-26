<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

public function __construct()
	{
		parent::__construct();
		$this->load->library(array('ion_auth','sprite_class','form_validation'));
		$this->load->helper(array('url', 'language','html','form'));
		$this->lang->load('auth');
			
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
public function index()
	{
		$data['title'] = 'SpriteTester for ALttP Randomizer';
		$data['adminArray'] = $data;
		$this->sprite_class->load('home', $data);
		
	}

public function version()
	{
		$data['adminArray'] = 'No Arrays Loaded';
		$this->sprite_class->load('version', $data);
	}
	
public function instructions()
	{
		$data['adminArray'] = 'No Arrays Loaded';
		$this->sprite_class->load('instructions',$data);
	}


/*** CLOSING BRACKET ***/

}