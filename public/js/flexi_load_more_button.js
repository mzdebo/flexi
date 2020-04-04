//Toggle submission form
jQuery(document).ready(function () {
  jQuery("#flexi_submit_form").click(function (e) {
    jQuery("#flexi_toggle_form").slideToggle("slow");
  });
});

//Load more button
jQuery(document).ready(function () {
  var paged = 1;
  var count = 0;

  jQuery(".flexi_load_more").click(function (e) {
    e.preventDefault();
    gallery_layout = jQuery("#gallery_layout").text();
    popup = jQuery("#popup").text();
    padding = jQuery("#padding").text();
    hover_effect = jQuery("#hover_effect").text();
    hover_caption = jQuery("#hover_caption").text();
    column = jQuery("#column").text();
    max_paged = jQuery("#max_paged").text();
    album = jQuery("#album").text();
    search = jQuery("#search").text();
    postsperpage = jQuery("#postsperpage").text();
    orderby = jQuery("#orderby").text();
    user = jQuery("#user").text();
    keyword = jQuery("#keyword").text();
    reset = jQuery(this).attr("data-reset");

    if (reset == "true") {
      paged = 1;
      count = 0;
      jQuery("#flexi_main_loop").empty();
    }

    jQuery.ajax({
      type: "post",
      dataType: "json",
      url: myAjax.ajaxurl,
      data: {
        action: "flexi_load_more",
        max_paged: paged,
        gallery_layout: gallery_layout,
        popup: popup,
        padding: padding,
        hover_effect: hover_effect,
        hover_caption: hover_caption,
        column: column,
        album: album,
        search: search,
        postsperpage: postsperpage,
        orderby: orderby,
        user: user,
        keyword: keyword,
      },
      beforeSend: function () {
        //alert("about to send");
        jQuery("#flexi_load_more").slideUp();
        jQuery("#flexi_loader").show();
      },
      success: function (response) {
        jQuery("#flexi_main_loop").append(response.msg).fadeIn("normal");
        paged++;
        count = response.count;

        //alert(max_paged + "--" + paged);
      },
      complete: function (data) {
        // Hide image container
        jQuery("#flexi_loader").hide();
        jQuery("#flexi_load_more").slideDown();

        // alert("response complete");
        // alert(count);
        if (count > 0) jQuery("#flexi_no_record").hide();
        if (paged > max_paged) jQuery("#flexi_load_more").slideUp();
      },
    });
  });
});
