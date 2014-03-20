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
    
    //verify if the registration is valid
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
    		
    		//send e-mail to customer:

    		$config = Array(
    				'protocol' => 'smtp',
    				'smtp_host' => 'ssl://smtp.gmail.com',
    				'smtp_port' => 465,
    				'smtp_user' => 'csc309assignment2@gmail.com',
    				'smtp_pass' => 'candystore309',
    				'mailtype' => 'html',
    				'charset' => 'iso-8859-1',
    				'crlf' => "\r\n",
    				'newline' => "\r\n"
    		);
    		$this->load->library('email');
    		$this->load->model('model_users');
    		
    		$this->email->initialize($config);
    		
    		$this->email->from('csc309assignment2@gmail.com', 'CandyStore');
    		$this->email->to($this->input->post('email'));
    		$this->email->subject("Confirm your account");
    		
    		$message = "<p>Thank you for your registration!</p>";
    				
    		$this->email->message($message);
    		
    		//$this->session->sess_destroy();    		
    			
    	//	redirect('candystore/index');
    		
    		if($this->email->send()){
    			echo "The confirmation email has been sent.";
    			redirect('candystore/registrationSucceded');
    		}else{
    			echo "Registration completed! However we could not send the confirmation email.";
    			redirect('candystore/registrationSucceded');
    		}
    		
    	}
    	else{
    		$this->load->view('register_view');
    	}
    	
    }
    
    function registrationSucceded(){
    	$this->load->view('registerSuccess.php');
    }
    
    //verify if the login is valid for registration
    function isValidLogin() {
    	$this->db->where('login', $this->input->post('login'));
    	
    	$query = $this->db->get('customer');
    	
    	if($query->num_rows() == 1){
    		//found a user
    		$this->form_validation->set_message('isValidLogin', '<span>Login already exist</span>');
    		return false;
    	}
    	else{
    		//can create a user with that login
    		return true;
    	}
    	 
    }

    //verify if the password is valid for registration
    function isValidPassword() {
    	if(strlen($this->input->post('password')) > 5){
    		return true;
    	} else{
    		$this->form_validation->set_message('isValidPassword', '<span>Password must have over 6 characters</span>');
    		return false;
    	}
    }
    
    //verify if the email is valid for registration
    function isValidEmail() {
    	$this->db->where('email', $this->input->post('email'));
    	 
    	$query = $this->db->get('customer');
    	 
    	if($query->num_rows() == 1){
    		//found a user
    		$this->form_validation->set_message('isValidEmail', '<span>Email already exist</span>');
    		return false;
    	}
    	
    	if(filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)
    	&& preg_match('/@.+\./', $this->input->post('email'))){
    		return true;	
    	} else{
    		$this->form_validation->set_message('isValidEmail', '<span>Incorrect email format</span>');
    		return false;
    	}
    }
    
    //validation of login
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
    
    //validation of login credentials
    function validate_credentials(){
    	$this->load->model('model_users');
    	
    	if($this->model_users->can_log_in()){
    		//create SESSION data, not sure if it's here though... 
    		return true;
    	}
    	else{
    		$this->form_validation->set_message('validate_credentials', '<span>Incorrect username/password</span>');
    		return false;
    	}
    }
    
    
    function newForm() {
    	if($this->isLoggedAsAdmin()){
	    	$this->load->view('product/newForm.php');
    	}
    	else{
    		$this->load->view('access_denied_view');
    	}
    }
    
    //creation of new product in the database
	function create() {
		if($this->isLoggedAsAdmin()){
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
	
				//	Then we redirect to the index page again
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
		} else{
			$this->load->view('access_denied_view');
		}	
	}
	
	//visualization of products
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	//visualization of customers
	function readCustomerInfo($id) {
		if($this->isLoggedAsAdmin()){
			$this->load->model('customer_model');
			$customer = $this->customer_model->get($id);
			$data['customer']=$customer;
			$this->load->view('customer/readCustomerInfo.php',$data);
		}
		else{
			$this->load->view('access_denied_view');
		}
		}
	
	//edit product
	function editForm($id) {
		if($this->isLoggedAsAdmin()){
			$this->load->model('product_model');
			$product = $this->product_model->get($id);
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
		else{
			$this->load->view('access_denied_view');
		}
	}
	
	//update a product in the database
	function update($id) {
		if($this->isLoggedAsAdmin()){
		
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
		else{
			$this->load->view('access_denied_view');
		}
	}
    	
	//delete a product in the database
	function delete($id) {
		if($this->isLoggedAsAdmin()){
		
			$this->load->model('product_model');
		
			if (isset($id)) 
				$this->product_model->delete($id);
		
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else{
			$this->load->view('access_denied_view');
		}
	}
	
	//delete a customer
	function delete_customer($id) {
		if($this->isLoggedAsAdmin()){
		
			$this->load->model('customer_model');
	
			if (isset($id))
				$this->customer_model->delete($id);
	
			//Then we redirect to the index page again
			redirect('candystore/index', 'refresh');
		}
		else{
			$this->load->view('access_denied_view');
		}
	}
	
	//creation of admin if does not exist in the database
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
	
	function orderManager($id) {
		if($this->isLoggedAsAdmin()){
			$this->load->model('order_model');

			$query = $this->db->get_where('order', array('customer_id' => $id));
			$orders = $query->result('Order');
			$data['orders']= $orders;
			
			//getting the order_items from the orders above:
			$this->load->model('order_item_model');
			$order_items = array();
			$data['order_items'] = array();
			foreach($orders as $order){
				$query = $this->db->get_where('order_item', array('order_id' => $order->id));
				$order_items = $query->result('Order_item');
				$data['order_items'] = $order_items;
			}
			
			//getting the products of the order_items above:
			$this->load->model('product_model');
			$products_order = $this->product_model->getAll();
			$data['products_order'] = $products_order;
			
			$this->load->view('order_management_view', $data);
		}
		else{
			$this->load->view('access_denied_view');
		}
	}
	
	//delete the order with id
	function delete_order($id){
		$this->load->model('order_model');
		
		if (isset($id))
			$this->order_model->delete($id);
		
		//Then we redirect to the page again
		redirect($_SERVER['REQUEST_URI'], 'refresh'); 
	}
	
	
	
	//logout function
	public function logout() {
		$this->session->sess_destroy();
		redirect('candystore/index');
	}
	
	public function isLoggedAsAdmin(){
		return ($this->session->userdata('is_logged_in') && $this->session->userdata['login'] == 'admin');
	}
      
   
    
    
    
}

