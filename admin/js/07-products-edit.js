(function(){

	'use strict';

	angular.module('admin.products.edit', [
		'ngRoute'
	])
	.config(['$routeProvider', function($routeProvider){
		$routeProvider
			.when('/products/:code', {
			    templateUrl: 'templates/products-edit.html',
	    		controller: 'productsEditCtrl'
	  		});
		}
	])
	.controller('productsEditCtrl', ['$scope', '$routeParams', 'productCrud', function($scope, $routeParams, productCrud){
		changeMenuActive('products');

		var code = $routeParams.code;
		$scope.code = code;

		if(code != 'create'){
			$scope.showProductData = false;
			$scope.$parent.loading = true;
			productCrud.get(code).then(function(response){
				$scope.product = response.data;
				$scope.showProductData = true;
				$scope.$parent.loading = false;
			}, function(){
				// error callback
			});
		} else {
			$scope.showProductData = true;
		}

		$scope.saveProduct = function(product){
			product = product || {};
			$scope.$parent.loading = true;
			productCrud.save(product).then(function(response){
				window.location.hash = '#!/products/' + response.data.code;
				$scope.$parent.loading = false;
				$scope.$parent.notification.show('success', 'Produto ' + (product.code ? 'atualizado' : 'cadastrado') + ' com sucesso!');
			}, function(){
				
			});
		}


	}])

	.service('productCrud', ['$http', function($http){

		return {
			get: function(code){
				return $http.get('GenericExecute.php?class=Product&action=Read&code=' + code);
			}, 
			save: function(product){
				var method = '';
				if(!product['code']){
					method = 'create';
				} else {
					method = 'update';
				}				
				return $http.post('GenericExecute.php?class=Product&action=' + method, product);
			}
		}

	}])


})();