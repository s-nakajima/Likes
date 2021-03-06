<?php
/**
 * Like::saveLike()のテスト
 *
 * @property Like $Like
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');

/**
 * Like::saveLike()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Test\Case\Model\Like
 */
class LikeSaveLikeTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'Like';

/**
 * Method name
 *
 * @var array
 */
	protected $_methodName = 'saveLike';

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
			'Like' => array(
				'id' => 1,
				'like_count' => '1',
				'unlike_count' => '1',
				'plugin_key' => 'bbses',
				'block_key' => 'block_1',
				'content_key' => 'aaa',
			),
			'LikesUser' => array(
				'like_id' => 0,
				'user_id' => 1,
				'is_liked' => 0,
			)
		);

		return $data;
	}

/**
 * SaveのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return void
 */
	public function dataProviderSave() {
		return array(
			array($this->__getData()), //修正
		);
	}

/**
 * SaveのExceptionErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return void
 */
	public function dataProviderSaveOnExceptionError() {
		return array(
			array($this->__getData(), 'Likes.Like', 'save'),
			array($this->__getData(), 'Likes.LikesUser', 'save'),
			array($this->__getData(), 'Likes.Like', 'updateAll'),

		);
	}

/**
 * SaveのValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *
 * @return void
 */
	public function dataProviderSaveOnValidationError() {
		return array(
			array($this->__getData(), 'Likes.Like'),
			array($this->__getData(), 'Likes.LikesUser'),
		);
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
			array($this->__getData(), 'plugin_key', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'block_key', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'content_key', '',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'like_count', 'a',
				__d('net_commons', 'Invalid request.')),
			array($this->__getData(), 'unlike_count', 'a',
				__d('net_commons', 'Invalid request.')),
		);
	}

}
