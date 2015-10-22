(function(){
	var myApp = angular.module('myApp',[]);

	myApp.controller('RegistrationCtrl', ['$scope', function($scope) {
		
	}]);

	myApp.controller('MainCtrl', ['$scope', function($scope) {
		$scope.showVideo = false;
		$scope.urlVideo = undefined;


		$scope.cameras = [{
			img: "../img/comedor.jpeg",
			site: "Comedor",
			video: "../img/movie.mp4"
		},
		{
			img: "../img/entrada.jpeg",
			site: "Entrada",
			video: "../img/movi.mp4"
		},{
			img: "../img/lavabo.jpeg",
			site: "Lavabo",
			video: "../img/movi.mp4"
		},{
			img: "../img/lavabo.jpeg",
			site: "Lavabo",
			video: "../img/movi.mp4"
		}];

		$scope.otherCameras = [{
			user: "Alberto Preemo",
			cameras: [{
				img: "../img/comedor.jpeg",
				site: "Comedor"
			},{
				img: "../img/comedor.jpeg",
				site: "Comedor"
			}]

		},{
			user: "Sergi Alonso",
			cameras: [{
				img: "../img/comedor.jpeg",
				site: "Comedor"
			}]
		}];

		$scope.onClickOwnCamera = function (index){
			if(index !== -1){
				var selectedCamera = $scope.cameras[index];
				$scope.urlVideo = selectedCamera.video;
				$scope.showVideo = true;
			}
		}

		$scope.onClickOtherCamera = function (index){
			if(index !== -1){
				var selectedCamera = $scope.otherCameras[index];
				$scope.urlVideo = selectedCamera.video;
				$scope.showVideo = true;
			}
		}

		$scope.closeVideo = function (){
			$scope.showVideo = false;
		}
	}]);

	myApp.directive('myDraggable', ['$document', function($document) {
	  	return {
	    	link: function(scope, element, attr) {
	    	var startX = 0, startY = 0, x = 200, y = 200;

      		element.css({
				position: 'absolute',
				border: '1px solid black',
				"border-radius" : '5px 5px 5px 5px',
				backgroundColor: 'white',
				cursor: 'pointer'
			});

			element.on('mousedown', function(event) {
				// Prevent default dragging of selected content
				event.preventDefault();
				startX = event.pageX - x;
				startY = event.pageY - y;
				$document.on('mousemove', mousemove);
				$document.on('mouseup', mouseup);
			});

			function mousemove(event) {
				y = event.pageY - startY;
				x = event.pageX - startX;
				element.css({
				  top: y + 'px',
				  left:  x + 'px'
				});
			}

			function mouseup() {
				$document.off('mousemove', mousemove);
				$document.off('mouseup', mouseup);
			}
		}
	};


	myApp.directive('resizer', function($document) {

    return function($scope, $element, $attrs) {

        $element.on('mousedown', function(event) {
            event.preventDefault();

            $document.on('mousemove', mousemove);
            $document.on('mouseup', mouseup);
        });

        function mousemove(event) {

            if ($attrs.resizer == 'vertical') {
                // Handle vertical resizer
                var x = event.pageX;

                if ($attrs.resizerMax && x > $attrs.resizerMax) {
                    x = parseInt($attrs.resizerMax);
                }

                $element.css({
                    left: x + 'px'
                });

                $($attrs.resizerLeft).css({
                    width: x + 'px'
                });
                $($attrs.resizerRight).css({
                    left: (x + parseInt($attrs.resizerWidth)) + 'px'
                });

            } else {
                // Handle horizontal resizer
                var y = window.innerHeight - event.pageY;

                $element.css({
                    bottom: y + 'px'
                });

                $($attrs.resizerTop).css({
                    bottom: (y + parseInt($attrs.resizerHeight)) + 'px'
                });
                $($attrs.resizerBottom).css({
                    height: y + 'px'
                });
            }
        }

        function mouseup() {
            $document.unbind('mousemove', mousemove);
            $document.unbind('mouseup', mouseup);
        }
    };
});

}]);

})();
