<?php
/* Posts Test cases generated on: 2012-01-08 01:46:16 : 1325954776*/
App::uses('ListController', 'Controller');

/**
 * PostsController Test Case
 *
 */
class ListControllerTestCase extends ControllerTestCase {
	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array('app.list');

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->list = new ListController();
		$this->list->constructClasses();
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->list);

		parent::tearDown();
	}

	function testIndex() {
		/*
		 * - `return` 戻り値の種類を指定
		 * 	- `vars` アクションを実行した後に view 変数を取得
		 * 	- `view` レンダリングされた view のうち、レイアウトを除いたものを取得
		 * 	- `contents` レンダリングされた view のうち、レイアウトを含めたものを取得
		 * 	- `result` アクションの戻り値を取得。※デフォルト値
		 */
		$result = $this->testAction('/List', array("return"=>"vars"));
		//print_r($result);
	}
}
