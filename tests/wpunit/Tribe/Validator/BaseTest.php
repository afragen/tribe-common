<?php

namespace Tribe\Validator;

use Tribe__Validator__Base as Validator;

class BaseTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * It should be instantiatable
	 *
	 * @test
	 */
	public function be_instantiatable() {
		$this->assertInstanceOf( Validator::class, $this->make_instance() );
	}

	/**
	 * @return Validator
	 */
	protected function make_instance() {
		return new Validator();
	}

	public function is_string_data() {
		return [
			[ '', false ],
			[ null, false ],
			[ array( 'foo' => 'bar' ), false ],
			[ array( 'foo', 'bar' ), false ],
			[ new \StdClass(), false ],
			[ 'f', true ],
			[ 'foo bar', true ],
		];
	}

	/**
	 * Test is_string
	 *
	 * @test
	 * @dataProvider is_string_data
	 */
	public function test_is_string( $value, $expected ) {
		$this->assertEquals( $expected, $this->make_instance()->is_string( $value ) );
	}

	public function is_numeric_data() {
		return [
			[ '', false ],
			[ null, false ],
			[ array( 'foo' => 'bar' ), false ],
			[ array( 'foo', 'bar' ), false ],
			[ new \StdClass(), false ],
			[ '23', true ],
			[ 23, true ],
			[ '23 89', false ],
		];
	}

	/**
	 * Test is_numeric
	 *
	 * @test
	 * @dataProvider is_numeric_data
	 */
	public function test_is_numeric( $value, $expected ) {
		$this->assertEquals( $expected, $this->make_instance()->is_numeric( $value ) );
	}

	public function is_time_data() {
		return [
			[ '', false ],
			[ null, false ],
			[ array( 'foo' => 'bar' ), false ],
			[ array( 'foo', 'bar' ), false ],
			[ new \StdClass(), false ],
			[ '23', true ],
			[ 23, true ],
			[ 'tomorrow 9am', true ],
			[ '+5 days', true ],
			[ 'yesterday', true ],
			[ strtotime( 'tomorrow 8am' ), true ],
		];
	}

	/**
	 * Test is_time
	 *
	 * @test
	 * @dataProvider is_time_data
	 */
	public function test_is_time( $value, $expected ) {
		$this->assertEquals( $expected, $this->make_instance()->is_time( $value ) );
	}

	public function is_user_bad_users() {
		return [
			[ null ],
			[ false ],
			[ 23 ],
			[ '23' ],
			[ array( 23 ) ],
			[ array( 'user' => 23 ) ],
		];
	}

	/**
	 * Test is_user bad users
	 *
	 * @test
	 * @dataProvider is_user_bad_users
	 */
	public function test_is_user_bad_users( $bad_user ) {
		$this->assertFalse( $this->make_instance()->is_user_id( $bad_user ) );
	}

	/**
	 * Test is_user with good user
	 *
	 * @test
	 */
	public function test_is_user_with_good_user() {
		$user_id = $this->factory()->user->create();
		$this->assertTrue( $this->make_instance()->is_user_id( $user_id ) );
	}

	public function is_positive_int_inputs() {
		return [
			[ 3, true ],
			[ 0, false ],
			[ - 1, false ],
			[ '3', true ],
			[ '0', false ],
			[ '-1', false ],
		];
	}

	/**
	 * Test is_positive_int
	 *
	 * @test
	 * @dataProvider is_positive_int_inputs
	 */
	public function test_is_positive_int( $value, $expected ) {
		$this->assertEquals( $expected, $this->make_instance()->is_positive_int( $value ) );
	}

	public function trim_inputs() {
		return [
			[ 'foo', 'foo' ],
			[ 'foo ', 'foo' ],
			[ ' foo ', 'foo' ],
			[ ' foo  ', 'foo' ],
			[ [ 'foo' => 'bar' ], [ 'foo' => 'bar' ] ],
			[ 23, 23 ],
		];
	}

	/**
	 * Test trim
	 *
	 * @test
	 * @dataProvider trim_inputs
	 */
	public function test_trim( $value, $expected ) {
		$this->assertEquals( $expected, $this->make_instance()->trim( $value ) );
	}
}