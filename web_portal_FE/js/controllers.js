(function(){
	var myApp = angular.module('myApp',[]);

	myApp.controller('RegistrationCtrl', ['$scope', function($scope) {
		
	}]);

	myApp.controller('MainCtrl', ['$scope','$http', function($scope,$http) {
		$scope.showVideo = [false,false,false,false];
		$scope.numCameras = 0;
		$scope.numCamerasOthers = 0;
		$scope.videoMode = false;
		$scope.someVideoisShown = false;
		$scope.videoModeButtonText = "Video Mode";
		$scope.showView = -1;
		$scope.noAlarms = true;

		$scope.alarms =[];


		$scope.cameras = [{
			img: "http://pticamberry.duckdns.org:8080/?action=snapshot",
			site: "Room",
			video: "http://pticamberry.duckdns.org:8080/?action=stream"
		},
		{
			img: "img/test.jpg",
			site: "Entrada",
			video: "img/movi.mp4"
		},{
			img: "img/lavabo.jpeg",
			site: "Lavabo",
			video: "img/movi.mp4"
		},{
			img: "img/comedor.jpeg",
			site: "Comedor",
			video: "img/movi.mp4"
		}];

		$scope.otherCameras = [{
			user: "Alberto Preemo",
			cameras: [{
				img: "../img/comedor.jpeg",
				site: "Comedor",
				show: false
			},{
				img: "../img/comedor.jpeg",
				site: "Comedor",
				show: false
			}]

		},{
			user: "Sergi Alonso",
			cameras: [{
				img: "../img/comedor.jpeg",
				site: "Comedor",
				show: false
			}]
		}];

		$scope.getOwnCameras = function(){
			$scope.showView = -1;
			$http.get('cameras.php')
				.success(function(cameras){
					console.log(cameras);
					//TODO: Transformar la lista de cameras del BE a un JSON
					$scope.cameras = cameras;
					$scope.showView = 0;
				})
				.error(function(err){
					//TODO: Mosrtrar un mensage de error en el FE
					console.log("Error: ",err);
					$scope.showView = 0;
				})
		}

		$scope.getPublicCameras = function() {
			$scope.showView = -1;
			$http.get('publicCameras.php')
				.success(function(cameras){
					console.log(cameras);
					//TODO: Transformar la lista de cameras del BE a un JSON
					$scope.otherCameras = cameras;
					$scope.showView = 1;
				})
				.error(function(err){
					//TODO: show message to FE
					console.log("Error: ",err);
					$scope.showView = 1;

				})
		}

		$scope.getAlarms = function (){
			$scope.showView = -1;
			$http.post('alarms.php')
			.success(function(data){
			    if(data === "undefined" || data.length === 0){
					//si data no esta definido o su size es 0 entences no tenemos nuevas alarmas
			    	var text = "No dispones de nuevas alarmas";
			    	$scope.noAlarms = true;
			    } else {
			    	$scope.alarms = data;
			    	for(var i = 0; i < $scope.alarms.length; ++i){
			    		http.get('getAlarmImage.php$img='+$scope.alarms[i]);
			    			.success(function(img){
			    				$scope.noAlarms = false;
			    			})
			    			.error(function(err){
			    				console.log("Error :",err);
			    			})
			    	}
			    }
			    $scope.showView = 2;
			})
			.error(function (err) {
			    console.log("Error: ",err);
			    $scope.noAlarms = true;
			    $scope.showView = 2;
			})
		}

		$scope.onClickOwnCamera = function (index){
			if(index !== -1 && $scope.numCameras != 3){
				var selectedCamera = $scope.cameras[index];
				$scope.urlVideo = selectedCamera.video;
				if($scope.showVideo[index] === false){
					++$scope.numCameras;
					$scope.showVideo[index] = true;
					$scope.someVideoisShown = true;
				}
			} else if ($scope.numCameras === 3){
				//TODO: Show alert masNumCameras = 3;
			}
		}

		$scope.onClickOtherCamera = function (userIndex,cameraIndex){
			if(cameraIndex !== -1 && $scope.numCamerasOthers != 3){
				var selectedCamera = $scope.otherCameras[userIndex].cameras[cameraIndex];
				$scope.urlVideo = selectedCamera.video;
				if($scope.otherCameras[userIndex].cameras[cameraIndex].show === false){
					++$scope.numCamerasOthers;
					$scope.otherCameras[userIndex].cameras[cameraIndex].show = true;
					$scope.someVideoisShown = true;
				}
			}
		}

		$scope.closeVideo = function (index){
			$scope.showVideo[index] = false;
			--$scope.numCameras;
			if($scope.numCameras + $scope.numCamerasOthers === 0){
				$scope.someVideoisShown = false;
				$scope.videoMode = false;
			}
		}

		$scope.viewControll = function(){
			if ($scope.videoMode){
				$scope.videoMode = false;
				$scope.videoModeButtonText = "Video Mode";
			} else {
				$scope.videoMode = true;
				$scope.videoModeButtonText = "Main Mode";
			}	
		}

		$scope.closeVideoOther = function (userIndex, cameraIndex){
			$scope.otherCameras[userIndex].cameras[cameraIndex].show = false;
			--$scope.numCamerasOthers;
		}

		$scope.menuOptionClicked = function (index){

		}

		$scope.init = function(){
			$scope.getOwnCameras();
		}

		$scope.init();

	}]);

})();
