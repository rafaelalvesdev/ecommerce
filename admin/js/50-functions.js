function changeMenuActive(menuName){
	angular.element(document.querySelector('#navbar').getElementsByTagName('li')).removeClass('active');
	angular.element(document.querySelector('#menu-' + menuName)).addClass('active');
}