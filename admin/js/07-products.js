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
	.controller('productsCtrl', ['$scope', 'productsService', function($scope, productsService){
		changeMenuActive('products');

		$scope.productsFound = [];
		$scope.currentPage = 1;
		$scope.totalItems = 0;

		var lastData;

		$scope.searchProducts = function(data){
			data = filterFormData(data);
			lastData = data;
			$scope.$parent.loading = true;
			var page = $scope.currentPage;
			productsService.search(data, page).then(function(response){
				$scope.totalItems = response.data.totalItems;
				angular.copy(response.data.products, $scope.productsFound);
				$(document.querySelector('#products-found')).show();
				$scope.$parent.loading = false;
			}, function(){
				$scope.$parent.notification.show('danger', 'Ocorreu um erro ao pesquisar os produtos.');
				$scope.$parent.loading = false;
			});
		}


		$scope.deleteProduct = function(id){
			if(confirm('Você tem certeza que deseja remover este produto?')){
				$scope.$parent.loading = true;
				productsService.delete(id).then(function(){
					$scope.searchProducts(lastData);
					$scope.$parent.loading = false;
					$scope.$parent.notification.show('success', 'Produto removido com sucesso.');
				}, function(){
					$scope.$parent.notification.show('danger', 'Ocorreu um erro ao remover o produto.');
					$scope.$parent.loading = false;
				});
			}
		}


	}])

	.service('productsService', ['$http', function($http){

		return {
			search: function(objSearch, page){
				var strData = '';
				for(var i in objSearch){
					strData += '&' + i + '=' + encodeURIComponent(objSearch[i])
				}
				return $http.get('GenericExecute.php?class=Product&action=Search&page=' + page + strData);
			},
			delete: function(id){
				return $http.get('GenericExecute.php?class=Product&action=Delete&id=' + id);	
			}
		}

	}])


})();