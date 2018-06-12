<?php 
//===================================  Code Complete ======================================//
//																						   //
//				Check By Ranjit. Don't Change.anythig without asking senior.			   //
//				Some Function In "Custom Helper" Pelase check it.						   //
//				like checkcaptcha(); sendCustomerEmail();,sendAdminEmail()				   //
//				path : system\helpers\ folder "custom_helper.php"						   //
//																						   //
//===================================  Code Complete ======================================//
	
	checkReferrerUrl();
	$this->load->model('product_price_model');
	$itemID = $this->input->post('itemID')?$this->input->post('itemID'):0;
	$productID = $this->input->post('productID')?$this->input->post('productID'):0;
	$sizeID = $this->input->post('sizeID')?$this->input->post('sizeID'):0;
	$productPriceData=array('productID'=>$productID,'sizeID'=>$sizeID,'itemID'=>$itemID);
	$resultPriceData=$this->product_price_model->getByAttributesQuery($productPriceData);
	
	if($resultPriceData['recordCount']>0){
		echo $this->config->item('priceSign').''.$resultPriceData['data'][0]->price.'~'.$resultPriceData['data'][0]->quantity;
	}else{
		echo "Out Of Stock.";
	}
	
?>