jQuery(document).ready(function() {
  jQuery(".ldups-learndash-select2").select2({ allowHtml: true });

  var ldupsAlertTitle = ldups_data.ldups_free_to_pro_alert_title;
  var ldupsAlertMessage = ldups_data.ldups_free_to_pro_alert_messgae;
  var ldupsUpgradeNow = ldups_data.ldups_free_to_pro_upgrade;
  // redirect to same page after rating is done.
  jQuery(".ldups_hide_rate").click(function (event) {
    event.preventDefault();
    jQuery.ajax({
      method: 'POST',
      url: ldups_data.ajaxurl,
      data: {
        action: 'ldups_update',
        nonce: ldups_data.nonce,
      },
      success: (res) => {
        window.location.href = window.location.href
      }
    });
  });

  // Free to pro upgrade js 
  jQuery('label[for="ldups_upsells_plugin_type-woocom"]').append("<span class ='ldups-pro-alert' style='padding-left:5px;'>Pro</span>");
  jQuery('label[for="ldups_upsells_plugin_type-edd"]').append("<span class ='ldups-pro-alert' style='padding-left:5px;'>Pro</span>"); 
  jQuery('label[for="ldups_upsells_showmore_enabled"]:first').append("<span class ='ldups-pro-alert'>Pro</span>");
  jQuery('label[for="ldups_upsells_widget_position"]:first').append("<span class ='ldups-pro-alert'>Pro</span>");
  jQuery('label[for="ldups_upsells_wocom_upsells_option"]:first').append("<span class ='ldups-pro-alert'>Pro</span>");
  jQuery('label[for="ldups_upsells_edd_upsells_enable"]:first').append("<span class ='ldups-pro-alert'>Pro</span>");
  jQuery('#ldups_upsells_plugin_type-woocom, #ldups_upsells_plugin_type-edd , #ldups_upsells_widget_position, #ldups_upsells_wocom_upsells_option, #ldups_upsells_showmore_enabled , #ldups_upsells_edd_upsells_enable').prop('disabled', true);
  jQuery('#ldups_upsells_plugin_type-standalone').attr('checked', true);
  jQuery('label[for="ldups_upsells_plugin_type-woocom"], label[for="ldups_upsells_plugin_type-edd"], label[for="ldups_upsells_showmore_enabled"]:first, label[for="ldups_upsells_widget_position"]:first, label[for="ldups_upsells_wocom_upsells_option"]:first, label[for="ldups_upsells_edd_upsells_enable"]:first, #ldups_upsells_widget_position_field .sfwd_option_input .sfwd_option_div .ld-select').click(function () {
    
    var ldupsUpgradeNow = ldups_data.ldups_free_to_pro_upgrade;
    var lineOne = ldups_data.ldups_free_to_pro_popup_line_one;
    var lineTwo = ldups_data.ldups_free_to_pro_popup_line_two;
    var lineThree = ldups_data.ldups_free_to_pro_popup_listing_one_bold;
    var lineFour = ldups_data.ldups_free_to_pro_popup_listing_one;
    var lineFive = ldups_data.ldups_free_to_pro_popup_listing_two_bold;
    var lineSix = ldups_data.ldups_free_to_pro_popup_listing_two;
    var lineSeven = ldups_data.ldups_free_to_pro_popup_listing_three_bold;
    var lineEight = ldups_data.ldups_free_to_pro_popup_listing_three;
    Swal.fire({
      title: '<div class="pro-alert-header"> Pro Field Alert! </div>',
      showCloseButton: true,
      html: '<div class="pro-crown"><svg xmlns="http://www.w3.org/2000/svg" height="100" width="100" viewBox="0 0 640 512"><path fill="#f8c844" d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5 .4 5.1 .8 7.7 .8 26.5 0 48-21.5 48-48s-21.5-48-48-48z"/></svg></div><div class="popup-text-one">' + lineOne + '</div><div class="popup-text-two">' + lineTwo + '</div> <ul><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> <b>' + lineThree + '</b>'+ lineFour +'</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg><b>' + lineFive + '</b>' + lineSix + '</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg><b>'+ lineSeven +'</b>' + lineEight + '</li> </ul>' + '<button class="ldups-upgrade-now" style="border: none"><a href="https://www.saffiretech.com/upsells-for-learndash/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=ldups" target="_blank" class="purchase-pro-link">'+ldupsUpgradeNow+'</a></button>',
      customClass: "ldups-popup",
      showConfirmButton: false,
    });

    jQuery( '.ldups-popup' ).css('width', '800px');
    jQuery( '.ldups-popup > .swal2-header').css('background', '#061727' );
    jQuery( '.ldups-popup > .swal2-header').css('margin', '-20px' );
    jQuery( '.pro-alert-header' ).css('padding-top', '25px' );
    jQuery( '.pro-alert-header' ).css('padding-bottom', '20px' );
    jQuery( '.pro-alert-header' ).css( 'color', 'white' );
    jQuery( '.pro-crown' ).css( 'margin-top', '20px' );
    jQuery( '.popup-text-one').css( 'font-size', '30px' );
    jQuery( '.popup-text-one' ).css( 'font-weight', '600' );
    jQuery( '.popup-text-one' ).css( 'padding-bottom', '10px' );
    jQuery( '.ldups-popup > .swal2-content > .swal2-html-container > ul ' ).css( 'text-align', 'justify' );
    jQuery( '.ldups-popup > .swal2-content > .swal2-html-container > ul ' ).css( 'padding-left', '25px' );
    jQuery( '.ldups-popup > .swal2-content > .swal2-html-container > ul ' ).css( 'padding-right', '25px' );
    jQuery( '.ldups-popup > .swal2-content > .swal2-html-container > ul ' ).css( 'line-height', '2em' );
    jQuery( '.popup-text-two' ).css( 'padding', '10px' );
    jQuery( '.popup-text-two' ).css( 'font-weignt', '500');
    jQuery( '.ldups-popup > .swal2-content > .swal2-html-container > ul, .popup-text-one, .popup-text-two').css('color', '#061727' );

  })
  
  jQuery('.ldups-footer-upgrade').insertAfter('#post-body');
});
