<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CandyStore extends CI_Controller {
   
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    		    	
	    	$this->load->library('upload', $config);
	    	
    }

    function index() {
    	$this->load->model('customer_model');
    	$customers = $this->customer_model->getAll();
    	$data['customers'] = $customers;
    	
    	$query = $this->db->query('SELECT login FROM customer');
    	
    	//verify if there is an admin in the database, if not we must create it.
    	//Why? -> because if someone registers an admin, we must return that already exists an admin and it cannot be created.
    	if ($query->num_rows() > 0){
    		foreach ($query->result_array() as $row)
    		{
    			if($row['login'] == 'admin'){
    				//there is an admin! \o/
    				$data['there_is_admin'] = true;
    			}
    		}
    		if ($data['there_is_admin'] !== true){
    			//create admin
    			$this->create_admin();

    			//Then we redirect to the index page again
    			redirect('candystore/index', 'refresh');
    			
    		}
    		//else do nothing
    	} else{
    		//create admin
    		$this->create_admin();

    		//Then we redirect to the index page again
    		redirect('candystore/index', 'refresh');
    		
    	}
    	
    	if(!$this->session->userdata('is_logged_in')){
    		//login view
    		$this->load->view('login_view');
    	} else{
    		if($this->session->userdata['login'] == 'admin'){
    			//admin view

    			$this->load->model('product_model');
    			$products = $this->product_model->getAll();
    			$data['products']=$products;
    			$this->load->view('product/list.php',$data);
    			
    			//$this->load->view('admin_view');
    		}
    		else{
    			//user view
    			$this->load->view('member_view');
    		}
    	}
    }
    
    function login_validation(){
    	
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('login', 'Login', 'required|trim|xss_clean|callback_validate_credentials');
    	$this->form_validation->set_rules('password', 'Password', 'required|trim');
    	
    	if ($this->form_validation->run()){
    		//session after all validations!
    		$data = array(
    			'login' => $this->input->post('login'),
    			'is_logged_in' => 1
    		);
    		$this->session->set_userdata($data);
    		redirect('candystore/index');
    	}
    	else{
    		$this->load->view('login_view');
    	}
    }
    
    function validate_credentials(){
    	$this->load->model('model_users');
    	
    	if($this->model_users->can_log_in()){
    		//create SESSION data, not sure if it's here though... 
    		return true;
    	}
    	else{
    		$this->form_validation->set_message('validate_credentials', 'Incorrect username/password');
    		return false;
    	}
    }
    
    
    function newForm() {
	    	$this->load->view('product/newForm.php');
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
    	
	function delete($id) {
		$this->load->model('product_model');
		
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('candystore/index', 'refresh');
	}
	

	function create_admin() {
		$this->load->model('customer_model');
		 
		$customer = new Customer();
		$customer->first = 'admin';
		$customer->last = 'admin';
		$customer->login = 'admin';
		$customer->password = 'admin';
		$customer->email = 'admin@admin.com';
	
		$data = $this->upload->data();
	
		$this->customer_model->insert($customer);
		
		$this->session->sess_destroy();
		
		 
	}
      
   
    
    
    
}

