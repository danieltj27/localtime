<?php

/**
 * @package Local Time
 * @copyright (c) 2025 Daniel James
 * @license https://opensource.org/license/gpl-2-0
 */

namespace danieltj\localtime\includes;

use phpbb\db\driver\driver_interface as database;
use phpbb\user;

final class functions {

	/**
	 * @var driver_interface
	 */
	protected $database;

	/**
	 * @var user
	 */
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct( database $database, user $user ) {

		$this->database = $database;
		$this->user = $user;

	}

	/**
	 * Returns a formatted timestamp of the current time.
	 * 
	 * @since 1.0.0-b2
	 * 
	 * @param  string $timezone A string representing a timezone selection.
	 * 
	 * @return string           A formatted timestamp based on the given timezone.
	 */
	public function get_tz_current_time( $timezone = 'UTC' ) {

		$datetime = new \DateTime( 'now', new \DateTimeZone( $timezone ) );

		// Convert the timestamp into the current user's datetime format.
		return $datetime->format( str_replace( '|', '', $this->user->data[ 'user_dateformat' ] ) );

	}

}
