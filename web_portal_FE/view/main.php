<?php
	session_start();

  if(!isset($_SESSION['USER'])) {
    header("Location: index.php");
  }
  else {
    $user = $_SESSION['USER'];
  
?> 

<!DOCTYPE html>
<html>
<head>
  <title> Main Portal</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
              <b><a href='perfil.php'> <?php echo "Welcome $user        ";?> </a></b>
            <button ng-class="videoMode ? 'btn btn-danger' : 'btn btn-success' " ng-click="viewControll()" ng-show="someVideoisShown">{{videoModeButtonText}}</button>
          <button type="submit" class="btn btn-danger"  onclick = "location='/logout.php'" >Salir</button>
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
              <a ng-click="getOwnCameras()">Mis Cámaras</a>
          </li>
          <li>
              <a ng-click="getPublicCameras()">Cámaras de otros</a>
          </li>
          <li>
              <a ng-click="getAlarms()">Mis Alarmas!</a>
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
        <h1 class="subtitle">Mis Cámaras</h1>
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
          <img class="video" ng-src="{{camera.video}}"></img>
          <h3 style="">{{camera.site}}</h3>
        </div>
      </div>
      <div ng-show="showView === 1 && !videoMode" class="others_cameras">
        <h1 class="subtitle">Cámaras de Otros</h1>
        <div  ng-repeat="user in otherCameras"> 
          <h3 class="other_cameras_user">{{user.user}}</h3>
          <div class="camera_content" ng-click="onClickOtherCamera($parent.$index,$index)" ng-repeat="camera in user.cameras">
            <img class="camera_image" ng-src={{camera.img}}>
            <h2 class="camera_site">{{camera.site}}</h2>
          </div>
        </div>
      </div>
      <div ng-show="showView === 2 && !videoMode" class="others_cameras">
        <h1 class="subtitle">Alarmas!</h1>
        <h3 class"alert_message" ng-show="noAlarms">No dispones de alarmas</h3>
        <div dstyle="display : block;">
          <h3 class="other_cameras_user">Videos:</h3>
          <div class="camera_content" ng-hide="noAlarms" ng-repeat="alarm in alarms | filter: { type : 'gif' }"> 
            <img class="camera_image alarm_image" ng-src="getAlarmImage.php?img={{alarm.url}}">
          </div>
        </div>
        <div style="display : block;">
          <h3 class="other_cameras_user">Imagenes:</h3>
          <div class="camera_content" ng-hide="noAlarms" ng-repeat="alarm in alarms | filter: { type : 'img'}"> 
            <img class="camera_image alarm_image" ng-src="getAlarmImage.php?img={{alarm.url}}">
          </div>
        </div>
      </div>
      <div ng-show="showView === 3" class="personal_cameras">
        <h1 class="subtitle">Preferencias</h1>
        <div>
          <h2>Añadir una cámara</h2>
          <form action="addCamera.php" method="post">
            <div class="form-group">
              <h4><label>URL del Vídeo:</label></h4>
              <center>
                <input type="url" name="Video" class="form-control preference_field" id="video" required>
              </center>
            </div>
            <div class="form-group">
              <h4><label>URL de la Imagen:</label></h4>
              <center>
                <input type="url" name="Image" class="form-control preference_field" id="img" required>
              </center>
            </div>
            <div class="form-group">
              <h4><label>Dónde está la cámara?</label></h4>
              <center>
                <input type="text" name="Site" class="form-control preference_field" id="site" required>
              </center>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <hr style="height:3px; border:none; color:rgb(0,0,0); background-color:rgb(0,0,0);">
          </form> 
        </div>
        <div>
          <h2>Haz tus cámaras publicas</h2>
          <form action="public.php" method="post">
            <div ng-repeat="camera in cameras">
              <div class="form-group">
                  <h4><label>{{camera.site}} </label></h4>
                  <input type="checkbox" name="cams[]" class="form-control" value = {{camera.site}} id="video" ng-checked = {{camera.check}}>
              </div>
            </div>
            <button type="submit" class="btn btn-success">Publicar</button>
            <hr style="height:3px; border:none; color:rgb(0,0,0); background-color:rgb(0,0,0);">
          </form>
        </div>
        <div>
          <h2>Elimina una cámara</h2>
            <form action="deleteCamera.php" method="post">
              <div ng-repeat="camera in cameras">
                <div class="form-group">
                  <h4><label>{{camera.site}}</label></h4>
                  <input type="checkbox" name="cams[]" class="form-control" id="video" value = {{camera.site}} >
                </div>
              </div>
               <button type="submit" class="btn btn-success">Eliminar</button>
               <hr style="height:3px; border:none; color:rgb(0,0,0); background-color:rgb(0,0,0);">
            </form>
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
  }
?>
