<?php
/**
 * LikesController Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * LikesController Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Test\Case\Controller
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class LikesControllerTest extends NetCommonsControllerTestCase {

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
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'test_likes';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'test_likes';

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __getData() {
		$data = array(
			'Frame' => array(
				'id' => '1',
			),
			'Like' => array(
				'plugin_key' => 'test_likes',
				'block_key' => 'block_1',
				'content_key' => 'test',
			),
			'LikesUser' => array(
				'like_id' => 1,
				'user_id' => 1,
				'is_liked' => 0,
			)
		);

		return $data;
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsControllerTestCase::loadTestPlugin($this, 'Likes', 'TestLikes');
		parent::setUp();

		//ログイン
		TestAuthGeneral::login($this);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * LikeアクションのGETテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderLikeGet
 * @return void
 */
	public function testLikeGet($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
			'action' => 'like',
		), $urlOptions);

		$this->_testGetAction($url, $assert, $exception, $return);
	}

/**
 * likeアクションのGETテスト用DataProvider
 *
 * ### 戻り値
 *  - urlOptions: URLオプション
 *  - assert: テストの期待値
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderLikeGet() {
		$results = array();
		$results[0] = array(
			'urlOptions' => array(),
			'assert' => null, 'exception' => 'BadRequestException',
		);
		$results[1] = array(
			'urlOptions' => array(),
			'assert' => null,
			'exception' => 'BadRequestException', 'return' => 'json',
		);
		return $results;
	}

/**
 * likeアクションのPOSTテスト
 *
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @dataProvider dataProviderLikePost
 * @return void
 */
	public function testLikePost($data, $urlOptions, $exception = null, $return = 'json') {
		$this->_testPostAction('post', $data, Hash::merge(array('action' => 'like'), $urlOptions), $exception, $return);
	}

/**
 * LikeアクションのPOSTテスト用DataProvider
 *
 * ### 戻り値
 *  - data: 登録データ
 *  - urlOptions: URLオプション
 *  - exception: Exception
 *  - return: testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderLikePost() {
		$data1 = $this->__getData();
		$data2 = $this->__getData();
		$data2['Like']['content_key'] = '';
		$data3 = $this->__getData();
		$data3['Like']['content_key'] = 'testcontent';

		return array(
			array(
				'data' => $data1, 'urlOptions' => array(),
			),
			array(
				'data' => $data2, 'urlOptions' => array(), 'exception' => 'BadRequestException',
			),
			array(
				'data' => $data3, 'urlOptions' => array(),
			),
		);
	}

/**
 * LikeアクションのExistsテスト
 *
 * @return void
 */
	public function testLikeExists() {
		$data = $this->dataProviderLikePost()[2]['data'];

		$this->_testPostAction('post', $data, array('action' => 'like'), null, 'json');

		$this->generateNc(Inflector::camelize($this->_controller));

		//ログイン
		TestAuthGeneral::login($this);

		$this->_mockForReturnTrue('Likes.Like', 'saveLike', 0);
		$this->_testPostAction('post', $data, array('action' => 'like'), null, 'json');
	}

}
