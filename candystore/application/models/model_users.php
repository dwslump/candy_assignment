<?php

class Model_users extends CI_Model {
	
	public function can_log_in() {
		
		$this->db->where('login', $this->input->post('login'));
		$this->db->where('password', $this->input->post('password'));
		
		$query = $this->db->get('customer');
		
		if($query->num_rows() == 1){
			//found a user
			return true;
		}
		else{
			return false;
		}
		
		
		
		
	}
	
} 