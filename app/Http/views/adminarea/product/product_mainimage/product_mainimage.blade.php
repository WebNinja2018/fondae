@include('adminarea.product.product-js')

<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="row">
      <form name="frm_news_mainImage" id="frm_news_mainImage"  action="{{ url('/') }}/adminarea/product/saveMainImage" method="post" class="form-horizontal" enctype="multipart/form-data" >
          <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
          <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
          <input type="hidden" name="url_title" id="url_title" value="{{$url_title}}" >
          <input type="hidden" class="form-control" name="isBack" id="isBack" value="">
          <?php if($tab==1){ $tab=2; }?>
          <input type="hidden" name="tab" id="tab" value="{{$tab}}" >
          <!--start add user -->
              <div class="box">
                  <div class="property_add">
                      <!-- strat box-body area-->
                          <!-- start general & seo tab-->
                           <div class="tab-content">
                               <div class="active tab-pane">
                                  <div class="addunit_forms">
                                      <div class="box-body">
                                         <div class="form-group_main">
                                           <div class="form-group">
                                             <label class="col-sm-2 col-md-2 col-xs-5 control-label">Event Image <span class="mandatory_field">*</span></label>
                                              <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="30" title="=> Image must be smaller than 300*400 => The product image may not be greater than 1000 KB.">
<img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="20" title="The location of your event may not be included on your flyer image. event goers will be notified of event location once they donate the required amount to your project. your project will not be approved if your event location is mentioned.">
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <input class="form-control" name="eventimage" maxlength="200" id="eventimage" type="file" value="" onchange="file_check();" />
                                                  <input type="hidden" name="eventimage_old" value="{{$eventimage}}" />
                                                  <div id='imagePreview' ></div>
                                                   @if(strlen($eventimage)>0)
                                                      <span id="image"><a href="javascript:fun_remove_thumb({{ $productID }},'{{ $eventimage }}');" class="close_img_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Image</a>
                                                          <img src="{{ url('/') }}/upload/product/event_image/{{ $eventimage }}" height="180" width="180" />
                                                      </span>
                                                   @endif
                                                   
                                              </div>
                                          </div>
                                          
                                          <?php /*?><div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label">Image Alt Tag</label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <input type="text" class="form-control" name="altimage" maxlength="200" id="altimage" placeholder="Image Alt Tag" value="{{ $altimage }}" >
                                              </div>
                                          </div><?php */?>
                                           <div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Date <span class="mandatory_field">*</span></label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                    <div class="input-group">
                                                      <div @if($isActive=='1' &&  (Session::get('admin_role')==39)) id="dontshow" @else id="sandbox-container"  @endif>
                                                          <input type="text"  name="productDate" id="productDate" class="form-control"  placeholder="Date" value="{{ date('m/d/Y',strtotime($productDate))}}" autocomplete="off" @if($isActive=='1' &&  (Session::get('admin_role')!=1)) readonly="readonly" @endif>
                                                          <label>Note: Your campaign must run for at least 2 weeks before your event</label>
                                                      </div>
                                                        <script type="text/javascript">
                                                              var newdate = new Date();
                                                              newdate.setDate(newdate.getDate() + 14);
                                                              $('#sandbox-container input').datepicker({
                                                                format: 'mm/dd/yyyy',
                                                                keyboardNavigation: false,
                                                                forceParse: false,
                                                                minDate: newdate,
                                                                startDate: newdate,
                                                                autoclose: true
                                                              })
                                                          </script>
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                  </div>
                                              </div>
                                              <img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="20" title="note that your project will end in full 20 days after your event date">

                                          </div>

                                          <div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label">Event Time<span class="mandatory_field">*</span></label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <input type='time' id="event_time" name="event_time" class="form-control" value='{!! $event_time !!}' required>
                                              </div>
                                          </div>

                                            <div class="form-group">
                                                    <label class="col-sm-2 col-md-2 col-xs-5 control-label">Event Description <span class="mandatory_field">*</span></label>
                                                    <div class="col-sm-6 col-md-6 col-xs-9">
                                                        <textarea required id="longDescription" name="longDescription" oninvalid="invalidComment(this);">{{ $longDescription }}</textarea>
<img src="{{ url('/') }}/components/images/tooltip.png" data-toggle="tooltip" data-placement="top" width="20" title="The location of your event may not be included in the details about your event. Event goers will be notified of event location once they donate your required amount to your project. Your project will not be approved if your event location is mentioned.">
                                                    </div>
                                                </div>

                                          
                                         
                                          
                                      </div>
                                  </div>
                               </div>
                          </div>
                          <!-- end general & seo tab-->
                      <!-- end box-body area-->
                   </div>
                  <!-- strat box footer area-->
                  <div class="box-footer">
                      <div class="col-xs-12 col-md-12 col-sm-12 text-left">
                           <div class="col-xs-12 col-md-12 col-sm-12">
                              <!--<button class="btn btn-warning waves-effect waves-light">Submit</button>-->
                              <?php /*?><input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Save As Draft">
                              <button class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_mata()">Back</button>
                              <?php */?>
                              
                              @if($isDraft==1)
                                  <input type="hidden" name="isDraft" id="isDraft" value="1" >
                                  @if($tab==4)
                                      <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5 submit"  onclick="fun_back_mainimage(1);" >Save</button>

                                      
                                      @if( $count_event>0)

                                       
                                        <input type="submit" class="btn btn-warning waves-effect waves-light submit" name="save" value="Go Live">
                                       
                                      @endif
                                  @else
                                      <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5 submit"  onclick="fun_back_mainimage(1);" >Continue</button>
                                  @endif
                              @else
                                  <input type="hidden" name="isDraft" id="isDraft" value="0" >
                                  <button type="submit" class="btn btn-primary waves-effect waves-light m-l-5 submit"  onclick="fun_back_mainimage(1);" >Save</button>
                              @endif
                              <?php /*?><button class="btn btn-primary waves-effect waves-light m-l-5" type="button" onclick="fun_back_mainimage(0)">Back</button><?php */?>
                           </div>
                      </div>
                    </div>
                  <!-- end box-footer area-->
                  </div>
              </div>
         <!-- end add pages--> 
      </form>
    </div>
</div>

<script type="text/javascript">



       function file_check()
            {
              var fileInput = document.getElementById('eventimage');
                var filePath = fileInput.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if(!allowedExtensions.exec(filePath)){
                    alert('Please upload file having extensions .jpeg/.jpg/.png only.');
                    fileInput.value = '';
                    return false;

                      $("#image").show( "slow" );
                }
                else if (fileInput.files && fileInput.files[0])
                {
                     var size = fileInput.files[0].size;

                            if(size > 1048576)
                            {
                                alert("Maximum file size exceeds");
                                 fileInput.value = '';
                                return false;
                                $("#image").show( "slow" );
                            }
                }
                 else{
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('imagePreview').innerHTML = '<img style="height: 200px; width:200px;" src="'+e.target.result+'"/>';
                              $("#image").hide( "slow" );
                            image
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
</script>
   
