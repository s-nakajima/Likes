<?php
/**
 * LikeHelper Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('View', 'View');
App::uses('LikeHelper', 'Likes.View/Helper');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * Display for LikeHelper Test Case
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Test\Case\View\Helper
 */
class LikeHelperDisplayTest extends NetCommonsCakeTestCase {

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
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->Like = new LikeHelper($View);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Like);
		parent::tearDown();
	}

/**
 * displayのテスト
 *
 * @param array $setting Array of use like setting data.
 * @param array $content Array of content data with like count.
 * @dataProvider dataProviderDisplay
 * @return void
 */
	public function testDisplay($setting, $content) {
		$result = $this->Like->display($setting, $content);

		if ($setting['use_like'] === 1) {
			$this->assertContains('glyphicon glyphicon-thumbs-up', $result);
		} else {
			$this->assertNotContains('glyphicon glyphicon-thumbs-up', $result);
		}

		if ($setting['use_unlike'] === 1) {
			$this->assertContains('glyphicon glyphicon-thumbs-down', $result);
		} else {
			$this->assertNotContains('glyphicon glyphicon-thumbs-down', $result);
		}
	}

/**
 * displayのDataProvider
 *
 * #### 戻り値
 *  - setting like setting data
 *  - content like content data
 *
 * @return array
 */
	public function dataProviderDisplay() {
		$setting1 = array('use_like' => 1, 'use_unlike' => 1);
		$content1 = array('Content' => array('key' => 'content_key', 'status' => '1'));

		$setting2 = array('use_like' => 1, 'use_unlike' => 0);
		$content2 = array('Content' => array('key' => 'content_key', 'status' => '1'));

		$setting3 = array('use_like' => 0, 'use_unlike' => 0);
		$content3 = array('Content' => array('key' => 'content_key', 'status' => '1'));

		return array(
			array($setting1, $content1),
			array($setting2, $content2),
			array($setting3, $content3),
		);
	}

}
