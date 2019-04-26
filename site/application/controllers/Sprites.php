<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sprites extends CI_Controller

{

// *** PRELOADERS ***

public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','sprite_class'));
		$this->load->helper(array('url', 'language','form'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		
	}

// *** INDEX ***
// *** Pulls data for all sprites ***

public function index()
	{
	
		$data['title'] = 'All Sprites';
	
		if (!$this->ion_auth->logged_in()) // Check if logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			//$data['error'] = '';
			$data['sprites'] = $this->sprites_model->get_all_sprites();
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/index', $data); // Loads the index
		}
	}

// *** TESTED SPRITES (WIP) ***
// *** Pulls data for only sprites that are tested ***
	
public function in_progress()
	{
	
		$data['title'] = 'Tested Sprites';
	
		if (!$this->ion_auth->logged_in()) // Check if logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			
			$data['sprites'] = $this->sprites_model->get_tested_sprites();
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/tested', $data); // Loads the index
		}
	}
 
// *** VIEW ***
// *** Gets details on a single sprite and it's evaluations ***

public function view($id)
	{
	
	$data['title'] = 'Sprite Info';
	
	$userid = $this->ion_auth->get_user_id();
	$spritedata = $this->sprites_model->get_sprite_data($id);
	$spriteUserID = $spritedata['user_id'];
	
	if (!$this->ion_auth->logged_in() )
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('managerGroup')) && $userid != $spriteUserID) // Check if user is a Manager or owns this sprite
		{
			$this->sprite_class->load('master/access_denied');
		}
	else
		{
			$data['evaluations'] = $this->sprites_model->get_sprite_evaluations($id);
			$data['notes'] = $this->sprites_model->get_sprite_notes($id);
			$data['spriteinfo'] = $spritedata; 
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/view', $data);
		}
	
	}

// *** UPLOAD ***
// *** Uploads a sprite ***

public function upload()
	{
	
	$data['title'] = 'Upload A New Sprite';
	
	if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			
			$data['error'] = '';
			$data['statuses'] = $this->sprites_model->get_statuses_submit();
			$data['userid'] = $this->ion_auth->get_user_id();
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/upload', $data);
		}
	
	}

public function do_upload()
        {
        	$data['title'] = 'Upload A New Sprite';
            $config['upload_path']          = './files/';
            $config['allowed_types']        = 'zspr';

            $this->load->library('upload', $config);
				
                if ( ! $this->upload->do_upload('userfile'))
                {
					$data['error'] = $this->upload->display_errors();
					$data['statuses'] = $this->sprites_model->get_statuses_submit();
					$data['userid'] = $this->ion_auth->get_user_id();
					$data['adminArray'] = $data;
                    $this->sprite_class->load('sprites/upload', $data);
                }
                else
                {
                	
                	$this->sprites_model->add_sprite();
                    $data = array('upload_data' => $this->upload->data(),'title'=>'Upload Successful');
                    $data['adminArray'] = $data;
                    $this->sprite_class->load('sprites/upload_success', $data);
                }			
                
        }
	
// *** EDIT ***
// *** Edit's existing sprite data ***

public function edit($id) 
	{
	
	$this->form_validation->set_rules('name', 'name', 'required');	
	
	$data['title'] = 'Edit Sprite Data';
	
	// Variables used for ownership check
	
	$userid = $this->ion_auth->get_user_id();
	$spritedata = $this->sprites_model->get_sprite_data($id);
	$spriteUserID = $spritedata['user_id'];
	
	if (!$this->ion_auth->logged_in() )
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('testerGroup')) && $userid != $spriteUserID) // Check if user is a tester or owns this sprite
		{
			$this->sprite_class->load('master/access_denied');
		}
	elseif ($this->form_validation->run() === FALSE)
		{
			$data['sprite'] = $this->sprites_model->get_sprite_data($id);
			$data['statuses'] = $this->sprites_model->get_statuses_edit();
			$data['userid'] = $this->ion_auth->get_user_id();
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/edit', $data);
		}
	else
		{	// Gathers data for the updated info - should be in the model, but had issues implementing it there (may have been a typo)
			$d = date("Y-m-d");

			$info = array(
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				'date_modified' => $d
				);
			
				$this->sprites_model->edit_sprite_info($id, $info);
				redirect('sprites/index');
		}
		
		}

// *** SHOW USER'S SPRITES ***
// *** Gets data for the currenlty logged in user's sprites ***

