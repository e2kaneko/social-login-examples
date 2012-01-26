<?php
class AllControllersTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Controller related class tests');

		$suite->addTestFile(APP_TEST_CASES . DS . 'Controller' . DS . 'ListControllerTest.php');
		return $suite;
	}
}