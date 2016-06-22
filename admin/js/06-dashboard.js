(function(){

	'use strict';

	angular.module('admin.dashboard', ['ngRoute'])
	.config(['$routeProvider', function($routeProvider){
		$routeProvider
			.when('/dashboard', {
			    templateUrl: 'templates/dashboard.html',
	    		controller: 'dashboardCtrl'
	  		});
		}
	])
	.controller('dashboardCtrl', ['$scope', function($scope){
		changeMenuActive('dashboard');
		
	}]);

})();