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
	$this->load->model('product_item_model');
	$productID = $this->input->post('productID')?$this->input->post('productID'):0;
	$sizeID = $this->input->post('sizeID')?$this->input->post('sizeID'):0;
	if($sizeID==0){
		echo '';
		exit;
	} 
	$productItemData=array('productID'=>$productID,'sizeID'=>$sizeID);
	$resultitemData=$this->product_item_model->getByAttributesQuery($productItemData);
	
	$itemSting='<div class="products_size_select">';
		$itemSting.='<select id="itemID" name="itemID" onchange="getproductprice();">';	
	if($resultitemData['recordCount']>0){
		if($resultitemData['recordCount']==1){
			$itemSting.='<option value="'.$resultitemData['data'][0]->itemID.'">'.$resultitemData['data'][0]->itemName.'</option>';
		}else{
			$itemSting.='<option value="">Please Select Item</option>';
			foreach($resultitemData['data'] as $itemData){
				$itemSting.='<option value="'.$itemData->itemID.'">'.$itemData->itemName.'</option>';
			}
		}
	}else{
		$itemSting='<input type="hidden" name="itemID" id="itemID" value="0" />';
	}
		$itemSting.='</select>';
	$itemSting.='</div>';
	echo $itemSting;
	exit;
?>