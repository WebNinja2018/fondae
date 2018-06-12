@include('adminarea.images.images-js')
<?php
use App\Http\Models\Images;
use App\Http\Models\Imagestype;
$imagestype= new Imagestype;

$ImageTypeListDate = array('imagesTypeID'=>$imagesTypeID,'itemID'=>$itemID);
$getImageTypeListDate = Images::where($ImageTypeListDate)->orderBy('displayOrder', 'ASC')->get();

$ImageType = array('imagesTypeID'=>$imagesTypeID);
$getImageType = Imagestype::where($ImageType)->get();

$imagesTypeID = $getImageType[0]->imagesTypeID;
$imagesType = $getImageType[0]->imagesType;
$isActive = $getImageType[0]->isActive;
$isImage = $getImageType[0]->isImage;
$isCaption = $getImageType[0]->isCaption;
$isDisplayOrder = $getImageType[0]->isDisplayOrder;
$isTitle = $getImageType[0]->isTitle;
$isWeblink = $getImageType[0]->isWeblink;
$isDescription = $getImageType[0]->isDescription; 
?>


<script>
	
	function makeFileList()
    {
        document.getElementById('submitFrm').click();
    }
	
    function funupload()
    {
        document.getElementById('imagesName').click();	
    }

	function fun_changeOrder()
	{
		var frmobj=window.document.frm_image;
		frmobj.action="{{ url('/') }}/adminarea/images/imagesorder";
		frmobj.submit();
	}
</script>
<?php $newsID=old('newsID')?old('newsID'):'0'; 
 $eventID=old('eventID')?old('eventID'):'0';
  $imagesID=old('imagesID')?old('imagesID'):'0';
 $portfolioID=old('portfolioID')?old('portfolioID'):'0'; 

$redirects_to=Input::get('redirects_to')?Input::get('redirects_to'):'';
if(strlen($redirects_to)==0){
$redirects_to=old('redirects_to')?old('redirects_to'): url('/').'/adminarea/news';
}?>
<div class="tab-pane" id="image_tab">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="row">
            <form name="frm_image" id="frm_image"  action="{{ url('/') }}/adminarea/images/saveimages" method="post" class="form-horizontal" enctype="multipart/form-data" >
                <input type="file" name="imagesName" id="imagesName" multiple="multiple" onChange="makeFileList()" accept="image/*" style="display:none;" />
                <input type="button" id="submitFrm" style="display:none;">
                <input type="hidden" name="newsID" id="newsID" value="{{ $newsID }}">
                <input type="hidden" name="eventID" id="eventID" value="{{ $eventID }}">
                <input type="hidden" name="portfolioID" id="portfolioID" value="{{ $portfolioID }}">
                <input type="hidden" name="itemID" id="itemID" value="{{ $itemID }}">
                <input type="hidden" name="counter" id="counter" value="1" />
                <input type="hidden" name="imagesTypeID" id="imagesTypeID" value="{{ $imagesTypeID }}" />
                <input type="hidden" name="imagesType" id="imagesType" value="{{ $imagesType }}" />
               <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
              <div class="box">
                <div id="imagechange" style="width: 83%;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                             <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="file-1" type="file" name="imagesName" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
                            </div>
                        </div>
                        
                    <div class="form-group">
                        <label for="" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>
                        <div class="col-md-4">&nbsp;</div>
                    </div>
                    <?php /*?><div onClick="funupload()" id="uploadImages" class="btn btn-default btn-primary">Click to upload</div>
                    <div id="uploadImages_1" class="btn btn-default btn-primary" style="display:none;">Please wait...</div><?php */?>
                    </div>  
                </div>
                <div id="imagetxtHint"></div> 
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 col-xs-12 col-md-10 col-md-offset-2">
                    </div>
                </div>
                <!-- List Start -->
                <section class="content-header top_header_content">
                    <?php /*?><a class="add_edit_btn" type="button" href="javascript:fun_changeOrder();"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Images Display Order</a><?php */?>
					<span class="pull-left"><b>Drag &amp; Drop</b> boxes to reorder your Images.</span>
                </section>
                <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                    <div class="table-responsive">
                      <table  class="table-bordered table-striped table-hover table">
                      	<thead>
                            <tr>
                                <th width="10%">Actions</th>
                                <th width="38%">Image Name</th>
                                <th width="38%">Display Order</th>
                                <th width="15%">Created Date</th>
                                <th width="10%">Status</th>
                                <th width="5%">View</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                          @if(isset($getImageTypeListDate))
                            <?php $no_row=1; ?>
                            @foreach($getImageTypeListDate as $getImageTypeListDate)
                              <tr id="ID_{{ $getImageTypeListDate->imagesID }}" @if($getImageTypeListDate->imagesID==$imagesID) class="bg-warning" @endif >
                                <td>
                                    <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete_image({{ $getImageTypeListDate->imagesID }},{{ $getImageTypeListDate->imagesTypeID }},{{ $getImageTypeListDate->itemID }});" title="Delete"></a>
                                </td>
                                <td>{{ $getImageTypeListDate->imagesName }}</td>
                                <td id="displayOrder_{{ $getImageTypeListDate->imagesID }}">{{ $getImageTypeListDate->displayOrder }}</td>
                                <td>{{ date('m/d/Y',strtotime($getImageTypeListDate->created_at)) }}</td>
                                <td>
                                    <a href="javascript:fun_single_status_image({{ $getImageTypeListDate->imagesID }});">
                                        <span id="status_{{ $getImageTypeListDate->imagesID }}">
                                            @if($getImageTypeListDate->isActive==1) Active @else Inactive @endif
                                        </span>
                                    </a>
                                </td>
                                <td>
                                <a class="glyphicon glyphicon-eye-open" href="" data-toggle="modal" data-target="#myModal_{{ $getImageTypeListDate->imagesID }}" title="View"></a>
                                    @include('adminarea.images.images-view')
                                </td>
                              </tr>
                            <?php $no_row++; ?>
                            @endforeach
                          @else
                           <tr>
                            <td colspan="6" style="text-align:center;">Record Not Found</td>
                           </tr>
                          @endif
                          </tbody>
                      </table>
                    </div>
                </div>
                </div>
        </form>  
      </div>
   </div>                 
