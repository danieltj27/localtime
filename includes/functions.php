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

		// Format timestamp and localise it for the current user.
		return $this->user->format_date( $datetime->getTimestamp(), $this->user->data[ 'user_dateformat' ], true );

	}

}
