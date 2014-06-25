<?php session_start(); ?>
<?php if(!(isset($_SESSION['user_loggedin']))) {
    $action = $_GET['action'];
    require "user_".$action.".php";
};
?>

<!DOCTYPE html>
<html ng-app="ajax">
<head>
    <title></title>

    <script src="angular/angular.js"></script>
    <script src="angular/angular-route.js"></script>
    <script src="angular/angular-resource.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <script>
        angular.module("ajax", [
                'ngRoute',
                'ngResource'
            ])
            .value("userId", <?php echo $_SESSION['user_loggedin']; ?>)
            .config(function($routeProvider) {
                $routeProvider.when("/", {
                    templateUrl: "views/listing.html"
                });
                $routeProvider.when("/add-new", {
                    templateUrl: "views/addNew.html"
                });
                $routeProvider.when("/:id", {
                    templateUrl: "views/viewList.html",
                    controller: "viewCtrl"
                });

            })
            .controller("listCtrl", function($scope, $http, $location, userId) {
                // the initial function that pulls lists from the database on load
                var init = function() {
                    $http({
                        url: "retrieve_lists.php",
                        method: "GET"
                    })
                        .success(function(response) {
                            $scope.lists = response;
                            console.log($scope.lists);

                            if(response.length > 0) {
                                $scope.hasLists = true;
                            }

                        })
                        .error(function(error) {
                            $scope.status = error || "Request Failed";
                        });
                };
                init();

                // the function that allows users to delete lists from the database
                $scope.deleteList = function(id, index) {
                    var url = 'http://localhost:8888/grocery_list/delete_list.php';

                    $http({
                        url: url,
                        method: "POST",
                        data: id
                    })
                        .success(function(data) {
                            $scope.lists.splice(index, 1);
                            if ($scope.lists.length == 0) {
                                $scope.hasLists = false;
                            }
                        });
                };

                // setting an empty object
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
                    var url = 'http://localhost:8888/grocery_list/add_list.php';

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
                                $scope.lists.push(add);
                                $scope.hasLists = true;
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
            .controller("viewCtrl", function($scope, $http, $routeParams, $location) {

                var getList = function(id) {
                    for (var i = 0; i < $scope.lists.length; i++) {
                        if (id == $scope.lists[i].id) {
                            $scope.activeList = $scope.lists[i];
                            break;
                        }
                    }
                    $http.get('retrieve_items.php?id=' + id)
                        .success(function(data) {
                            $scope.items = data;
                        })
                        .error(function(error) {
                            $scope.viewError = error;
                        })
                };
                getList($routeParams.id);

                $scope.doneToggle = function(item) {
                    if (item.done) {
                        item.done = false;
                    } else {
                        item.done = true;
                    }
                };

                $scope.hideDoneToggle = function() {
                    if ($scope.hideDone) {
                        $scope.hideDone = false;
                        document.getElementById('hide-toggle').innerHTML="Hide Checked";
                    } else {
                        $scope.hideDone = true;
                        document.getElementById('hide-toggle').innerHTML="Show Checked";
                    }
                };

                $scope.shouldBeHidden = function(item) {
                    if ($scope.hideDone && item.done) {
                        return true;
                    }
                };

                $scope.updateList = function() {
                    var doneArray = [];

                    console.log($scope.items);

                    for(var i = 0; i < $scope.items.length; i++) {
                        console.log($scope.items[i].id + " = " + $scope.items[i].done);
                        if ($scope.items[i].done == true) {
                            doneArray.push($scope.items[i].id);
                            $scope.items.splice(i, 1);
                            i = i - 1;
                        }
                    }

                    console.log(doneArray);

                    $http({
                        url: 'http://localhost:8888/grocery_list/delete_items.php',
                        method: "POST",
                        data: doneArray
                    })
                        .success(function(data) {
                            console.log(data);
                            $location.path('/');
                        });
                };

                // the function that allows users to delete lists from the database
                $scope.deleteList = function(id) {
                    var url = 'http://localhost:8888/grocery_list/delete_list.php';

                    $http({
                        url: url,
                        method: "POST",
                        data: id
                    })
                        .success(function(data) {
                            for (var i = 0; i < $scope.lists.length; i++) {
                                console.log("id: "+id);
                                console.log("list id: "+$scope.lists[i].id);

                                if (id == $scope.lists[i].id) {
                                    console.log("list id: "+$scope.lists[i].id);
                                    $scope.lists.splice(i, 1);
                                    break;
                                }
                            }
                            $location.path('/');
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
                    <a class="btn btn-primary btn-sm pull-right" href="kill.php">Logout</a>
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