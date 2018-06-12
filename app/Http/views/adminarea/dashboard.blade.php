@extends('adminarea.home')
@section('content')
<?php use Symfony\Component\HttpFoundation\Session\Session1;?>
<div class="col-sm-12 col-md-12 col-xs-12 home_main_content">
    <div class="row">
        <!-- Main content -->
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="content-header-media col-sm-12 col-md-12 col-xs-12">
                <div class="header-section">
                    <div class="col-md-12 col-lg-12 col-sm-12 ">
                        <h1>Welcome Fondae</h1>
                    </div>
                </div>
                <img src="{{ url('/images/dashboard_header.jpg') }}" alt="header image" class="animation-pulseSlow">
            </div>
           </div>
        <!-- /.content -->
        @if(Session::get('admin_user')==1)
        	<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
              
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/slideshow')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/slider.png" alt="slider" title="slider" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Slideshow<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/product')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/product.gif" alt="Products" title="Products" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Event<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/order')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/purchase_order.png" alt="Role" title="Role" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Donation<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/customer')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/user.png" alt="User" title="User" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">User<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/report/contactus')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/contact.png" alt="Contact us" title="Contact us" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Contact us<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/report/emailnews')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/email.png" alt="Gallery" title="Gallery" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Email<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/pages')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/page.jpg" alt="Page Mangement" title="Page Mangement" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Page Mangement<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/adminmenu')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/menu.png" alt="Menu" title="Menu" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Menu<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/globalsetting')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/global.png" alt="Global Setting" title="Global Setting" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Global setting<br>
                    </div>
                </a> 
              </div>
            </div>
              <?php /*?><div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/news')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/news.jpg" alt="News" title="News" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">News<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/links')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/link.jpg" alt="link" title="link" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Link<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/faq')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/faq1.png" alt="FAQ" title="FAQ" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">FAQ'S<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/staff')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/staff.png" alt="Staff" title="Staff" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Staff<br>
                    </div>
                </a> 
              </div><?php */?>
              
              <?php /*?><div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/portfolio')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/portfolio.png" alt="portfolio" title="portfolio" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Portfolio<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/gallery')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/gallery.png" alt="Gallery" title="Gallery" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Gallery<br>
                    </div>
                </a> 
              </div><?php */?>
              
              <?php /*?><div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/testimonials')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/testimonial.png" alt="Gallery" title="Gallery" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Testimonials<br>
                    </div>
                </a> 
              </div><?php */?>
              
              
              
              
           <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="card-box">
                         <div class="nav-tabs-custom">
                           <h4 class="text-dark  header-title"><i class="fa fa-file-text" aria-hidden="true"></i> Reports</h4>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Contact Us</a></li>
                            </ul>
                            <!-- strat tab content -->
                              <div class="tab-content">
                                  <div class="active tab-pane" id="home">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                     <th>Actions</th>
                                                     <th>First Name</th>
                                                     <th>Last Name</th>
                                                     <th>Email</th>
                                                     <th>Created Date</th>
                                                     <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (($recordcount)>0)
                                                    @if(isset($recordcount)) <?php $no_row=1;?>
                                                        @foreach($qGetAllContactus as $GetAllContact)
                                                            <tr  id="ID_{{ $GetAllContact->contactusID }}">
                                                                <td>
                                                                   <a href="javascript:fun_single_delete({{ $GetAllContact->contactusID }} );"  title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                                </td>
                                                                <td>{{ $GetAllContact->firstName }}</td>
                                                                <td>{{ $GetAllContact->lastName }}</td>
                                                                <td>{{ $GetAllContact->email }}</td>
                                                                <td>{{ date('m/d/Y',strtotime($GetAllContact->created_at)) }}</td>
                                                                <td>
                                                                    <a href="" data-toggle="modal" data-target="#myModal_{{ $GetAllContact->contactusID }}" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                    @include('adminarea.reports.contactus-view')
                                                                </td>
                                                            </tr>
                                                            <?php $no_row++;?> 
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <tr>
                                                        <td colspan="7" align="center">Record not found.</td>
                                                    </tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                  </div>
                                  
                                <!-- end property summary-->
                                </div>
                            <!--end tab-content -->
                          </div>
                    </div>
                </div>
           </div>
       </div>
       @else
       			<div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/product')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/product.gif" alt="Products" title="Products" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Create Your Event<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/order')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/purchase_order.png" alt="Role" title="Role" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Donation<br>
                    </div>
                </a> 
              </div>
              <div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="javascript:fun_edit();" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/user.png" alt="User" title="User" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">My Profile<br>
                    </div>
                </a> 
              </div>
              <?php /*?><div class="col-sm-6 col-lg-3 col-xs-6 col-md-3 home_icon_div"> 
                <a href="{{url('/adminarea/product/addeditproduct')}}" class="widget widget-hover-effect1">
                    <div class="widget-simple">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                      	<div class="home_icon_style">
                        	<img src="{{ url('/') }}/components/images/add-event.png" alt="Products" title="Products" class="animation-pulseSlow">
                        </div>
                      </div>
                      <h3 class="widget-content text-right animation-pullDown">Event<br>
                    </div>
                </a> 
              </div><?php */?>
     @endif
    </div>
</div>
<script type="text/javascript">
	function fun_single_delete(contactusID)
	{
		if(confirm("Are you sure want to delete this record? "))
		{
			$.ajax({
				type: "POST",
				url: "{{ url('/') }}/adminarea/report/contactsingledelete",
				data: "contactusID=" + contactusID,
				success: function(total){
				$("#ID_"+contactusID).animate({ opacity: "hide" }, "slow");
				}
			});
		}
	}
</script>
@endsection