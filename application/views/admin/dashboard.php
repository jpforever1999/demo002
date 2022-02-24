<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="universal admin is super flexible, powerful, clean & modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, universal admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="pixelstrap">
        <link rel="icon" href="/assets/images/favicon.png" type="image/x-icon"/>
        <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon"/>
        <title>Universal - Premium Admin Template</title>
        <!--Google font-->
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="/assets/css/fontawesome.css">
        <!-- ico-font -->
        <link rel="stylesheet" type="text/css" href="/assets/css/icofont.css">
        <!-- Themify icon -->
        <link rel="stylesheet" type="text/css" href="/assets/css/themify.css">
        <!-- Flag icon -->
        <link rel="stylesheet" type="text/css" href="/assets/css/flag-icon.css">
        <!-- prism css -->
        <link rel="stylesheet" type="text/css" href="/assets/css/prism.css">
        <!-- Bootstrap css -->
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
        <!-- SVG icon css -->
        <link rel="stylesheet" type="text/css" href="/assets/css/whether-icon.css">
        <!-- Chartist -->
        <link rel="stylesheet" type="text/css" href="/assets/css/chartist.css">
        <!-- App css -->
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
        <!-- Responsive css -->
        <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
    </head>
<div class="page-body">
<div class="container-fluid">
<div class="page-header">
<div class="row">
<div class="col-lg-6">
<h3>Dashboard</h3>
</div>
<?= $breadcrumbs ?>
</div>
</div>
</div>
<!-- Container-fluid Ends -->
<!-- Container-fluid starts -->
<div class="container-fluid">
<div class="card border-widgets">
<div class="row m-0">
<div class="col-xl-3 col-6 xs-width-100">
<div class="crm-top-widget card-body">
	<div class="media">
		<i class="icon-user font-primary align-self-center mr-3"></i>
		<div class="media-body">
		<?php $count_all_visiter = isset($count_all_visiter) ? $count_all_visiter:'-'; ?>  
			<span class="mt-0">All Visiter</span>
			<h4 class="counter"><?php echo $count_all_visiter; ?></h4>
		</div>
	</div>
</div>
</div>
<div class="col-xl-3 col-6 xs-width-100">
<div class="crm-top-widget card-body">
	<div class="media">
		<i class="icon-email font-secondary align-self-center mr-3"></i>
		<div class="media-body">
		<?php $count_all_subscribe= isset($count_all_subscribe) ? $count_all_subscribe:'-'; ?> 
			<span class="mt-0">Subscribe</span>
			<h4 class="counter"><?php echo $count_all_subscribe ?></h4>
		</div>
	</div>
</div>
</div>
<div class="col-xl-3 col-6 xs-width-100">
<div class="crm-top-widget card-body">
	<div class="media">
		<i class="icon-package font-success align-self-center mr-3"></i>
		<div class="media-body">
		<?php $count_all_product = isset($count_all_product) ? $count_all_product:'-'; ?>                                              
		  <span class="mt-0">Products</span>
			<h4 class="counter"><?php echo $count_all_product; ?></h4>
		</div>
	</div>
</div>
</div>
<div class="col-xl-3 col-6 xs-width-100">
<div class="crm-top-widget card-body">
	<div class="media">
		<i class="icon-direction-alt font-info align-self-center mr-3"></i>
		<div class="media-body">
		<?php $count_all_post = isset($count_all_post) ? $count_all_post:'-'; ?>  
			<span class="mt-0">All Post</span>
			<h4 class="counter"><?php echo $count_all_post; ?></h4>
		</div>
	</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-xl-6 xl-100">
<div class="card" >
<div class="card-header">
	<h5>Total sales</h5>
	<div class="card-header-right">
		<ul class="list-unstyled card-option">
			<li><i class="icofont icofont-simple-left "></i></li>
			<li><i class="view-html fa fa-code"></i></li>
			<li><i class="icofont icofont-maximize full-card"></i></li>
			<li><i class="icofont icofont-minus minimize-card"></i></li>
			<li><i class="icofont icofont-refresh reload-card"></i></li>
			<li><i class="icofont icofont-error close-card"></i></li>
		</ul>
	</div>
