<?php
class WCBF_Main{
    function __construct(){
	add_action( 'plugins_loaded', array( $this, 'wcbf_class_loader' ), 99 );
        add_action( 'admin_init', array( $this, 'enqueue_custom_script' ) );
	add_action( 'activated_plugin', array( $this, 'wcbf_save_error' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script_form_valid' ) );
        add_action( 'woocommerce_product_query', array( $this, 'get_filtered_results' ) );
        add_shortcode( 'filter', array( $this, 'filter_shortcode' ) );
        add_filter( 'plugin_row_meta', array( $this, 'wcbf_plugin_link' ), 10, 2 );
        add_action( 'media_buttons', function(){
         ?> <input type="button" id="add_filter_btn" class="button" value="Add Filter" onclick="InsertContainer();" /><?php 
        });
        add_action( 'admin_footer', array( $this, 'wcbf_btn_shortcode_script' ));

    }

	  /**
	   * Function to save error in db if any error occurs
	   * during plugin activation
	   */
	  function wcbf_save_error() {
		  update_option( 'plugin_error',  ob_get_contents() );
	  }

      /**
       * Function to call when plugin activated.
       * 
       */
    function activate(){
      $this->add_default_values_to_db();
    }

      /**
       * Adds some new values to save in db
       * for persisting filter settings in db
       */
    function add_default_values_to_db(){
      add_option( 'wcbf_search_type', 'Fuzzy' ); //search type to be saved in db (default saves 'fixed' when plugin activate)
      add_option( 'wcbf_text_from', 'Start Date' ); //Start date label to be saved in db (default saves 'Start Date' when plugin activate)
      add_option( 'wcbf_text_to', 'End Date' ); //End date label to be saved in db (default saves 'End Date' when plugin activate)
      add_option( 'wcbf_is_end_date_enabled', 'yes' ); //Show end date? to be saved in db (default saves 'true' when plugin activate)
      add_option( 'wcbf_time_from', 'Start Time' ); //Start time to be saved in db (default)
      add_option( 'wcbf_time_to', 'End Time' ); //End time to be saved in db (default)
      add_option( 'wcbf_rf_s_date', 'yes' ); //Required FIeld validators for field 'start_Date'
      add_option( 'wcbf_rf_e_date', 'yes' ); //Required FIeld validators for field 'end date'
      add_option( 'wcbf_rf_s_time', 'yes' );//Required FIeld validators for field 'start_time'
      add_option( 'wcbf_rf_e_time', 'yes' );//Required FIeld validators for field 'end_time'
      add_option( 'wcbf_fuzzy_time_en', 'yes' );//Field for fuzzy time start enable
      add_option( 'wcbf_fuzzy_end_time', 'yes' );//Field for fuzzy time end enable 'end_time'
      add_option( 'wcbf_min_price', 'yes' ); //Field for min price en
      add_option( 'wcbf_max_price', 'yes' ); //field for max price en
      add_option( 'wcbf_min_price_text', 'Starting Price' ); //field for text of min price
      add_option( 'wcbf_is_rating_enabled', 'no' ); // field to check if rating is enabled
      add_option( 'wcbf_rating_text', 'Ratings' ); // field for the text of rating
      add_option( 'wcbf_is_keyword_search_enabled', 'no' ); //field to check if wordwise search is enabled
      add_option( 'wcbf_keyword_search_text', 'Search by name' ); // field for the text of wordwise search
    }
    
      /**
       * Function to get the highest bookable product's price
       * @return int
       */
    function get_highest_price_product(){
      $products = wc_get_products( [ 'type' => 'booking' ] );
      $price = [];
      foreach( $products as $p ){
        array_push( $price, $p->get_data()['price'] );
      }
      rsort( $price );
      return $price[0];
    }
      /**
       * Static function called when filter settings
       * are loaded to retrieve values from DB
       * returns array $arr of values fetched from DB
       */
    public static function get_filter_settings(){
     $format = self::date_format_to_frontend_format( get_option( 'date_format' ) );
     $time_format = get_option( 'time_format' );
      $arr = array(
                    'wcbf_search_type'               => get_option( 'wcbf_search_type' ),
                    'wcbf_text_from'                 => get_option( 'wcbf_text_from' ),
                    'wcbf_text_to'                   => get_option( 'wcbf_text_to' ),
                    'wcbf_is_end_date_enabled'       => get_option( 'wcbf_is_end_date_enabled' ),
                    'wcbf_is_time_enabled'           => get_option( 'wcbf_is_time_enabled' ),
                    'wcbf_time_from'                 => get_option( 'wcbf_time_from' ),
                    'wcbf_time_to'                   => get_option( 'wcbf_time_to' ),
                    'wcbf_rf_s_date'                 => get_option( 'wcbf_rf_s_date' ),
                    'wcbf_rf_e_date'                 => get_option( 'wcbf_rf_e_date' ),
                    'wcbf_rf_s_time'                 => get_option( 'wcbf_rf_s_time' ),
                    'wcbf_rf_e_time'                 => get_option( 'wcbf_rf_e_time' ),
                    'wcbf_fuzzy_time_en'             => get_option( 'wcbf_fuzzy_time_en' ),
                    'wcbf_fuzzy_end_time'            => get_option( 'wcbf_fuzzy_end_time' ),
                    'date_format'                    => $format,
                    'wcbf_min_price'                 => get_option( 'wcbf_min_price' ),
                    'wcbf_min_price_text'            => get_option( 'wcbf_min_price_text' ),
                    'wcbf_max_price'                 => get_option( 'wcbf_max_price' ),
                    'wcbf_is_rating_enabled'         => get_option( 'wcbf_is_rating_enabled' ),
                    'wcbf_rating_text'               => get_option( 'wcbf_rating_text' ),
                    'wcbf_is_keyword_search_enabled' => get_option( 'wcbf_is_keyword_search_enabled' ),
                    'wcbf_keyword_search_text'       => get_option( 'wcbf_keyword_search_text' ),
                    'time_format'                    => $time_format
                );
      return $arr;
    }
    /**
     * Function hooked to add filter_widget short code
     * to be placed anywhere on website
     */
    function filter_shortcode(){
      require_once( 'views/widget/widget_view.php' );
    }
    /**
     * Function to show filtered results
     * @param $query object
     * @return  modified query
     */
    public function get_filtered_results( $query ){
        
        $retrieved_nonce = $_REQUEST['_wpnonce'];
        if( ! wp_verify_nonce( $retrieved_nonce, 'get_filtered_results' ) ){
            return $query;
        }
        else{
            // if start date is not set and not mandatory, takes current date
            // also for retaining all products when no search filter is performed
            if( ! isset( $_POST['start_date'] ) || $_POST['start_date'] == null ){
              $_POST['start_date'] = date( get_option( 'date_format' ) );
            }
                $today_date = date( get_option( 'date_format' ) );
                //Checks if it's main qurey AND page is shop currently AND start date of search is given
            if ( $query->is_main_query() && is_shop() && isset( $_POST['start_date'] ) && $_SERVER['REQUEST_METHOD'] == 'POST' && ! empty( $_POST['action'] ) ){
                $product_ids = [];
                //checks for date and time settings
              if( isset( $_POST['start_date'] ) ){
                //fetches all bookable products
                $products = wc_get_products( [ 'type' => 'booking' ] );
                //if start date is sets,  saves it in variable
                $s_date = sanitize_text_field( $_POST['start_date'] );
                if( isset( $_POST['end_date'] ) ){
                  $e_date = sanitize_text_field( $_POST['end_date'] );
                }
                //if end date is not set, maximize the end date range (works when end date is not provided)
                // CASE WHEN (END DATE CHECK IS DISBALED FROM FILTER SETTINGS in FUZZY SEARCH)

                if( ! isset($e_date) || $_POST['end_date'] == null ){
                    //Fetches current date
                    $current_date = date( 'Y-m-d' );
                    $result = (int) substr( $current_date , 0, 4);
                    //Adding 3 years to current date's year;
                    $result += 3;
                    $new_date = substr_replace( $current_date, $result, 0, 4 );
                    // Assigning 3 year after value when not selected end date.
                    $e_date = $new_date;
                  }
                // if start time and end time is set (only when fuzzy setting enabled)
                if( isset( $_POST['strt_time'] ) && isset( $_POST['en_time'] ) ){
                    if( $_POST['strt_time'] != null && $_POST['en_time'] != null ){
                            $s_time = sanitize_text_field( $_POST['strt_time'] );
                            $e_time = sanitize_text_field( $_POST['en_time'] );
                    }
                    else{
                            $s_time = '00:00';
                            $e_time = '23:59';
                    }
                }
                      /**
                       * If date_format selected in wp is word-type
                       * calls the function to convert into numeric and
                       * assign them.
                       */
                if(get_option('date_format') == 'F j, Y'){
                    $today_date = self::word_date_to_numeric_date( $today_date );
                    $s_date     = self::word_date_to_numeric_date( $s_date );
                    $e_date     = self::word_date_to_numeric_date( $e_date );
                }

              }   
                // Looping through all the bookable products
              foreach( $products as $product ){
                    //saving informative info in vars
                    $id = $product->get_data()['id'];

                    if( isset( $s_time ) && isset( $e_time ) ){
                        $strt_range = $s_date .' '. $s_time;   // concating start time and date for fuzzy search
                        $end_range  = $e_date .' '. $e_time;    // concating end time and date for fuzzy search
                    }
                    else{
                      $strt_range = $s_date . ' ' . '00:00';
                      $end_range  = $e_date . ' ' . '23:59';
                    }

                    $booking = new wcbf_product_booking( $product );

                      /**
                       * If start range is less than todays date & endRange is greater than start range
                       */
                    if( $strt_range >= $today_date && $end_range >= $strt_range ){
                      if( get_option( 'wcbf_search_type' ) == 'Fuzzy' ){
                        $booking_override = new wcbf_product_booking( $product );
                        // Getting all blocks in range
                        $blocks_in_range = $booking->get_blocks_in_range(
                                                                        strtotime($strt_range),
                                                                        strtotime($end_range) - 1
                                                                        );
                            /**
                             * Args to pass to new definition
                             */
                        $args = array(
                                      'blocks'      => $blocks_in_range,
                                      'intervals'   => [],
                                      'resource_id' => 0,
                                      'from'        => strtotime( $strt_range ),
                                      'to'          => strtotime( $end_range ) - 1,
                                    );

                        // Get available blocks in range
                        $available_blocks = $booking_override->get_available_blocks( $args );

                        //Add product in array if time available
                        if( 0 < count( $available_blocks ) ){
                          $product_ids[] = $id;
                        }


                    }
                    else{
                      if( ! isset( $_POST['end_date'] ) || $_POST['end_date'] == null ){
                        $e_date = $s_date;
                      }
                      $c = $this->wcbf_bookings_get_total_available_bookings_for_range( $product, strtotime( $s_date ), strtotime($e_date) + 1 );
                      // If the the return result is in integer (Integer value represents # of blocks available for booking)
                      if ( is_int( $c ) ){
                        $product_ids[] = $id;
                      }
                    }
                  }
                }
                        if( $product_ids != null ){
                              /**
                               * Applying price filteration if enabled
                               */
                              if( get_option( 'wcbf_min_price' ) == 'yes' ){
                                      // Checks if minprice and maxprice are set when both are enabled
                                      if( isset( $_POST['min_price'] ) ){
                                              $min_price = sanitize_text_field( $_POST['min_price'] );
                                              if( isset( $_POST['max_price'] ) && $_POST['max_price'] != null ){
                                                      //assigning values
                                                      $max_price = sanitize_text_field( $_POST['max_price'] );
                                                      // a new array init to save product ids which matches our criteria
                                                      $priced_product_array = array();
                                                      //first looping through all products
                                                      foreach( $products as $product ){
                                                              //fetching price of each product
                                                              $price = $product->get_data()['price'];
                                                              //condition says it all
                                                              if( $price >= $min_price && $price <= $max_price ){
                                                                      //pushing all those product in our new array which passes this check
                                                                      array_push( $priced_product_array, $product->get_data()['id'] );
                                                              }
                                                      }
                                                      // takign intersection of our previously time ranged based search array
                                                      // and our new prices search array and assigning in the product_ids array
                                                      $product_ids = $this->product_intersection( $product_ids, $priced_product_array );
                                                      if( $product_ids == null ){
                                                              $query->set( 'page_id', 1);
                                                              return $query;
                                                      }
                                              }
                                              else{
                                                      //if max price not set (CONDITION WHEN END PRICE NOT ENABLED)
                                                      $max_price = $this->get_highest_price_product();
                                                      $priced_product_array = array();
                                                      //first looping through all products
                                                      foreach( $products as $product ){
                                                              //fetching price of each product
                                                              $price = $product->get_data()['price'];
                                                              //condition says it all
                                                              if( $price >= $min_price && $price <= $max_price )
                                                              {
                                                                      //pushing all those product in our new array which passes this check
                                                                      array_push($priced_product_array, $product->get_data()['id'] );
                                                              }
                                                      }
                                                      // takign intersection of our previously time ranged based search array
                                                      // and our new prices search array and assigning in the product_ids array
                                                      $product_ids = $this->product_intersection( $product_ids, $priced_product_array );
                                                      if( $product_ids == null ){
                                                              $query->set( 'page_id', 1 );
                                                              return $query;
                                                      }
                                              }
                                      }

                              }

                              /**
                               * Ratings filteration if enabled
                               */

                              if( get_option( 'wcbf_is_rating_enabled' ) == 'yes' ){
                                      if( isset( $_POST['ratingg'] ) && $_POST['ratingg'] != '0' ){
                                              //assigning values
                                                $selected_rating = sanitize_text_field( $_POST['ratingg'] );
                                              // a new array init to save product ids which matches our criteria
                                              $rating_product_array = array();
                                              //first looping through all products
                                              foreach( $products as $p ){
                                                      //fetching rating of each product
                                                      $ratings = round( $p->get_data()['average_rating'] ) ;
                                                      //condition says it all
                                                      if( $ratings >= $selected_rating ){
                                                              //pushing all those product in our new array which passes this check
                                                              array_push( $rating_product_array, $p->get_data()['id'] );
                                                      }
                                              }
                                              // takign intersection of our previously time ranged + price(optional) based search array
                                              // and our new rating search array and assigning in the product_ids array
                                              $product_ids = $this->product_intersection( $product_ids, $rating_product_array );
                                              if( $product_ids == null ){
                                                      $query->set( 'page_id' , 1 );
                                                      return $query;
                                              }
                                      }
                              }

                              /**
                               * Wordwise filteration if enabled
                               */
                              if( get_option( 'wcbf_is_keyword_search_enabled' ) == 'yes' ){
                                      if( isset( $_POST['wcbf_product_name'] ) && $_POST['wcbf_product_name'] != null ){
                                              $wcbf_product_name = strtolower( sanitize_text_field( $_POST['wcbf_product_name'] ) );
                                              $name_product_array = array();
                                              foreach( $products as $p ){
                                                      //fetching name of each product
                                                      $name = strtolower( $p->get_data()['name'] );
                                                       //Some string processing here for OR search
                                                      $wcbf_submited_name = explode( ' ', $wcbf_product_name );
                                                      $product_name = explode( ' ', $name );
                                                      for( $i = 0 ; $i < count( $wcbf_submited_name ) ; $i++ ){
                                                              for( $j = 0 ; $j < count( $product_name ) ; $j++ ){
                                                                      if( $wcbf_submited_name[$i] == $product_name[$j] ){
                                                                              array_push( $name_product_array, $p->get_data()['id'] );
                                                                      }
                                                                      else{
                                                                          continue;
                                                                      }
                                                              }
                                                      }
                                              }
                                              // taking intersection of our previously time ranged + price(optional) based search array
                                              // and our new OR search array and assigning in the product_ids array
                                              $product_ids = $this->product_intersection( $product_ids, $name_product_array );
                                              if($product_ids == null){
                                                      $query->set( 'page_id', 1 );
                                                      return $query;
                                              }
                                      }
                              }
                              /**
                               * Sets the post id on the shop page, the array containing all th eproduct id's which 
                               * will be shown to the user after they filter the result after their cirteria
                               */
                            $query->set( 'post__in', $product_ids );
                              return $query;
                        }
                        /**
                         * If the result is null or the products id's array is null
                         * it will show the no product found.
                         */
                        else{
                            $query->set( 'page_id', 1 );
                            return $query;
                        }
            }
	    return $query;
        }
        return $query;
    }
    /**
     * Give this function a booking or resource ID, and a range of dates and get back
     * how many places are available for the requested quantity of bookings for all blocks within those dates.
     *
     * Replaces the WC_Product_Booking::get_available_bookings method.
     *
     * @param  WC_Product_Booking | integer $bookable_product Can be a product object or a booking prouct ID.
     * @param  integer $start_date
     * @param  integer $end_date
     * @param  integer|null optional $resource_id
     * @param  integer $qty
     * @return array|int|boolean|WP_Error False if no places/blocks are available or the dates are invalid.
     */
    public function wcbf_bookings_get_total_available_bookings_for_range( $bookable_product, $start_date, $end_date, $resource_id = null, $qty = 1 ) {
      // alter the end date to limit it to go up to one slot if the setting is enabled
      if ( $bookable_product->get_check_start_block_only() ) {
        $end_date = strtotime( '+ ' . $bookable_product->get_duration() . ' ' . $bookable_product->get_duration_unit(), $start_date );
      }
      // Check the date is not in the past
      if ( date( 'Ymd', $start_date ) < date( 'Ymd', current_time( 'timestamp' ) ) ) {
        return false;
      }
      // Check we have a resource if needed
      $booking_resource = $resource_id ? $bookable_product->get_resource( $resource_id ) : null;
      if ( $bookable_product->has_resources() && ! is_numeric( $resource_id ) ) {
        return false;
      }
      $min_date   = $bookable_product->get_min_date();
      $max_date   = $bookable_product->get_max_date();
      $check_from = strtotime( "midnight +{$min_date['value']} {$min_date['unit']}", current_time( 'timestamp' ) );
      $check_to   = strtotime( "+{$max_date['value']} {$max_date['unit']}", current_time( 'timestamp' ) );
      // Min max checks
      if ( 'month' === $bookable_product->get_duration_unit() ) {
        $check_to = strtotime( 'midnight', strtotime( date( 'Y-m-t', $check_to ) ) );
      }
      if ( $end_date < $check_from || $start_date > $check_to ) {
        return false;
      }
      // Get availability of each resource - no resource has been chosen yet
      if ( $bookable_product->has_resources() && ! $resource_id ) {
        return $bookable_product->get_all_resources_availability( $start_date, $end_date, $qty );
      } else {
        // If we are checking for bookings for a specific resource, or have none.
        $check_date     = $start_date;
        while ( $check_date < $end_date ) {
          if ( ! $bookable_product->check_availability_rules_against_date( $check_date, $resource_id ) ) {
            return false;
          }
          if ( $bookable_product->get_check_start_block_only() ) {
            break; // Only need to check first day
          }
          $check_date = strtotime( '+1 day', $check_date );
        }
        // Get blocks availability
        
        return $bookable_product->get_blocks_availability( $start_date, $end_date, $qty, $booking_resource );
      }
   
    }

    /**
     * Function intersection of products
     * @param Array1,Array2
     * @return array
     */
    function product_intersection( $arr1, $arr2 ){
      return array_intersect( $arr1, $arr2 );
    }
    /**
     * Function to include custom script file to this plugin
     * used in jQuery
     */
    function enqueue_custom_script() {
      wp_enqueue_script( 'custom-jQuery', plugins_url('assets/js/admin_view.js', dirname( __FILE__ ) ) );
    } 
    /**
     * Custom function to enqueue scripts
     */
    function enqueue_script_form_valid(){
      wp_enqueue_script( 'jquery-ui-datepicker' );
      wp_enqueue_script( 'jquery-ui-slider' );
      wp_enqueue_script( 'jQuery1', plugins_url( 'assets/js/widget_view.js', dirname( __FILE__ ) ), array( 'jquery' ), null );
      wp_enqueue_script( 'time-picker', plugins_url( 'assets/js/jquery.timepicker.min.js', dirname( __FILE__ ) ) );
      wp_enqueue_script( 'rating', plugins_url( 'assets/js/jquery.barrating.js', dirname( __FILE__ ) ) );
    }
    
      /**
       * Function to add hyperlink on the plugin page below plugin
       */
    function wcbf_plugin_link( $links, $file ) {
        $name = explode( '/', plugin_basename( (__FILE__) ) );
        $dir_with_plugin_name = $name[0].'/woocommerce-booking-filter.php' ;
	    if ( $dir_with_plugin_name == $file ) {
		    $row_meta = array(
			    'wcbf_settings' => '<a target="_self" href=" ' . esc_url( site_url() . '/wp-admin/admin.php?page=wc-settings&tab=settings_tab' ) . '" target="_blank">' . esc_html__( 'Go to Settings Page' ) . '</a>'
		    );
		    return array_merge( $links, $row_meta );
	    }
	    return (array) $links;
    }
        /**
         * Function to add short code on WYSIWYG editor
         * on post/page edit page via button
         */
    function wcbf_btn_shortcode_script(){
      ?>
        <script>
              function InsertContainer() {        
                window.send_to_editor( "[filter]" );
              }
        </script>
      <?php 
    }
      /** 
       * Convert a date format to a jQuery UI DatePicker format  
       * 
       * @param string $dateFormat a date format 
       * @return string 
       */ 
    static function date_format_to_frontend_format( $dateFormat ){
      $chars = array( 
          // Day
          'd' => 'dd', 'j' => 'd', 'l' => 'DD', 'D' => 'D',
          // Month 
          'm' => 'mm', 'n' => 'm', 'F' => 'MM', 'M' => 'M', 
          // Year 
          'Y' => 'yy', 'y' => 'y', 
      );
      return strtr( (string) $dateFormat, $chars ); 
    }
	  /**
	   * @param string $word_date
	   * Converts numeric string of time from Alphabetical string of date
	   * @return false|string
	   */
    static function word_date_to_numeric_date( $word_date ){
        $t_stamp = strtotime( $word_date );
	return date( 'Y-m-d', $t_stamp );
    }
	  /**
	   * Function to load overidden class
	   */
    function wcbf_class_loader(){
	    include WCBF_ABSPATH . 'includes/wcbf-booking-override.php';
    }
}