<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('User_model', 'user');
		if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
		$data['title'] = 'Dashboard';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('dashboard/index', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
        );
        $this->parser->parse('layout/index', $template);
    }
}

/* End of file Dashboard.php and path \application\controllers\Dashboard.php */
