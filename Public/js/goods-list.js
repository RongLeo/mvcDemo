var app = angular.module("content",[]);

app.config(function($httpProvider) {
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
}); 

app.controller("goodsController", ["$scope","$http",function($scope,$http){
    var path = $.trim($('#currCPath').val());
    // 获取json数据
    $http.post('goodsList','p=' + path).success(function(resp) {
    	      // 绑定服务器返回的json数据到模板
    	      if (resp.status == 1) {
    	      	   $scope.goodsList = resp.data;
    	      }
    });
}]);