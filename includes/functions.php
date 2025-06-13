<?php

/**
 * @package Local Time
 * @copyright (c) 2025 Daniel James
 * @license https://opensource.org/license/gpl-2-0
 */

namespace danieltj\localtime\includes;

use phpbb\user;

final class functions {

	/**
	 * @var user
	 */
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct( user $user ) {

		$this->user = $user;

	}

	/**
	 * Returns current localised time of a given timezone.
	 * 
	 * @since 1.0.0-b4 
	 * @since 1.0.1    Catch exception for invalid timezones.
	 * 
	 * @param  string $timezone A string representing a timezone selection.
	 * 
	 * @return string           A formatted and localised timestamp.
	 */
	public function get_l10n_local_time( $timezone = 'UTC' ) {

		try {

			/**
			 * Required for \phpbb\datetime wrapper.
			 * 
			 * @link https://www.php.net/manual/en/class.datetimezone.php
			 */
			$dtz = new \DateTimeZone( $timezone );

		} catch ( \DateInvalidTimeZoneException $error ) {

			// Always fallback to UTC.
			$dtz = new \DateTimeZone( 'UTC' );

		}

		// phpBB wrapper class for php DateTime to localise timestamps.
		$datetime = new \phpbb\datetime( $this->user, 'now', $dtz );

		return $datetime->format( $this->user->data[ 'user_dateformat' ], true );

	}

}
