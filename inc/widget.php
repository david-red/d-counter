<?php

class DC_Widget extends WP_Widget
{
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct()
	{
		parent::__construct(
			'dc_widget',
			__( 'Counter Statistic', 'dc' ),
			array(
				'description' => __( 'Display Total visits, online', 'dc' ),
			)
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance )
	{
		printf( '
			<p><b>%s:</b> %d</p>
			<p><b>%s:</b> %d</p>',
			$instance['total_visits'],
			D_Counter::sl_setting( 'total_hit' ) ? D_Counter::sl_setting( 'total_hit' ) : 1,
			$instance['online'],
			D_Counter::online()
		);
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 *
	 * @return void
	 */
	public function form( $instance )
	{
		$total  = esc_attr( $instance['total_visits'] );
		$online = esc_attr( $instance['online'] );
		?>
		<p>
			<label><?php _e( 'Total visits', 'dc' ); ?>:</label>
			<input type="text" value="<?php echo $total; ?>" name="<?php echo $this->get_field_name( 'total_visits' ); ?>">
		</p>
		<p>
			<label><?php _e( 'Online', 'dc' ); ?>:</label>
			<input type="text" value="<?php echo $online; ?>" name="<?php echo $this->get_field_name( 'online' ); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return void
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance                   = $old_instance;
		$instance['total_visits']   = strip_tags( $new_instance['total_visits'] );
		$instance['online']         = strip_tags( $new_instance['online'] );

		return $instance;
	}
}

add_action( 'widgets_init', function()
{
	register_widget( 'DC_Widget' );
} );