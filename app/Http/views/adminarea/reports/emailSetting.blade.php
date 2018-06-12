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
	$formID=Input::get('formID')?Input::get('formID'):'0';
	
	$listPage_name=Input::get('listPage_name')?Input::get('listPage_name'):'';
	if($emailID==0){
		$emailID=old('emailID')?old('emailID'):'';
	}
	if($formID==0){
		$formID=old('formID')?old('formID'):0;
	}
	$adminemailID=old('adminemailID')?old('adminemailID'):'';
	$adminsubject=old('adminsubject')?old('adminsubject'):'';	
	$adminemailMessage=old('adminemail')?old('adminemail'):'';	

	$emailInstantID=old('emailInstantID')?old('emailInstantID'):'';	
	$messageInst=old('messageInst')?old('messageInst'):'';

	$emailAutoID=old('emailAutoID')?old('emailAutoID'):'';	
	$subject=old('subject')?old('subject'):'';
	$message1=old('message1')?old('message1'):'';	

	$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
	if(strlen($redirects_to)==0){
	$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
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
		frmobj.action="{{ url('/') }}/adminarea/report/emailsetting";
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
			document.frm_emailResponder.action=frmobj.redirects_to.value;
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
			document.frm_emailSetting.action=frmobj.redirects_to.value;
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
        <ol class="breadcrumb">
          <li><a href="{{ url('/') }}/adminarea/home"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="{{ $redirects_to }}">{{ $listPage_name }}</a></li>
          <li class="active">Email Setting</a></li>
        </ol>
        <form name="frm_emailSetting" id="frm_emailSetting"  action="{{ url('/') }}/adminarea/report/saveEmailResponder" method="post" class="form-horizontal" >
        <input type="hidden" class="form-control" name="formID" id="formID" value="{{ $formID }}">
        <input type="hidden" class="form-control" name="emailID" id="emailID" value="{{ $emailID }}">
        <input type="hidden" class="form-control" name="listPage_name" id="listPage_name" value="{{ $listPage_name }}">
        <input type="hidden" class="form-control" name="orderType" id="orderType" value="{{ Input::get('orderType') }}">
        <input type="hidden" name="method" value="update"/>
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" />
            <section class="content-header top_header_content">
                <div class="box">
                    @include('adminarea.include.message')
                    <div class="property_add">
                        <div class="box-title with-border">
                            <h2>Add Email</h2>
                        </div>
                       <div class="tab-content">
                         <div class="active tab-pane">
                            <div class="addunit_forms">
                                <div class="box-body">
                                    <div role="main">
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
                                             <div class="col-sm-12 col-md-12 col-xs-12">
                                                <div class="row">
                                                  <div class="form-group">
                                                      <div class="form-group">
                                                        <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Email:</label>
                                                        <div class="ccol-sm-6 col-md-6 col-xs-9">
                                                                <input type="text" class="form-control" name="email" id="email" value="{{ $email }}" placeholder="Email" maxlength="100">
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Type :</label>
                                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                                 <label class="radio-inline"><input type="radio" name="emailType" value="1" @if($emailType == 1) checked="checked" @endif checked="checked">&nbsp;To</label>
                                                                 <label class="radio-inline"><input type="radio" name="emailType" value="2" @if($emailType == 2) checked="checked" @endif  />&nbsp;CC</label>
                                                                 <label class="radio-inline"><input type="radio" name="emailType" value="3" @if($emailType == 3) checked="checked" @endif />&nbsp;BCC</label>
                                                            </div>
                                                      </div>
                                                      <div class="form-group">
                                                           <div class=" col-md-12 col-xs-12 col-sm-12 text-left">
                                                              <button type="submit" class="btn btn-default btn-primary">Save</button>
                                                              <button class="btn btn-primary" type="button" onclick="fun_EmailSettingback({{ $orderType }})">Cancel</button>
                                                              
                                                           </div>
                                                      </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <!--================================Add Email End=====================================-->
                                         <div class="col-sm-12 col-md-12 col-xs-12">
                                             <div class="row">
                                                <div class="table-responsive ">
                                                  <table class="table table-bordered  table-hover table-striped">
                                                  		<thead>
                                                            <tr>
                                                                <th width="5%">No</th>
                                                                <th width="25%">Email</th>
                                                                <th width="10%">Type</th>
                                                                <th width="10%">Created Date</th>
                                                                <th width="8%">Status</th>
                                                                <th width="10%">Action</th>
                                                              </tr>
                                                      	</thead>
                                                        <tbody>
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
                                                                    <a href="javascript:fun_edit({{ $emailSettingList->emailID }});"  title="Edit" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                                    
                                                                    <a href="javascript:fun_single_delete({{ $emailSettingList->emailID }});" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                                </td>
                                                              </tr>
                                                              <?php $no_row++;?>
                                                            @endforeach
                                                        </tbody>
                                                  </table>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
           </section>
       </form>
        <form name="frm_emailResponder" id="frm_emailResponder"  action="{{ url('/') }}/adminarea/report/saveEmailResponder" method="post" class="form-horizontal" >
        <input type="hidden" class="form-control" name="formID" id="formID" value="{{ $formID }}">
        <input type="hidden" class="form-control" name="listPage_name" id="listPage_name" value="{{ $listPage_name }}">
        <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" />
        <input type="hidden" class="form-control" name="orderType" id="orderType" value="{{ Input::get('orderType') }}">
        <input type="hidden" name="method" value="updateResponder"/>
        <section class="content-header top_header_content">
            <div class="box">
                <div class="property_add">
                    <div class="box-title with-border">
                        <h2>Edit Admin Notification Email</h2>
                    </div>
                   <div class="tab-content">
                     <div class="active tab-pane">
                        <div class="addunit_forms">
                            <div class="box-body">
                                <div role="main">
                                     <div class="col-sm-12 col-md-12 col-xs-12">
                                        <div class="row">
                                        <!--================================Edit Admin Notification Email Start=====================================-->
                                          <div class="form-group">
                                                <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Subject:</label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <input type="text" class="form-control" name="adminsubject" id="adminsubject" value="<?php echo @$adminsubject; ?>" placeholder="subject">
                                                </div>
                                          </div>	
                                           <input type="hidden" name="adminemailID" value="{{ $adminemailID }}" />
                                          <div class="form-group">
                                                <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Message :</label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                 <textarea id="adminemail_content" name="adminemail">{{ $_POST['adminemail'] }}</textarea> 
                                                </div>
                                          </div>
                                        <!--================================Edit Admin Notification Email End=====================================-->
                                        </div>
                                     </div>
                                </div>
                            </div>
                         </div>
                      </div>
                    </div>
                </div>
            </div>
        </section>               
        <section class="content-header top_header_content">
            <div class="box">
                 <div class="property_add">
                    <div class="box-title with-border">
                        <h2>Edit Instant Auto Responder</h2>
                    </div> 
                   <div class="tab-content">
                     <div class="active tab-pane">
                        <div class="addunit_forms">
                            <div class="box-body">
                                <div role="main">
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                        <div class="row">                                            <!--================================Edit Instant Auto Responder Start=====================================-->
                                            <?php
                                                foreach($emaiinstantresponse as $emailResponse)
                                                {
                                                    $emailInstantID = $emailResponse->emailInstantID;
                                                    $messageInst = 	$emailResponse->messageInst;
                                                } 
                                            ?>
                                            <input type="hidden" name="emailInstantID" value="{{ $emailInstantID }}" />
                                              <div class="form-group">
                                                <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Message :</label>
                                                <div class="col-sm-6 col-md-6 col-xs-9">
                                                 <textarea id="messageInst_content" name="messageInst">{{ $messageInst }}</textarea>
                                                </div>
                                              </div>
                                            <!--================================Edit Instant Auto Responder End=====================================-->
                                        </div>
                                     </div>
                                </div>
                            </div>
                         </div>
                      </div>
                    </div>
                </div>
            </div>
        </section>               
        <section class="content-header top_header_content">
            <div class="box">
                <div class="property_add">
                    <div class="box-title with-border">
                        <h2>Edit Email Auto Responder</h2>
                    </div>
                   <div class="tab-content">
                     <div class="active tab-pane">
                        <div class="addunit_forms">
                            <div class="box-body">
                                <div class="col-sm-12 col-md-12 col-xs-12" role="main">
                                     <div class="row">
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
                                            <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Subject:</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                              <input type="text" class="form-control" name="subject" id="subject" value="{{ $subject }}" placeholder="subject">
                                            </div>
                                          </div>	
                                          <div class="form-group">
                                            <label for="question" class="col-sm-2 col-md-2 col-xs-5 control-label text-right">Message :</label>
                                            <div class="col-sm-6 col-md-6 col-xs-9">
                                                <textarea id="message1_content" name="message1">{{ $message1 }}</textarea>
                                            </div>
                                          </div>
                                        <!--================================Edit Email Auto Responder End=====================================-->
                                     </div>
                                </div>
                            </div>
                         </div>
                      </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                         <div class="col-xs-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-default btn-warning">Submit</button>
                            <button class="btn btn-primary" type="button" onclick="fun_back({{ $orderType }})">Back</button>
                        </div>
                     </div>
                </div>
            </div>
        </section>
    </form>

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
							remote: {
										type: 'POST',
										url: "{{ url('/') }}/adminarea/report/checkemail?formID={{$formID}}",
										message: 'Please enter unique email.',
										delay: 1000
							}
														
						}
				},
			}
    });
});
</script>
@endsection