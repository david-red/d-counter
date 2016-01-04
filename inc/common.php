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
			$total_hit = empty( sl_setting( 'total_hit' ) ) ? 0 : sl_setting( 'total_hit' );
			update_setting( 'total_hit', $total_hit );
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
}

new D_Counter;