</div>
<div class="card-body">
	<div class="ct-10 total-chart"></div>
	<div class="code-box-copy">
		<button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
	</div>
</div>
</div>
</div>
<div class="col-xl-6 xl-100">
<div class="card" >
<div class="card-header">
	<h5>Total Vender</h5>
	<div class="card-header-right">
		<ul class="list-unstyled card-option">
			<li><i class="icofont icofont-simple-left "></i></li>
			<li><i class="view-html fa fa-code"></i></li>
			<li><i class="icofont icofont-maximize full-card"></i></li>
			<li><i class="icofont icofont-minus minimize-card"></i></li>
			<li><i class="icofont icofont-refresh reload-card"></i></li>
			<li><i class="icofont icofont-error close-card"></i></li>
		</ul>
	</div>
</div>
<div class="card-body">
	<div class="ct-1 total-chart"></div>
	<div class="code-box-copy">
		<button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head1" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
	</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-xl-8 col-lg-12">
<div class="card">
<div class="card-header">
	<h5>Combo Chart</h5>
	<div class="card-header-right">
		<ul class="list-unstyled card-option">
			<li><i class="icofont icofont-simple-left "></i></li>
			<li><i class="view-html fa fa-code"></i></li>
			<li><i class="icofont icofont-maximize full-card"></i></li>
			<li><i class="icofont icofont-minus minimize-card"></i></li>
			<li><i class="icofont icofont-refresh reload-card"></i></li>
			<li><i class="icofont icofont-error close-card"></i></li>
		</ul>
	</div>
</div>
<div class="card-body">
	<div class="ct-12 combo-chart"></div>
	<div class="code-box-copy">
		<button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head2" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
	</div>
