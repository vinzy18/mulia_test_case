<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Item_model extends CI_Model 
{
    private $table = 'items';
	private $column_order = array(null, 'id', 'inv_number', 'item_name', 'qty', 'price', 'total', 'created_at'); 
	private $column_search = array('inv_number', 'item_name', 'qty', 'price', 'total', 'created_at'); 
	private $order = array('item_name' => 'asc'); 

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
	
	public function getItemById($id)
	{
		return $this->db->get_where($this->table, ['id' => $id])->row();
	}

	public function getItemsByInvoiceId($id)
	{
		return $this->db->get_where($this->table, ['inv_id' => $id])->result();
	}
             
	public function insert($data)
    {
        return $this->db->insert('items', $data);
    }  
	
	public function update($id, $data){
		$this->db->where('id', $id);
		return $this->db->update($this->table, $data);
	}

	public function remove($id){
		$this->db->where('id', $id);
		$this->db->delete('items');
	}

	public function removeByInvoiceId($id){
		$this->db->where('inv_id', $id);
		$this->db->delete('items');
	}
                        
}


/* End of file Item_model.php and path \application\models\Item_model.php */
