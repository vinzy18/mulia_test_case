<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Auth_model', 'auth');
    }

    public function index()
    {
		if ($this->session->userdata('logged_in')) {
			redirect('dashboard');
		}

		$this->load->view('login');
    }

	public function login() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->auth->checkCredential($username, $password);

        if ($user) {
            $this->session->set_userdata([
                'logged_in' => true,
                'user_id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->fullname,
            ]);	
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', "Credential doesn't match");
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}

/* End of file Auth.php and path \application\controllers\Auth.php */
