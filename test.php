<html class="ng-app">
    <head>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/angular.js/1.1.1/angular.min.js"></script>
        <style src="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"></style>
        <style src="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css"></style>
        <script type="text/javascript">
            function HomeCtrl($scope) {
                $scope.test = "aaa"
            }
        </script>
        <style>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700);
@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css);
body {
  background: #111115;
  font-family: "Open Sans", sans-serif;
  -webkit-perspective: 600px;
  -moz-perspective: 600px;
  perspective: 600px;
}

.toggle_menu {
  background: rgba(255, 255, 255, 0.2);
  z-index: 99999;
  position: absolute;
  top: 50px;
  right: 50px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  cursor: pointer;
}

.toggle_menu:active {
  background: rgba(255, 255, 255, 0.3);
  -webkit-transition: all .25s ease-in-out;
  -moz-transition: all .25s ease-in-out;
  transition: all .25s ease-in-out;
}

.toggle_menu i {
  width: 50px;
  height: 50px;
  line-height: 50px;
  text-align: center;
  color: #fff;
  font-size: 22px;
}

.main {
  position: relative;
  z-index: 1;
  width: 100vw;
  height: 100vh;
  -webkit-transition: all .5s ease-in-out;
  -moz-transition: all .5s ease-in-out;
  transition: all .5s ease-in-out;
}

.main.has_menu_open {
  -webkit-transform: rotateX(-4deg) translate3D(0px, 0px, -100px) scale(.9);
  -moz-transform: rotateX(-4deg) translate3D(0px, 0px, -100px) scale(.9);
  -ms-transform: rotateX(-4deg) translate3D(0px, 0px, -100px) scale(.9);
  -o-transform: rotateX(-4deg) translate3D(0px, 0px, -100px) scale(.9);
  transform: rotateX(-4deg) translate3D(0px, 0px, -100px) scale(.9);
}

.main .bg {
  position: absolute;
  top: 0px;
  left: 0px;
  right: 0px;
  bottom: 0px;
  z-index: 2;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  width: 100vw;
  height: 100vh;
  opacity: 0;
  -webkit-transition: opacity .5s ease-in-out;
  -moz-transition: opacity .5s ease-in-out;
  transition: opacity .5s ease-in-out;
}

.main .bg.visible {
  opacity: 1;
}

.main .bg.bg1 {
  //background-image: url(http://www.planwallpaper.com/static/images/HD-Wallpapers1.jpeg);
  background-color: blue; 
}

