<?php 
	use Illuminate\Support\Facades\Custom;
	use App\Http\Models\Customer;

	$customerID=$request->customerID?$request->customerID:'';
	$hashkey=$request->hashkey?$request->hashkey:'';

	$customerData=array('md5(customerID)'=>$customerID,'isActive'=>1);
	$Customer=new Customer;
	$resultCustomer=$Customer->getByAttributesQuery($customerData);
	$data['hashkey']=$hashkey;
	$data['md5customerID']=$customerID;
	$data['custoemerRecordcount']=$resultCustomer['recordCount'];
	$data['qGetcustomerData']=$resultCustomer['data'];

?>