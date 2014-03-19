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
    		$this->load->model('product_model');
    		$products = $this->product_model->getAll();
    		$data['products']=$products;
    		
    		if($this->session->userdata['login'] == 'admin'){
    			//admin view

    			$this->load->view('admin_view',$data);
    			 
    		}
    		else{
    			//user view
    			$this->load->view('member_view',$data);
    		}
    		}
    }
    
    function register_customer(){
    	$this->load->view('register_view');
    }
    
    function register_validation(){
    	
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('first', 'First', 'required|trim');
    	$this->form_validation->set_rules('last', 'Last', 'required|trim');
    	$this->form_validation->set_rules('login', 'Login', 'required|trim|callback_isValidLogin');
    	$this->form_validation->set_rules('password', 'Password', 'required|trim|callback_isValidPassword');
    	$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_isValidEmail');

    	if ($this->form_validation->run()){
    		/*echo '<script language="javascript">';
    		echo 'alert("Registration Successfull!")';
    		echo '</script>';
    		*/
    		
    		//create a new member:
    		$this->load->model('customer_model');
    			
    		$customer = new Customer();
    		$customer->first = $this->input->post('first');
    		$customer->last = $this->input->post('last');
    		$customer->login = $this->input->post('login');
    		$customer->password = $this->input->post('password');
    		$customer->email = $this->input->post('email');;
    		
    		$data = $this->upload->data();
    		
    		$this->customer_model->insert($customer);
    		
    		//$this->session->sess_destroy();    		
    		
    		redirect('candystore/index');
    	}
    	else{
    		$this->load->view('register_view');
    	}
    	
    }
    
    function isValidLogin() {
    	$this->db->where('login', $this->input->post('login'));
    	
    	$query = $this->db->get('customer');
    	
    	if($query->num_rows() == 1){
    		//found a user
    		$this->form_validation->set_message('isValidLogin', 'Login already exist');
    		return false;
    	}
    	else{
    		//can create a user with that login
    		return true;
    	}
    	 
    }
    
    function isValidPassword() {
    	if(strlen($this->input->post('password')) > 5){
    		return true;
    	} else{
    		$this->form_validation->set_message('isValidPassword', 'Password must have over 6 characters');
    		return false;
    	}
    }
    
    function isValidEmail() {
    	$this->db->where('email', $this->input->post('email'));
    	 
    	$query = $this->db->get('customer');
    	 
    	if($query->num_rows() == 1){
    		//found a user
    		$this->form_validation->set_message('isValidEmail', 'Email already exist');
    		return false;
    	}
    	
    	if(filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)
    	&& preg_match('/@.+\./', $this->input->post('email'))){
    		return true;	
    	} else{
    		$this->form_validation->set_message('isValidEmail', 'Incorrect email format');
    		return false;
    	}
    }
    
    function login_validation(){
    	
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('login', 'Login', 'required|trim|callback_validate_credentials');
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
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('candystore/index');
	}
      
   
    
    
    
}

