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
	
	$this->load->model('customer_wishlist_model');
	
	$customer_wishlist_id=$this->input->post('customer_wishlist_id')?$this->input->post('customer_wishlist_id'):'0';
	$wishlistName=$this->input->post('wishlistName')?$this->input->post('wishlistName'):'';
	$returnPageLink=$this->input->post('returnPageLink')?$this->input->post('returnPageLink'):'';
	
	$this->form_validation->set_rules('wishlistName', 'wishlistName' ,'required|trim');
	
	if($this->form_validation->run())
	{	
		checkCaptcha(base_url().'customer-wishlist-addedit');
		$wishlistData=array(
						'customer_wishlist_id'=>$customer_wishlist_id,
						'customerID'=>$this->session->userdata('customerID'),
						'wishlistName'=>$wishlistName,
						);
		if($customer_wishlist_id == 0)
		{
			$wishlistData['uniqueID'] = md5(uniqid(rand(), true));
			$wishlistData['createdBy'] = $this->session->userdata('customerID');
			$wishlistData['createdDate'] = date('Y-m-d H:i:s',strtotime('NOW'));
			$wishlistData['isActive'] = 1;
		}
			$customer_wishlist_id=$this->customer_wishlist_model->addEdit($wishlistData);
			if(strlen($returnPageLink) > 0)
			{
				fun_redirect($returnPageLink,$_POST);
			}
			else
			{
				fun_redirect(base_url().'customer-wishlist-addedit',$_POST);
			}
	}else{
		$this->session->set_flashdata('errorMsg', validation_errors());
		fun_redirect(base_url().'customer-wishlist-addedit',$_POST);
	}

 ?>