<!DOCTYPE html>
<html ng-app="Gasstations">
<head>
  <title>Gasstations</title>
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular-resource.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
  <script src="/app/js/gasstations.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="container">
    <div class="navbar navbar-inverse">
      <a href="#/" class="navbar-brand" href="#">Gasstations</a>      
    </div>
    <div ng-view></div>
  </div>
</body>
</html>