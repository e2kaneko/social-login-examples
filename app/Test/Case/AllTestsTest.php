<?php
class AllTests extends PHPUnit_Framework_TestSuite {

	/**
	 * Suite define the tests for this suite
	 *
	 * @return void
	 */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('All Tests');

		$path = APP_TEST_CASES . DS;

		$suite->addTestFile($path . 'AllControllerTest.php');
		return $suite;
	}
}
