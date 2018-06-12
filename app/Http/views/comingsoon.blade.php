<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>

<body data-spy="scroll" data-target="#fixed-collapse-navbar">
<div id="loader-container">
    <div class='loader'></div>
</div>

<!--Header-->
<section id="top_header">    
    @include('include.header')
    <div id="navigation" data-spy="affix" data-offset-top="98">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                  <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fixed-collapse-navbar" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <!-- <a class="navbar-brand" href="#">Brand</a> -->
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    @include('include.topmenu')
                  </div><!-- /.container-fluid -->
                </nav>
            </div>
        </div>
    </div>
</section>
<!--Top Banner-->





<div>
    <div class="container">
        <div class="row">
            <div class="main text-left">
                <h3 class="wow" data-wow-duration="2s" data-wow-delay="0.2s">Message</h3>
            </div>
            <div class="help_base">
                
                <div class="col-sm-7 testimonial-info">
                 
                    <p>We are not ready to sign ppl up or have then create a fondae just yet but that we will be shortly and you should fill a contact us form so when we get ready we will mail you </p>
                    <p>Thank you so much for showing your interest.</p>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>



@include('include.footer')
@include('include.footer-js')
</body>
</html>