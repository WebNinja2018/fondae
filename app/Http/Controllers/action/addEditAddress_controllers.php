<?php
//===================================  Code Complete ======================================//
//																						   //
//				Check By ranjit. Don't Change.anythig without asking senior.			   //
//				Some Function In "Custom Helper" Pelase check it.						   //
//				like checkcaptcha(); sendCustomerEmail();,sendAdminEmail()				   //
//				path : system\helpers\ folder "custom_helper.php"						   //
//																						   //
//===================================  Code Complete ======================================//
	checkLogin();
	checkReferrerUrl();
	
	$this->load->model('customer_address_model');
	
	$customerAddressID=$this->input->post('customerAddressID')?$this->input->post('customerAddressID'):'0';
	$firstName=$this->input->post('firstName')?$this->input->post('firstName'):'';
	$lastName=$this->input->post('lastName')?$this->input->post('lastName'):'';
	$address1=$this->input->post('address1')?$this->input->post('address1'):'';
	$address2=$this->input->post('address2')?$this->input->post('address2'):'';
	$city=$this->input->post('city')?$this->input->post('city'):'';
	$state=$this->input->post('state')?$this->input->post('state'):'';
	$country=$this->input->post('country')?$this->input->post('country'):'';
	$zipcode=$this->input->post('zipcode')?$this->input->post('zipcode'):'';
	$phone=$this->input->post('phone')?$this->input->post('phone'):'';
	$typeID=$this->input->post('typeID')?$this->input->post('typeID'):'';
	$returnPageLink=$this->input->post('returnPageLink')?$this->input->post('returnPageLink'):'';
	
	
	//Server Side Validation
	$this->form_validation->set_rules('firstName', 'firstName' ,'required|trim');
	$this->form_validation->set_rules('lastName', 'lastName' ,'required|trim');	
	$this->form_validation->set_rules('address1', 'address1' ,'required|trim');	
	$this->form_validation->set_rules('address2', 'address2' ,'required|trim');	
	$this->form_validation->set_rules('city', 'city' ,'required|trim');	
	$this->form_validation->set_rules('state', 'state' ,'required|trim');	
	$this->form_validation->set_rules('country', 'country' ,'required|trim');	
	$this->form_validation->set_rules('zipcode', 'zipcode' ,'required|trim');	
	$this->form_validation->set_rules('phone', 'phone' ,'required|trim');	
	$this->form_validation->set_rules('typeID', 'typeID' ,'required|trim');	
	
	if($this->form_validation->run())
	{	
		// Check Captcha and set return url.
		checkCaptcha(base_url().'address-addedit');
		$ip=$_SERVER['REMOTE_ADDR'];
		$addressData=array(
						'customerAddressID'=>$customerAddressID,
						'customerID'=>$this->session->userdata('customerID'),
						'firstName'=>$firstName,
						'lastName'=>$lastName,
						'address1'=>$address1,
						'address2'=>$address2,
						'city'=>$city,
						'state'=>$state,
						'country'=>$country,
						'phone'=>$phone,
						'zipcode'=>$zipcode,
						'typeID'=>$typeID,
						'createdDate'=>date('Y-m-d H:i:s',strtotime('NOW')),
						'isActive'=>1
						);
			$customerAddressID=$this->customer_address_model->addEdit($addressData);
			if(strlen($returnPageLink) > 0)
			{
				fun_redirect($returnPageLink,$_POST);
			}
			else
			{
				fun_redirect(base_url().'address-addedit',$_POST);
			}
			
			
	}else{
		$this->session->set_flashdata('errorMsg', validation_errors());
		fun_redirect(base_url().'address-addedit',$_POST);
	}

 ?>