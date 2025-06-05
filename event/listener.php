<?php

/**
 * @package Local Time
 * @copyright (c) 2025 Daniel James
 * @license https://opensource.org/license/gpl-2-0
 */

namespace danieltj\localtime\event;

use phpbb\language\language;
use phpbb\template\template;
use danieltj\localtime\includes\functions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface {

	/**
	 * @var language
	 */
	protected $language;

	/**
	 * @var template
	 */
	protected $template;

	/**
	 * @var functions
	 */
	protected $functions;

	/**
	 * Constructor
	 */
	public function __construct( language $language, template $template, functions $functions ) {

		$this->language = $language;
		$this->template = $template;
		$this->functions = $functions;

	}

	/**
	 * Register Events
	 */
	static public function getSubscribedEvents() {

		return [
			'core.user_setup_after'				=> 'add_languages',
			'core.memberlist_view_profile'		=> 'add_member_tpl_vars',
			'core.ucp_pm_view_messsage'			=> 'add_pm_tpl_vars',
			'core.viewtopic_post_rowset_data'	=> 'update_post_row_data',
			'core.viewtopic_modify_post_row'	=> 'add_post_tpl_vars',
		];

	}

	/**
	 * Add Languages
	 */
	public function add_languages() {

		$this->language->add_lang( [ 'common' ], 'danieltj/localtime' );

	}

	/**
	 * memberlist
	 */
	public function add_member_tpl_vars( $event ) {

		$this->template->assign_vars( [
			'LOCAL_TIME' => $this->functions->get_l10n_local_time( $event[ 'member' ][ 'user_timezone' ] ),
		] );

	}

	/**
	 * includes/ucp/ucp_pm_viewmessage:view_message
	 */
	public function add_pm_tpl_vars( $event ) {

		$this->template->assign_vars( [
			'AUTHOR_LOCAL_TIME'	=> $this->functions->get_l10n_local_time( $event[ 'message_row' ][ 'user_timezone' ] ),
		] );

	}

	/**
	 * viewtopic
	 */
	public function update_post_row_data( $event ) {

		$event[ 'rowset_data' ] = array_merge( $event[ 'rowset_data' ], [
			'user_timezone' => $event[ 'row' ][ 'user_timezone' ],
		] );

	}

	/**
	 * viewtopic
	 */
	public function add_post_tpl_vars( $event ) {

		$event[ 'post_row' ] = array_merge( $event[ 'post_row' ], [
			'POSTER_LOCAL_TIME' => $this->functions->get_l10n_local_time( $event[ 'row' ][ 'user_timezone' ] ),
		] );

	}

}
