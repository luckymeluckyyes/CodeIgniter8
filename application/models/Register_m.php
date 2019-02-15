<?php 

class Register_m extends CI_Model {

	public function __construct() {

		parent::__construct();
	}

	public function register_user($user) {

		$this->db->insert('users', $user);
		return TRUE;
	}

	public function emailcheck($email) {

		$this->db->where('email', $email);
		$r = $this->db->get('users');
		if($r->num_rows() > 0) {

			return TRUE;
		} else {

			return FALSE;
		}
	}

	public function login_user($email, $password) {

		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$result = $this->db->get('users');

		if($result->num_rows() == 1) {

			return $result->row(0)->id;
		} else {

			$this->session->set_flashdata('error', 'Email or password is incorrect');
			return FALSE;
		}
	}

	public function getuserdata($user_id) {

		$this->db->where('id', $user_id);
		$result = $this->db->get('users');

		return $result->row();
	}
}

 ?>