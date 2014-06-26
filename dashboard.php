<?php session_start(); ?>
<?php if(!(isset($_SESSION['user_loggedin']))) {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        require "user_".$action.".php";
    } else {
        header('Location: /grocery_list/');
    }
};
?>

<!DOCTYPE html>
<html ng-app="grocery">
<head>
    <title></title>

    <script src="angular/angular.js"></script>
    <script src="angular/angular-route.js"></script>
    <script src="angular/angular-resource.js"></script>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/site.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="app/app.js"></script>
    <script src="app/config.js"></script>
    <script src="app/listCtrl.js"></script>
    <script src="app/viewCtrl.js"></script>
    <script>
            angular.module("grocery").value("userId", <?php echo $_SESSION['user_loggedin']; ?>)
    </script>

</head>
<body ng-controller="listCtrl">
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-push-2">
                <p class="text-right pull-right">
                    <a class="btn btn-primary btn-sm " ng-show="$route.current.templateUrl != 'views/listing.html'" ng-click="dashboard()">Dashboard</a>
                    <a class="btn btn-primary btn-sm" href="logout.php">Logout</a>
                </p>
                <h2 class="text-muted">
                    <?php echo $_SESSION['username']; ?>'s Grocery Lists
                </h2>
            </div>
        </div>
    </div>
</div>

<ng-view></ng-view>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>

</body>
</html>