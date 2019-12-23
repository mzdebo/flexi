<style>
  /* (item margins = 5) */
  .flexi_masonry {
    -webkit-column-width: 150px;
    -moz-column-width: 150px;
    column-width: 150px;
    /* same with bottom margin for the items */
    -webkit-column-gap: 5px;
    -moz-column-gap: 5px;
    column-gap: 5px;
  }

  .flexi_masonry img {
    display: block;
    /* expand! */
    width: 100%;
    height: auto;
    background-color: silver;
    /* bottom margin */
    margin: 0 0 1px 0;
  }

  .flexi_hover-zoom {
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
  }

  .flexi_hover-zoom:hover {
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    transform: scale(0.9);
    border: 0;
  }

  flexi_figcaption {
    display: none;
  }
</style>
<script>
  jQuery(document).ready(function() {
    jQuery('[data-fancybox]').fancybox({
      caption: function(instance, item) {
        return jQuery(this).find('flexi_figcaption').html();
      }
    });
  });
</script>
<?php
do_action("flexi_grip_top");
?>

<div id="flexi_gallery">
  <flexi>
    <div class='flexi_masonry'>