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
			<header id="header" class="header header-nav-links header-nav-menu h-auto py-1" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': false, 'stickyEnableOnMobile': true, 'stickyStartAt': 70, 'stickyChangeLogo': false, 'stickyHeaderContainerHeight': 70}">
				<div class="header-body border-top-0 bg-dark box-shadow-none h-auto">
					<div class="header-container container h-100">
						<div class="header-row h-100">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="#" class="goto-top">
                                            <img src="{{asset ('admintemp/img/logo.png')}}" alt="logo_GBI" width="50" class="rounded-circle">
                                        </a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									
                                    <button class="btn header-btn-collapse-nav d-lg-none order-3 mt-0 ml-3 mr-0" data-toggle="collapse" data-target=".header-nav">
										<i class="fas fa-bars"></i>
									</button>
									
                                    <!-- start: header nav menu -->
									<div class="header-nav header-nav-links header-nav-light-text header-nav-dropdowns-dark collapse">
										<div class="header-nav-main header-nav-main-mobile-dark header-nav-main-effect-1 header-nav-main-sub-effect-1">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
                                                 
                                                    <li>
													    <a class="nav-link" href="#" data-hash data-hash-offset="120">
													        Home
													    </a>    
													</li>

                                                    <li>
													    <a class="nav-link" href="#cabang" data-hash data-hash-offset="120">
													        Cabang
													    </a>    
													</li>

                                                    
													<li class="dropdown">
													    <a class="nav-link dropdown-toggle" href="#">
													        Jadwal Ibadah
													    </a>
													    <ul class="dropdown-menu">
													        <li>
													            <a class="nav-link" href="pages-signup.html">
													                Ibadah Umum
													            </a>
													        </li>
													        
                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Ibadah Anak/remaja
													            </a>
													        </li>
													        
                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Kelompok Tumbuh Bersama
													            </a>
													        </li>
													        
													    </ul>
													</li>
                                                    
													<li class="dropdown">
													    <a class="nav-link dropdown-toggle" href="#">
													        Layanan
													    </a>
													    <ul class="dropdown-menu">
													        <li>
													            <a class="nav-link" href="{{ route('pembaptisan') }}">
													                Pembaptisan
													            </a>
													        </li>
													        
                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Pemuridan
													            </a>
													        </li>
													        
                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Penyerahan Anak
													            </a>
													        </li>
													        
                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Permohonan Doa
													            </a>
													        </li>

                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Pemberkatan Nikah
													            </a>
													        </li>

                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Pendaftaran Komunitas
													            </a>
													        </li>

                                                            <li>
													            <a class="nav-link" href="pages-signup.html">
													                Pendaftaran Sekolah Minggu
													            </a>
													        </li>
													        
													    </ul>
													</li>

                                                                                                        
												</ul>
                                                
											</nav>
										</div>
									</div>

                                    
                                    @if (Route::has('login'))
                                        
                                            @auth
                                                {{-- <a
                                                    href="{{ url('/dashboard') }}"
                                                    class="nav-link"
                                                >
                                                    Dashboard
                                                </a> --}}
                                                <div id="userbox" class="userbox ml-3">
                                                    <a href="#" data-toggle="dropdown">
                                                        <div class="profile-info">
                                                            <span class="name text-white">{{ Auth::user()->name }}</span>
                                                        </div>
                                        
                                                        <i class="fa custom-caret text-white"></i>
                                                    </a>
                                        
                                                    <div class="dropdown-menu bg-dark shadow" style="opacity: 0.9">
                                                        <ul class="list-unstyled mb-2">
                                                            <li class="divider"></li>
                                                            <li>
                                                                <a role="menuitem" tabindex="-1" href="{{route('profile.edit')}}"><i class="bx bx-user-circle"></i> My Profile</a>
                                                            </li>
                                                            <li>
                                                                <form method="POST" action="{{ route('logout') }}" style="display: none;" id="logout-form">
                                                                    @csrf
                                                                </form>
                                                                <a role="menuitem" tabindex="-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off"></i> Logout</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @else
                                                
                                                    <a
                                                        href="{{ route('login') }}"
                                                        class="nav-link btn btn-primary btn-rounded text-3 ml-3 d-none d-sm-block"
                                                    >
                                                        Log In
                                                    </a>
                                                

                                                @if (Route::has('register'))
                                                    <a
                                                        href="{{ route('register') }}"
                                                        class="nav-link btn btn-primary btn-rounded text-3 ml-2 d-none d-sm-block bg-dark"
                                                    >
                                                        Register
                                                    </a>
                                                @endif
                                            @endauth
                                       
                                    @endif
									<!-- end: header nav menu -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div role="main" class="main">
                <section class="section section-concept section-no-border section-dark section-angled section-angled-reverse border-top-0 m-0" id="section-concept" style="background-image: url('https://assets.loket.com/neo/production/images/banner/20211114103040_619082e0d6dd5.jpg'); background-size: cover; background-position: center; animation-duration: 750ms; animation-delay: 300ms; animation-fill-mode: forwards;">
                    <div class="h-100 w-100 pt-5" style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="section-angled-layer-bottom bg-light" style="padding: 8rem 0;"></div>
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

				<section id="intro" class="section section-no-border section-angled bg-light border-top-0 pt-0 pb-5 m-0">
					
					<div class="container pb-2 h-100">
						
                        <h1 class="mx-auto text-center pb-5" id="cabang">Cabang</h1>
						<div class="row text-center mb-5 pb-lg-3">
							
                            <div class="my-auto col-md-4 col-lg-4 text-center divider-left-border divider-right-border">
								<div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="750" data-appear-animation-duration="750">
									<label class="font-weight-semibold negative-ls-1 text-6 text-color-dark mb-0">GBI Sungai Yordan</label>
									<p class="text-color-grey font-weight-semibold pb-1 mb-2">Taman Ratu</p>
									<p class="mb-0"><a href="https://themeforest.net/item/porto-admin-responsive-html5-template/8539472" class="text-color-primary d-flex align-items-center justify-content-center text-3 font-weight-semibold text-decoration-none" target="_blank">View More<i class="fas fa-long-arrow-alt-right ml-2 text-3 mb-0"></i></a></p>
								</div>
							</div>
                            <div class="my-auto col-md-4 col-lg-4 text-center divider-left-border divider-right-border">
								<div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="750" data-appear-animation-duration="750">
									<label class="font-weight-semibold negative-ls-1 text-6 text-color-dark mb-0">GBI Sungai Yordan</label>
									<p class="text-color-grey font-weight-semibold pb-1 mb-2">Taman Ratu</p>
									<p class="mb-0"><a href="https://themeforest.net/item/porto-admin-responsive-html5-template/8539472" class="text-color-primary d-flex align-items-center justify-content-center text-3 font-weight-semibold text-decoration-none" target="_blank">View More<i class="fas fa-long-arrow-alt-right ml-2 text-3 mb-0"></i></a></p>
								</div>
							</div>
                            <div class="my-auto col-md-4 col-lg-4 text-center divider-left-border divider-right-border">
								<div class="appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="750" data-appear-animation-duration="750">
									<label class="font-weight-semibold negative-ls-1 text-6 text-color-dark mb-0">GBI Sungai Yordan</label>
									<p class="text-color-grey font-weight-semibold pb-1 mb-2">Taman Ratu</p>
									<p class="mb-0"><a href="https://themeforest.net/item/porto-admin-responsive-html5-template/8539472" class="text-color-primary d-flex align-items-center justify-content-center text-3 font-weight-semibold text-decoration-none" target="_blank">View More<i class="fas fa-long-arrow-alt-right ml-2 text-3 mb-0"></i></a></p>
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

				{{-- <section class="section section-no-border section-angled bg-color-light-scale-1 border-top-0 m-0">
					<div class="section-angled-layer-top section-angled-layer-increase-angle" style="padding: 3.7rem 0; background-color: #0169fe;"></div>
					<div class="container py-5 my-5">
						<div class="row align-items-center text-center my-5">
							<div class="col-md-6">
								<h2 class="text-color-dark font-weight-bold text-9 mb-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">Introducing Porto Front End</h2>
								<p class="font-weight-semibold text-primary text-4 fonts-weight-semibold positive-ls-2 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">FRONT-END WITH SAME LOOK'N FEEL AS THE BACK-END</p>
								<p class="font-weight-500 pb-2 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">Porto Admin integration give you a package of new features to add in the front-end template, such as advanced tables, advanced forms, etc... Also allows you to create the back-end of your site using the same design.</p>
								<a href="https://themeforest.net/item/porto-admin-responsive-html5-template/8539472" class="btn btn-modern btn-gradient btn-rounded btn-px-5 py-3 text-3 mb-4 appear-animation" target="_blank" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000" data-appear-animation-duration="750" target="_blank">VIEW PORTO FRONT-END</a>
								<p class="appear-animation text-4" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1200">* Porto Front-End <strong class="text-dark">is not included</strong> in the admin and is available for $16.</p>
							</div>
							<div class="col-md-6 py-5">
								<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500">
									<img class="porto-lz"src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_dots2.png" alt="" width="149" height="142" style="position: absolute; top: -60px; right: -8%;">
								</div>
								<div class="appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="0" data-appear-animation-duration="750">
									<div class="strong-shadow rounded strong-shadow-top-right">
										<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_front_end.jpg" class="img-fluid border border-width-10 border-color-light rounded box-shadow-3" alt="Porto Admin" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</section> --}}

				{{-- <section class="section border-0 section-angled section-angled-reverse section-funnel m-0 position-relative overflow-visible" style="background-image: url(img/lazy.png); background-size: 100%; background-position: top; background-repeat: no-repeat; background-color: rgb(34, 37, 42);" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_performance_bg.png">
					<div class="section-angled-layer-top section-angled-layer-increase-angle" style="padding: 5rem 0; background-color: #22252a;"></div>
					<svg version="1.1" viewBox="500 200 600 900" width="1920" height="100%" xmlns="http://www.w3.org/2000/svg" class="background-svg-style-1" style="top: 120px;">
						<defs>
							<filter id="shadow" x="-300%" y="-300%" width="600%" height="600%">
							<feDropShadow dx="0" dy="0" stdDeviation="10 10" flood-color="#08c" radius="10" flood-opacity="1" />
							</filter>
						</defs>
						<path id="svg_17" d="m1644.875212,897.875106l-1684.875221,-0.374889l1.25,-446.250108c-1.25,0.372765 496.124925,24.124892 496.124925,24.124892c0,0 255.000064,-106.250026 253.875257,-106.624912c1.124807,0.374885 129.874839,-2.125116 128.750031,-2.500001c1.124808,0.374885 112.374836,-32.125123 111.250027,-32.500008c1.124809,0.374885 144.874844,21.62489 144.874844,21.62489c0,0 128.750032,-73.750018 127.625222,-74.124903c1.124811,0.374884 133.624844,9.124887 133.624844,9.124887c0,0 108.750027,35.000009 108.750027,35.000009c0,0 178.750045,-125.000031 177.625231,-125.374915" opacity="0.5" stroke-opacity="null" stroke-width="0" stroke="#191b1e" fill="#191b1e" fill-opacity="0.4"/>
						<path id="svg_6" d="m1663.83437,909.61168l-1704.94553,-0.72172l1.11111,-486.66724l648.88966,30.00004l105.55568,-41.11116l126.66682,1.11111l122.22236,-34.44449l126.66682,14.44447c0.49906,0.72171 126.05477,-64.83392 126.05477,-64.83392c0,0 128.88904,4.44445 128.38998,3.72273c0.49906,0.72172 118.27698,28.49953 118.27698,28.49953c0,0 173.33353,-108.88902 172.83447,-109.61073" stroke-opacity="null" stroke-width="0" stroke="#1a1b1f" fill="#1a1b1f" fill-opacity="0.4"/>
						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="250" stroke="#000" ry="3.5" rx="3.5" id="svg_9" cy="453.023736" cx="609.150561" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="2000" stroke="#FFF" r="20" id="svg_9" cy="453.023736" cx="609.150561" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 101.5% 50.4%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500" stroke="#000" ry="3.5" rx="3.5" id="svg_10" cy="411.595173" cx="715.341014" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="250" stroke="#FFF" r="20" id="svg_9" cy="411.595173" cx="715.341014" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 119.2% 45.7%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="750" stroke="#000" ry="3.5" rx="3.5" id="svg_11" cy="412.071364" cx="841.05527" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="2000" stroke="#FFF" r="20" id="svg_9" cy="412.071364" cx="841.05527" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 140.1% 45.7%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1000" stroke="#000" ry="3.5" rx="3.5" id="svg_12" cy="378.261847" cx="964.388575" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="250" stroke="#FFF" r="20" id="svg_9" cy="378.261847" cx="964.388575" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 160.7% 42%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1250" stroke="#000" ry="3.5" rx="3.5" id="svg_13" cy="391.595177" cx="1090.102832" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="2000" stroke="#FFF" r="20" id="svg_9" cy="391.595177" cx="1090.102832" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 181.6% 43.5%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1500" stroke="#000" ry="3.5" rx="3.5" id="svg_14" cy="327.706436" cx="1216.769206" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="250" stroke="#FFF" r="20" id="svg_9" cy="327.706436" cx="1216.769206" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 202.8% 36.4%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="1750" stroke="#000" ry="3.5" rx="3.5" id="svg_15" cy="332.150871" cx="1346.213343" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="2000" stroke="#FFF" r="20" id="svg_9" cy="332.150871" cx="1346.213343" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 224.3% 36.9%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="2000" stroke="#000" ry="3.5" rx="3.5" id="svg_16" cy="358.26192" cx="1463.43529" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="250" stroke="#FFF" r="20" id="svg_9" cy="358.26192" cx="1463.43529" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 243.8% 39.8%;" />

						<ellipse class="dots appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="2250" stroke="#000" ry="3.5" rx="3.5" id="svg_7" cy="278.817661" cx="1589.546107" stroke-opacity="null" stroke-width="0" fill="#fff"/>
						<circle class="appear-animation" data-appear-animation="dotPulse" data-appear-animation-delay="2000" stroke="#FFF" r="20" id="svg_9" cy="278.817661" cx="1589.546107" stroke-opacity="null" stroke-width="0.2" fill="none" style="transform-origin: 264.6% 30.9%;" />

						</g>
					</svg>
					<img class="img-fluid position-absolute d-none d-lg-block appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300" data-appear-animation-duration="750" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_notebook.png" alt="Performance on Laptop" style="display: block; top: -170px; left: 30px;">
					<div class="container text-center py-5 mb-5">
						<div class="row justify-content-center pb-md-5 mb-md-5">
							<div class="col-md-7 offset-lg-5 pb-md-5 mb-md-5">
								<h2 class="text-color-light font-weight-bold text-9 appear-animation mb-3" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">Top Performance</h2>
								<p class="custom-text-color-1 color-inherit mb-4 pb-lg-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">Porto has high performance base, all structure are focusing on performance as main point. Porto speed optimization is super fast compared to other templates.</p>
							</div>
						</div>
						<div class="row align-items-center pb-md-5 mb-md-5">
							<div class="col-12 col-md-7 text-center mt-5">
								<h2 class="font-weight-bold text-color-light text-7 text-md-6 text-lg-9 pt-5 pt-md-4 mt-5 mb-lg-5 mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">Works Perfectly on <span class="highlighted-word highlighted-word-animation-1 highlighted-word-animation-1-no-rotate alternative-font-4 font-weight-bold pb-2"> Any </span> Device!</h2>
								<p class="custom-text-color-1 color-inherit appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">We believe you will face lots of traffic from mobile device users not only from desktop or laptop users. Porto is the best solution for you, works fine on any screen resolutions and mobile devices. Try Porto and see how it works!</p>
							</div>
							<div class="col-5 d-none d-md-block">
								<div class="text-right mr-3 mr-lg-5 ml-auto mb-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="600" data-appear-animation-duration="750" style="max-width: 244px;" data-plugin-options="{'accY': -100}">
									<img class="img-fluid" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_iphone.png" width="244" height="228" alt="Performance on Mobile">
								</div>
								<img class="img-fluid appear-animation z-index-1 position-relative" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="800" data-appear-animation-duration="750" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_ipad.png" width="437" height="241" alt="Performance on Tablet" style="margin-bottom: 0%">
							</div>
						</div>
					</div>
					<div class="section-funnel-layer-bottom" style="bottom: 20px;">
						<div class="section-funnel-layer bg-light"></div>
						<div class="section-funnel-layer bg-light"></div>
					</div>
				</section> --}}

				{{-- <section id="demos" class="section section-no-border section-light bg-light position-relative z-index-3 border-top-0 pt-0 m-0">
					<div class="container" style="margin-top: -60px;">
						<div class="row align-items-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250" data-appear-animation-duration="750">
							<div class="col-lg-8 offset-lg-2 text-center">
								<ul class="list list-unstyled d-flex justify-content-center text-primary font-weight-semibold positive-ls-2 flex-column flex-md-row text-4 pb-1 mb-2">
									<li>1. SELECT FILES</li>
									<li class="mx-5">2. CUSTOMIZE</li>
									<li>3. DONE</li>
								</ul>
								<p class="font-weight-500 text-4 px-lg-5 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">Porto Admin is a truely complete template, with over 20 demos that make it suitable for any type of admin project. We believe you will like Porto Admin.</p>
								<p class="d-flex align-items-center justify-content-center font-weight-bold text-color-dark line-height-2 text-8 negative-ls-1 pb-2 mb-5 appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="600"><span class="highlighted-word highlighted-word-animation-1 highlighted-word-animation-1-2 highlighted-word-animation-1-2-dark highlighted-word-animation-1 pos-2 alternative-font-4 font-weight-extra-bold line-height-1 text-8 py-2 mr-3">20</span> Prebuilt Dashboards Ready to Use</p>
							</div>
						</div>
					</div>
					<div class="container-fluid" id="demos">
						<div class="row justify-content-center portfolio-list sort-destination overflow-visible" data-sort-id="portfolio">

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-default.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-default.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Default</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3 portfolio-item-new">
										<a target="_blank" href="ecommerce-dashboard.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-ecommerce.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">eCommerce</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-dark-header.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-dark-header.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Dark Header</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-dark.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-dark.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Dark</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-boxed.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-boxed-static-header.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Boxed With Static Header</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-boxed-fixed-header.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-boxed-fixed-header.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Boxed With Fixed Header</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-header-menu.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-horizontal-menu-pills.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Horizontal Menu - Pills</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-header-menu-stripe.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-horizontal-menu-stripe.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Horizontal Menu - Stripe</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-header-menu-top-line.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-horizontal-menu-top-line.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Horizontal Menu - Top Line</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-light-sidebar.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-light-sidebar.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Light Sidebar</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-left-sidebar-scroll.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-sidebar-scroll.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Scroll</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-left-sidebar-big-icons.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-big-icons.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Big Icons Dark</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-left-sidebar-big-icons-light.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-big-icons-light.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Big Icons Light</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-left-sidebar-panel.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-sidebar-panel-dark.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Panel Dark</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-left-sidebar-panel-light.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-sidebar-panel-light.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Panel Light</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-tab-navigation.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-tab-navigation-light.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Tab Navigation Light</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-tab-navigation-dark.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-tab-navigation-dark.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Tab Navigation Dark</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-tab-navigation-boxed.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-tab-navigation-boxed.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Tab Navigation Boxed</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-two-navigations.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-two-navigations.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Two Navigations</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-square-borders.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-default.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Square Borders</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-sidebar-sizes-sm.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-sidebar-sm.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Size SM</h5>
									</div>
								</div>
							</div>

							<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-1-5 isotope-item">
								<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200" data-appear-animation-duration="750">
									<div class="portfolio-item hover-effect-1 text-center pb-2 mb-3">
										<a target="_blank" href="layouts-sidebar-sizes-xs.html">
											<div class="thumb-info thumb-info-no-zoom thumb-info-no-overlay thumb-info-no-bg box-shadow-7">
												<div class="thumb-info-wrapper thumb-info-wrapper-demos m-0">
													<img src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/previews/preview-sidebar-xs.jpg" width="350" height="259" class="img-fluid h-auto" alt="">
												</div>
											</div>
										</a>
										<h5 class="font-weight-semibold text-color-dark text-capitalize text-3 mt-3">Left Sidebar Size XS</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="row pt-3 mt-5">
							<div class="col text-center">
								<a href="layouts-default.html" class="btn btn-dark btn-rounded btn-modern btn-px-5 py-3 text-3 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300">VIEW MAIN DASHBOARD</a>
							</div>
						</div>
					</div>
				</section> --}}

				{{-- <section class="section section-angled section-angled-reverse section-funnel border-0 m-0 section-dark">
					<div class="section-angled-layer-top section-angled-layer-increase-angle bg-light" style="padding: 4rem 0;"></div>
					<div class="container py-5 mt-4 mb-3">
						<div class="row align-items-center pt-2 pb-3 mt-4 mb-5">
							<div class="col-lg-6 pr-lg-5 position-relative text-center mb-5 mb-lg-0">
								<img alt="Porto Headers" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_headers.png" class="img-fluid appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300" />
							</div>
							<div class="col-lg-5 text-center px-lg-0">
								<h5 class="text-primary font-weight-semibold positive-ls-2 text-4 mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="250" data-appear-animation-duration="750">ADVANCED USABILITY-FOCUSED </h5>
								<h2 class="text-color-light font-weight-bold text-9 mt-0 mb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">Dashboards, Headers and Navs</h2>
								<p class="font-weight-500 custom-text-color-1 color-inherit appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800" data-appear-animation-duration="750">Porto comes with several headers and menus options for you to use on your project. We have created several options always focused on the best user experience to improve your business.</p>
								<p class="font-weight-500 custom-text-color-1 color-inherit pb-2 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000" data-appear-animation-duration="750">Select any of the options we have giver you or create your own.</p>
								<div class="d-flex align-items-center justify-content-center">
									<i class="fa fa-check text-color-primary bg-light rounded-circle p-2 mr-3 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1600" data-appear-animation-duration="750"></i>
									<p class="mb-0 line-height-5 ls-0 text-color-light font-weight-500 text-left appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="1300" data-appear-animation-duration="750">Menus, Nav Icons, Search Icons, Alerts,<br>Account Items, Search and much more...</p>
								</div>
							</div>
						</div>
					</div>
					<div class="section-funnel-layer-bottom" style="bottom: -30px;">
						<div class="section-funnel-layer bg-color-light-scale-1"></div>
						<div class="section-funnel-layer bg-color-light-scale-1"></div>
					</div>
				</section> --}}

				{{-- <section class="section section-funnel position-relative z-index-3 border-0 pt-0 m-0">
					<div class="container pb-5">
						<h2 class="fotn-weight-extra-bold text-center mt-0 mb-1">
							<b class="text-color-dark text-13 d-block line-height-1 font-weight-extra-bold appear-animation" data-appear-animation="blurIn" data-appear-animation-delay="250" data-appear-animation-duration="750">7K+</b>
							<span class="font-weight-bold text-color-dark text-5 negative-ls-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600" data-appear-animation-duration="750">People Already Using Porto Admin</span>
						</h2>
						<p class="font-weight-bold text-4 text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="750">100K+ IN ALL PORTO VERSIONS</p>
						<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="850" data-appear-animation-duration="850">
							<h5 class="font-weight-semibold positive-ls-2 text-4 text-primary text-center mb-0">TOP 5 STAR RATING</h5>
							<p class="font-weight-500 text-default text-center mb-4">Real people, real stories. Hear from our community.</p>
							
							<div class="owl-carousel owl-theme carousel-center-active-item-2 nav-style-4 mb-4 pb-3" data-plugin-carousel data-plugin-options='{ "items": 1, "dots": false, "loop": true, "nav": true }'>
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">onealbs</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"I have purchased this template four times for different projects and will soon be purchasing my fifth. This options for this template are limitless and customer service is amazing!"</p>
								</div>	
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">mrmelton</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"This template is pure joy to work with and customize. Everything is designed so clearly and it just makes your life easier to design a site. Highly recommend."</p>
								</div>
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">daniyal1997</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"This theme continues to blow my mind! I can't believe how many features and layouts that are included and yet how elegantly it's all executed underneath."</p>
								</div>
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">alfvlx</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"The best template i had work on!!!!!"</p>
								</div>
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">marcoss2009</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"The best theme in Themeforest. I like it because I can customize it without problems."</p>
								</div>
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">moirajanetallen</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"Very impressed with the great customer support."</p>
								</div>
								
								<div>
									<div class="d-flex flex-column flex-md-row justify-content-between mb-3">
										<div class="author">
											<h4 class="font-weight-500 text-5 mt-0 mb-0">majstro7</h4>
											<span class="opacity-7">Themeforest User</span>
										</div>
										<span class="star-rating">
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
											<i class="fas fa-star text-color-dark"></i>
										</span>
									</div>
									<p class="font-weight-500 opacity-8 text-4 line-height-8 mb-0">"Good code quality ! Very fast and good support ! I recommended it in 100% !"</p>
								</div>
							</div>
						</div>
						<p class="text-center mb-5"><a class="btn btn-dark btn-modern btn-rounded btn-px-5 py-3 text-1 ls-0 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="250" data-appear-animation-duration="600" href="https://themeforest.net/item/porto-admin-responsive-html5-template/8539472" target="_blank">BUY PORTO ADMIN NOW</a></p>
					</div>
					<div class="section-funnel-layer-bottom" style="bottom: -30px">
						<div class="section-funnel-layer bg-light"></div>
						<div class="section-funnel-layer bg-light"></div>
					</div>
				</section> --}}

				{{-- <section id="support" class="section section-angled bg-light border-0 m-0 position-relative z-index-3 pt-0">
					<div class="container pb-5 mb-5">
						<div class="row align-items-center mb-5">
							<div class="col-lg-6 pr-xl-5 mb-5 mb-lg-0">
								<h2 class="text-color-dark font-weight-bold text-9 mt-0 mb-1">Professional Support</h2>
								<h5 class="font-weight-semibold positive-ls-2 text-4 text-primary mb-3">ONLINE DOCUMENTATION, VIDEOS AND FORUM</h5>
								<p class="ls-0 text-default fw-400 mb-5">Any problem while using Porto Admin? We're here to help you.</p>
								<div class="d-flex align-items-center border border-top-0 border-right-0 border-left-0 pb-4 mb-4">
									<i class="fa fa-check text-color-primary bg-light rounded-circle box-shadow-4 p-2 mr-3"></i>
									<p class="mb-0"><b class="text-color-dark">Online Documentation -</b> Contains all descriptions related to Porto Admin usage and features.</p>
								</div>
								<div class="d-flex align-items-center border border-top-0 border-right-0 border-left-0 pb-4 mb-4">
									<i class="fa fa-check text-color-primary bg-light rounded-circle box-shadow-4 p-2 mr-3"></i>
									<p class="mb-0 mb-0 opacity-5"><b class="text-color-dark">Video Documentation (coming soon) -</b> Need visual instructions? Check our video tutorials.</p>
								</div>
								<div class="d-flex align-items-center pb-4 mb-4 pb-lg-0 mb-lg-0">
									<i class="fa fa-check text-color-primary bg-light rounded-circle box-shadow-4 p-2 mr-3"></i>
									<p class="mb-0"><b class="text-color-dark">Support Center -</b> Contact us if you get any issue while using Porto Admin.</p>
								</div>
							</div>
							<div class="col-lg-4 offset-lg-2">
								<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="500">
									<img class="img-fluid" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_dots2.png" alt="" style="position: absolute; bottom: -2%; left: -43%; transform: rotate(90deg)">
								</div>
								<img alt="Porto Support" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/support_login.jpg" class="img-fluid border border-width-10 border-color-light rounded box-shadow-3 ml-5 appear-animation" data-appear-animation="fadeInUp" data-appear-animation-delay="200" style="width: 590px; max-width: none;">
								<img alt="Porto Documentation" src="img/lazy.png" data-plugin-lazyload data-plugin-options="{'threshold': 500, 'effect':'fadeIn'}" data-original="img/landing/porto_docs.jpg" class="img-fluid  rounded box-shadow-3 position-absolute appear-animation" data-appear-animation="fadeInUp" data-appear-animation-delay="700" style="left: -100px; bottom: 50px;">
							</div>
						</div>
					</div>
					<div class="section-angled-layer-bottom section-angled-layer-increase-angle" style="padding: 4rem 0; background: #222529;"></div>
				</section> --}}
			</div>
			<footer id="footer" class="bg-color-dark-scale-5 border border-right-0 border-left-0 border-bottom-0 border-color-light-3 mt-0">
				<div class="container text-center my-3 py-5">
					<a href="#" class="goto-top">
						<img src="{{asset ('admintemp/img/logo.png')}}" alt="logo_GBI" width="75" class="rounded-circle mb-4 appear-animation" data-plugin-lazyload data-plugin-options="{'threshold': 500}" data-original="{{asset ('admintemp/img/logo.png')}}" data-appear-animation="fadeIn" data-appear-animation-delay="300">
					</a>
					<ul class="social-icons social-icons-big social-icons-dark-2">
						<li class="social-icons-instagram"><a href="http://www.instagram.com/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
						<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
						<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
						<li class="social-icons-youtube"><a href="http://www.youtube.com/" target="_blank" title="Youtube"><i class="fab fa-youtube"></i></a></li>
					</ul>
				</div>
				<div class="copyright bg-color-dark-scale-4 py-4">
					<div class="container text-center py-2">
						<p class="mb-0 text-2 ls-0">Copyright 2014 - 2021 GBI Sungai Yordan - All Rights Reserved</p>
					</div>
				</div>
			</footer>
		</div>

		@include('admin.script')


	</body>
</html>