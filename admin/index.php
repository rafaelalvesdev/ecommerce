<!DOCTYPE html>
<html ng-app="admin" ng-controller="adminCtrl">
	<head>
		<title>PaperCommerce ADMIN</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="assets.php?type=js"></script>
		<link rel="stylesheet" type="text/css" href="assets.php?type=css">
	</head>
	<body>
		<loading></loading>
		<div id="root">
			<?php require_once 'menu.php' ?>
			<notification alert-data="notification"></notification>
			<div id="content" ng-view>
			</div>
		</div>
	</body>
</html>