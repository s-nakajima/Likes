/**
 * @fileoverview Likes Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * Likes Service Javascript
 *
 * @param {string} Controller name
 * @param {function('$http', '$q')} Controller
 */
NetCommonsApp.factory('LikesSave', ['$http', '$q', function($http, $q) {
  return function(post) {

    var deferred = $q.defer();
    var promise = deferred.promise;

    $http.get('/net_commons/net_commons/csrfToken.json')
      .success(function(token) {
          post._Token.key = token.data._Token.key;

          //POSTリクエスト
          $http.post(
              '/likes/likes/like.json',
              $.param({_method: 'POST', data: post}),
              {cache: false,
                headers:
                    {'Content-Type': 'application/x-www-form-urlencoded'}
              }
          )
          .success(function(data) {
                //success condition
                deferred.resolve(data);
              })
          .error(function(data, status) {
                //error condition
                deferred.reject(data, status);
              });
        })
      .error(function(data, status) {
          //Token error condition
          deferred.reject(data, status);
        });

    promise.success = function(fn) {
      promise.then(fn);
      return promise;
    };

    promise.error = function(fn) {
      promise.then(null, fn);
      return promise;
    };

    return promise;
  };
}]);


/**
 * Likes Controller Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, LikesSave)} Controller
 */
NetCommonsApp.controller('Likes', function($scope, LikesSave) {

  /**
   * Request parameters
   *
   * @type {object}
   */
  $scope.data = null;

  /**
   * Options parameters
   *   - disabled
   *   - likeCounts
   *   - unlikeCounts
   *
   * @type {object}
   */
  $scope.options = null;

  /**
   * initialize
   *   - disabled
   *   - likeCounts
   *   - unlikeCounts
   *
   * @return {void}
   */
  $scope.initialize = function(data, options) {
    $scope.data = data;
    $scope.options = options;
  };

  /**
   * save
   *
   * @return {void}
   */
  $scope.save = function(isLiked) {
    $scope.data['LikesUser']['is_liked'] = isLiked;

    LikesSave($scope.data)
      .success(function(data) {
          //success condition
          $scope.options.disabled = true;
          if (isLiked) {
            $scope.options['likeCount'] = $scope.options['likeCount'] + 1;
          } else {
            $scope.options['unlikeCount'] = $scope.options['unlikeCount'] + 1;
          }
        })
      .error(function(data, status) {
          //error condition
        });
  };
});


/**
 * LikeSettings Controller Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('LikeSettings', function($scope) {

  /**
   * initialize
   *   - useLikeDomId
   *   - useUnlikeDomId
   *
   * @return {void}
   */
  $scope.initialize = function(useLikeDomId, useUnlikeDomId) {
    $scope.useLikeDomId = useLikeDomId;
    $scope.useUnlikeDomId = useUnlikeDomId;
  };

  /**
   * Use like button
   *
   * @return {void}
   */
  $scope.useLike = function() {
    var likeElement = $('#' + $scope.useLikeDomId);
    var unlikeElement = $('#' + $scope.useUnlikeDomId);

    if (likeElement[0].checked) {
      unlikeElement[0].disabled = false;
    } else {
      unlikeElement[0].disabled = true;
      unlikeElement[0].checked = false;
    }
  };
});