.main .bg.bg2 {
  background-image: url(http://intrawallpaper.com/wp-content/uploads/space_desktop_wallpaper1.jpg);
}

.main .bg.bg3 {
  background-image: url(https://newevolutiondesigns.com/images/freebies/summer-wallpaper-9.jpg);
}

.main .bg.bg4 {
  background-image: url(https://newevolutiondesigns.com/images/freebies/hd-widescreen-wallpaper-10.jpg);
}

.menu {
  position: fixed;
  z-index: 99;
  background: #292931;
  bottom: 0px;
  left: 10%;
  right: 10%;
  width: 80%;
  height: 110px;
  -webkit-transform: translate3D(0px, 150px, 0px) rotateX(45deg) scale(0.9);
  -moz-transform: translate3D(0px, 150px, 0px) rotateX(45deg) scale(0.9);
  -ms-transform: translate3D(0px, 150px, 0px) rotateX(45deg) scale(0.9);
  -o-transform: translate3D(0px, 150px, 0px) rotateX(45deg) scale(0.9);
  transform: translate3D(0px, 150px, 0px) rotateX(45deg) scale(0.9);
  -webkit-transition: all .75s ease-in-out;
  -moz-transition: all .75s ease-in-out;
  transition: all .75s ease-in-out;
}

.menu.is_open {
  -webkit-transform: translate3D(0px, 0px, 0px) rotateX(2deg) scale(1);
  -moz-transform: translate3D(0px, 0px, 0px) rotateX(2deg) scale(1);
  -ms-transform: translate3D(0px, 0px, 0px) rotateX(2deg) scale(1);
  -o-transform: translate3D(0px, 0px, 0px) rotateX(2deg) scale(1);
  transform: translate3D(0px, 0px, 0px) rotateX(2deg) scale(1);
}

.menu ul {
  position: relative;
  margin: 0px;
  padding: 20px;
  height: 70px;
  width: 100%;
  box-sizing: border-box;
  display: -webkit-box;
  display: -moz-box;
  display: box;
  display: -webkit-flex;
  display: -moz-flex;
  display: -ms-flexbox;
  display: flex;
}

.menu ul li {
  margin: 10px;
  list-style: none;
  height: 50px;
  line-height: 50px;
  text-align: center;
  color: #eee;
  font-size: 20px;
  font-weight: 300;
  background: rgba(238, 238, 238, 0.075);
  cursor: pointer;
  -webkit-transition: all .25s ease-in-out;
  -moz-transition: all .25s ease-in-out;
  transition: all .25s ease-in-out;
  -webkit-font-smoothing: antialiased;
  -webkit-box-flex: 1;
  -moz-box-flex: 1;
  box-flex: 1;
  -webkit-flex: 1;
  -moz-flex: 1;
  -ms-flex: 1;
  flex: 1;
}

.menu ul li.active {
  color: palegoldenrod;
}

.menu ul li:hover {
  background: rgba(238, 238, 238, 0.15);
  -webkit-transform: translate3D(0px, 0px, 0px) scale(1.05);
  -moz-transform: translate3D(0px, 0px, 0px) scale(1.05);
  -ms-transform: translate3D(0px, 0px, 0px) scale(1.05);
  -o-transform: translate3D(0px, 0px, 0px) scale(1.05);
  transform: translate3D(0px, 0px, 0px) scale(1.05);
}

.copy {
  position: fixed;
  width: 100%;
  height: 30px;
  line-height: 30px;
  top: 20px;
  left: 0px;
  right: 0px;
  z-index: 999;
  text-align: center;
  font-size: 16px;
  color: #fff;
  -webkit-transform: translate3D(0px, -70px, 0px);
  -moz-transform: translate3D(0px, -70px, 0px);
  -ms-transform: translate3D(0px, -70px, 0px);
  -o-transform: translate3D(0px, -70px, 0px);
  transform: translate3D(0px, -70px, 0px);
  -webkit-transition: all .75s ease-in-out;
  -moz-transition: all .75s ease-in-out;
  transition: all .75s ease-in-out;
}

.copy a,
.copy a:visited,
.copy a:active {
  margin-left: 10px;
  color: gold;
}

.copy.is_visible {
  -webkit-transform: translate3D(0px, 0px, 0px);
  -moz-transform: translate3D(0px, 0px, 0px);
  -ms-transform: translate3D(0px, 0px, 0px);
  -o-transform: translate3D(0px, 0px, 0px);
  transform: translate3D(0px, 0px, 0px);
}
        </style>

    </head>
    <body>

        <div ng-controller="HomeCtrl">
            <div ng-click="menu_open = !menu_open" ng-init="menu_open = false" class="toggle_menu"><i class="fa fa-bars"></i></div>
            <div ng-class="{'has_menu_open': menu_open == true}" ng-init="menu_index = 1" class="main">
                <div ng-class="{'visible': menu_index == 1}" class="bg bg1">1<div><?php include "mypoints.php"; ?></div></div>
                <div ng-class="{'visible': menu_index == 2}" class="bg bg2"><?php include "calendar.php"; ?></div>
                <div ng-class="{'visible': menu_index == 3}" class="bg bg3">3</div>
                <div ng-class="{'visible': menu_index == 4}" class="bg bg4">4</div>
            </div>
            <div ng-class="{'is_open': menu_open == true}" class="menu">
                <ul>
                    <li ng-click="menu_index = 1;
                                menu_open = false;" ng-class="{'active': menu_index == 1}">MyPoints</li>
                    <li ng-click="menu_index = 2;
                                menu_open = false;" ng-class="{'active': menu_index == 2}">Calendar</li>
                    <li ng-click="menu_index = 3;
                                menu_open = false;" ng-class="{'active': menu_index == 3}">Projects</li>
                    <li ng-click="menu_index = 4;
                                menu_open = false;" ng-class="{'active': menu_index == 4}">Contacts</li>
                </ul>
            </div>
            <div ng-class="{'is_visible': menu_open == true}" class="copy">A Pen by Andrea Macchieraldo<a href="http://facebook.com/andrea.macchieraldo" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="https://github.com/macchie/" target="_blank"><i class="fa fa-github-square"></i></a></div>
        </div>
    </body>
</html>