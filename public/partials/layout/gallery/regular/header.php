<style>

/* Blur */
#blur img {
	-webkit-filter: blur(3px);
	filter: blur(3px);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.flexi_gallery_child:hover #blur img {
	-webkit-filter: blur(0);
	filter: blur(0);
}

/* Gray Scale */
#gray img {
	-webkit-filter: grayscale(0);
	filter: grayscale(0);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.flexi_gallery_child:hover #gray img {
	-webkit-filter: grayscale(100%);
	filter: grayscale(100%);
}

/* Zoom In #1 */
#zoom img {
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;

}
.flexi_gallery_child:hover #zoom img {
	-webkit-transform: scale(1.3);
	transform: scale(1.3);
}

figure {
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
}


.caption {
  position: absolute;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  width: 100%;
  transition: .5s ease-out;
  opacity:0;
  color: white;
  font-size: 20px;
  padding: 20px;
  text-align: center;
}

.flexi_gallery_child:hover .caption {
  opacity: 1;
}

    </style>
<div id="flexi_gallery">
<div class="pure-g" id="flexi_main_loop">