public function usersprites()
	{
	
		$data['title'] = 'My Sprites';
	
		if (!$this->ion_auth->logged_in()) // Check if logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else
		{
			$id = $this->ion_auth->get_user_id();
			$data['sprites'] = $this->sprites_model->get_user_sprites($id);
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/usersprites', $data);
		}
	}
	
// *** UPDATE ***
// *** Uploads a new sprite version ***

public function update($id)
	{
	
	$this->form_validation->set_rules('name', 'Sprite Name', 'required');	
	
	$data['title'] = 'Update Sprite';
	
	if (!$this->ion_auth->logged_in() )
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	else
		{	
		if ($this->form_validation->run() === FALSE)
       		{
 				$data['error'] = '';
 				$data['sprite'] = $this->sprites_model->get_sprite_data($id);
				$data['statuses'] = $this->sprites_model->get_statuses_edit();
				$data['userid'] = $this->ion_auth->get_user_id();
				$data['adminArray'] = $data;
				$this->sprite_class->load('sprites/update', $data);
 			}
			
		}

	}

public function do_update($id)
        {
        	$data['title'] = 'Update Sprite';
            $config['upload_path']          = './files/';
            $config['allowed_types']        = 'zspr';

            $this->load->library('upload', $config);
				
                if ( ! $this->upload->do_upload('userfile'))
                {
					$data['error'] = $this->upload->display_errors();
					$data['statuses'] = $this->sprites_model->get_statuses_submit();
					$data['userid'] = $this->ion_auth->get_user_id();
					$data['adminArray'] = $data;
                    $this->sprite_class->load('sprites/upload', $data);
                }
                else
                {
                	$upload_file_name = $this->upload->data('file_name');
                	$d = date("Y-m-d");
                	$spriteVersion = $this->input->post('submission_version');
                	$updatedVersion = $spriteVersion + 1;
				
					$info = array(
        				'status' => $this->input->post('status'),
        				'date_modified' => $d,
        				'filename' => $upload_file_name,
        				'submission_version' => $updatedVersion
        				);
            		
            			$this->sprites_model->edit_sprite_info($id, $info);
            			$data = array('upload_data' => $this->upload->data(),'title'=>'Upload Successful');
            			$data['adminArray'] = $data;
            			$this->sprite_class->load('sprites/upload_success', $data);
                	
                }			
                
        }

// *** DOWNLOAD ***
// *** Parses sprite info, then downloads the sprite under the correct naming convention ***
	
public function download($file)
{
	if(!$this->ion_auth->in_group($this->config->item('uploadGroup')))
	{
		$this->sprite_class->load('master/access_denied');
	}
	
	$this->load->helper('download');
	
	$sprite = $this->sprites_model->get_sprite_data($file);
	$name = url_title($sprite['name'], 'dash', TRUE);
	$link = $sprite['filename'];
	$fixedname = $name.".".$sprite['vt_version'].".".$sprite['submission_version'].".zspr"; 

	if(is_file("files/$link"))
		{
			$location = file_get_contents('./files/'.$link);
			force_download($fixedname, $location); 
			redirect('sprites/index','refresh');
		}
	else
		{
		$data['error'] = 'The file for that Sprite does not exist!';
		$data['sprites'] = $this->sprites_model->get_all_sprites();
		$data['adminArray'] = $data;
		$this->sprite_class->load('sprites/index', $data); // Loads the index
		}
}


// *** EVALUATE ***
// *** Begins an evaluation on a sprite ***

public function evaluate($id)
	{
		$data['title'] = 'Evaluate Sprite';
		$spriteData = $this->sprites_model->get_sprite_data($id);
	
	if (!$this->ion_auth->logged_in() ) // Check if user is logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('testerGroup'))) // Check if user is part of the Tester group
		{	
			$this->sprite_class->load('master/access_denied');
		}
	elseif ($this->sprites_model->evaluation_check($id) == 0) // Checks if any evaluations that belong to the user exist
		{
			$data['message'] = 'New Evaluation Created for "'.$spriteData['name'].'"';
			$this->sprites_model->create_evaluation($id);
			$data['evaluation'] = $this->sprites_model->get_current_evaluation($id);
			$data['sprite'] = $this->sprites_model->get_sprite_data($id);
			$data['form_open'] = FALSE;
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/evaluate', $data);		
		}
	else // Continues an existing evaluation
		{	
			$data['message'] = 'Continuing Existing Evaluation for "'.$spriteData['name'].'"';
			$data['evaluation'] = $this->sprites_model->get_current_evaluation($id);
			$data['sprite'] = $this->sprites_model->get_sprite_data($id);
			$data['form_open'] = FALSE;
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/evaluate', $data);	
		}
	}

