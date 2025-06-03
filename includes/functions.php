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
	 * Return the local time string for the given user.
	 * 
	 * @since 1.0.0
	 * 
	 * @param integer $user_id The ID of the user to search for.
	 * 
	 * @return string  A string containing the user's local time converted
	 *                 into the format of the current authenticated user.
	 */
	public function get_users_local_time( $user_id ) {

		$user_id = (int) $user_id;

		// Return blank string for invalid users.
		if ( 0 === $user_id ) {

			return '';

		}

		$result = $this->database->sql_query( 'SELECT user_timezone FROM ' . USERS_TABLE . ' WHERE ' . $this->database->sql_build_array( 'SELECT', [
			'user_id' => (int) $user_id
		] ) );

		$user_data = $this->database->sql_fetchrow( $result );
		$this->database->sql_freeresult( $result );

		if ( false === $user_data ) {

			return '';

		}

		$datetime = new \DateTime( 'now', new \DateTimeZone( $user_data[ 'user_timezone' ] ) );

		// Convert the timestamp into the current user's datetime format.
		return $datetime->format( str_replace( '|', '', $this->user->data[ 'user_dateformat' ] ) );

	}

}