</div>
<script type="text/javascript">
	$("#file-1").fileinput({
		uploadUrl: "{{ url('/') }}/adminarea/images/saveimages", // you must set a valid URL here else you will get an error
		allowedFileExtensions : ['jpg', 'png','gif','jpeg'],
		overwriteInitial: false,
		//maxFileSize: 1000,
		maxFilesNum: 10,
		uploadExtraData:{imagesTypeID:<?php echo $imagesTypeID?>,itemID:<?php echo $itemID?>},
		//allowedFileTypes: ['image', 'video', 'flash'],
		/*slugCallback: function(filename) {alert(filename);
			return filename.replace('(', '_').replace(']', '_');
		}*/
	}).on('fileuploaded', function(event, data, previewId, index) {
		window.location.reload();
	});
	/*
	$(".file").on('fileselect', function(event, n, l) {
		alert('File Selected. Name: ' + l + ', Num: ' + n);
	});
	*/
</script>

<script type="text/javascript" src="{{ url('/components/js/jquery-ui_drop.js') }}"></script>
<script type="text/javascript">
    $(function() {
     function stopCallback(event, ui) {
			  var myOrder =  $(this).sortable('toArray').toString().split("ID_").join("");
			  $.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/images/saveorder",
				data: 'item='+myOrder,
				success: function(data)
				{
					var array = myOrder.split(",");
					var count=1;
					for (index = 0; index < array.length; ++index) {
					
						$('#displayOrder_'+array[index]).html(count);
						count++;
					}
					//$( "#sortable" ).load(window.location.href + " .faq_category" );
					//location.reload();
				}
				});
				setTimeout(function(){
				  $(".flash").slideUp("slow", function () {
				  $(".flash").hide();
				}); }, 3000);
    }

    $("#sortable").sortable({
        stop: stopCallback
    }).disableSelection();
});
</script>