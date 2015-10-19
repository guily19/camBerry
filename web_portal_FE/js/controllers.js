(function(){
	var myApp = angular.module('myApp',[]);

	myApp.controller('RegistrationCtrl', ['$scope', function($scope) {
		
	}]);

	myApp.controller('MainCtrl', ['$scope', function($scope) {
		$scope.cameras = [{
			img: "../img/comedor.jpeg",
			site: "Comedor"
		},
		{
			img: "../img/entrada.jpeg",
			site: "Entrada"
		}];

		$scope.otherCameras = [{
			img: "../img/comedor.jpeg",
			site: "Comedor",
			user: "Alberto Preemo"
		}]
	}]);

})();