// *** EVALUATION ACTIONS ***
// *** All the actions that can be performed during a sprite evaluation ***

// *** Tech Issue - for problems that would impare the sprite's functionality/presentation in the game ***

public function tech_issue($id)
{
	
	$this->form_validation->set_rules('tech_feedback', 'Feedback', 'required');

	if(!$this->ion_auth->in_group($this->config->item('testerGroup')))
	{
		$this->sprite_class->load('master/access_denied');
	}
	elseif ($this->form_validation->run() === FALSE)
	{
			$data['message'] = "Continuing Existing Evaluation";
			$data['evaluation'] = $this->sprites_model->get_evaluation($id);
			$data['form_open'] = "Tech";
			$data['sprite'] = $this->sprites_model->get_sprite_data($id);
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/evaluate', $data);
	}
	else
	{
		$userid = $this->ion_auth->get_user_id();
		$d = date("Y-m-d");
		
		// Parse the inputs to prepare for a multi-line note
		
		$progress = $this->input->post('progress');
		
		// Checks if palettes where checked
		
		if ( null !== $this->input->post('palette[]'))
			{
				$palettesArray = $this->input->post('palette[]');
				$paletteString = 'Palettes: '.implode(', ',$palettesArray)."\n";
			}
			else
			{
				$paletteString = "";
			}
	
		$indexes = 'Indexes: '.$this->input->post('indexes');
		$frames = "\n".'Frames: '.$this->input->post('frames');
		$text = "\n".'Feedback: '.$this->input->post('tech_feedback');
		
		// Create a multiline note
		$content = $paletteString.$indexes.$frames.$text;
			
		$data = array(
			'evaluation_id' => $id,
			'feedback_type' => 1,
			'content' => $content,
			'date_created' => $d,
			'user_id' => $userid,
			'progress' => $progress
		);
		
		$this->sprites_model->add_note($data);
		$evaluation = $this->sprites_model->get_evaluation($id);
		$sprite_id = $evaluation['sprite_id'];
		$progress = $evaluation['progress'] + 1;
		$this->sprites_model->step_progress($id , $progress);
		redirect('sprites/evaluate/'.$sprite_id, 'refresh');
	
	}
	
}

// *** Any creative issues that are more subjective ***

public function feedback($id)
{
	$this->form_validation->set_rules('creative_feedback', 'Feedback', 'required');

	if(!$this->ion_auth->in_group($this->config->item('testerGroup')))
	{
		$this->sprite_class->load('master/access_denied');
	}
	elseif ($this->form_validation->run() === FALSE)
	{
			$data['message'] = "Continuing Existing Evaluation";
			$data['evaluation'] = $this->sprites_model->get_evaluation($id);
			$data['form_open'] = "Creative";
			$data['sprite'] = $this->sprites_model->get_sprite_data($id);
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/evaluate', $data);
	}
	else
	{
		$userid = $this->ion_auth->get_user_id();
		$d = date("Y-m-d");
		
		// Parse the inputs to prepare for a multi-line note
		
		$progress = $this->input->post('progress');
		
		// Checks if palettes where checked
		
		if ( null !== $this->input->post('palette[]'))
			{
				$palettesArray = $this->input->post('palette[]');
				$paletteString = 'Palettes: '.implode(', ',$palettesArray)."\n";
			}
			else
			{
				$paletteString = "";
			}
	
		$indexes = 'Indexes: '.$this->input->post('indexes');
		$frames = "\n".'Frames: '.$this->input->post('frames');
		$text = "\n".'Feedback: '.$this->input->post('creative_feedback');
		
		// Create a multiline note
		$content = $paletteString.$indexes.$frames.$text;
			
		$data = array(
			'evaluation_id' => $id,
			'feedback_type' => 2,
			'content' => $content,
			'date_created' => $d,
			'user_id' => $userid,
			'progress' => $progress 
		);
		
		$this->sprites_model->add_note($data);
		$evaluation = $this->sprites_model->get_evaluation($id);
		$sprite_id = $evaluation['sprite_id'];
		$progress = $evaluation['progress'] + 1;
		$this->sprites_model->step_progress($id , $progress);
		redirect('sprites/evaluate/'.$sprite_id, 'refresh');
	
	}
}

