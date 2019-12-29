//Toggle submission form
jQuery(document).ready(function() {
  jQuery("#flexi_submit_form").click(function(e) {
    jQuery("#flexi_toggle_form").slideToggle("slow");
  });
});

//Load more button
jQuery(document).ready(function() {
  var paged = 1;

  jQuery(".flexi_load_more").click(function(e) {
    e.preventDefault();
    //gallery_layout = jQuery(this).attr("gallery_layout");
    //popup = jQuery(this).attr("popup");
    gallery_layout = jQuery("#gallery_layout").text();
    popup = jQuery("#popup").text();
    max_paged = jQuery("#max_paged").text();
    reset = jQuery("#reset").text();

    if (reset == "true") {
      paged = 1;
      jQuery("#flexi_main_loop").empty();
    }

    jQuery.ajax({
      type: "post",
      dataType: "json",
      url: myAjax.ajaxurl,
      data: {
        action: "flexi_load_more",
        paged: paged,
        gallery_layout: gallery_layout,
        popup: popup
      },
      beforeSend: function() {
        //alert("about to send");
        jQuery("#flexi_load_more").slideUp();
        jQuery("#flexi_loader").show();
      },
      success: function(response) {
        jQuery("#flexi_main_loop").append(response.msg);
        paged++;

        //alert(max_paged + "--" + paged);
      },
      complete: function(data) {
        // Hide image container
        jQuery("#flexi_loader").hide();
        jQuery("#flexi_load_more").slideDown();
        jQuery("#flexi_no_record").hide();
        // alert("response complete");
        if (paged > max_paged) jQuery("#flexi_load_more").slideUp();
      }
    });
  });
});
