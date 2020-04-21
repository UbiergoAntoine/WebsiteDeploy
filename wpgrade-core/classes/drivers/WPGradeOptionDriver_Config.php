<?php
/**
 * @package        wpgrade
 * @category       core
 * @author         Pixel Grade Team
 */
class WPGradeOptionDriver_Config extends WPGradeOptionDriver {

	/**
	 * @var Redux_Options
	 */
	protected $config = null;

	/**
	 * ...
	 */
	function __construct( $config ) {
		$this->config = $config;
	}

	/**
	 * @return mixed
	 */
	function get( $key, $default = null ) {
		if ( isset( $this->config[ $key ] ) ) {
			return $this->config[ $key ];
		} else { // no value
			return $default;
		}
	}

	/**
	 * @return static $this
	 */
	function set( $key, $value ) {
		$this->config[ $key ] = $value;

		return $this;
	}

} # class
