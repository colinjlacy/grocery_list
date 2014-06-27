angular.module("grocery")
    .controller("listCtrl", function($scope, $http, $location, $route, userId) {
        // the initial function that pulls lists from the database on load

        var init = function() {
            $http({
                url: "retrieve_lists.php",
                method: "GET"
            })
                .success(function(response) {
                    $scope.lists = response;

                    for(var i = 0; i < $scope.lists.length; i++) {
                        $scope.lists[i].urlencode = encodeURIComponent($scope.lists[i].title);
                    }

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
            var url = 'delete_list.php';

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

        $scope.dashboard = function() {
            $location.path("/");
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

        $scope.remove = function(index) {
            $scope.add.items.splice(index, 1);
        };

        $scope.save = function() {
            $scope.add.userId = userId;
            var add = $scope.add;
            var url = 'add_list.php';

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
                        add.urlencode = encodeURIComponent(add.title);
                        $scope.lists.push(add);
                        $scope.hasLists = true;
                        $scope.add = {};
                        $location.path('/');
                    } else {
                        $scope.add.error = data;
                    }
                })
                .error(function(error) {
                    console.log(error);
                    $scope.add.error = error;
                });
        };

    });
