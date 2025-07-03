<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
		$data['title'] = 'Master Data User';

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'content'   => $this->load->view('master_data/user/index', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('master_data/user/script', '', TRUE),
        );
			
        $this->parser->parse('layout/index', $template);
    }

	public function index_data() {

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
				$row[] = date("d-m-Y", strtotime($user->created_at ));;
				// contoh tambah action
				$row[] = '<a href="#" class="btn btn-sm btn-primary">Edit</a>';

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
}

/* End of file User.php and path \application\controllers\User.php */
