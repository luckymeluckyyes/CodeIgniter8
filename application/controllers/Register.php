<?php 

class Register extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model('register_m');
	}

	public function index() {

		$this->load->view('register_v');
	}

	public function register_process() {

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$phone = $this->input->post('phone');

		$user = array(
			'name' => $name,
			'email' => $email,
			'password' => $password,
			'phone' => $phone
		);

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('con_password', 'Confirm Password','required|matches[password]');

		if($this->form_validation->run() == FALSE) {

			$this->session->set_flashdata('error', validation_errors('<p class="alert alert-danger">'));
			redirect('register');
		} else {

			$call = $this->register_m->register_user($user);

			if($call) {

				$this->session->set_flashdata('register_success', 'You are successfully registered.You can login now.'.anchor('register/login_process', 'Login Here!'));
				redirect('register');
			} else {

				redirect('register');
			}
		}
	}

	public function check_avail($email) {

		$emailcheck = $this->register_m->emailcheck($email);

		if($emailcheck) {

			$this->form_validation->set_message('check_avail', 'The '.$email.' already exists.');
			return FALSE;
		} else {

			return TRUE;
		}
	}

	public function login_process() {

		if($this->session->userdata('logged_in') == TRUE) {

			redirect('register/loggedin');
		}

		$this->load->view('login');

		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE) {

			$this->session->set_flashdata('error', validation_errors());
		} else {

			$user_id = $this->register_m->login_user($email, $password);

			if($user_id) {

				$user_data = array(
					'user_id' => $user_id,
					'email' => $email,
					'logged_in' => TRUE
				);

				$this->session->set_userdata($user_data);
				$this->session->set_flashdata('login_success', 'You are now logged in.');
				redirect('register/loggedin');
			} else {

				redirect('register/login_process');
			}
		}
	}

	public function loggedin() {

		if($this->session->userdata('logged_in') == FALSE) {

			$this->session->set_flashdata('error', '<p class="alert alert-danger">Please login to view this page.</p>');
			redirect('register/login_process');
			exit;
		}

		$user_id = $this->session->userdata('user_id');
		$user = $this->register_m->getuserdata($user_id);
		$this->load->view('loggedin_v', $user);
	}

	public function logout() {

		$ar = array('user_id', 'email', 'logged_in');
		$this->session->unset_userdata($ar);
		$this->session->set_flashdata('logout_success', 'You are logged out successfully!');
		redirect('register/login_process');
	}
}

 ?>