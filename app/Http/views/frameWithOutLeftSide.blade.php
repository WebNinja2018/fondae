<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body data-spy="scroll" data-target="#fixed-collapse-navbar">
<?php /*?><div id="loader-container">
    <div class='loader'></div>
</div><?php */?>
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
             <div class="help_base">
                <div class="container">
                    <div class="footer-form wow " data-wow-duration="2s" data-wow-delay="0.4s">
                          @if($qGetPagesResult[0]->pageContentType==1 )
                              <div class="inner_only_content">
                              {!! $qGetPagesResult[0]->pageLongDescription !!} {{-- Coding For Page Type Content.--}}
                              </div>
                           @endif
                              
                           @if($qGetPagesResult[0]->pageContentType==3)
                                  {!! $qGetPagesResult[0]->pageLongDescription !!} {{-- Coding For Page Type Content.--}}
                           @endif

                           @if($qGetPagesResult[0]->pageContentType==2 || $qGetPagesResult[0]->pageContentType==3)
                                  @include('dynamic.'.$filename)
                           @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER-->
<footer>
@include('include.footer')
</footer>
<!-- FOOTER-->
<!-- JS-->
<?php /*?>@include('include.footer-js')<?php */?>
<!-- JS-->
</body>
</html>