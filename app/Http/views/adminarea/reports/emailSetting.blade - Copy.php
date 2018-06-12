@extends('adminarea.home')
@section('content')
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#messageInst_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#message1_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#adminemail_content').redactor({
				imageUpload: "{{ url('/') }}/redactor/scripts/image_upload.php",
				fileUpload: "{{ url('/') }}/redactor/scripts/file_upload.php"
			});
		}
	);
</script>
<?php
	$emailID=Input::get('emailID')?Input::get('emailID'):'0';
	$listPage=Input::get('listPage')?Input::get('listPage'):'';
	$listPage_name=Input::get('listPage_name')?Input::get('listPage_name'):'';
	if($emailID==0){
		$emailID=old('emailID')?old('emailID'):'';
	}
	$adminemailID=old('adminemailID')?old('adminemailID'):'';
	$adminsubject=old('adminsubject')?old('adminsubject'):'';	
	$adminemailMessage=old('adminemail')?old('adminemail'):'';	

	$emailInstantID=old('emailInstantID')?old('emailInstantID'):'';	
	$messageInst=old('messageInst')?old('messageInst'):'';

	$emailAutoID=old('emailAutoID')?old('emailAutoID'):'';	
	$subject=old('subject')?old('subject'):'';
	$message1=old('message1')?old('message1'):'';	

	if($listPage==''){
		$listPage=old('listPage')?old('listPage'):'';		
	}
	if($listPage_name==''){
		$listPage_name=old('listPage_name')?old('listPage_name'):'';		
	}
	

	foreach($adminemail as $emailNotification)
	{
		$adminemailID = $emailNotification->adminemailID;
		$adminsubject = $emailNotification->adminsubject;
		$adminemailMessage = $emailNotification->adminemail;
	}

	$_POST['adminemail'] = $adminemailMessage;	
