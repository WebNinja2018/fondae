<?php 
	use Illuminate\Support\Facades\Custom;
	use App\Http\Models\Customer;

	$customerData=array('customerID'=>$customerID,'isActive'=>1);
	$Customer=new Customer;
	$resultCustomer=$Customer->getByAttributesQuery($customerData);
	$data['customerRecordCount']=$resultCustomer['recordCount'];
	$data['qGetcustomerData']=$resultCustomer['data'];
	
?>