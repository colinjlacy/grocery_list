<?php session_start(); ?>
<?php if(!(isset($_SESSION['user_loggedin']))) {
    header('Location: /index.php');
};
?>

<!DOCTYPE html>
<html ng-app="ajax">
<head>
    <title></title>

    <script src="angular/angular.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">

    <script>
        angular.module("ajax", [])
            .controller("defaultController", function($scope, $http, $templateCache) {
                $scope.submit = function(input) {
                    $http({
                        url: "set_session.php",
                        method: "POST",
                        data: {
                            'name' : input
                        }
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        cache: $templateCache
                    })
                        .success(function(response) {
                            $scope.status = response.status;
                        })
                        .error(function(error) {
                            $scope.status = error || "Request Failed";
                        });
                };
            })
    </script>

</head>
<body ng-controller="defaultController">

<? if (isset($_SESSION['name'])) { ?>
    <h1>
        <?php
        echo($_SESSION['name']);
        ?>
    </h1>
<?php }; ?>

<div class="well">
    <p class="alert alert-success" ng-show="status">
        {{status}}
    </p>
    <label class="control-label">
        Enter a name
        <input type="text" ng-model="name" class="form-control"/>
    </label>
    <button class="btn btn-primary" ng-click="submit(name)">Submit</button>
</div>

</body>
</html>