<?php session_start(); ?>
<?php if(!(isset($_SESSION['user_loggedin']))) {
    require 'user_login.php';
};
?>

<!DOCTYPE html>
<html ng-app="ajax">
<head>
    <title></title>

    <script src="angular/angular.js"></script>
    <script src="angular/angular-route.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/site.css">

    <script>
        angular.module("ajax", [
                'ngRoute'
            ])
            .config(function($routeProvider) {
                $routeProvider.when("/", {
                    templateUrl: "views/listing.html"
                });
                $routeProvider.when("/addNew", {
                    templateUrl: "views/addNew.html"
                })
            })
            .config(function ($httpProvider) {
                $httpProvider.defaults.headers.post['Content-Type'] = ''
                    + 'application/x-www-form-urlencoded; charset=UTF-8';
            })
            .controller("listCtrl", function($scope, $http) {
                var init = function() {
                    $http({
                        url: "data.php",
                        method: "GET"
                    })
                        .success(function(response) {
                            $scope.lists = response;
                        })
                        .error(function(error) {
                            $scope.status = error || "Request Failed";
                        });
                };
                init();

                $scope.add = {};

                $scope.addItem = function(item) {

                    if(!($scope.add.items)) {
                        $scope.add.items = [];
                    }

                    $scope.add.items.push(item);
                    $scope.itemToAdd = null;
                    var input = document.getElementById('addInput');
                    input.focus();
                };

                $scope.save = function() {
                    var add = $scope.add;
                    var url = 'http://localhost:8888/grocery_list/view_new.php';

                    $http({
                        url: url,
                        method: "POST",
                        data: add
                    })
                        .success(function(data) {
                            console.log(data);
                        });
                };
            })
    </script>

</head>
<body ng-controller="listCtrl">
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p class="text-right">
                    <a class="btn btn-primary btn-sm pull-right">Logout</a>
                </p>
                <h2 class="text-muted">
                    <?php echo $_SESSION['username']; ?>'s Grocery Lists
                </h2>
            </div>
        </div>
    </div>
</div>

<ng-view></ng-view>

</body>
</html>