?>
<script type="text/javascript">
	function fun_single_status(emailID)
	{
		$.ajax({
			type: "POST",
			url: "{{ url('/') }}/adminarea/report/singlestatus",
			data: "emailID=" + emailID,
			success: function(result){
				
				if(result == 0)
				{
					$('#status_'+emailID).html("Inactive");
				}
				if(result == 1)
				{
					$('#status_'+emailID).html("Active");
				}
			}
		});
	}
	function fun_single_delete(emailID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/report/singledelete",
				data: "emailID=" + emailID,
				success: function(total){
				$("#ID_"+emailID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
	
	function fun_edit(emailID)
	{
		var frmobj=window.document.frm_emailSetting;
		frmobj.emailID.value=emailID;
		frmobj.action="{{ url('/') }}/adminarea/report/emailSetting";
		frmobj.submit();
	}
	function fun_back()
	{
		
		var frmobj=window.document.frm_emailResponder;
		if((orderType)>0){
			if(orderType==1){
				document.frm_emailResponder.action="{{ url('/') }}/adminarea/order";
			}else{
				document.frm_emailResponder.action="{{ url('/') }}/adminarea/order/donation";
			}
		}else{
			document.frm_emailResponder.action="{{ Input::get('listPage') }}";
		}
		frmobj.submit();
	}
	function fun_EmailSettingback(orderType)
	{
		var frmobj=window.document.frm_emailSetting;
		if((orderType)>0){
			if(orderType==1){
				document.frm_emailSetting.action="{{ url('/') }}/adminarea/order";
			}else{
				document.frm_emailSetting.action="{{ url('/') }}/adminarea/order/donation";
			}
		}else{
			document.frm_emailSetting.action="{{ Input::get('listPage') }}";
		}
		frmobj.submit();
	}
	function fun_addnew()
	{
		var frmobj=window.document.frm_emailSetting;
		frmobj.email.value="";
		frmobj.emailID.value="";
		frmobj.emailType.value="";
		frmobj.action="{{ url('/') }}/adminarea/report/emailSetting";
		frmobj.submit();
	}
</script>

<?php $orderType = Input::get('orderType')? Input::get('orderType') : '';?>
<div class="right_side" role="main">
    <div class="center_container">
        <ul class="breadcrumb">
          <li><a href="{{ url('/') }}/adminarea/home">Home</a></li>
          <li><a href="{{ $listPage }}">{{ $listPage_name }}</a></li>
          <li class="active">Email Setting</a></li>
        </ul>
    </div>
    <div class="panel row">
      <div class="panel-body">
        <div class="col-md-13" role="main">
            <form name="frm_emailSetting" id="frm_emailSetting"  action="{{ url('/') }}/adminarea/report/saveEmailSetting" method="post" class="form-horizontal" >
            <input type="hidden" class="form-control" name="formID" id="formID" value="{{ Input::get('formID') }}">
            <input type="hidden" class="form-control" name="emailID" id="emailID" value="{{ Input::get('emailID') }}">
            <input type="hidden" class="form-control" name="listPage_name" id="listPage_name" value="{{ $listPage_name }}">
            <input type="hidden" class="form-control" name="listPage" id="listPage" value="{{ $listPage }}">
            <input type="hidden" class="form-control" name="orderType" id="orderType" value="{{ Input::get('orderType') }}">
            <input type="hidden" name="method" value="update"/>
            {!! Form::hidden('redirects_to', URL::current()) !!}	
                <div class="panel panel-default">
            	   @include('adminarea.include.message')
                  <div class="panel-heading">
                    <h3 class="panel-title">Add Email</a></h3>
                  </div>
                  <div class="col-md-12" role="main">
                     <div class="tab-content">
                     	<?php
							//dd($emailsetting);
							if($emailID >0)
							{
								if(isset($emailsetting))
								{
									foreach($emailsetting as $emailSettingEdit)
									{
										$email = $emailSettingEdit->email;
										$emailType = $emailSettingEdit->emailType;
									}
								}
							}else{
								$email = '';
								$emailType = '';
							}
						?>
                        <!--================================Add Email Start=====================================-->
                          <div class="form-group">
                            <label for="" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="question" class="col-sm-2 control-label">Email:</label>
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="email" id="email" value="{{ $email }}" placeholder="Email" maxlength="100">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="question" class="col-sm-2 control-label">Type :</label>
                            <div class="col-md-6">
								<div class="checkbox">
								<div class="row">
									 <label><input type="radio" name="emailType" value="1" @if($emailType == 1) checked="checked" @endif checked="checked" >&nbsp;To</label>
									 <label><input type="radio" name="emailType" value="2" @if($emailType == 2) checked="checked" @endif  />&nbsp;CC</label>
									 <label><input type="radio" name="emailType" value="3" @if($emailType == 3) checked="checked" @endif />&nbsp;BCC</label>
								 </div>
								 </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-default btn-primary">Save</button>
                              <button class="btn btn-default" type="button" onclick="fun_EmailSettingback({{ $orderType }})">Cancel</button>
                              
                            </div>
                          </div>
                        <!--================================Add Email End=====================================-->
                     </div>
                     <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Email</th>
                            <th width="10%">Type</th>
                            <th width="10%">Created Date</th>
                            <th width="8%">Status</th>
                            <th width="10%">Action</th>
                          </tr>
                          
                       	  <?php $no_row=1; ?>
						  @foreach($emailSetting as $emailSettingList)
                          <tr id="ID_{{ $emailSettingList->emailID }}" @if($emailSettingList->emailID==$emailID) class="bg-warning" @endif >
                            <td>{{ $no_row }}</td>
                            <td>{{ $emailSettingList->email }}</td>
                            <td>@if($emailSettingList->emailType == 1)
									To
								@elseif($emailSettingList->emailType == 2)
									CC
								@else
									BCC
								@endif
                            </td>
                            <td>{{ date('m/d/Y',strtotime($emailSettingList->created_at)) }}</td>
                            <td>
                                <a href="javascript:fun_single_status({{ $emailSettingList->emailID }});">
                                    <span id="status_{{ $emailSettingList->emailID }}">
                                        @if($emailSettingList->isActive==1) Active @else Inactive @endif
                                    </span>
                                </a>
                            </td>
                            <td>
                             	<a class="glyphicon glyphicon-pencil" href="javascript:fun_edit({{ $emailSettingList->emailID }});"></a>
                                &nbsp;&nbsp;
                                <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete({{ $emailSettingList->emailID }});"></a>
                            </td>
                          </tr>
                          <?php $no_row++;?>
						@endforeach
                      </table>
                    </div>
                </div>
            </div>
            
            </form>
            
            <form name="frm_emailResponder" id="frm_emailResponder"  action="{{ url('/') }}/adminarea/report/saveEmailResponder" method="post" class="form-horizontal" >
            <input type="hidden" class="form-control" name="formID" id="formID" value="{{ Input::get('formID') }}">
            <input type="hidden" class="form-control" name="listPage_name" id="listPage_name" value="{{ $listPage_name }}">
			<input type="hidden" class="form-control" name="listPage" id="listPage" value="{{ $listPage }}">
            <input type="hidden" class="form-control" name="orderType" id="orderType" value="{{ Input::get('orderType') }}">
            <input type="hidden" name="method" value="updateResponder"/>
			{!! Form::hidden('redirects_to', URL::current()) !!}
                <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Edit Admin Notification Email</a></h3>
                      </div>
                      <div class="col-md-12" role="main">
                      <div class="form-group">
                            <label for="" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                         <div class="tab-content">
                         
                            <!--================================Edit Admin Notification Email Start=====================================-->
                              <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">Subject:</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" name="adminsubject" id="adminsubject" value="<?php echo @$adminsubject; ?>" placeholder="subject">
                                </div>
                              </div>	
                               <input type="hidden" name="adminemailID" value="{{ $adminemailID }}" />
                              <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">Message :</label>
                                <div class="col-md-7">
                                 <textarea id="adminemail_content" name="adminemail">{{ $_POST['adminemail'] }}</textarea> 
                                </div>
                              </div>
                            <!--================================Edit Admin Notification Email End=====================================-->
                         </div>
                    </div>
                </div>
                <div class="panel panel-default">
                
                     
                      <div class="panel-heading">
                        <h3 class="panel-title">Edit Instant Auto Responder</a></h3>
                      </div>
                      <div class="col-md-12" role="main">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                         <div class="tab-content">
                            <!--================================Edit Instant Auto Responder Start=====================================-->
                            <?php
                            	foreach($emaiinstantresponse as $emailResponse)
								{
									$emailInstantID = $emailResponse->emailInstantID;
									$messageInst = 	$emailResponse->messageInst;
								} 
                            ?>
                            <input type="hidden" name="emailInstantID" value="{{ $emailInstantID }}" />
                              <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">Message :</label>
                                <div class="col-md-7">
                                 <textarea id="messageInst_content" name="messageInst">{{ $messageInst }}</textarea>
                                </div>
                              </div>
                            <!--================================Edit Instant Auto Responder End=====================================-->
                         </div>
                     
                    </div>
                </div>
                <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Edit Email Auto Responder</a></h3>
                      </div>
                      <div class="col-md-12" role="main">
                      <div class="form-group">
                            <label for="" class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                         <div class="tab-content">
                            <?php
								foreach($emailautoresponse as $emailAutoResponse)
								{
									$emailAutoID = $emailAutoResponse->emailAutoID;	
									$subject = $emailAutoResponse->subject;	
									$message1 = $emailAutoResponse->message1;	
								}
                            ?>
                            <!--================================Edit Email Auto Responder Start=====================================-->
                               <input type="hidden" name="emailAutoID" value="{{ $emailAutoID }}" />
                              <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">Subject:</label>
                                <div class="col-md-4">
                                  <input type="text" class="form-control" name="subject" id="subject" value="{{ $subject }}" placeholder="subject">
                                </div>
                              </div>	
                              <div class="form-group">
                                <label for="question" class="col-sm-2 control-label">Message :</label>
                                <div class="col-md-7">
                                	<textarea id="message1_content" name="message1">{{ $message1 }}</textarea>
                                </div>
                              </div>
                            <!--================================Edit Email Auto Responder End=====================================-->
                         </div>
                         
                       
                    </div>
                </div>
            
			
            <button type="submit" class="btn btn-default btn-primary">Submit</button>
            <button class="btn btn-default" type="button" onclick="fun_back({{ $orderType }})">Back</button>
               
             </form>
             
         </div>
      </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#frm_emailSetting').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
				email:{
					message: 'Please Enter Valid Email ID',
					validators: 
						{
							notEmpty:{message: 'Please Enter Email'},
							emailAddress: {message: 'Please Enter Valid Email'},
														
						}
				},
			}
    });
});
</script>
@endsection