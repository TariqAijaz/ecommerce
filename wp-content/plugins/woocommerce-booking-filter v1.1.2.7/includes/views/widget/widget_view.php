<?php
   /**
    * retreiving the value from main class
    */
   $filter_settings                = WCBF_Main::get_filter_settings();
   $type                           = $filter_settings['wcbf_search_type'];
   $startdate                      = $filter_settings['wcbf_text_from'];
   $enddate                        = $filter_settings['wcbf_text_to'];
   $checker                        = $filter_settings['wcbf_is_end_date_enabled'];
   $time_true                      = $filter_settings['wcbf_is_time_enabled'];
   $start_time                     = $filter_settings['wcbf_time_from'];
   $end_time                       = $filter_settings['wcbf_time_to'];
   $wcbf_fuzzy_time_en             = $filter_settings['wcbf_fuzzy_time_en'];
   $wcbf_fuzzy_end_time            = $filter_settings['wcbf_fuzzy_end_time'];
   $date_format                    = $filter_settings['date_format'];
   $time_format                    = $filter_settings['time_format'];
   $wcbf_min_price                 = $filter_settings['wcbf_min_price'];
   $wcbf_min_price_text            = $filter_settings['wcbf_min_price_text'];
   $wcbf_max_price                 = $filter_settings['wcbf_max_price'];
   $wcbf_is_rating_enabled         = $filter_settings['wcbf_is_rating_enabled'];
   $wcbf_rating_text               = $filter_settings['wcbf_rating_text'];
   $wcbf_keyword_search_text       = $filter_settings['wcbf_keyword_search_text'];
   $wcbf_is_keyword_search_enabled = $filter_settings['wcbf_is_keyword_search_enabled'];
   /**
    * Values for Required Field validation
    */
   $rf_s_date = $filter_settings['wcbf_rf_s_date'];
   $rf_e_date = $filter_settings['wcbf_rf_e_date'];
   $rf_s_time = $filter_settings['wcbf_rf_s_time'];
   $rf_e_time = $filter_settings['wcbf_rf_e_time'];
   /**
    * retaining values after search
    * and redirection
    */
   if (isset($_POST['start_date'])){
       $s_date = $_POST['start_date'];
   }
       
   if (isset($_POST['end_date'])){
       $e_date = $_POST['end_date'];
   }
   
   if (isset($_POST['strt_time'])){
       $s_time = $_POST['strt_time'];
   }
       
   if (isset($_POST['en_time'])){
        $e_time = $_POST['en_time'];
   }
      
   
   // Retrieves highest price of product
   $highest_price = WCBF_Main::get_highest_price_product();
   
   /**
    * applying custom filter/hooks
    */
   $custom_css_class = null;
   $custom_css = apply_filters('WCBF_add_custom_css_class', $custom_css_class);
   $custom_text_bottom = null;
   $custom_text_bottom = apply_filters('WCBF_add_custom_text_on_bottom', $custom_text_bottom);
   
   /**
    * Today Date
    */
   function get_today() {
       return date("Y-m-d");
   }
   ?>
<head>
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js" integrity="sha256-0IXY0aA9BMZHp1azQSgmyQTG4+8NwTeDlKmjpQYrcXs=" crossorigin="anonymous"></script>
   <style>
      <?php
         echo include WCBF_ABSPATH . 'assets/css/widget_view.css';
         ?>
   </style>
</head>
<div class="WCBF-widget-wrapper <?php esc_html_e( $custom_css ); ?>">
<input type="hidden" value="<?php esc_html_e( $date_format ); ?>"/>
<div class="WCBF_widget_head ">
   <h3>Filter Available Bookings</h3>
