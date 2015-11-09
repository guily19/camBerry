

<!DOCTYPE html>
<html>
<head>
	<title> Main Portal</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/animate.css">

	<script src="js/angular.min.js"></script>
	<script src="js/controllers.js"></script>

	<!-- Remove in server -->
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/animate.css">
	 
	 <script src="../js/angular.min.js"></script> 
	 <script src="../js/controllers.js"></script>

</head>
<body ng-app="myApp" ng-controller="MainCtrl">
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">CamBerry</a>
        </div>
        <form class="navbar-form navbar-right">
        	<button ng-class="videoMode ? 'btn btn-danger' : 'btn btn-success' " ng-click="viewControll()" ng-show="someVideoisShown">{{videoModeButtonText}}</button>
        	<button type="submit" class="btn btn-success">Log out</button>
        </form>
      </div>
    </nav>
	<div class="main_content">
		<div class="videos_wrapper">
			<div class="video_wrapper bounceInDown" ng-repeat="camera in cameras" ng-class="showVideo ? 'animated' : '' " ng-show="showVideo[$index] === true">
				<img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideo($index)">
				<img class="video" src="{{camera.video}}"></img>
				<div style="font-size: 20px; color: white;">{{camera.site}}</div>
			</div>
		</div>
		<div class="personal_cameras" ng-show="!videoMode" animated>
			<h1 class="subtitle">My Cameras</h1>
			<div class="cameras_wrapper">
				<div class="camera_content" ng-click="onClickOwnCamera($index)" ng-repeat="camera in cameras">
					<img class="camera_image" ng-src={{camera.img}}>
					<h2 class="camera_site">{{camera.site}}</h2>
				</div>
			</div>
		</div>
		<div class="videos_wrapper" ng-repeat="user in otherCameras">
			<div class="video_wrapper bounceInRight" ng-repeat="camera in user.cameras" ng-class="showVideo ? 'animated' : '' " ng-show="camera.show === true">
				<img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideoOther($parent.$index, $index)">
				<video class="video" ng-src="{{camera.video}}"></video>
				<h3 style="">{{camera.site}}</h3>
			</div>
		</div>
		<div class="others_cameras" ng-show="!videoMode" >
			<h1 class="subtitle">Other's Cameras</h1>
			<div  ng-repeat="user in otherCameras"> 
				<h3 class="other_cameras_user">{{user.user}}</h3>
				<div class="camera_content" ng-click="onClickOtherCamera($parent.$index,$index)" ng-repeat="camera in user.cameras">
					<img class="camera_image" ng-src={{camera.img}}>
					<h2 class="camera_site">{{camera.site}}</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="footer"></div>
</body>
</html>