// *** Passes an evaluation ***

public function evaluation_pass($id)
{
	if(!$this->ion_auth->in_group($this->config->item('testerGroup')))
	{
		$this->sprite_class->load('master/access_denied');
	}
	else
	{
		$evaluation = $this->sprites_model->get_evaluation($id);
		$sprite_id = $evaluation['sprite_id'];
		$progress = $evaluation['progress'] + 1;
		$this->sprites_model->step_progress($id , $progress);
		$data['adminArray'] = $data;
		redirect('sprites/evaluate/'.$sprite_id, 'refresh');
	}
}

// *** Edit's an exisiting note on an evaluation ***

public function note_edit($id)
	{
	
	$data['title'] = 'Edit Note';
	$this->form_validation->set_rules('content', 'Content', 'required');
	
	if (!$this->ion_auth->logged_in() ) // Check if user is logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('managerGroup'))) // Check if user is part of the Manager group
		{	
			$this->sprite_class->load('master/access_denied');
		}
	elseif ($this->form_validation->run() === FALSE)
		{
			$data['note'] = $this->sprites_model->get_note($id);
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/note_edit', $data);
		}
	else
		{	// Gathers data for the updated info
			
			$d = date("Y-m-d");
			
			$user = $this->ion_auth->user()->row();
			$username = $user->username;
			
			$modifiedTag = "\n".'Modified by: '.$username.' on '.$d;
			
			$updatedContent = $this->input->post('content').$modifiedTag;			
			$info = array(
				'feedback_type' => $this->input->post('feedback_type'),
				'content' => $updatedContent
				);
			
				$this->sprites_model->edit_note($id, $info);
				redirect('sprites/view/'.$this->input->post('sprite_id'));
		}
	
	}
	
// *** Deletes a note ***
	
public function note_delete($id)
	{
	if (!$this->ion_auth->logged_in() ) // Check if user is logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('managerGroup'))) // Check if user is part of the Manager group
		{	
			$this->sprite_class->load('master/access_denied');
		}
	else
		{
			$data['note'] = $this->sprites_model->get_note($id);
			$data['adminArray'] = $data;
			$this->sprite_class->load('sprites/note_delete', $data);
		}
	
	}

// *** Re-direct once note is deleted to confirm ***

public function note_delete_confirmed($id)
	{
	if (!$this->ion_auth->logged_in() ) // Check if user is logged in
		{
			redirect('auth/login', 'refresh');
		}
	elseif (!$this->ion_auth->in_group($this->config->item('managerGroup'))) // Check if user is part of the Manager group
		{	
			$this->sprite_class->load('master/access_denied');
		}
	else
		{
		$this->sprites_model->delete_note($id);
		redirect('sprites/view/'.$this->input->post('sprite_id'));
		}
	}
	
// *** Uploads feedback specific for the admins of the site ***

public function site_feedback() // Work In Progress.
	{
	
	
	$this->form_validation->set_rules('feedback', 'feedback', 'required');
	
	if (!$this->ion_auth->logged_in()) // Check if user is logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
	elseif ($this->form_validation->run() === FALSE)
	{
			$data['adminArray'] = 'No Arrays Loaded';
			$this->sprite_class->load('master/site_feedback',$data);
	}
		else
		{
		$userid = $this->ion_auth->get_user_id();
		$d = date("Y-m-d");
		
			
		$data = array(
			'evaluation_id' => 0,
			'feedback_type' => 4,
			'content' => $this->input->post('feedback'),
			'date_created' => $d,
			'user_id' => $userid,
			'progress' => 0,
		);
		
		$this->sprites_model->add_note($data);
		redirect('home','refresh');
	
	}
		
	}
	
// *** Shows feedback for the site to the admin ***
	
public function show_site_feedback()
	{
		if (!$this->ion_auth->logged_in()) // Check if user is logged in
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) // Check if user is admin
		{	
			$this->sprite_class->load('master/access_denied');
		}
		else
		{
		$data['notes'] = $this->sprites_model->get_site_feedback();
		$data['adminArray'] = $data;
		$this->sprite_class->load('master/show_site_feedback',$data);
		
		}
	}

// *** SPRITE APPROVAL *** //
// *** WIP, adds the sprite to the "approved" table and sets the status to approved.
 
// *** CLOSING BRACKET *** //

}