</div>
</div>
</div>
<div class="col-xl-4 col-lg-12">
<div class="card" >
<div class="whether-widget">
	<div class="whether-widget-top card-header">
		<div class="row">
			<div class="col-sm-6">
				<img src="/assets/images/dashboard/sun.png" alt=""/>
				<span class="block_whether_bottom">Cool Day</span>
			</div>
			<div class="col-sm-6">
				<div class="details">
					<span>India, Surat</span>
					<h4><span class="counter">36</span><sup>o</sup>F</h4>
				</div>
			</div>
		</div>
	</div>
	<div class="whether-widget-bottom card-body">
		<div class="row">
			<div class="col-6 p-0">
				<div class="media pt-0">
					<div class="mr-3">
						<svg
							version="1.1"
							id="cloudRainMoonFill"
							class="climacon climacon_cloudRainMoonFill"
							viewBox="15 15 70 70">
							<g class="climacon_iconWrap climacon_iconWrap-cloudRainMoonFill">
								<g class="climacon_wrapperComponent climacon_wrapperComponent-moon climacon_componentWrap-moon_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
										d="M61.023,50.641c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C73.021,45.269,67.649,50.641,61.023,50.641z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_moon"
										fill="#FFFFFF"
										d="M59.235,30.851c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C63.961,39.527,60.139,35.705,59.235,30.851z"/>
								</g>
								<g class="climacon_wrapperComponent climacon_wrapperComponent-rain">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- left"
										d="M41.946,53.641c1.104,0,1.999,0.896,1.999,2v15.998c0,1.105-0.895,2-1.999,2s-2-0.895-2-2V55.641C39.946,54.537,40.842,53.641,41.946,53.641z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- middle"
										d="M49.945,57.641c1.104,0,2,0.896,2,2v15.998c0,1.104-0.896,2-2,2s-2-0.896-2-2V59.641C47.945,58.535,48.841,57.641,49.945,57.641z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- right"
										d="M57.943,53.641c1.104,0,2,0.896,2,2v15.998c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2V55.641C55.943,54.537,56.84,53.641,57.943,53.641z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- left"
										d="M41.946,53.641c1.104,0,1.999,0.896,1.999,2v15.998c0,1.105-0.895,2-1.999,2s-2-0.895-2-2V55.641C39.946,54.537,40.842,53.641,41.946,53.641z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- middle"
										d="M49.945,57.641c1.104,0,2,0.896,2,2v15.998c0,1.104-0.896,2-2,2s-2-0.896-2-2V59.641C47.945,58.535,48.841,57.641,49.945,57.641z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_rain climacon_component-stroke_rain- right"
										d="M57.943,53.641c1.104,0,2,0.896,2,2v15.998c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2V55.641C55.943,54.537,56.84,53.641,57.943,53.641z"/>
								</g>
								<g class="climacon_componentWrap climacon_componentWrap_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
										d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_cloud"
										fill="#FFFFFF"
										d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
								</g>
							</g>
						</svg>
						<!-- cloudRainMoonFill -->
					</div>
					<div class="align-self-center  media-body">
						<h5 class="mt-0"><span class="counter digits">25</span><sup>o</sup>C</h5>
						<span>Newyork , USA</span>
					</div>
				</div>
			</div>
			<div class="col-6 p-0">
				<div class="media pt-0">
					<div class="mr-3">
						<svg
							version="1.1"
							id="cloudDrizzleMoonFillAlt"
							class="climacon climacon_cloudDrizzleMoonFillAlt"
							viewBox="15 15 70 70">
							<g class="climacon_iconWrap climacon_iconWrap-cloudDrizzleMoonFillAlt">
								<g class="climacon_wrapperComponent climacon_wrapperComponent-moon climacon_componentWrap-moon_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
										d="M61.023,50.641c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C73.021,45.269,67.649,50.641,61.023,50.641z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_moon"
										fill="#FFFFFF"
										d="M59.235,30.851c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C63.961,39.527,60.139,35.705,59.235,30.851z"/>
								</g>
								<g class="climacon_wrapperComponent climacon_wrapperComponent-drizzle">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-left"
										id="Drizzle-Left_1_"
										d="M56.969,57.672l-2.121,2.121c-1.172,1.172-1.172,3.072,0,4.242c1.17,1.172,3.07,1.172,4.24,0c1.172-1.17,1.172-3.07,0-4.242L56.969,57.672z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-middle"
										d="M50.088,57.672l-2.119,2.121c-1.174,1.172-1.174,3.07,0,4.242c1.17,1.172,3.068,1.172,4.24,0s1.172-3.07,0-4.242L50.088,57.672z"/>
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_drizzle climacon_component-stroke_drizzle-right"
										d="M43.033,57.672l-2.121,2.121c-1.172,1.172-1.172,3.07,0,4.242s3.07,1.172,4.244,0c1.172-1.172,1.172-3.07,0-4.242L43.033,57.672z"/>
								</g>
								<g class="climacon_componentWrap climacon_componentWrap_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
										d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_cloud"
										fill="#FFFFFF"
										d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
								</g>
							</g>
						</svg>
						<!-- cloudDrizzleMoonFillAlt -->
					</div>
					<div class="align-self-center  media-body">
						<h5 class="mt-0"><span class="counter digits">95</span><sup>o</sup>F</h5>
						<span>Peris , London</span>
					</div>
				</div>
			</div>
			<div class="col-6 p-0">
				<div class="media">
					<div class="mr-3">
						<svg
							version="1.1"
							id="cloudHailAltMoonFill"
							class="climacon climacon_cloudHailAltMoonFill"
							viewBox="15 15 70 70">
							<g class="climacon_iconWrap climacon_iconWrap-cloudHailAltMoon">
								<g class="climacon_wrapperComponent climacon_wrapperComponent-moon climacon_componentWrap-moon_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_sunBody"
										d="M61.023,50.641c-6.627,0-11.999-5.372-11.999-11.998c0-6.627,5.372-11.999,11.999-11.999c0.755,0,1.491,0.078,2.207,0.212c-0.132,0.576-0.208,1.173-0.208,1.788c0,4.418,3.582,7.999,8,7.999c0.614,0,1.212-0.076,1.788-0.208c0.133,0.717,0.211,1.452,0.211,2.208C73.021,45.269,67.649,50.641,61.023,50.641z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_moon"
										fill="#FFFFFF"
										d="M59.235,30.851c-3.556,0.813-6.211,3.989-6.211,7.792c0,4.417,3.581,7.999,7.999,7.999c3.802,0,6.979-2.655,7.791-6.211C63.961,39.527,60.139,35.705,59.235,30.851z"/>
								</g>
								<g class="climacon_wrapperComponent climacon_wrapperComponent-hailAlt">
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
										<circle cx="42" cy="65.498" r="2"/>
									</g>
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
										<circle cx="49.999" cy="65.498" r="2"/>
									</g>
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
										<circle cx="57.998" cy="65.498" r="2"/>
									</g>
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-left">
										<circle cx="42" cy="65.498" r="2"/>
									</g>
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-middle">
										<circle cx="49.999" cy="65.498" r="2"/>
									</g>
									<g class="climacon_component climacon_component-stroke climacon_component-stroke_hailAlt climacon_component-stroke_hailAlt-right">
										<circle cx="57.998" cy="65.498" r="2"/>
									</g>
								</g>
								<g class="climacon_componentWrap climacon_componentWrap_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
										d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_cloud"
										fill="#FFFFFF"
										d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
								</g>
							</g>
						</svg>
						<!-- cloudHailAltMoonFill -->
					</div>
					<div class="media-body align-self-center">
						<h5 class="mt-0"><span class="counter digits">50</span><sup>o</sup>C</h5>
						<span>Surat , India</span>
					</div>
				</div>
			</div>
			<div class="col-6 p-0">
				<div class="media">
					<div class="mr-3">
						<svg
							version="1.1"
							id="cloudSnowAltFill"
							class="climacon climacon_cloudSnowAltFill"
							viewBox="15 15 70 70">
							<g class="climacon_iconWrap climacon_iconWrap-cloudSnowAltFill">
								<g class="climacon_wrapperComponent climacon_wrapperComponent-snowAlt">
									<g class="climacon_component climacon_component climacon_component-snowAlt">
										<path
											class="climacon_component climacon_component-stroke climacon_component-stroke_snowAlt"
											d="M43.072,59.641c0.553-0.957,1.775-1.283,2.732-0.731L48,60.176v-2.535c0-1.104,0.896-2,2-2c1.104,0,2,0.896,2,2v2.535l2.195-1.268c0.957-0.551,2.18-0.225,2.73,0.732c0.553,0.957,0.225,2.18-0.73,2.731l-2.196,1.269l2.196,1.268c0.955,0.553,1.283,1.775,0.73,2.732c-0.552,0.954-1.773,1.282-2.73,0.729L52,67.104v2.535c0,1.105-0.896,2-2,2c-1.104,0-2-0.895-2-2v-2.535l-2.195,1.269c-0.957,0.553-2.18,0.226-2.732-0.729c-0.552-0.957-0.225-2.181,0.732-2.732L46,63.641l-2.195-1.268C42.848,61.82,42.521,60.598,43.072,59.641z"/>
										<circle
											class="climacon_component climacon_component-fill climacon_component-fill_snowAlt"
											fill="#FFFFFF"
											cx="50"
											cy="63.641"
											r="2"/>
									</g>
								</g>
								<g class="climacon_componentWrap climacon_componentWrap_cloud">
									<path
										class="climacon_component climacon_component-stroke climacon_component-stroke_cloud"
										d="M43.945,65.639c-8.835,0-15.998-7.162-15.998-15.998c0-8.836,7.163-15.998,15.998-15.998c6.004,0,11.229,3.312,13.965,8.203c0.664-0.113,1.338-0.205,2.033-0.205c6.627,0,11.998,5.373,11.998,12c0,6.625-5.371,11.998-11.998,11.998C57.168,65.639,47.143,65.639,43.945,65.639z"/>
									<path
										class="climacon_component climacon_component-fill climacon_component-fill_cloud"
										fill="#FFFFFF"
										d="M59.943,61.639c4.418,0,8-3.582,8-7.998c0-4.417-3.582-8-8-8c-1.601,0-3.082,0.481-4.334,1.291c-1.23-5.316-5.973-9.29-11.665-9.29c-6.626,0-11.998,5.372-11.998,11.999c0,6.626,5.372,11.998,11.998,11.998C47.562,61.639,56.924,61.639,59.943,61.639z"/>
								</g>
							</g>
						</svg>
						<!-- cloudSnowAltFill -->
					</div>
					<div class="align-self-center  media-body">
						<h5 class="mt-0"><span class="counter digits">35</span><sup>o</sup>F</h5>
						<span>Lahor , Pakistan</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-xl-3 col-sm-6 xl-50">
