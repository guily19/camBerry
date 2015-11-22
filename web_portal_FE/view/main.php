<?php
	session_start();
    include('db_access.php');
	
	if(isset($_SESSION['USER'])) {
		$user = $_SESSION['USER'];
  function logout(){
    header ("Location: logout.php");
  }
?> 

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
  <link rel="stylesheet" type="text/css" href="../css/simple-sidebar.css">
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
              <a> <?php echo "Welcome $user";?> </a>
            <button ng-class="videoMode ? 'btn btn-danger' : 'btn btn-success' " ng-click="viewControll()" ng-show="someVideoisShown">{{videoModeButtonText}}</button>
          <button type="submit" class="btn btn-danger"  onclick = "location='/logout.php'" >Log out</button>
        </form>
      </div>
    </nav>
    <div id="wrapper">
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
          <li class="sidebar-brand">
              <a href="#">
                  Start Bootstrap
              </a>
          </li>
          <li>
              <a ng-click="getOwnCameras()">Tus Cameras</a>
          </li>
          <li>
              <a ng-click="getPublicCameras()">Cameras de otros</a>
          </li>
          <li>
              <a ng-click="getAlarms()">Tus Alarmas!</a>
          </li>
          <li>
              <a ng-click="showView = 3">Preferencias</a>
          </li>
      </ul>
    </div>
    <div id="page-content-wrapper">
    <div class="main_content">
      <div ng-show="showView === -1" class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
      </div>
      <div ng-show="showView === 0 || videoMode" class="videos_wrapper">
        <div class="video_wrapper bounceInDown" ng-repeat="camera in cameras" ng-class="showVideo ? 'animated' : '' " ng-show="showVideo[$index] === true">
          <img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideo($index)">
          <img class="video" src="{{camera.video}}"></img>
          <div style="font-size: 20px; color: white;">{{camera.site}}</div>
        </div>
      </div>
      <div ng-show="showView === 0 && !videoMode" class="personal_cameras" animated>
        <h1 class="subtitle">My Cameras</h1>
        <div class="cameras_wrapper">
          <div class="camera_content" ng-click="onClickOwnCamera($index)" ng-repeat="camera in cameras">
            <img class="camera_image" ng-src={{camera.img}}>
            <h2 class="camera_site">{{camera.site}}</h2>
          </div>
        </div>
      </div>
      <div ng-show="showView === 1 || videoMode" class="videos_wrapper" ng-repeat="user in otherCameras">
        <div class="video_wrapper bounceInRight" ng-repeat="camera in user.cameras" ng-class="showVideo ? 'animated' : '' " ng-show="camera.show === true">
          <img class="close_icon" ng-src="img/icons/close.png" ng-click="closeVideoOther($parent.$index, $index)">
          <video class="video" ng-src="{{camera.video}}"></video>
          <h3 style="">{{camera.site}}</h3>
        </div>
      </div>
      <div ng-show="showView === 1 && !videoMode" class="others_cameras">
        <h1 class="subtitle">Other's Cameras</h1>
        <div  ng-repeat="user in otherCameras"> 
          <h3 class="other_cameras_user">{{user.user}}</h3>
          <div class="camera_content" ng-click="onClickOtherCamera($parent.$index,$index)" ng-repeat="camera in user.cameras">
            <img class="camera_image" ng-src={{camera.img}}>
            <h2 class="camera_site">{{camera.site}}</h2>
          </div>
        </div>
      </div>
      <div ng-show="showView === 2 && !videoMode" class="personal_cameras">
        <h1 class="subtitle">Alarms!</h1>
        <div  ng-repeat="alarm in alarms"> 
          <div class="camera_content">
            <img class="camera_image" ng-src={{camera.img}}>
            <h2 class="camera_site">{{alarm}}</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="footer"></div>
</body>
</html>
 <?php
        }else {
    ?>
            <a href="register.php">Registrarse</a> | <a href="index.php">Ingresar</a>
    <?php
        }
    ?> 