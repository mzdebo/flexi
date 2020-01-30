<style>
.masonry-wrapper {
  padding: 1.5em;
  max-width: 960px;
  margin-right: auto;
  margin-left: auto;
}
.masonry {
  columns: 1;
  column-gap: 1px;
}
.masonry-item {
  display: inline-block;
  vertical-align: top;
  margin-bottom: 1px;
}
@media only screen and (max-width: 1023px) and (min-width: 768px) {  .masonry {
    columns: 2;
  }
}
@media only screen and (min-width: 1024px) {
  .masonry {
    columns: 5;
  }
}
.masonry-item, .masonry-content {
  border-radius: 4px;
  overflow: hidden;
}

</style>
<?php
$i = 0;
?>
<div id="flexi_gallery">
        <div class="masonry" id="flexi_main_loop">
