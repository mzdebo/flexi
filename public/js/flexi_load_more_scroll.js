//Load more button
jQuery(document).ready(function() {
  var paged = 1;
  var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
    bottomOffset = 2000; // the distance (in px) from the page bottom when you want to load more posts

  jQuery(window).scroll(function(e) {
    e.preventDefault();
    gallery_layout = jQuery("#gallery_layout").text();
    popup = jQuery("#popup").text();
    max_paged = jQuery("#max_paged").text();
    album = jQuery("#album").text();
    search = jQuery("#search").text();
    postsperpage = jQuery("#postsperpage").text();
    orderby = jQuery("#orderby").text();
    user = jQuery("#user").text();
    keyword = jQuery("#keyword").text();
    reset = jQuery("#reset").text();

    if (reset == "true") {
      paged = 1;
      jQuery("#flexi_main_loop").empty();
    }
    if (
      jQuery(document).scrollTop() > jQuery(document).height() - bottomOffset &&
      canBeLoaded == true
    ) {
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: {
          action: "flexi_load_more",
          max_paged: paged,
          gallery_layout: gallery_layout,
          popup: popup,
          album: album,
          search: search,
          postsperpage: postsperpage,
          orderby: orderby,
          user: user,
          keyword: keyword
        },
        beforeSend: function() {
          //alert("about to send");
          jQuery("#flexi_load_more").slideUp();
          jQuery("#flexi_loader").show();
          // you can also add your own preloader here
          // you see, the AJAX call is in process, we shouldn't run it again until complete
          canBeLoaded = false;
        },
        success: function(response) {
          jQuery("#flexi_main_loop").append(response.msg);
          canBeLoaded = true; // the ajax is completed, now we can run it again
          paged++;

          //alert(max_paged + "--" + paged);
        },
        complete: function(data) {
          // Hide image container
          jQuery("#flexi_loader").hide();

          jQuery("#flexi_no_record").hide();
          // alert("response complete");
          if (paged > max_paged) {
            //Stop scrolling. No more post left.
            canBeLoaded = false;
          }
        }
      });
    }
  });
});
