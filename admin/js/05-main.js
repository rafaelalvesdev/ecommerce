(function(){

	'use strict';

	angular.module('admin', [
		'ngRoute',
		'admin.dashboard',
		'admin.products'
	])
	.config(['$locationProvider', '$routeProvider', function config($locationProvider, $routeProvider) {
			$locationProvider.hashPrefix('!');

			$routeProvider.otherwise({redirectTo: '/dashboard'});
		}
	])
	.run(function($rootScope, $location){
		
		

	});

})();