<?php
class Order_item_model extends CI_Model {

	function getAllFromOrder($id)
	{  
		$query = $this->db->get_where('order_item',array('order_id' => $id));
		
		return $query->result('Order_item');
	}  
	
	function getProductFromOrderItem($id)
	{
		$query = $this->db->get_where('product',array('id' => $id));
		
		return $query->row(0,'Product');
	}
	
	function delete($id) {
		return $this->db->delete("product",array('id' => $id ));
	}
	
	function insert($product) {
		return $this->db->insert("product", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price,
												  'photo_url' => $product->photo_url));
	}
	 
	function update($product) {
		$this->db->where('id', $product->id);
		return $this->db->update("product", array('name' => $product->name,
				                                  'description' => $product->description,
											      'price' => $product->price));
	}
	
	
}
?>