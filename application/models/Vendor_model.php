<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Vendor_model extends CI_Model 
{
	private $table = 'vendor';
	private $column_order = array(null, 'id', 'name', 'address', 'vendor_code', 'email', 'join_date', 'user_id'); 
	private $column_search = array('name', 'address', 'vendor_code', 'email', 'join_date'); 
	private $order = array('name' => 'asc'); 

	private function _get_datatables_query()
	{
		$this->db->from($this->table);

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

	public function getVendor($id)
	{
		return $this->db->get_where('vendor', ['user_id' => $id])->row();
	}
	
	public function insert($data)
    {
        return $this->db->insert('vendor', $data);
    }
                        
	public function update($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}
}


/* End of file User_model.php and path \application\models\User_model.php */
