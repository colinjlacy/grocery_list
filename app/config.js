angular.module("grocery")
    .config(function($routeProvider) {
        $routeProvider.when("/", {
            templateUrl: "views/listing.html"
        });
        $routeProvider.when("/add-new", {
            templateUrl: "views/add-new.html"
        });
        $routeProvider.when("/:id", {
            templateUrl: "views/view-list.html",
            controller: "viewCtrl"
        });

    });
