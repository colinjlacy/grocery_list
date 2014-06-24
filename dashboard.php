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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <script>
        angular.module("ajax", [
                'ngRoute'
            ])
            .value("userId", <?php echo $_SESSION['user_loggedin']; ?>)
            .config(function($routeProvider) {
                $routeProvider.when("/", {
                    templateUrl: "views/listing.html"
                });
                $routeProvider.when("/add-new", {
                    templateUrl: "views/addNew.html"
                });

            })
            .controller("listCtrl", function($scope, $http, $location, userId) {
                var init = function() {
                    $http({
                        url: "retrieveLists.php",
                        method: "GET"
                    })
                        .success(function(response) {
                            $scope.lists = response;

                            var breakString = "&?colin!?&";

                            for (var i = 0; i < $scope.lists.length; i++) {
                                $scope.lists[i].items = $scope.lists[i].content.split(breakString);
                                $scope.lists[i].snippet = $scope.lists[i].items.slice(0,3).join(", ") + "...";
                            }



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
                    $scope.add.itemToAdd = "";
                    var input = document.getElementById('addInput');
                    input.focus();
                };

                $scope.save = function() {
                    $scope.add.userId = userId;
                    var add = $scope.add;
                    var url = 'http://localhost:8888/grocery_list/processNewList.php';

                    $http({
                        url: url,
                        method: "POST",
                        data: add
                    })
                        .success(function(data) {
                            console.log(data);
                            if(!isNaN(data)) {
                                $scope.add.error = null;
                                add.id = data;
                                add.snippet = add.items.slice(0,3).join(", ") + "...";
                                $scope.lists.push(add);
                                $location.path('/');
                                $scope.add = {};
                            } else {
                                $scope.add.error = data;
                            }
                        })
                        .error(function(error) {
                            console.log(error);
                            $scope.add.error = error;
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