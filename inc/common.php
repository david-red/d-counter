<?php
class D_Counter
{
	function __construct()
	{
		$this->init();
		$this->increase();
	}

	function init()
	{
		add_option( 'visitors_online', array() );
	}

	function increase()
	{
		if( ! session_id() )
		{
			session_start();
		}

		if ( ! isset( $_SESSION['visited'] ) )
		{
			$total_hit = self::sl_setting( 'total_hit' ) ? self::sl_setting( 'total_hit' ) : 1;
			self::update_setting( 'total_hit', $total_hit + 1 );
			$_SESSION['visited'] = 'yes';
		}
		self::set_visitors();
	}

	public static function set_visitors()
	{
		if( ! session_id() )
		{
			session_start();
		}

		$visitors   = get_option( 'visitors_online', true );
		$has        = false;

		foreach ( $visitors as $k => $visitor )
		{
			if ( $visitor['time'] < strtotime( 'now' ) )
			{
				unset( $visitors[$k] );
			}

			if ( session_id() == $visitor['id'] )
			{
				$visitor['time'] = strtotime( 'now' ) + 600;
				$has = true;
			}
		}

		if ( ! $has )
		{
			$visitors[] = array(
				'id'    => session_id(),
				'time'  => strtotime( 'now' ) + 600
			);
		}

		update_option( 'visitors_online', $visitors );
	}

	public static function online()
	{
		$visitors = get_option( 'visitors_online', true );

		return empty( $visitors ) ? 1 : count( $visitors );
	}

	/**
	 * Select a setting
	 *
	 * @param string $name
	 *
	 * @return mixed
	 */
	static function sl_setting( $name )
	{
		$settings = get_option( 'd-settings' );
		return isset( $settings[$name] ) ? $settings[$name] : '';
	}

	/**
	 * Update a setting
	 *
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return void
	 */
	static function update_setting( $name, $value )
	{
		$settings = get_option( 'd-settings' );
		if ( ! empty( $settings[$name] ) )
		{
			$settings[$name] = $value;
			update_option( 'd-settings', $settings );
		}
	}
}

new D_Counter;