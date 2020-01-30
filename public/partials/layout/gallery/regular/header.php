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


.flexi_effect {
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
	position: relative;
}

/* Caption */


#flexi_title{
	overflow: hidden;
}

/* Caption style */


/* Style 1 */
.flexi_caption_1 {
  position: absolute;
  bottom: 30px;
  right: 50px;
  z-index: 2;
  width: 90%;
  height: 20px;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .5s;
  color: #fff;
  margin-right: -30px;
  text-align: center;
}
.flexi_caption_1 h3 {
  font-size: 18px;

}
.flexi_caption_1 p {
display:none;
}
.flexi_gallery_child:hover .flexi_caption_1 {
  right: 150%;
}



/* Style 2 */
.flexi_caption_2 {
  position: absolute;
  top: -100%;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  opacity: 1;
  text-align: center;

}
.flexi_caption_2 h3 {
	padding: 2px 0 0;
  color: #fff;
  font-size: 24px;
  font-family: 'Open Sans', sans-serif;
  font-weight: 600;
}
.flexi_caption_2 p {

	color: #fff;
	font-family: 'Open Sans', sans-serif;
}
.flexi_gallery_child:hover .flexi_caption_2 {
  top: 0;
  left: 0;
}

/* Style 3 */
.flexi_caption_3 {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  opacity: 0;
}
.flexi_caption_3 h3,
.flexi_caption_3 p {
  position: absolute;
  left: -100%;
  width: 260px;
  padding: 0;
  text-align: left;
  -webkit-transition: .3s;
  transition: .3s;
  padding: 2px 0 0;
  color: #fff;
  font-size: 24px;
  font-family: 'Open Sans', sans-serif;
  font-weight: 600;
}
.flexi_caption_3 h3 {
  top: 30px;
}
.flexi_caption_3 p {
  top: 75px;
  font-size: 12px;
}
.flexi_gallery_child:hover .flexi_caption_3 {
  opacity: 1;
}
.flexi_gallery_child:hover .flexi_caption_3 h3,
.flexi_gallery_child:hover .flexi_caption_3 p {
  left: 20px;
}
.flexi_gallery_child:hover .flexi_caption_3 h3 {
  -webkit-transition-delay: .2s;
  transition-delay: .2s;
}
.flexi_gallery_child:hover .flexi_caption_3 p {
  -webkit-transition-delay: .5s;
  transition-delay: .5s;
}

/* Style 4 */

.flexi_caption_4 {
  position: absolute;
  bottom: -60px;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 40px;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  text-align: center;
}
.flexi_caption_4 h3 {
  padding: 2px 0 0;
  color: #fff;
  font-size: 24px;
  font-family: 'Open Sans', sans-serif;
  font-weight: 600;
}

.flexi_gallery_child:hover .flexi_caption_4 {
  bottom: 0;
}

/* Style 5 */

.flexi_caption_5 h3,
.flexi_caption_5 p {
  position: absolute;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 40px;
  line-height: 40px;
  padding: 0;
  background: rgba(0,0,0,.6);
  color: #fff;
  text-align: center;
  -webkit-transition: .3s;
  transition: .3s;
}
.flexi_caption_5 h3 {
  top: -80px;
  font-size: 18px;
}
.flexi_caption_5 p {
  bottom: -80px;
  font-size: 13px;
}
.flexi_gallery_child:hover .flexi_caption_5 h3 {
  top: 0;
  font-size: 18px;
  padding: 0px 0 5px;
}
.flexi_gallery_child:hover .flexi_caption_5 p {
  bottom: -30px;
}

    </style>
<div id="flexi_gallery">
<div class="pure-g" id="flexi_main_loop">
