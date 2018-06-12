<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="row">
      <form name="frm_news_meta" id="frm_news_meta"  action="{{ url('/') }}/adminarea/product/saveMetaKeyword" method="post" class="form-horizontal" enctype="multipart/form-data" >
          <input type="hidden" class="form-control" name="productID" id="productID" value="{{$productID}}">
          <input type="hidden" name="redirects_to" id="redirects_to" value="{{$redirects_to}}" >
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
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Page Title <span class="mandatory_field">*</span></label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <input type="text" class="form-control" name="pageTitle" id="pageTitle" maxlength="70" placeholder="Enter page Title" value="{{$pageTitle}}">
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Description</label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <textarea rows="3" class="form-control" placeholder="Description" maxlength="300"  name="metaDescription" id="metaDescription">{{$metaDescription}}</textarea>
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Meta Keywords</label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <textarea rows="3" class="form-control" placeholder="Meta Keywords" maxlength="300"  name="metaKeyword" id="metaKeyword">{{$metaKeyword}}</textarea>
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label class="col-sm-2 col-md-2 col-xs-5 control-label text-left">Keyword Search</label>
                                              <div class="col-sm-6 col-md-6 col-xs-9">
                                                  <textarea rows="3" class="form-control" placeholder="Keyword Search" maxlength="300"  name="keywordDescription" id="keywordDescription_content">{{$keywordDescription}}</textarea>
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
                              <input type="submit" class="btn btn-warning waves-effect waves-light" name="save" value="Submit">
                              <button class="btn btn-primary waves-effect waves-light m-l-5" onclick="fun_back_mata()">Back</button>
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