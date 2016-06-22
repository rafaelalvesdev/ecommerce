(function(){

	'use strict';

	angular.module('admin', [
		'ngRoute',
		'admin.dashboard',
		'admin.products',
		'admin.products.edit'
	])
	.config(['$locationProvider', '$routeProvider', function config($locationProvider, $routeProvider) {
			$locationProvider.hashPrefix('!');

			$routeProvider.otherwise({redirectTo: '/dashboard'});
		}
	])
	.run(function($rootScope, $location){
		
		

	})
	.controller('adminCtrl', ['$scope','$timeout', function($scope, $timeout){
		
		$scope.notification = {
			"status":"hide",
			show: function(type, message){
				$scope.notification.type = type;
				$scope.notification.message = message;
				$scope.notification.realShow = true;
				$timeout(function(){
					$scope.notification.status = 'show';
				}, 50);
				$timeout(function(){
					$scope.notification.status = 'hide';
					$timeout(function(){
						$scope.notification.realShow = false;
					}, 1000);
				}, 8000);
			}
		};
		

	}])
	.directive('loading', function () {
		return {
			restrict: 'E',
			replace: true,
			template: '<div class="loading"><div><img src="images/loading.gif" width="28" height="28" /></div></div>',
			link: function ($scope, element, attr) {
				$scope.$watch('loading', function (val) {
					if (val)
						$(element).show();
					else
						$(element).hide();
				});
			}
		}
	})
	.directive('notification', ['$timeout', function ($timeout) {
		return {
            restrict: 'E',
            template:"<div class='alert alert-{{alertData.type}} alert-{{alertData.status}}' ng-show='alertData.realShow' role='alert'>{{alertData.message}}</div>",
            scope:{
              alertData:"="
            }
        };
    }]);  

})();