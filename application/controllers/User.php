<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('user_m');
		$this->load->library('form_validation');
    }

	public function index()
	{
		$data['row'] = $this->user_m->get();
		$this->template->load('template','user/user_data',$data);
	}

	public function add()
	{
		$this->form_validation->set_rules('fullname', 'Name','required|callback_addname_check');
        $this->form_validation->set_rules('username', 'User name', 'required|min_length[5]|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]',
            array('matches' => ' Those passwords didn’t match. Try again.')
        );
        $this->form_validation->set_rules('level', 'Level', 'required');

		$this->form_validation->set_message('required', '%s must be filled');
        $this->form_validation->set_message('min_length', '{field} at least 5 characters');
        $this->form_validation->set_message('is_unique', '{field} is already in use');

		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');


		if($this->form_validation->run() == FALSE){
			$this->template->load('template','user/user_form_add');

		}else{
			$post = $this->input->post(null, TRUE);
            $this->user_m->add($post);
            if($this->db->affected_rows() > 0) {
                echo "<script>alert('data saved');</script>";
            }
            echo "<script>window.location='".site_url('user')."';</script>";
		}
	}

	function addname_check(){
		$post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM user WHERE name = '$post[fullname]'");
        if($query->num_rows() > 0) {
            $this->form_validation->set_message('addname_check', '{field} is already in use');
            return FALSE;
        } else {
            return TRUE;
        }
	}

	public function edit($id)
	{
		$this->form_validation->set_rules('fullname', 'Name', 'required|callback_fullname_check');
        $this->form_validation->set_rules('username', 'User name', 'required|min_length[5]|callback_username_check');
        if($this->input->post('password')){
			$this->form_validation->set_rules('password', 'Password', 'min_length[5]');
        	// $this->form_validation->set_rules('passconf', 'Password Confirmation', 'matches[password]',
            // array('matches' => 'passwords didn’t match. please try again.')
        	// );
		}
        // if($this->input->post('passconf')){
        // 	$this->form_validation->set_rules('passconf', 'Password Confirmation', 'matches[password]',
        //     array('matches' => ' passwords didn’t match. please try again.')
        // 	);
		// }
        $this->form_validation->set_rules('level', 'Level', 'required');
		$this->form_validation->set_message('required', '%s must be filled');
        $this->form_validation->set_message('min_length', '{field} at least 5 characters');
        // $this->form_validation->set_message('is_unique', '{field} is already in use');

		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');


		if($this->form_validation->run() == FALSE){
			$query = $this->user_m->get($id);
			if($query->num_rows() > 0) {
                $data['row'] = $query->row();
                $this->template->load('template', 'user/user_form_edit', $data);
            } else {
                echo "<script>alert('data not found');";
                echo "window.location='".site_url('user')."';</script>";
            }

		}else{
			$post = $this->input->post(null, TRUE);
            $this->user_m->edit($post);
            if($this->db->affected_rows() > 0) {
                echo "<script>alert('data updated');</script>";
            }
            echo "<script>window.location='".site_url('user')."';</script>";
		}
	}

    function fullname_check(){
		$post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM user WHERE name = '$post[fullname]' AND user_id != '$post[user_id]'");
        if($query->num_rows() > 0) {
            $this->form_validation->set_message('fullname_check', '{field} is already in use');
            return FALSE;
        } else {
            return TRUE;
        }
	}

	function username_check(){
		$post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM user WHERE username = '$post[username]' AND user_id != '$post[user_id]'");
        if($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', '{field} is already in use');
            return FALSE;
        } else {
            return TRUE;
        }
	}

	public function del()
    {
        $id = $this->input->post('user_id');
        $this->user_m->del($id);

        if($this->db->affected_rows() > 0) {
            echo "<script>alert('data deleted');</script>";
        }
        echo "<script>window.location='".site_url('user')."';</script>";
    }
}