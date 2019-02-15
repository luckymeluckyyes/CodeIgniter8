<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model('user_model');
	}

	public function index() {

		$data['users'] = $this->user_model->get_users();
		$this->load->view('user_v', $data);
	}

	public function show($id) {

		$data['users'] = $this->user_model->get_users($id);
		$this->load->view('user_v', $data);
	}

	public function edit($id) {

		$data['users'] = $this->user_model->get_users($id);
		$this->load->view('edit_user', $data);
	}

	public function edit_process() {

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');

		$user_id = $this->input->post('user_id');

		$user = array(
			'name' => $name,
			'email' => $email,
			'password' => $password,
			'phone' => $phone
		);

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_edit_check_avail');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE) {

			 $this->session->set_flashdata('error', validation_errors('<p class="alert alert-danger">'));
			 redirect('user/edit/'.$user_id);
		} else {

			$call = $this->user_model->update_user($user, $user_id);

			if($call) {

				$this->session->set_flashdata('edit_success', 'User data successfully updated!');
				redirect('user');
			} else {

				redirect('user');
			}
		}
	}

	public function edit_check_avail() {

		$email = $this->input->post('email');
		$id = $this->input->post('user_id');

		$emailcheck = $this->user_model->editemailcheck($email, $id);

		if($emailcheck) {

			$this->form_validation->set_message('edit_check_avail', 'The '.$email.' already exists.');
			return FALSE;
		} else {

			return TRUE;
		}
	}

	public function delete($id) {

		$s = $this->user_model->delete_user($id);

		if($s) {

			$this->session->set_flashdata('delete_success', 'User successfully deleted');
			redirect('user');
		} else {

			$this->session->set_flashdata('error', 'Some error occured. Please try again!');
			redirect('user');
		}
	}

	public function delete_multi() {

		$u_ids = $this->input->post('ids');
		$u_ids = implode(',', $u_ids);
		$s = $this->user_model->delete_multi_user($u_ids);

		if($s) {

			$this->session->set_flashdata('delete_success', 'Selected user deleted successfully');
			redirect('user');
		} else {

			$this->session->set_flashdata('error', 'Some error occured. Please try again!');
			redirect('user');
		}
	}
}

 ?>