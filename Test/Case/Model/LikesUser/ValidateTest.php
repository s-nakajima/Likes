<?php
/**
 * LikesUser::beforeValidate Like()のテスト
 *
 * @property LikesUser $LikesUser
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Likesuser::BeforeValidate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Test\Case\Model\LikesUser
 */
class LikesUserBeforeValidateTest extends NetCommonsModelTestCase {

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'likes';

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.likes.like',
		'plugin.likes.likes_user',
	);

/**
 * Model name
 *
 * @var array
 */
	protected $_modelName = 'LikesUser';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'beforeValidate';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$data = array(
			'Frame' => array(
				'id' => '6',
			),
			'LikesUser' => array(
				'like_id' => 0,
				'user_id' => 1,
				'is_liked' => 0,
			),
		);

		return $data;
	}

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ
 *
 * @return void
 */
	public function dataProviderValidationError() {
		return array(
			array($this->__getData(), 'is_liked', 'a',
				__d('net_commons', 'Invalid request.')),
		);
	}

/**
 * Validatesのテスト
 *
 * @param array $data 登録データ
 * @param string $field フィールド名
 * @param string $value セットする値
 * @param string $message エラーメッセージ
 * @param array $overwrite 上書きするデータ
 * @dataProvider dataProviderValidationError
 * @return void
 */
	public function testValidationError($data, $field, $value, $message, $overwrite = array()) {
		$model = $this->_modelName;

		if (is_null($value)) {
			unset($data[$model][$field]);
		} else {
			$data[$model][$field] = $value;
		}
		$data = Hash::merge($data, $overwrite);

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertFalse($result);

		$this->assertEquals($this->$model->validationErrors[$field][0], $message);
	}

}
