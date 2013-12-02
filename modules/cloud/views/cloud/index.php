<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Ushahidi v3 Cloud Module</title>
	<meta name="description" content="Ushahidi V3 Cloud">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">

	<!-- Google Font -->
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>


	<style>


	/*Lets start with the cloud formation rather*/

	body {
		/*To hide the horizontal scroller appearing during the animation*/
		overflow-x: hidden;
		margin: 0; padding: 0;
		font-family: 'Montserrat';
	}

	#content {
		margin:1em;
		position:absolute;
		top:0;
	}

	#clouds{
		padding: 100px 0;
		background: #c9dbe9;
		background: -webkit-linear-gradient(top, #c9dbe9 0%, #fff 100%);
		background: -linear-gradient(top, #c9dbe9 0%, #fff 100%);
		background: -moz-linear-gradient(top, #c9dbe9 0%, #fff 100%);
	}

	/*Time to finalise the cloud shape*/
	.cloud {
		width: 200px; height: 60px;
		background: #fff;

		border-radius: 200px;
		-moz-border-radius: 200px;
		-webkit-border-radius: 200px;

		position: relative;
	}

	.cloud:before, .cloud:after {
		content: '';
		position: absolute;
		background: #fff;
		width: 100px; height: 80px;
		position: absolute; top: -15px; left: 10px;

		border-radius: 100px;
		-moz-border-radius: 100px;
		-webkit-border-radius: 100px;

		-webkit-transform: rotate(30deg);
		transform: rotate(30deg);
		-moz-transform: rotate(30deg);
	}

	.cloud:after {
		width: 120px; height: 120px;
		top: -55px; left: auto; right: 15px;
	}

	/*Time to animate*/
	.x1 {
		-webkit-animation: moveclouds 15s linear infinite;
		-moz-animation: moveclouds 15s linear infinite;
		-o-animation: moveclouds 15s linear infinite;
	}

	/*variable speed, opacity, and position of clouds for realistic effect*/
	.x2 {
		left: 200px;

		-webkit-transform: scale(0.6);
		-moz-transform: scale(0.6);
		transform: scale(0.6);
		opacity: 0.6; /*opacity proportional to the size*/

		/*Speed will also be proportional to the size and opacity*/
		/*More the speed. Less the time in 's' = seconds*/
		-webkit-animation: moveclouds 25s linear infinite;
		-moz-animation: moveclouds 25s linear infinite;
		-o-animation: moveclouds 25s linear infinite;
	}

	.x3 {
		left: -250px; top: -200px;

		-webkit-transform: scale(0.8);
		-moz-transform: scale(0.8);
		transform: scale(0.8);
		opacity: 0.8; /*opacity proportional to the size*/

		-webkit-animation: moveclouds 20s linear infinite;
		-moz-animation: moveclouds 20s linear infinite;
		-o-animation: moveclouds 20s linear infinite;
	}

	.x4 {
		left: 470px; top: -250px;

		-webkit-transform: scale(0.75);
		-moz-transform: scale(0.75);
		transform: scale(0.75);
		opacity: 0.75; /*opacity proportional to the size*/

		-webkit-animation: moveclouds 18s linear infinite;
		-moz-animation: moveclouds 18s linear infinite;
		-o-animation: moveclouds 18s linear infinite;
	}

	.x5 {
		left: -150px; top: -150px;

		-webkit-transform: scale(0.8);
		-moz-transform: scale(0.8);
		transform: scale(0.8);
		opacity: 0.8; /*opacity proportional to the size*/

		-webkit-animation: moveclouds 20s linear infinite;
		-moz-animation: moveclouds 20s linear infinite;
		-o-animation: moveclouds 20s linear infinite;
	}

	@-webkit-keyframes moveclouds {
		0% {margin-left: 1000px;}
		100% {margin-left: -1000px;}
	}
	@-moz-keyframes moveclouds {
		0% {margin-left: 1000px;}
		100% {margin-left: -1000px;}
	}
	@-o-keyframes moveclouds {
		0% {margin-left: 1000px;}
		100% {margin-left: -1000px;}
	}
	</style>

</head>
<body>

	<div id="clouds">
		<div class="cloud x1"></div>
		<div class="cloud x2"></div>
		<div class="cloud x3"></div>
		<div class="cloud x4"></div>
		<div class="cloud x5"></div>
	</div>

	<div id="content">

		<h1>Ushahidi v3 Cloud Module</h1>
		<p>This is the cloud module.</p>

		<h2>Create Site</h2>

		<form id="create_map" method="post" action="/cloud/create/">

			<label for="domain">Subdomain</label>
			<input type="text" name="domain">
			<br/><small>https://[subdomain].somesite.com/</small>
			<br/>
			<input type="submit" value="Create Deployment" />

		</form>

		<h2>Current Sites</h2>

		<ul>
		<?php foreach ($sites as $site) { ?>
			<li><a href="//<?=$site->domain?>"><?=$site->domain?></a></li>
		<?php } ?>
		</ul>

	</div>


</body>
</html>
