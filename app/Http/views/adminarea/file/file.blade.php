@include('adminarea.file.file-js')
<?php
use App\Http\Models\File;
use App\Http\Models\Filetype;
$filetype= new Filetype;

$FileTypeListDate = array('fileTypeID'=>$fileTypeID,'itemID'=>$itemID);
$getFileTypeListDate = File::where($FileTypeListDate)->orderBy('displayOrder', 'ASC')->get();

$FileType = array('fileTypeID'=>$fileTypeID);
$getFileType = Filetype::where($FileType)->get();

$fileTypeID = $getFileType[0]->fileTypeID;
$fileType = $getFileType[0]->fileType;
$isActive = $getFileType[0]->isActive;
$isFile = $getFileType[0]->isFile;
$isCaption = $getFileType[0]->isCaption;
$isDisplayOrder = $getFileType[0]->isDisplayOrder;
$isTitle = $getFileType[0]->isTitle;
$isWeblink = $getFileType[0]->isWeblink;
$isDescription = $getFileType[0]->isDescription; 
?>


<script>
	
	function makeFileList()
    {
        document.getElementById('submitFrm').click();
    }
	
    function funupload()
    {
        document.getElementById('fileName').click();	
    }

	function fun_changeFileOrder()
	{
		var frmobj=window.document.frm_file;
		frmobj.action="{{ url('/') }}/adminarea/file/fileorder";
		frmobj.submit();
	}
</script>
<?php $newsID=old('newsID')?old('newsID'):'0'; 
 $eventID=old('eventID')?old('eventID'):'0';
  $fileID=old('fileID')?old('fileID'):'0';
 $portfolioID=old('portfolioID')?old('portfolioID'):'0'; ?>

<div class="tab-pane" id="file_tab">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="row">
            <form name="frm_file" id="frm_file"  action="{{ url('/') }}/adminarea/file/savefile" method="post" class="form-horizontal" enctype="multipart/form-data" >
                <input type="button" id="submitFrm" style="display:none;">
                <input type="hidden" name="newsID" id="newsID" value="{{ $newsID }}">
                <input type="hidden" name="eventID" id="eventID" value="{{ $eventID }}">
                <input type="hidden" name="portfolioID" id="portfolioID" value="{{ $portfolioID }}">
                <input type="hidden" name="itemID" id="itemID" value="{{ $itemID }}">
                <input type="hidden" name="counter" id="counter" value="1" />
                <input type="hidden" name="fileTypeID" id="fileTypeID" value="{{ $fileTypeID }}" />
                <input type="hidden" name="fileType" id="fileType" value="{{ $fileType }}" />
                <?php /*?><input type="hidden" value="{{ URL::previous() }}" name="redirects_to"  id="redirects_to"/><?php */?>
              <div class="box">
                <div id="filechange" style="width: 83%;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
                             <div class="col-md-12 col-sm-12 col-xs-12">
                                <input id="fileName" type="file" name="fileName" multiple class="file" data-overwrite-initial="false" data-min-file-count="1">
                            </div>
                        </div>
                        <script type="text/javascript">
                        
                            $("#fileName").fileinput({
                                uploadUrl: "{{ url('/') }}/adminarea/file/savefile", // you must set a valid URL here else you will get an error
                                allowedFileExtensions : ['doc', 'pdf','xls' , 'txt' ],
                                overwriteInitial: false,
                                //maxFileSize: 1000,
                                maxFilesNum: 10,
                                uploadExtraData:{fileTypeID:<?php echo $fileTypeID?>,itemID:<?php echo $itemID?>},
                                //allowedFileTypes: ['file', 'video', 'flash'],
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
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 col-xs-12 col-md-10 col-md-offset-2">
                    </div>
                </div>
                <!-- List Start -->
                <section class="content-header top_header_content">
                    <a class="add_edit_btn" type="button" href="javascript:fun_changeFileOrder();"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;&nbsp;Change Images Display Order</a>
                </section>
                <div class="col-md-12 col-sm-12 col-xs-12" role="main">
                    <div class="table-responsive">
                      <table  class="table-bordered table-striped table-hover table">
                      	<thead>
                            <tr>
                                <th width="10%">Actions</th>
                                <th width="38%">File Name</th>
                                <th width="38%">Display Order</th>
                                <th width="15%">Created Date</th>
                                <th width="10%">Status</th>
                                <th width="5%">View</th>
                            </tr>
                         </thead>
                         <tbody>
                          @if(isset($getFileTypeListDate))
                            <?php $no_row=1; ?>
                            @foreach($getFileTypeListDate as $getFileTypeListDate)
                              <tr id="ID_{{ $getFileTypeListDate->fileID }}" @if($getFileTypeListDate->fileID==$fileID) class="bg-warning" @endif >
                                <td>
                                    <a class="glyphicon glyphicon-trash" href="javascript:fun_single_delete_file({{ $getFileTypeListDate->fileID }},{{ $getFileTypeListDate->fileTypeID }},{{ $getFileTypeListDate->itemID }});" title="Delete"></a>
                                </td>
                                <td>{{ $getFileTypeListDate->fileName }}</td>
                                <td>{{ $getFileTypeListDate->displayOrder }}</td>
                                <td>{{ date('m/d/Y',strtotime($getFileTypeListDate->created_at)) }}</td>
                                <td>
                                    <a href="javascript:fun_single_status_file({{ $getFileTypeListDate->fileID }});">
                                        <span id="status_{{ $getFileTypeListDate->fileID }}">
                                            @if($getFileTypeListDate->isActive==1) Active @else Inactive @endif
                                        </span>
                                    </a>
                                </td>
                                <td>
                                <a class="glyphicon glyphicon-eye-open" href="" data-toggle="modal" data-target="#myModal_{{ $getFileTypeListDate->fileID }}" title="View"></a>
                                    @include('adminarea.file.file-view')
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
