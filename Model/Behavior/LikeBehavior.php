<?php
/**
 * Like Behavior
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
App::uses('Current', 'NetCommons.Utility');

/**
 * Like Behavior
 *
 * 使用するプラグインのコンテンツモデルにLikeモデル、LikesUserモデルの
 * アソシエーションを設定します。<br>
 * fieldオプションの指定がない場合は全データを取得しますが、<br>
 * fieldオプションを個別に指定する場合は、Likeモデルのfieldも明示的に指定してください。<br>
 *
 * #### Sample code
 * ##### ContentModel
 * ```
 * class BbsArticle extends BbsesAppModel {
 * 	public $actsAs = array(
 * 		'Likes.Like'
 * 	)
 * }
 * ```
 * ##### ContentController
 * ```
 * $bbsArticle = $this->BbsArticle->find('list');
 * ```
 * ##### ResultSample
 * ```
 * $bbsArticle = array(
 * 	'BbsArticle' => array(...),
 * 	'Likes' => array(
 * 		'id' => '999',
 * 		'plugin_key' => 'abcdefg',
 * 		'block_key' => 'abcdefg',
 * 		'content_key' => 'abcdefg',
 * 		'like_count' => '9',
 * 		'unlike_count' => '9',
 * 	)
 * )
 * ```
 *
 * 設定オプションは[setupメソッド](#setup)を参照
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Model\Behavior
 */
class LikeBehavior extends ModelBehavior {

/**
 * Model name
 *
 * @var array
 */
	private $__model;

/**
 * Key field name
 *
 * @var array
 */
	private $__field;

/**
 * SetUp behavior
 *
 * Likeモデル、LikesUserモデルのアソシエーションで、別モデル、別フィールド名を指定することがます。<br>
 * デフォルト値は、モデル名が呼び出し元名称、フィールド名が"key"になっています。
 *
 * @param object $model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		if (isset($config['model'])) {
			$this->__model = $config['model'];
		} else {
			$this->__model = $model->alias;
		}

		if (isset($config['field'])) {
			$this->__field = $config['field'];
		} else {
			$this->__field = 'key';
		}

		$likesUserConditions = array(
			'Like.id = LikesUser.like_id',
		);
		if (Current::read('User.id')) {
			$likesUserConditions['LikesUser.user_id'] = Current::read('User.id');
		} else {
			$likesUserConditions['LikesUser.session_key'] = CakeSession::id();
		}

		$model->bindModel(array(
			'belongsTo' => array(
				'Like' => array(
					'className' => 'Likes.Like',
					'foreignKey' => false,
					'conditions' => array(
						'Like.plugin_key' => Inflector::underscore($model->plugin),
						$this->__model . '.' . $this->__field . ' = ' . 'Like.content_key',
					),
				),
				'LikesUser' => array(
					'className' => 'Likes.LikesUser',
					'foreignKey' => false,
					'conditions' => $likesUserConditions,
				),
			)
		), false);

		parent::setup($model, $config);
	}
}