</div>
<hr>
<div>
   <form action="<?php echo site_url() . '/shop/' ?>" method="POST" name="filter_criteria" id="filter_critera">
      <div class="major_div">
         <label><?php esc_html_e(  $startdate );
            if (isset($rf_s_date)) {
                if ($rf_s_date == 'yes') echo '&nbsp <span style="color:red;">*</span>';
            } ?></label>
         <input name="start_date" placeholder="Place your Start Date here" readonly="readonly"  autocomplete="off" min=<?php echo get_today(); ?>  id="start_date" type="text"  value="<?php if ( isset( $s_date ) ) esc_html_e( $s_date ); else echo get_today(); ?>"  />
         <label id="sd-td"></label>
      </div>
      <?php if ($checker == 'yes'): ?>
      <div class="major_div">
         <label>
         <?php esc_html_e( $enddate );
            if (isset($rf_s_date)) {
                if ($rf_e_date == 'yes') echo '&nbsp <span style="color:red;">*</span>';
            } ?>
         </label>
         <input name="end_date" readonly="readonly" placeholder="Place your End Date here" autocomplete="off"  min=<?php echo get_today(); ?> id="end_date" type="text" value="<?php if ( isset( $e_date ) ) esc_html_e( $e_date ); ?>" />
         <label id="ed-td"></label>
      </div>
      <?php endif; ?>
      <?php if ($wcbf_fuzzy_time_en == 'yes'): ?>
      <div class="major_div">
         <label>
         <?php esc_html_e( $start_time );
            if (isset($rf_s_date)) {
                if ($rf_s_time == 'yes') echo '&nbsp <span style="color:red;">*</span>';
            } ?>
         </label>
         <input name="strt_time"   autocomplete="off" id="strt_time" placeholder="Place your Start Time here" data-time-format="<?php esc_html_e( $time_format ); ?>"  type="text"  value="<?php if ( isset( $s_time ) ) esc_html_e( $s_time ); ?>"  />
         <label id="st-td"></label>
      </div>
      <?php if ($wcbf_fuzzy_end_time == 'yes'): ?>
      <div class="major_div">
         <label>
         <?php esc_html_e( $end_time );
            if (isset($rf_s_date)) {
                if ($rf_e_time == 'yes') echo '&nbsp <span style="color:red;">*</span>';
            } ?>
         </label>
         <input name="en_time" placeholder="Place your End Time here" autocomplete="off"  id="en_time" type="text"  data-time-format="<?php esc_html_e( $time_format ); ?>" value="<?php if ( isset( $e_time ) ) esc_html_e( $e_time ); ?>"  />
         <label id="et-td"></label>
      </div>
      <?php endif; ?>
      <?php endif; ?>
      <?php if ( $wcbf_min_price == 'yes' ): ?>
      <?php if ( $wcbf_max_price == 'yes' ) { ?>
      <div class="major_div">
         <label><?php esc_html_e( $wcbf_min_price_text ); ?></label>
         <p>
            <input type="text" id="amount1" readonly >
         </p>
         <div id="wrapper-slider">
            <div id="slider-range"></div>
         </div>
      </div>
      <?php } else { ?>
      <div class="major_div">
         <label><?php esc_html_e( $wcbf_min_price_text ); ?></label>
         <p>
            <input type="text" id="amount" readonly>
         </p>
         <div id="wrapper-slider">
            <div id="slider"></div>
         </div>
      </div>
      <?php } ?>
      <?php endif; ?>
      <?php if ($wcbf_is_rating_enabled == 'yes'): ?>
      <div class="major_div">
         <label><?php esc_html_e( $wcbf_rating_text ); ?></label>
         <div>
            <div id="wcbf-rating" class="major_div">
               <div id="rating5">
                  <input type="radio" name="ratingg" value="5" <?php $ratingg = "0";
                     if (isset($_POST['ratingg'])) $ratingg = $_POST['ratingg'];
                     if ($ratingg == '5') {
                         esc_html_e( 'checked="checked"' );
                     } ?>>
                  <?php $i = 1;
                     while ($i <= 5): ?>
                  <div class="circle-fill" id="rat"></div>
                  <?php $i++;
                     endwhile; ?>
               </div>
               <div id="rating4">
                  <input type="radio" name="ratingg" value="4"  <?php $ratingg = "0";
                     if (isset($_POST['ratingg'])) $ratingg = $_POST['ratingg'];
                     if ($ratingg == '4') {
                         esc_html_e( 'checked="checked"' );
                     } ?>>
                  <?php $i = 1;
                     while ($i <= 4): ?>
                  <div class="circle-fill" id="rat"></div>
                  <?php $i++;
                     endwhile; ?>
                  <div class="circle-null" id="rat"> </div>
                  & up
               </div>
               <div id="rating3">
                  <input type="radio" name="ratingg" value="3" <?php $ratingg = "0";
                     if (isset($_POST['ratingg'])) $ratingg = $_POST['ratingg'];
                     if ($ratingg == '3') {
                         esc_html_e( 'checked="checked"' );
                     } ?>>
                  <?php $i = 1;
                     while ($i <= 3): ?>
                  <div class="circle-fill" id="rat"></div>
                  <?php $i++;
                     endwhile; ?>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  & up
               </div>
               <div id="rating2">
                  <input type="radio" name="ratingg" value="2" <?php $ratingg = "0";
                     if (isset($_POST['ratingg'])) $ratingg = $_POST['ratingg'];
                     if ($ratingg == '2') {
                         esc_html_e( 'checked="checked"' );
                     } ?>>
                  <?php $i = 1;
                     while ($i <= 2): ?>
                  <div class="circle-fill" id="rat"></div>
                  <?php $i++;
                     endwhile; ?>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  & up
               </div>
               <div id="rating1">
                  <input type="radio" name="ratingg" value="1"  <?php $ratingg = "0";
                     if (isset($_POST['ratingg'])) $ratingg = sanitize_text_field( $_POST['ratingg'] );
                     if ($ratingg == '1') {
                         esc_html_e( 'checked="checked"' );
                     } ?>>
                  <div class="circle-fill" id="rat"></div>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  <div class="circle-null" id="rat"> </div>
                  & up
               </div>
               <input type="button" id="reset-rating-button" value="Clear">
            </div>
         </div>
         <?php endif; ?>
         <?php if ($wcbf_is_keyword_search_enabled == 'yes'): ?>
         <div class="major_div">
            <label><?php esc_html_e( $wcbf_keyword_search_text ); ?></label>
            <input name="wcbf_product_name" id="wcbf_product_name" type="text" placeholder="Enter name" value="<?php if (isset($_POST['wcbf_product_name'])) esc_html_e( sanitize_Text_field( $_POST['wcbf_product_name'] ) ); ?>"  />
         </div>
         <?php endif; ?>
         <div class="major_div">
            <input name="filter" id="sub" type="submit" value="Filter" />
            <input name="reset" id="reset" type="button" value="Reset Fields" /><br><i><?php esc_html_e( $custom_text_bottom ) ?></i>
         </div>
         <input type="hidden" id="RFV_settings" name="RFV_settings" value="<?php echo $rf_s_date . '-' . $rf_e_date . '-' . $rf_s_time . '-' . $rf_e_time ?>"/>
         <input type="hidden" name="action" value="filter_result" />
         <input type="hidden" id="highest_price" name="highest_price" value="<?php echo $highest_price; ?>" />
         <input type="hidden" id="min_price" name="min_price" value="<?php if (isset($_POST['min_price'])) esc_html_e( sanitize_text_field( $_POST['min_price'] ) );
            else esc_html_e( sanitize_text_field( '1' ) ); ?>" />
         <?php wp_nonce_field('get_filtered_results'); ?>
         <input type="hidden" id="max_price" name="max_price" value="<?php if (isset($_POST['max_price'])) esc_html_e( sanitize_text_field(  $_POST['max_price'] ) );
            else esc_html_e( sanitize_text_field(  $highest_price ) ); ?>" />
         <input type="hidden" id="currency" value="<?php esc_html_e( get_woocommerce_currency_symbol() ); ?>" />
   </form>
   </div>
</div>

