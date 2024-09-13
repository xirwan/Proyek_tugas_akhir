{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

{{-- <!doctype html>
<html class="fixed">
	<head>

		@include('admin.css')

	</head>
	<body> --}}
<x-app-layout>
	<div class="row">
		<div class="col-lg-10">
			<div class="row mb-3">
				<div class="col-xl-6">
					<section class="card card-featured-left card-featured-primary mb-3">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-primary">
										<i class="fas fa-life-ring"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Support Questions</h4>
										<div class="info">
											<strong class="amount">1281</strong>
											<span class="text-primary">(14 unread)</span>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(view all)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-xl-6">
					<section class="card card-featured-left card-featured-secondary">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-secondary">
										<i class="fas fa-dollar-sign"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Total Profit</h4>
										<div class="info">
											<strong class="amount">$ 14,890.30</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(withdraw)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6">
					<section class="card card-featured-left card-featured-tertiary mb-3">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-tertiary">
										<i class="fas fa-shopping-cart"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Today's Orders</h4>
										<div class="info">
											<strong class="amount">38</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(statement)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="col-xl-6">
					<section class="card card-featured-left card-featured-quaternary">
						<div class="card-body">
							<div class="widget-summary">
								<div class="widget-summary-col widget-summary-col-icon">
									<div class="summary-icon bg-quaternary">
										<i class="fas fa-user"></i>
									</div>
								</div>
								<div class="widget-summary-col">
									<div class="summary">
										<h4 class="title">Today's Visitors</h4>
										<div class="info">
											<strong class="amount">3765</strong>
										</div>
									</div>
									<div class="summary-footer">
										<a class="text-muted text-uppercase" href="#">(report)</a>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>	
</x-app-layout>
		{{-- @include('admin.script')
	</body>
</html> --}}