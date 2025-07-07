<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$data['title'] = 'Master Data User';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('master_data/user/index', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('master_data/user/script', '', TRUE),
        );
			
        $this->parser->parse('layout/index', $template);
    }

	public function index_data() 
	{

		if ($this->input->is_ajax_request() == true) {
			
            $list = $this->user->get_datatables();
            $data = array();
			$no = $_POST['start'];
			foreach ($list as $user) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $user->fullname;
				$row[] = $user->username;
				$row[] = $user->email;
				if($user->is_vendor == 1){
					$row[] = '<span class="badge badge-pill badge-success">Yes</span>';
				} else {
					$row[] = '<span class="badge badge-pill badge-danger">No</span>';
				}
				$row[] = date("d-m-Y", strtotime($user->created_at));
				// contoh tambah action
				$row[] = '<a href="#" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i> </a> ';

				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->user->count_all(),
				"recordsFiltered" => $this->user->count_filtered(),
				"data" => $data,
			);

			echo json_encode($output);
        } else {
            exit('No data.');
        }
	}

	public function create() 
	{
		$data['title'] = 'Master Data User';
		$data['sub_title'] = 'Create new User';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));
		$data['roles'] = $this->db->get('roles')->result();
		
		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('master_data/user/create', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('master_data/user/script', '', TRUE),
        );
        $this->parser->parse('layout/index', $template);

	}

	public function store() 
	{

		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {

			 $data = [
                'fullname'  => $this->input->post('fullname', TRUE),
                'email' => $this->input->post('email', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id', TRUE),
            ];

            if ($this->user->insert($data)) {
                $this->session->set_flashdata('success', 'User has been created');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user');
            }

			redirect('user');
		} else {
			redirect('user/create');
			$this->session->set_flashdata('error', validation_errors());
		}

	}
}

/* End of file User.php and path \application\controllers\User.php */
