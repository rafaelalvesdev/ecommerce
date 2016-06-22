function changeMenuActive(menuName){
	angular.element(document.querySelector('#navbar').getElementsByTagName('li')).removeClass('active');
	angular.element(document.querySelector('#menu-' + menuName)).addClass('active');
}

function filterFormData(data){
	data = data || {};
	var objData = {};
	for (var i in data){
		if(i.substr(0, 1) != '$'){
			objData[i] = data[i];
		}
	}
	return objData;
}