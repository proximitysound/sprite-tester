<?php
class Sprites_model extends CI_Model {

public function __construct()
	{
	
	}

public function get_all_sprites()
	{
		$this->db->select(array
			(	'sprites.id',
				'sprites.name',
				'sprites.user_id',
				'sprites.vt_version',
				'sprites.submission_version',
				'username',
				'status',
				'filename',
				'sprites.date_created',
				'sprites.date_modified',
				'status_name',
				'COUNT(evaluations.id) as test_count'
		
		));
		$this->db->from('sprites');
		$this->db->join('users', 'users.id = sprites.user_id');
		$this->db->join('statuses', 'sprites.status = statuses.id');
		$this->db->join('evaluations','evaluations.sprite_id = sprites.id AND evaluations.submission_version = sprites.submission_version','left outer')->group_by('sprites.id');
		$this->db->order_by('sprites.name', 'ASC');
		$query = $this->db->get();	
		return $query->result_array();
	}
	
public function get_tested_sprites()
	{
		$this->db->select(array
			(	'sprites.id',
				'sprites.name',
				'sprites.user_id',
				'sprites.vt_version',
				'sprites.submission_version',
				'username',
				'status',
				'filename',
				'sprites.date_created',
				'sprites.date_modified',
				'status_name',
				'COUNT(evaluations.sprite_id) as test_count'
		
		), FALSE);
		$this->db->from('sprites');
		$this->db->join('users', 'users.id = sprites.user_id');
		$this->db->join('statuses', 'sprites.status = statuses.id');
		$this->db->join('evaluations','evaluations.sprite_id = sprites.id')->group_by('evaluations.sprite_id');
		$this->db->order_by('sprites.name', 'ASC');
		$query = $this->db->get();	
		return $query->result_array();
	}

public function get_statuses_submit()
	{
		$this->db->where('admin', '0');
		$query = $this->db->get('statuses');
		return $query->result_array();
	}
	
public function get_statuses_edit()
	{
		$where = "admin = '0' OR admin = '1'";
		$this->db->where($where);
		$query = $this->db->get('statuses');
		return $query->result_array();
	}

public function add_sprite()
	{
		
		$upload_file_name = $this->upload->data('file_name');
		$d = date("Y-m-d");
		
		
		$data = array(
			'name' => $this->input->post('name'),
			'filename' => $upload_file_name,
			'status' => $this->input->post('status'),
			'vt_version' => '0',
			'submission_version' => '1',
			'user_id' => $this->input->post('user_id'),
			'date_created' => $d,
			'date_modified' => $d
		);

		return $this->db->insert('sprites', $data);
		$this->session->set_flashdata('uploaded_sprite' , 'Success');
		
	}
	
public function get_sprite_data($id)
	{
	
		$this->db->where('id', $id);
		$query = $this->db->get('sprites');
		return $query->row_array();

	}
	
public function edit_sprite_info($id, $info)
	{
	
		$this->db->where('id', $id);
		return $this->db->update('sprites', $info);
	
	}		

public function get_user_sprites($id)
	{
		$this->db->select('sprites.id,sprites.name,user_id,vt_version,submission_version,username,status,filename,date_created,date_modified,status_name');
		$this->db->from('sprites');
		$this->db->join('users', 'users.id = sprites.user_id');
		$this->db->join('statuses', 'sprites.status = statuses.id');
		$this->db->order_by('sprites.name', 'ASC');
		$this->db->where('user_id', $id);
		$query = $this->db->get();	
		return $query->result_array();
	}
	
public function create_evaluation($id)
	{
		$userid = $this->ion_auth->get_user_id();
		$d = date("Y-m-d");
		$spritedata = $this->sprites_model->get_sprite_data($id);
		
		$data = array(
			'user_id' => $userid,
			'sprite_id' => $id,
			'vt_version' => $spritedata['vt_version'],
			'submission_version' => $spritedata['submission_version'],
			'progress' => 1,
			'date_created' => $d,
			'date_modified' => $d
		);
		return $this->db->insert('evaluations', $data);
			
	}
	
public function evaluation_check($id)
	{	
		$userid = $this->ion_auth->get_user_id();
		$spritedata = $this->sprites_model->get_sprite_data($id);
	
		$this->db->where('vt_version',$spritedata['vt_version']);
		$this->db->where('submission_version',$spritedata['submission_version']);
		$this->db->where('user_id', $userid);
		$this->db->where('sprite_id', $id);
		$query = $this->db->count_all_results('evaluations');
		return $query;
	}
	
public function get_current_evaluation($id)
	{
		$userid = $this->ion_auth->get_user_id();
		$spritedata = $this->sprites_model->get_sprite_data($id);
		
		$this->db->where('vt_version',$spritedata['vt_version']);
		$this->db->where('submission_version',$spritedata['submission_version']);
		$this->db->where('user_id', $userid);
		$this->db->where('sprite_id', $id);
		$query = $this->db->get('evaluations');
		return $query->row_array();
		
	}
	
public function get_evaluation($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('evaluations');
		return $query->row_array();	
	}

public function add_note($data)
	{
		return $this->db->insert('notes', $data);
	}

public function step_progress($id,$progress)
	{
		$d = date("Y-m-d");
		
		$this->db->where('id', $id);
		return $this->db->update('evaluations', array(
												'progress' => $progress,
												'date_modified' => $d
												));	
	
	}

public function get_sprite_evaluations($id)
	{
		$spritedata = $this->sprites_model->get_sprite_data($id);
		
		$this->db->select(array(
				'username',
				'evaluations.id',
				'evaluations.sprite_id',
				'evaluations.progress',
				'evaluations.date_created',
				'evaluations.date_modified',
				'SUM(CASE notes.feedback_type WHEN 1 then 1 else 0 end) AS error_notes'	
		));
		
		$this->db->from('evaluations');
		$this->db->where('evaluations.sprite_id', $spritedata['id']);
		$this->db->where('vt_version',$spritedata['vt_version']);
		$this->db->where('submission_version',$spritedata['submission_version']);
		$this->db->join('users','evaluations.user_id = users.id');
		$this->db->join('notes','notes.evaluation_id = evaluations.id', 'left')->group_by('notes.evaluation_id');
		$this->db->order_by('evaluations.date_modified');
		$query = $this->db->get();
		return $query->result_array();
		
	}

public function get_sprite_notes($id)
	{
		$spritedata = $this->sprites_model->get_sprite_data($id);
		
		$this->db->select(array(
				'username',
				'notes.id',
				'notes.progress',
				'feedback_type',
				'content',
				'notes.date_created',
		
		));
		
		$this->db->where('evaluations.sprite_id', $spritedata['id']);
		$this->db->join('evaluations', 'notes.evaluation_id = evaluations.id','left');
		$this->db->join('users','users.id = evaluations.user_id','left');
		$this->db->order_by('username');
		$query = $this->db->get('notes');
		return $query->result_array();
		
	}
	
public function get_note($id)
	{
		$this->db->select(array(
				'username',
				'notes.id',
				'notes.progress',
				'feedback_type',
				'content',
				'sprites.name as sprite_name',
				'notes.date_created',
				'evaluations.sprite_id'
		
		));
		$this->db->join('evaluations', 'notes.evaluation_id = evaluations.id');
		$this->db->join('users','users.id = notes.user_id');
		$this->db->join('sprites', 'sprites.id = evaluations.sprite_id');
		$this->db->where('notes.id',$id);
		$query = $this->db->get('notes');
		return $query->row_array();		
	}
	
public function edit_note($id,$info)
	{
		$this->db->where('id', $id);
		return $this->db->update('notes', $info);
	}
	
public function delete_note($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('notes');
	}
	
public function get_site_feedback()
	{
		$this->db->select(array(
				'username',
				'notes.id',
				'content',
				'notes.date_created',
		));
		
		$this->db->where('feedback_type', 4);
		$this->db->join('users','users.id = notes.user_id','left');
		$query = $this->db->get('notes');
		return $query->result_array();
	}

//*** CLOSING BRACKET ***
}