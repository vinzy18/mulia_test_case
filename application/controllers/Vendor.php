<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendor_model', 'vendor');
        $this->load->model('User_model', 'user');
		if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

   	public function index()
    {
		$data['title'] = 'Master Data Vendor';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('master_data/vendor/index', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('master_data/vendor/script', '', TRUE),
        );
			
        $this->parser->parse('layout/index', $template);
    }

	public function index_data() 
	{

		if ($this->input->is_ajax_request() == true) {
			
            $list = $this->vendor->get_datatables();
            $data = array();
			$no = $_POST['start'];
			foreach ($list as $vendor) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $vendor->name;
				$row[] = $vendor->vendor_code;
				$row[] = $vendor->address;
				$row[] = $vendor->email;
				$row[] = date("d-m-Y", strtotime($vendor->join_date));
				$row[] = date("d-m-Y", strtotime($vendor->created_at));
				// contoh tambah action
				$btn_generate_user = '';
				if(!$vendor->user_id) {
					$btn_generate_user = '<a href="#" data-fullname=' . $vendor->name .' data-email=' . $vendor->email .' data-vendor_id=' . $vendor->id .' class="btn btn-sm btn-warning btn-generate-user"><i class="fas fa-solid fa-paper-plane"></i> Generate User</a>';
				}
				$row[] = '<a href="#" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i> </a> ' . $btn_generate_user;

				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->vendor->count_all(),
				"recordsFiltered" => $this->vendor->count_filtered(),
				"data" => $data,
			);

			echo json_encode($output);
        } else {
            exit('No data.');
        }
	}

	public function create() 
	{

		$data['title'] = 'Master Data Vendor';
		$data['sub_title'] = 'Create new Vendor';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('master_data/vendor/create', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('master_data/vendor/script', '', TRUE),
        );
        $this->parser->parse('layout/index', $template);

	}

	public function store() 
	{

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');


		if ($this->form_validation->run() == TRUE) {

			$join_date = date($this->input->post('join_date', TRUE));
			 $data = [
                'name'  => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'vendor_code' => $this->vendorCodeGenerator($join_date),
                'join_date' => $join_date,
                'address' => $this->input->post('address', TRUE),
            ];

            if ($this->vendor->insert($data)) {
                $this->session->set_flashdata('success', 'Vendor has been created');
            } else {
                $this->session->set_flashdata('error', 'Failed to create vendor');
            }

			redirect('vendor');
		} else {
			$this->session->set_flashdata('error', validation_errors());
			redirect('vendor/create');
		}

		
	}

	public function generate_user() 
	{

		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');


		if ($this->form_validation->run() == TRUE) {

			$is_vendor = $this->input->post('is_vendor', TRUE) ? 1 : NULL;
			$vendor_id = $this->input->post('vendor_id', TRUE);

			 $data = [
                'fullname'  => $this->input->post('fullname', TRUE),
                'email' => $this->input->post('email', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                'is_vendor' => $is_vendor,
            ];

            if ($this->user->insert($data)) {
                $this->session->set_flashdata('success', 'User has been created');
				$this->vendor->update($vendor_id, ['user_id' => $this->db->insert_id()]);
            } else {
                $this->session->set_flashdata('error', 'Failed to create user');
            }

			redirect('vendor');
		} else {
			redirect('vendor');
			$this->session->set_flashdata('error', validation_errors());
		}

	}

	private function vendorCodeGenerator($join_date)
	{
		$month = date('m', strtotime($join_date));
		$year  = date('y', strtotime($join_date));
		$mmyy  = $month . $year;

		$this->db->select('vendor_code');
		$this->db->from('vendor');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$last_code = $query->row()->vendor_code;
			$last_number = (int) substr($last_code, 8);
			$new_number = $last_number + 1;
		} else {
			$new_number = 1;
		}

		$new_vendor_code = 'VND' . $mmyy . str_pad($new_number, 4, '0', STR_PAD_LEFT);
		return $new_vendor_code;
	}

}

/* End of file Vendor.php and path \application\controllers\Vendor.php */
