<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Invoice_model extends CI_Model 
{
    private $table = 'invoice';
	private $column_order = array(null, 'id', 'inv_number', 'vendor_name ', 'period', 'post_date', 'status', 'total_qty', 'total_cost', 'is_confirmed'); 
	private $column_search = array('inv_number', 'vendor_name ', 'period', 'post_date', 'status', 'total_qty', 'total_cost', 'is_confirmed'); 
	private $order = array('id' => 'desc'); 

	private function _get_datatables_query()
	{
		$this->db->from($this->table);

		$CI =& get_instance();
		$role_id = $CI->session->userdata('role_id');
		$vendor_id = $CI->session->userdata('vendor_id');

		if ($role_id == 3) {
			$this->db->where('vendor_id', $vendor_id);
		} else if($role_id == 2) {
			$this->db->where('is_confirmed', 1);
		}

		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		return $this->db->get()->result();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		return $this->db->count_all_results();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function getInvoice($id)
	{
		return $this->db->get_where('invoice', ['id' => $id])->row();
	}
             
	public function insert($data)
    {
		$this->db->insert('invoice', $data);
        return $this->db->insert_id();
    }         

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}               

	public function remove($id){
		$this->db->where('id', $id);
		return $this->db->delete('invoice');
	}        
	
}


/* End of file Invoice_model.php and path \application\models\Invoice_model.php */
