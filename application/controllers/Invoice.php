<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Invoice_model', 'invoice');
		$this->load->model('Item_model', 'item');
		$this->load->model('User_model', 'user');
		$this->load->model('Vendor_model', 'vendor');
		if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
		$data['title'] = 'Invoices';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('invoice/index', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('invoice/script', '', TRUE),
        );
			
        $this->parser->parse('layout/index', $template);
    }

	public function index_data() 
	{

		if ($this->input->is_ajax_request() == true) {
			
            $list = $this->invoice->get_datatables();
            $data = array();
			$no = $_POST['start'];
			foreach ($list as $invoice) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $invoice->inv_number;
				$row[] = $invoice->vendor_name;
				$row[] = date('F Y', strtotime($invoice->period . '-01'));
				$row[] = date("d-m-Y", strtotime($invoice->post_date));
				if($invoice->status == 'draft'){
					$row[] = '<span class="badge badge-pill badge-warning">Draft</span>';
				} else {
					$row[] = '<span class="badge badge-pill badge-success">Confirmed</span>';
				}
				$row[] = number_format($invoice->total_qty, 0, ',', '.');
				$row[] = 'Rp. ' . number_format($invoice->total_cost, 0, ',', '.');
				// contoh tambah action
				$btn = '';
				if($invoice->is_confirmed == 0 || !$invoice->is_confirmed){
					$btn_confirm = '<button data-id=' . $invoice->id . ' data-inv_number="'. $invoice->inv_number .'" class="btn btn-sm btn-success btn_confirm"><span class="fw-bold">Confirm</span> </button>';
					$btn_delete = '<button data-id=' . $invoice->id . ' data-inv_number="'. $invoice->inv_number .'" class="btn btn-sm btn-danger btn_delete"><i class="fas fa-solid fa-trash"></i> </button> ';
					$btn = '<a href="' . site_url('invoice/edit/' . $invoice->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i> </a> '. $btn_delete . $btn_confirm;
				} 
				$row[] = $btn;


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
		$user_id = $this->session->userdata('user_id');
		$vendor = $this->vendor->getVendor($user_id);
		
		$data['title'] = 'Invoice';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));
		$data['sub_title'] = 'Create new Invoice';
		$data['vendor_name'] = $vendor->name ?? 'Admin';
		$data['vendor_id'] = $vendor->id ?? null;

		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('invoice/create', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('invoice/script', '', TRUE),
        );
        $this->parser->parse('layout/index', $template);

	}

	public function edit($id) 
	{
		$user_id = $this->session->userdata('user_id');
		$vendor = $this->vendor->getVendor($user_id);
		
		$data['title'] = 'Invoice';
		$data['sub_title'] = 'Edit Invoice';
		$data['user'] = $this->user->getUser($this->session->userdata('user_id'));
		$data['vendor_name'] = $vendor->name;
		$data['vendor_id'] = $vendor->id;
		$data['invoice'] = $this->invoice->getInvoice($id);
		$data['items'] = $this->item->getItemsByInvoiceId($id);
		$data['attachment'] = $this->db->get_where('attachment', ['inv_id' => $data['invoice']->id])->row();
		
		$template       = array(
            'header'    => $this->load->view('layout/header', '', TRUE),
            'sidebar'   => $this->load->view('layout/sidebar', '', TRUE),
            'topbar'    => $this->load->view('layout/topbar', $data, TRUE),
            'content'   => $this->load->view('invoice/edit', $data, TRUE),
            'footer'    => $this->load->view('layout/footer', '', TRUE),
            'script'    => $this->load->view('layout/script', '', TRUE),
            'script2'    => $this->load->view('invoice/script', '', TRUE),
        );
        $this->parser->parse('layout/index', $template);

	}

	public function store()
	{
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
		$this->form_validation->set_rules('period', 'Period', 'required');
		$this->form_validation->set_rules('post_date', 'Post Date', 'required');
		$this->form_validation->set_rules('total_qty', 'Total Quantity', 'required');
		$this->form_validation->set_rules('total_cost', 'Grand Total', 'required');
		
		if ($this->form_validation->run() == TRUE) {
			
			$post_date = date($this->input->post('post_date'));
			$inv_number = $this->invoiceNumberGenerator();

			$data_invoice = [
				'inv_number' => $inv_number,
				'vendor_id' => $this->input->post('vendor_id'),
				'vendor_name' => $this->input->post('vendor_name'),
				'period' => date($this->input->post('period')),
				'post_date' => $post_date,
				'status' => 'draft',
				'total_qty' => $this->input->post('total_qty'),
				'total_cost' => $this->input->post('total_cost'),
				'is_confirmed' => NULL,
			];

			$inv_id = $this->invoice->insert($data_invoice);

			if ($inv_id) {
				$items = $this->input->post('item_name');
				$quantity = $this->input->post('quantity');
				$price = $this->input->post('price');
				$total = $this->input->post('total');
				foreach($items as $i => $item) {
					$data_item = [
						'inv_id' 	 => $inv_id,
						'inv_number' => $inv_number,
						'item_name'  => $item,
						'quantity'   => $quantity[$i],
						'price' 	 => $price[$i],
						'total' 	 => $total[$i],
					];

					$this->item->insert($data_item);
				}

				$config['upload_path']   = './uploads/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['max_size']      = 2048; 
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('attachment')) {
					$upload_data = $this->upload->data();

					$file_path = $upload_data['full_path'];
					$file_type = $upload_data['file_type'];

					$file_content = file_get_contents($file_path);
					$base64_image = 'data:' . $file_type . ';base64,' . base64_encode($file_content);
					$data_attachment = [
						'inv_id'         => $inv_id, 
						'attachment_img' => $base64_image,
						'attachment_ext' => $upload_data['file_ext']
					];

					$this->db->insert('attachment', $data_attachment);
				}

				

				$this->session->set_flashdata('success', 'Invoice has been submited');
            } else {
                $this->session->set_flashdata('error', 'Failed to submit invoice');
            }
			redirect('invoice/create');

		} else {
			redirect('invoice/create');
			$this->session->set_flashdata('error', validation_errors());
		}

		// Note: period disimpan sebagai VARCHAR dan akan dimasking di index_data
	}

	public function update()
	{
		$this->form_validation->set_rules('inv_id', 'Invoice ID', 'required');
		$this->form_validation->set_rules('inv_number', 'Invoice Number', 'required');
		$this->form_validation->set_rules('period', 'Period', 'required');
		$this->form_validation->set_rules('post_date', 'Post Date', 'required');
		$this->form_validation->set_rules('total_qty', 'Total Quantity', 'required');
		$this->form_validation->set_rules('total_cost', 'Grand Total', 'required');
		
		if ($this->form_validation->run() == TRUE) {
			$inv_id = $this->input->post('inv_id');
			$inv_number = $this->input->post('inv_number');

			// ini update invoice
			$data_invoice = [
				'total_qty' => $this->input->post('total_qty'),
				'total_cost' => $this->input->post('total_cost'),
			];

			$this->invoice->update($inv_id, $data_invoice);

			// ini update item lama
			$items_id = $this->input->post('item_id');
			$item_old = $this->input->post('item_name_old');
			$quantity_old = $this->input->post('quantity_old');
			$price_old = $this->input->post('price_old');
			$total_old = $this->input->post('total_old');
			foreach($items_id as $i => $item) {
				$data_item = [
					'item_name'  => $item_old[$i],
					'quantity'   => $quantity_old[$i],
					'price' 	 => $price_old[$i],
					'total' 	 => $total_old[$i],
				];

				$this->item->update($item, $data_item);
			}

			// ini nambah kalo ada item baru
			if($this->input->post('item_name')){
				$items = $this->input->post('item_name');
				$quantity = $this->input->post('quantity');
				$price = $this->input->post('price');
				$total = $this->input->post('total');
				foreach($items as $i => $item) {
					$data_item = [
						'inv_id' 	 => $inv_id,
						'inv_number' => $inv_number,
						'item_name'  => $item,
						'quantity'   => $quantity[$i],
						'price' 	 => $price[$i],
						'total' 	 => $total[$i],
					];
	
					$this->item->insert($data_item);
				}
			}

			// ini delete item lama
			$deleted_ids = $this->input->post('deleted_ids');
			if (!empty($deleted_ids)) {
				foreach($deleted_ids as $item_id){
					$this->item->remove($item_id);
				}
			}
			$this->session->set_flashdata('success', 'Invoice has been updated');
			redirect('invoice');

		} else {
			redirect('invoice/create');
			$this->session->set_flashdata('error', validation_errors());
		}

		// Note: period disimpan sebagai VARCHAR dan akan dimasking di index_data
	}

	public function confirm($id)
	{
		$data = [
			'is_confirmed' => $this->input->post('is_confirmed'),
			'status' => $this->input->post('status'),
		];

		if($this->invoice->update($id, $data)){
			$this->session->set_flashdata('success', 'Invoice has been confirmed');
		} else {
			$this->session->set_flashdata('error', 'Failed to confirm invoice');
		}
		redirect('invoice');
	}

	public function delete($id)
	{
		if($this->invoice->remove($id)){
			$this->item->removeByInvoiceId($id);
			$this->db->where('inv_id', $id)->delete('attachment');
			$this->session->set_flashdata('success', 'Invoice has been deleted');
		} else {
			$this->session->set_flashdata('error', 'Failed to confirm invoice');
		}
	}

	private function invoiceNumberGenerator()
	{
		// Format Invoice: INV/vendor_code(last digit(s))/year(yy)/month.day(mm.dd)/xxxx(4 digits incremental)
		$user_id 	 = $this->session->userdata('user_id');
		$vendor 	 = $this->vendor->getVendor($user_id);
		$vendor_code = (int) substr($vendor->vendor_code, 7);

		$day 	= date('d');
		$month 	= date('m');
		$year  	= date('y');
		$mmdd  	= $month . $day;

		$this->db->select('inv_number');
		$this->db->from('invoice');
		$this->db->like('inv_number', 'INV/'.$vendor_code.'/');
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();		

		if ($query->num_rows() > 0) {
			$last_code = $query->row()->inv_number;
			$last_number = (int) substr($last_code, -4);
			$new_number = $last_number + 1;
		} else {
			$new_number = 1;
		}

		$new_invoice_number = 'INV/'. $vendor_code . '/' . $year . '/' . $mmdd . '/' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
		return $new_invoice_number;
	}

	private function upload() {
        if (!is_dir($this->secure_upload_path)) {
            mkdir($this->secure_upload_path, 0755, true);
        }

        $file = $_FILES['image'];

        // Validasi MIME dan size
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            show_error('File type not allowed.');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            show_error('File too large (max 2MB).');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_filename = md5(uniqid(rand(), true)) . '.' . $ext;
        $full_path = $this->secure_upload_path . $new_filename;

        if (move_uploaded_file($file['tmp_name'], $full_path)) {
            // Simpan ke database
            $this->db->insert('uploaded_files', [
                'filename' => $new_filename,
                'original_name' => $file['name']
            ]);
            redirect('upload');
        } else {
            show_error('Gagal upload.');
        }
    }

}

/* End of file Invoice.php and path \application\controllers\Invoice.php */
