<?php

namespace App\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session1;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;

//Load Models
use App\Http\Models\Frm_contactus;
use App\Http\Models\Frm_recommendus;
use App\Http\Models\Frm_mailing_list;
use App\Http\Models\Formbuilder;
use App\Http\Models\Emailsetting;
use App\Http\Models\Emaiinstantresponse;
use App\Http\Models\Emailautoresponse;
use App\Http\Models\Adminemail;

class Report_controllers extends Controller
{
	// contact us start
	public function contactus(Request $request)
	{
		$frm_contactus= new Frm_contactus;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $contactusID)
				{
					$query = Frm_contactus::where('contactusID', $contactusID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $contactusID)
				{
					Frm_contactus::destroy($contactusID);
				}
			}
		}
		
		$result=$frm_contactus ->getAllContactus();
		
		$data['recordcount']=$result['rows'];
		$data['qGetAllContactus']=$result['data'];
		return view('adminarea.reports.contactus',$data);
	}

	public function contactsingledelete(Request $request)
	{
		$contactusID =$request->contactusID;
		Frm_contactus::destroy($contactusID);
	}
	
	public function getExportContactus()
	{
		$frm_contactus= new Frm_contactus;
		$table = $frm_contactus ->getAllContactus();
		$file = fopen('file.csv', 'w');
		$output="First Name,Last Name,email,phone,comment,created at\n";
		foreach ($table['data'] as $row) {
			$output .= $row->firstName.','.$row->lastName.','.$row->email.','.$row->phone.','.$row->comment.','.$row->created_at."\n";
		}
		return response($output)
                ->header('Content-Type','application/csv')               
                ->header('Content-Disposition', 'attachment; filename="Export_Contacts.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');        
	}

	// Email This Page start
	public function emailthispage(Request $request)
	{
		$frm_recommendus= new Frm_recommendus;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $recommendusID)
				{
					$query = Frm_recommendus::where('recommendusID', $recommendusID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $recommendusID)
				{
					Frm_recommendus::destroy($recommendusID);
				}
			}
		}
		
		$result=$frm_recommendus ->getAllEmailthispage();
		
		$data['recordcount']=$result['rows'];
		$data['qGetAllEmailthispage']=$result['data'];
		return view('adminarea.reports.emailthispage',$data);
	}

	public function emailthispagesingledelete(Request $request)
	{
		$recommendusID =$request->recommendusID;
		Frm_recommendus::destroy($recommendusID);
	}

	public function getExportEmailthispage()
	{
		$frm_recommendus= new Frm_recommendus;
		$table = $frm_recommendus ->getAllEmailthispage();
		$file = fopen('file.csv', 'w');
		$output="Your Name,Your Email,Friend Name,Friend Email,Comment,Page Link,created at\n";
		foreach ($table['data'] as $row) {
			$output .= $row->yourName.','.$row->yourEmail.','.$row->friendName.','.$row->friendEmail.','.$row->message.','.$row->pageLink.','.$row->created_at."\n";
		}
		return response($output)
                ->header('Content-Type','application/csv')               
                ->header('Content-Disposition', 'attachment; filename="Export_Emailthispage.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');        
	}

	// Email News start
	public function emailnews(Request $request)
	{
		$frm_mailing_list= new Frm_mailing_list;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $mailingID)
				{
					$query = Frm_mailing_list::where('mailingID', $mailingID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $mailingID)
				{
					Frm_mailing_list::destroy($mailingID);
				}
			}
		}
		
		$result=$frm_mailing_list ->getAllEmailnews();
		
		$data['recordcount']=$result['rows'];
		$data['qGetAllEmailnews']=$result['data'];
		return view('adminarea.reports.emailnews',$data);
	}

	public function emailnewssingledelete(Request $request)
	{
		$mailingID =$request->mailingID;
		Frm_mailing_list::destroy($mailingID);
	}
	
	public function getExportEmailnews()
	{
		$frm_mailing_list= new Frm_mailing_list;
		$table = $frm_mailing_list ->getAllEmailnews();
		$file = fopen('file.csv', 'w');
		$output="Email,created at\n";
		foreach ($table['data'] as $row) {
			$output .= $row->email.','.$row->created_at."\n";
		}
		return response($output)
                ->header('Content-Type','application/csv')               
                ->header('Content-Disposition', 'attachment; filename="Export_Emailnews.csv"')
                ->header('Pragma','no-cache')
                ->header('Expires','0');        
	}
	// Form start
	public function formbuilder(Request $request)
	{
		$formbuilder= new Formbuilder;
		
		if($request->method== "multiplestatus")
		{
			$isActive = array('isActive'=>$request->status);
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $formID)
				{
					$query = Formbuilder::where('formID', $formID)
									->update($isActive);
				}
			}
		}
		
		if($request->method== "multipleDelete")
		{
			if($request->checkUncheck)
			{
				foreach($request->checkUncheck as $formID)
				{
					Formbuilder::destroy($formID);
				}
			}
		}
		
		$result=$formbuilder ->getAllFormbuilder();
		
		$data['recordcount']=$result['rows'];
		$data['qGetAllFormbuilder']=$result['data'];
		return view('adminarea.reports.formbuilder',$data);
	}

	public function formbuildersingledelete(Request $request)
	{
		$formID =$request->formID;
		Formbuilder::destroy($formID);
	}

	// Email Setting Start
	public function emailsetting(Request $request)
	{	
		$formID = $request->formID;
		$emailID =$request->emailID;
		if($emailID==0){
			$emailID=old('emailID')?old('emailID'):0;
		}
		if($formID==0){
			$formID=old('formID')?old('formID'):0;
		}
		$data['formbuilder'] = Formbuilder::select('formID','isEmail','isInstant','isAuto','isadminmail')->find($formID);
		$data['emailSetting'] = Emailsetting::where('formID', $formID)->get();
		$data['emaiinstantresponse'] = Emaiinstantresponse::where('formID', $formID)->get();
		$data['emailautoresponse'] = Emailautoresponse::where('formID', $formID)->get();
		$data['adminemail'] = Adminemail::where('formID', $formID)->get();
		$data['emailsetting'] = Emailsetting::where('emailID', $emailID)->get();
		
		return view('adminarea.reports.emailSetting',$data);
		
	}
	
	function saveEmailResponder(Request $request)
	{
		$formID =$request->formID;
		$emailID =$request->emailID?$request->emailID:0;
		$method =$request->method;
		$emailInstantID =$request->emailInstantID;
		$messageInst =$request->messageInst;
		$emailAutoID =$request->emailAutoID;
		$subject =$request->subject;
		$message1 =$request->message1;
		$adminemailID =$request->adminemailID;
		$adminsubject =$request->adminsubject;
		$adminemailMessage =$request->adminemail;
		
		if($method == "update"){
		
			if($emailID == 0)
			{	
				$email =$request->email;
				$emailType =$request->emailType;
				$info = array(
					"formID"=>$formID,
					"email"=>trim($email),
					"isActive"=>1,
					"emailType"=>intval($emailType),
				  );
			    $emailsetting= new Emailsetting($info);
				$emailsetting->save();
			
			}else{
				
				$email =$request->email;
				$emailType =$request->emailType;
				$emailsetting= new Emailsetting();
				$info = array(
					"email"=>$email,
					"emailType"=>$emailType,
				);
				$query = $emailsetting->where('emailID', $emailID)
                				->update($info);
			}
		}	
		
		
		if($method=="updateResponder"){
			if($emailInstantID==0)
			{
				$info = array(
					"formID"=>$formID,
					"messageInst"=>trim($messageInst)
				);
			    $emaiinstantresponse= new Emaiinstantresponse($info);
				$emaiinstantresponse->save();

			}
			else
			{
				$emaiinstantresponse= new Emaiinstantresponse();
				$info = array(
					"messageInst"=>$messageInst,
				);
				$query = $emaiinstantresponse->where('formID', $formID)
                							->update($info);
				
			}
			
			if($emailAutoID==0)
			{
				
				$info = array(
						"formID"=>$formID,
						"subject"=>$subject,
						"message1"=>trim($message1)
					  );
				$emailautoresponse= new Emailautoresponse($info);
				$emailautoresponse->save();
			}
			else
			{
				$emailautoresponse= new Emailautoresponse();
				$info = array(
					"subject"=>$subject,
					"message1"=>trim($message1),
				);
				$query = $emailautoresponse->where('formID', $formID)
                							->update($info);
				
			}
			
			if($adminemailID==0)
			{
				$info = array(
						"formID"=>$formID,
						"adminsubject"=>$adminsubject,
						"adminemail"=>$adminemailMessage
					  );
				$adminemail= new Adminemail($info);
				$adminemail->save();
			}
			else
			{
				$adminemail= new Adminemail();
				$info = array(
						"adminsubject"=>$adminsubject,
						"adminemail"=>$adminemailMessage
					  );
				$query = $adminemail->where('formID', $formID)
										->update($info);
				
			}
		}
		return Redirect::back()->withInput()->with(array('flash_message' => 'Successfully added'));

	}
	public function singlestatus(Request $request)
	{
		$emailID =$request->emailID;
		$email=Emailsetting::find($emailID);
		$isActive = $email->isActive;
		if($isActive == 1)
		{
			$isActive=0;
		}
		else
		{
			$isActive=1;
		}
		$data = array('isActive'=>$isActive);
		$query = Emailsetting::where('emailID', $emailID)
                				->update($data);
		echo $isActive;
	}
	public function singledelete(Request $request)
	{
		$emailID =$request->emailID;
		Emailsetting::destroy($emailID);
	}

	function checkemail(Request $request)
	{
		$email=$request->email?$request->email:'';
		$formID=$request->formID?$request->formID:'';
		$getpassword=array('email'=>$email,'formID'=>$formID);
		$resultUser = Emailsetting::where($getpassword)->first();

		if(count($resultUser) > 0){
			$valid=false;
		}else{
			$valid=true;
		}
		
		echo json_encode(array(
			'valid' => $valid,
		));
	}
	// Email Setting End
}