<div class="card bg-primary">
<div class="card-body">
	<div class="row social-media-counter">
		<div class="col text-center">
			<i class="icofont icofont-social-facebook"></i>
		</div>
		<div class="col text-center">
			<h4 class="counter">256</h4>
			<p>Friend</p>
		</div>
		<div class="col text-center">
			<h4 class="counter">364</h4>
			<p>Post</p>
		</div>
	</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 xl-50">
<div class="card bg-secondary">
<div class="card-body">
	<div class="row social-media-counter">
		<div class="col text-center">
			<i class="icofont icofont-social-twitter"></i>
		</div>
		<div class="col text-center">
			<h4 class="counter">698</h4>
			<p>Friend</p>
		</div>
		<div class="col text-center">
			<h4 class="counter">7018</h4>
			<p>Post</p>
		</div>
	</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 xl-50">
<div class="card bg-success">
<div class="card-body">
	<div class="row social-media-counter">
		<div class="col text-center">
			<i class="icofont icofont-brand-linkedin"></i>
		</div>
		<div class="col text-center">
			<h4 class="counter">156</h4>
			<p>Friend</p>
		</div>
		<div class="col text-center">
			<h4 class="counter">985</h4>
			<p>Post</p>
		</div>
	</div>
</div>
</div>
</div>
<div class="col-xl-3 col-sm-6 xl-50">
<div class="card bg-info">
<div class="card-body">
	<div class="row social-media-counter">
		<div class="col text-center">
			<i class="icofont icofont-social-instagram"></i>
		</div>
		<div class="col text-center">
			<h4 class="counter">1489</h4>
			<p>Friend</p>
		</div>
		<div class="col text-center">
			<h4 class="counter">9875</h4>
			<p>Post</p>
		</div>
	</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-12">
