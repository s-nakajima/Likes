<?php
/**
 * TestLikes Model
 *
 * @property TestLikes $testLikes
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LikesAppModel', 'Likes.Model');
App::uses('Like', 'Likes.Model');

/**
 * TestLikes Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Likes\Test\test_app\Plugin\TestLikes\Model
 */
class TestLikes extends LikesAppModel {

/**
 * name
 *
 * @var string
 */
	public $name = 'Like';

/**
 * alias
 *
 * @var string
 */
	public $alias = 'Like';

/**
 * use behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Likes.Like' => array(
			'model' => 'testmodel',
			'field' => 'testfield',
		),
	);

}
