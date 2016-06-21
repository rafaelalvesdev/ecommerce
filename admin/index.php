<!DOCTYPE html>
<html ng-app="admin">
	<head>
		<title>PaperCommerce ADMIN</title>
		<script type="text/javascript" src="assets.php?type=js"></script>
		<link rel="stylesheet" type="text/css" href="assets.php?type=css">
	</head>
	<body>		
		<div id="root">
			<?php require_once 'menu.php' ?>
			<div id="content" ng-view>
			</div>
		</div>
	</body>
</html>