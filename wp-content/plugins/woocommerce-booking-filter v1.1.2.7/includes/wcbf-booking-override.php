<?php
class wcbf_product_booking extends WC_Product_Booking {

    function __construct( $product  ) {
	    parent::__construct( $product );
    }

	/**
     * Get an array of blocks within in a specified date range - might be days, might be blocks within days, depending on settings.
     *
     * @param       $start_date
     * @param       $end_date
     * @param array $intervals
     * @param int   $resource_id
     * @param array $booked
     *
     * @return array
     */
    public function get_blocks_in_range( $start_date, $end_date, $intervals = array(), $resource_id = 0, $booked = array() ) {

        $default_interval = 'hour' === $this->get_duration_unit() ? $this->get_duration() * 60 : $this->get_duration();

        if ( empty( $intervals ) ) {
            $intervals = array( $default_interval, $default_interval );
        }

        // if we're only checking against the first block the first interval
        // should be equal to the standard slot size.
        if ( $this->get_check_start_block_only() ) {

            $intervals[0] = $default_interval;
        }

        if ( 'day' === $this->get_duration_unit() ) {
            $blocks_in_range = $this->get_blocks_in_range_for_day( $start_date, $end_date, $resource_id, $booked );

        } elseif ( 'month' === $this->get_duration_unit() ) {

            $blocks_in_range = $this->get_blocks_in_range_for_month( $start_date, $end_date, $resource_id );
        } else {
            $blocks_in_range = $this->get_blocks_in_range_for_hour_or_minutes( $start_date, $end_date, $intervals, $resource_id, $booked );
        }

        return array_unique( $blocks_in_range );
    }

	/**
	 * Get blocks/day blocks in range for day duration unit.
	 *
	 * @param $start_date
	 * @param $end_date
	 * @param integer $resource_id
	 * @param array $bookings { $booking[0] start and $booking[1] end }
	 *
	 * @return array
	 */
	public function get_blocks_in_range_for_day( $start_date, $end_date, $resource_id, $bookings ) {
		$blocks = array();
		$available_qty    = $this->get_available_quantity( $resource_id );

		// get booked days with a counter to specify how many bookings on that date
		$booked_days_with_count = array();
		foreach ( $bookings as $booking ) {
			$booking_start = $booking[0];
			$booking_end   = $booking[1];
			$current_booking_day = $booking_start;
			// < because booking end depicts an end of a day and not a start for a new day.
			while ( $current_booking_day < $booking_end ) {
				$date = date( 'Y-m-d', $current_booking_day );

				if ( isset( $booked_days_with_count[ $date  ] ) ) {
					$booked_days_with_count[ $date ]++;
				} else {
					$booked_days_with_count[ $date ] = 1;
				}

				$current_booking_day = strtotime( '+1 day', $current_booking_day );
			}
		}

		// If exists always treat booking_period in minutes.
		$min_date_into_future = $this->get_min_date()['value'];
		// Fetching current date
		$current_date = date(get_option('date_format'));

		if( $min_date_into_future >= 1 && $current_date == date( get_option( 'date_format' ), $start_date ) ){
			$start_date_string = date( 'Y-m-d' , $start_date );
			$result = (int)substr( $start_date_string, -2, 2 );

			$result += $min_date_into_future;
			$start_date_string = substr_replace( $start_date_string, $result, -2, 2 );
			$new_start_date = strtotime( $start_date_string );
			$check_date = $new_start_date;
		}
		else{
                    $check_date = $start_date;
                }
		
		while ( $check_date <= $end_date ) {
			if ( WC_Product_Booking_Rule_Manager::check_availability_rules_against_date( $this, $resource_id, $check_date ) ) {

				$date = date( 'Y-m-d', $check_date );
				if ( ! isset( $booked_days_with_count[ $date ] ) || $booked_days_with_count[ $date ] < $available_qty ) {

					$blocks[] = $check_date;

				}
			}

			// move to next day
			$check_date = strtotime( '+1 day', $check_date );

		}
		return $blocks;
	}

	/**
	 * For months, loop each month in the range to find blocks.
	 *
	 * @param $start_date
	 * @param $end_date
	 * @param integer $resource_id
	 *
	 * @return array
	 */
	public function get_blocks_in_range_for_month( $start_date, $end_date, $resource_id ) {

		$blocks = array();

		if ( 'month' !== $this->get_duration_unit() ) {
			return $blocks;
		}

		// Generate a range of blocks for months
		$from       = strtotime( date( 'Y-m-01', $start_date ) );
		$to         = strtotime( date( 'Y-m-t', $end_date ) );
		$month_diff = 0;
		$month_from = strtotime( '+1 MONTH', $from );

		while ( $month_from <= $to ) {
			$month_from = strtotime( '+1 MONTH', $month_from );
			$month_diff ++;
		}

		for ( $i = 0; $i <= $month_diff; $i ++ ) {
			$year  = date( 'Y', ( $i ? strtotime( "+ {$i} month", $from ) : $from ) );
			$month = date( 'n', ( $i ? strtotime( "+ {$i} month", $from ) : $from ) );

			if ( ! WC_Product_Booking_Rule_Manager::check_availability_rules_against_date( $this, $resource_id, strtotime( "{$year}-{$month}-01" ) ) ) {
				continue;
			}

			$blocks[] = strtotime( "+ {$i} month", $from );
		}
		return $blocks;
	}

	/**
	 * Get blocks in range for hour or minute duration unit.
	 * For minutes and hours find valid blocks within THIS DAY ($check_date)
	 *
	 * @param $start_date
	 * @param $end_date
	 * @param $intervals
	 * @param integer $resource_id
	 * @param $booked
	 *
	 * @return array
	 */
	public function get_blocks_in_range_for_hour_or_minutes( $start_date, $end_date, $intervals, $resource_id, $booked ) {
		$block_start_times_in_range     = array();
		$interval   = $intervals[0];
		$check_date = $start_date;

		// Setup.
		$first_block_time_minute  = $this->get_first_block_time() ? ( date( 'H', strtotime( $this->get_first_block_time() ) ) * 60 ) + date( 'i', strtotime( $this->get_first_block_time() ) ) : 0;
		$default_bookable_minutes = $this->get_default_availability() ? range( $first_block_time_minute, ( 1440 + $interval ) ) : array();
		$sorted_rules             = $this->get_availability_rules( $resource_id ); // Work out what minutes are actually bookable on this day

		// Get available slot start times.
		$minutes_booked     = $this->get_unavailable_minutes( $booked );

		// Looping day by day look for available blocks
		// using `<=` instead of `<` because https://github.com/woothemes/woocommerce-bookings/issues/325
		while ( $check_date <= $end_date ) {
			$bookable_minutes_for_date  = array_merge( $default_bookable_minutes, WC_Product_Booking_Rule_Manager::get_minutes_from_rules( $sorted_rules, $check_date ) );

			if ( ! $this->get_default_availability() ) {
				$bookable_minutes_for_date  = $this->apply_first_block_time( $bookable_minutes_for_date, $first_block_time_minute );

			}

			$bookable_start_and_end     = $this->get_bookable_minute_start_and_end( $bookable_minutes_for_date );
			$blocks                     = $this->get_bookable_minute_blocks_for_date( $check_date, $start_date, $end_date, $bookable_start_and_end, $intervals, $resource_id, $minutes_booked );

			$block_start_times_in_range = array_merge( $blocks, $block_start_times_in_range );
			$check_date                 = strtotime( '+1 day', $check_date );// Move to the next day
		}
		return $block_start_times_in_range;
	}

}

?>

