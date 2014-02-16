app = angular.module('Gasstations', ['ngResource']);

app.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
      when('/', {templateUrl: '/app/partials/stations.html',   controller: 'GasstationCtrl'}).
      when('/:id', {templateUrl: '/app/partials/station.html', controller: GasstationCtrl});
}]);

app.factory('SomeCache', function($cacheFactory) {
    return $cacheFactory('someCache', {
        capacity: 3
    });
});


GasstationCtrl = ["$scope", "$routeParams", "$http", "SomeCache", function($scope, $routeParams, $http, SomeCache) {
  if ($routeParams.id) {
    result = SomeCache.get($routeParams.id);
    
    if (!result) {
        $http.get('/stations/' + $routeParams.id, {cache: true})
        .success(function(data){
            $scope.station = data;
            SomeCache.put($routeParams.id, data);
        });
    }
    
    $scope.station = result;
  } else {
    result = SomeCache.get('stations');
    
    if (!result) {
    $http.get('/stations/', {cache: true})
     .success(function(data){
         $scope.stations = data;
     });
    }
  }
}];