(function(){


	'use strict';

	angular.module('admin.products', [
		'ngRoute',
		'ui.bootstrap'
	])
	.config(['$routeProvider', function($routeProvider){
		$routeProvider
			.when('/products', {
			    templateUrl: 'templates/products.html',
	    		controller: 'productsCtrl'
	  		});
		}
	])
	.controller('productsCtrl', ['$scope', 'productSearchService', function($scope, productSearchService){
		changeMenuActive('products');

		$scope.productsFound = [];
		$scope.currentPage = 1;
		$scope.totalItems = 0;

		$scope.searchProducts = function(data){
			data = filterFormData(data);
			$scope.$parent.loading = true;
			var page = $scope.currentPage;
			productSearchService.search(data, page).then(function(response){
				$scope.totalItems = response.data.totalItems;
				angular.copy(response.data.products, $scope.productsFound);
				$(document.querySelector('#products-found')).show();
				$scope.$parent.loading = false;
			}, function(){
				$scope.$parent.notification.show('danger', 'Ocorreu um erro ao pesquisar os produtos.');
				$scope.$parent.loading = false;
			});
		}


	}])

	.service('productSearchService', ['$http', function($http){

		return {
			search: function(objSearch, page){
				var strData = '';
				for(var i in objSearch){
					strData += '&' + i + '=' + encodeURIComponent(objSearch[i])
				}
				return $http.get('GenericExecute.php?class=Product&action=Search&page=' + page + strData);
			}
		}

	}])


})();