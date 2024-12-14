<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GBI Sungai Yordan</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @include('admin.css')
        <link rel="stylesheet" href="{{ asset ('admintemp/css/landing.css')}}">
    </head>
	
    <body class="alternative-font-4 loading-overlay-showing" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 100}">

		<div class="loading-overlay">
			<div class="bounce-loader">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>
		
		<div class="body">
			
			@include('user.header')

			<div role="main" class="main">
                <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse border-top-0 m-0" id="section-concept" style="background-image: url('https://assets.loket.com/neo/production/images/banner/20211114103040_619082e0d6dd5.jpg'); background-size: cover; background-position: center; animation-duration: 750ms; animation-delay: 300ms; animation-fill-mode: forwards;">
                    <div class="h-100 w-100 pt-5" style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="container pt-3 pb-5 mt-lg-5" >
                            <div class="row align-items-center pt-3">
                                <div class="col-lg-5 mb-5">
                                    <h5 class="text-primary font-weight-bold mb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-duration="750">PORTO ADMIN HTML5 TEMPLATE</h5>
                                    <h1 class="font-weight-bold text-color-light text-13 line-height-2 mt-0 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">The Best Admin Template<span class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="600" data-appear-animation-duration="800"><span class="d-inline-block text-primary highlighted-word highlighted-word-rotate highlighted-word-animation-1 alternative-font-3 font-weight-bold text-1 ml-2">ever</span></span></h1>
                                    <p class="custom-font-size-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900" data-appear-animation-duration="750">Porto Admin is simply the best choice for your new project. The template is several years among the most popular in the world.<a href="#intro" data-hash data-hash-offset="120" class="text-color-light font-weight-semibold text-1 d-block">VIEW MORE <i class="fa fa-long-arrow-alt-right ml-1"></i></a></p>
    
                                    <div id="popup-content-1" class="dialog dialog-lg zoom-anim-dialog rounded p-3 mfp-hide mfp-close-out">
                                        <div class="embed-responsive embed-responsive-4by3">
                                            <video width="100%" height="100%" autoplay muted loop controls>
                                                  <source src="video/presentation.mp4?r=2" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 offset-lg-1 mb-5 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1200" data-appear-animation-duration="750">
                                    <div class="border-width-10 border-color-light clearfix border border-radius">
                                        <video class="float-left" width="100%" height="100%" autoplay muted loop>
                                              <source src="video/presentation.mp4?r=2" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</section>
				<section class="section section-no-border border-top-0 pt-0 pb-0 m-0">
					<div class="container">
						<div class="row align-items-center justify-content-between">
							<div class="col-lg-4 pr-lg-4 mb-5 mb-md-0">
								<h2 class="text-color-dark text-7 font-weight-semibold line-height-2 mb-2">The new generation of admin templates is here.</h2>
								<p class="pr-lg-5">A complete suite of tools designed to make life easier with a top quality admin templates.</p>
							</div>
							<div class="col-md-4 col-lg-auto icon-box text-center mb-md-4">
								<i class="icon-bg icon-1"></i>
								<h4 class="font-weight-bold text-color-dark custom-font-size-2 line-height-3 my-0">Super High<br>Performance</h4>
							</div>
							<div class="col-md-4 col-lg-auto icon-box text-center mx-xl-5 my-5 my-md-0 pb-md-4">
								<i class="icon-bg icon-4"></i>
								<h4 class="font-weight-bold text-color-dark custom-font-size-2 line-height-3 my-0">Created with Top<br>Plugins and Extensions</h4>
							</div>
							<div class="col-md-4 col-lg-auto icon-box text-center mb-4">
								<i class="icon-bg icon-3"></i>
								<h4 class="font-weight-bold text-color-dark custom-font-size-2 line-height-3 my-0">Extremely Easy<br>to Customize</h4>
							</div>
							<div class="col-sm-12">
								<hr class="solid opacity-7 my-5">
								<h2 class="font-weight-bold text-color-dark text-center text-10 pt-3 mb-3">The Most Customizable + Solid and Tested Base</h2>
							</div>
							<div class="col-lg-8 offset-lg-2 px-lg-0 text-center mb-5 mb-sm-4 mb-lg-0">
								<p class="font-weight-500 text-4 mb-5">Porto Admin has a huge variety of options and features to create your project, it has also a very solid based that is being improved and tested by professional developers since 2014.</p>
							</div>
						</div>
					</div>
				</section>
			</div>

			@include('user.footer')

		</div>

		@include('admin.script')

	</body>
</html>