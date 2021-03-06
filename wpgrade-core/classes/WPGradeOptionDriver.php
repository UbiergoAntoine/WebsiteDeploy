<?php
/**
 * @package        wpgrade
 * @category       core
 * @author         Pixel Grade Team
 */
abstract class WPGradeOptionDriver {

	/**
	 * @return option value or default
	 */
	abstract function get( $option, $default = null );

	/**
	 * @return static $this
	 */
	function set( $key, $value ) {
		throw new Exception( 'Set operation not supported by ' . __CLASS__ );
	}

} # class