<div class="">
<div class="card height-equal" >
	<div class="card-header">
		<h5 class="text-uppercase">Recent Activity</h5>
		<div class="card-header-right">
			<ul class="list-unstyled card-option">
				<li><i class="icofont icofont-simple-left "></i></li>
				<li><i class="view-html fa fa-code"></i></li>
				<li><i class="icofont icofont-maximize full-card"></i></li>
				<li><i class="icofont icofont-minus minimize-card"></i></li>
				<li><i class="icofont icofont-refresh reload-card"></i></li>
				<li><i class="icofont icofont-error close-card"></i></li>
			</ul>
		</div>
	</div>
	<div class="card-body">
		<ul class="crm-activity equal-height-xl">
			<li class="media">
				<span class="mr-3 font-primary">E</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">Established fact that a reader will be distracted</h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
			<li class="media">
				<span class="mr-3 font-secondary">A</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">Any desktop publishing packages and web page editors.</h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
			<li class="media">
				<span class="mr-3 font-success">T</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">There isn't anything embarrassing hidden.</h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
			<li class="media">
				<span class="mr-3 font-info">C</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">Contrary to popular belief, Lorem Ipsum is not simply. </h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
			<li class="media">
				<span class="mr-3 font-warning">H</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">H-Code - A premium portfolio template from ThemeZaa </h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
			<li class="media">
				<span class="mr-3 font-danger">T</span>
				<div class="align-self-center media-body">
					<h6 class="mt-0">There isn't anything embarrassing hidden.</h6>
					<ul class="dates">
						<li class="digits">25 July 2017</li>
						<li class="digits">20 hours ago</li>
					</ul>
				</div>
			</li>
		</ul>
		<div class="code-box-copy">
			<button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head3" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
		</div>
	</div>
