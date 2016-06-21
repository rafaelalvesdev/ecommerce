(function(){


	'use strict';

	angular.module('admin.products', [
		'ngRoute'
	])
	.config(['$routeProvider', function($routeProvider){
		$routeProvider
			.when('/products', {
			    templateUrl: 'templates/products.html',
	    		controller: 'productsCtrl'
	  		});
		}
	])
	.controller('productsCtrl', ['$scope', 'productServices', function($scope, productServices){
		
		$scope.title = 'Produtos';
		$scope.smallTitle = 'Gerenciar';
		changeMenuActive('products');


		$scope.searchProducts = function(data){
			var objData = {};
			for (var i in data){
				if(i.substr(0, 1) != '$'){
					objData[i] = data[i];
				}
			}

			productServices.search(objData).then(function(response){
				$scope.productsFound = response.data;
			});
		}


	}])

	.service('productServices', ['$http', function($http){

		return {
			search: function(objSearch){
				return $http.post('GenericExecute.php?class=Product&action=Search', objSearch);
			}
		}

	}])


})();