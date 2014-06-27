angular.module("grocery")
    .controller("viewCtrl", function($scope, $http, $routeParams, $location, rootUrl, path) {

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
                url: '{{rootUrl}}{{path}}delete_items.php',
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
            var url = '{{rootUrl}}{{path}}delete_list.php';

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


    });