</div>
</div>
</div>
<div class="col-md-6 col-sm-12">
<div class="card height-equal">
<div class="card-header">
<h5>Product Cart</h5>
<div class="card-header-right">
<ul class="list-unstyled card-option">
	<li><i class="icofont icofont-simple-left "></i></li>
	<li><i class="view-html fa fa-code"></i></li>
	<li><i class="icofont icofont-maximize full-card"></i></li>
	<li><i class="icofont icofont-minus minimize-card"></i></li>
	<li><i class="icofont icofont-refresh reload-card"></i></li>
	<li><i class="icofont icofont-error close-card"></i></li>
</ul>
</div>
</div>
<div class="card-body">
<div class="user-status table-responsive product-chart">
<table class="table table-bordernone">
<thead>
<tr>
	<th scope="col">Details</th>
	<th scope="col">Quantity</th>
	<th scope="col">Status</th>
	<th scope="col">Price</th>
</tr>
</thead>
<tbody>
<tr>
	<td>Simply dummy text of the</td>
	<td class="digits">1</td>
	<td class="font-secondary">Pending</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Long established</td>
	<td class="digits">5</td>
	<td class="font-danger">Cancle</td>
	<td class="digits">$65236523</td>
</tr>
<tr>
	<td>Sometimes by accident</td>
	<td class="digits">10</td>
	<td class="font-danger">Cancle</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Classical Latin literature</td>
	<td class="digits">9</td>
	<td class="font-info">Return</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>keep the site on the Internet</td>
	<td class="digits">8</td>
	<td class="font-secondary">Pending</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Molestiae consequatur</td>
	<td class="digits">3</td>
	<td class="font-danger">Cancle</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td class="pb-1">Sometimes by accident</td>
	<td class="digits">8</td>
	<td class="font-info">Return</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>keep the site on the Internet</td>
	<td class="digits">8</td>
	<td class="font-secondary">Pending</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Sometimes by accident</td>
	<td class="digits">10</td>
	<td class="font-danger">Cancle</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Long established</td>
	<td class="digits">1</td>
	<td class="font-secondary">Pending</td>
	<td class="digits">$6523</td>
</tr>
<tr>
	<td>Simply dummy text of the</td>
	<td class="digits">8</td>
	<td class="font-secondary">Pending</td>
	<td class="digits">$6523</td>
</tr>
</tbody>
</table>
</div>
<div class="code-box-copy">
<button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#example-head4" title="Copy"><i class="icofont icofont-copy-alt"></i></button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- prism js -->
<script src="/assets/js/prism/prism.min.js"></script>
<!-- clipboard js -->
<script src="/assets/js/clipboard/clipboard.min.js" ></script>
<!-- custom card js  -->
<script src="/assets/js/custom-card/custom-card.js" ></script>
<!--Sparkline  Chart JS-->
<script src="/assets/js/sparkline/sparkline.js"></script>
<!-- Chartist  -->
<script src="/assets/js/chartis/chartist.js"></script>
<!-- Theme js-->
<script src="/assets/js/dashboard-crm.js" ></script>
<script src="/assets/js/script.js" ></script>
<script src="/assets/js/theme-customizer/customizer.js"></script>
<script src="/assets/js/chat-sidebar/chat.js"></script>
<!--Height Equal Js-->
<script src="/assets/js/height-equal.js"></script>
<!-- Counter js-->
<script src="/assets/js/counter/jquery.waypoints.min.js"></script>
<script src="/assets/js/counter/jquery.counterup.min.js"></script>
<script src="/assets/js/counter/counter-custom.js"></script>
</body>
</html>
