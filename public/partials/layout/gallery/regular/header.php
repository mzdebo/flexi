<style>
    /* Image Frame */
.flexi_image_frame {
  border-radius: 0px;
  border: 0px solid #ddd;
  -moz-transition: all 0.5s;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
}

.flexi_image_frame:hover {
    -moz-transition: all 0.5s;
  -webkit-transition: all 0.5s;
  transition: all 0.5s;
    /*Zoom on hover*/
  -moz-transform: scale(0.9);
  -webkit-transform: scale(0.9);
  transform: scale(0.9);
  /* Image border on hover */
  border: 0px solid #ddd;
  /* Image radius on hover */
  border-radius: 0px;

  /* Opacity */
  opacity: 0.5;

  /* grayscale */
  -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
  filter: grayscale(100%);

}
/* title over image text */
.flexi_middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%)

}
.flexi_gallery_child:hover .flexi_middle {
  opacity: 1;
}

.flexi_title {
  background-color: #4CAF50;
  color: white;
  font-size: 16px;
  padding: 16px 32px;
}

    </style>
<div id="flexi_gallery">
<div class="pure-g" id="flexi_main_loop">
