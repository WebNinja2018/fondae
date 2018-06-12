<?php 
		use App\Http\Models\Emaiinstantresponse;
	
		if(isset($_POST['formID'])){
			$emaiinstantresponse= new Emaiinstantresponse;
			$emailInstantData=array('formID'=>$_POST['formID']); //  Email Sent To Instant Massage START
			$resutlMassageData=$emaiinstantresponse->getByAttributesQuery($emailInstantData);
			$data['qGetMassageData'] = $resutlMassageData['data'];
		}else{
			return Redirect::fun_redirect('home');
		}
	
?>