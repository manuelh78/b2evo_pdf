<?php
/**
 * This file implements a class derived of the generic Skin class in order to provide custom code for
 * the skin in this folder.
 *
  *
 * @package skins
 * @subpackage pdf
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


class pdf_Skin extends Skin
{
	/**
	 * Skin version
	 * @var string
	 */
	var $version = '6.9.3';


	/**
	 * Get default name for the skin.
	 * Note: the admin can customize it.
	 */
	function get_default_name()
	{
		return 'pdf';
	}


	/**
	 * Get default type for the skin.
	 */
	function get_default_type()
	{
		return 'normal';
	}


	/**
	 * Get supported collection kinds.
	 *
	 * This should be overloaded in skins.
	 *
	 * For each kind the answer could be:
	 * - 'yes' : this skin does support that collection kind (the result will be was is expected)
	 * - 'partial' : this skin is not a primary choice for this collection kind (but still produces an output that makes sense)
	 * - 'maybe' : this skin has not been tested with this collection kind
	 * - 'no' : this skin does not support that collection kind (the result would not be what is expected)
	 * There may be more possible answers in the future...
	 */
	 public function get_supported_coll_kinds()
	 {
		 $supported_kinds = array(
				 'main' => 'no',
				 'std' => 'yes',		// Blog
				 'photo' => 'no',
				 'forum' => 'no',
				 'manual' => 'no',
				 'group' => 'no',  // Tracker
				 // Any kind that is not listed should be considered as "maybe" supported
			 );

		 return $supported_kinds;
	 }
}

?>