<?php

/**
 * Widget Styles
 * @author Osmar Matos <osmar@lemonjuicewebapps.com>
 * @author Vitor Rigoni <vitor@lemonjuicewebapps.com>
 */

header("Content-Type: text/css");
require_once( '../../../../wp-load.php' );
$w = new LemonNewsWidget();
$data = $w->getSelectedStyle();

if (empty($data)) exit;

if ($data['slug'] == 'CustomCss') {
	$css = get_option( 'lemon_news_custom_styles' );
	echo $css;
	die;
}

extract($data);

?>
#lemon-news-wrapper {
	height: 80px;
}

.lemon-news {
	position: relative;
	width: 100%;
	margin-bottom: 3px !important;
}

.lemon-news-wrapper {
	position: relative;
}

.lemon-news-help {
	margin-bottom: 3px;
}

.lemon-news-email {
	<?php if ($roundBorder == true): ?>
	border-radius: 4px !important;
	<?php else: ?>
	border-radius: 0 !important;
	<?php endif ?>
	border: 1px solid #CCC;
	float: left;
	height: 20px !important;
	width: 70%;
	box-shadow: none !important;
	transition: 100ms all ease;
	-o-transition: 100ms all ease;
	-moz-transition: 100ms all ease;
	-webkit-transition: 100ms all ease;
}

.lemon-news-email:focus {
	height: 18px;
	border-bottom: 3px solid <?php echo $color; ?> !important;
	border-color: <?php echo $color; ?> !important;
	box-shadow: none !important;
	transition: 100ms all ease;
	-o-transition: 100ms all ease;
	-moz-transition: 100ms all ease;
	-webkit-transition: 100ms all ease;
}

.lemon-news-send {
	background: <?php echo $color; ?>;
	<?php if ($roundBorder == true): ?>
	border-radius: 4px !important;
	<?php else: ?>
	border-radius: 0 !important;
	<?php endif; ?>
	box-shadow: none !important;
	border: none;
	color: #fff;
	float: right;
	padding: 7px;
	margin: 0 0 0 -1px;
	width: 24%;
	display: block;
	height: 30px !important;
    line-height: 18px;
    text-shadow: none !important;
	transition: 100ms all ease;
	-o-transition: 100ms all ease;
	-moz-transition: 100ms all ease;
	-webkit-transition: 100ms all ease;
}

.lemon-news-send:hover {
	cursor: pointer;
	background: <?php echo $hover; ?>;
	color: white !important;
	transition: 100ms all ease;
	-o-transition: 100ms all ease;
	-moz-transition: 100ms all ease;
	-webkit-transition: 100ms all ease;
} 

.lemon-news-send:active {
	box-shadow: 0 2px 3px rgba(0,0,0, 0.3) inset;
	color: white !important;
}

.lemon-news-feedback {
	<?php if ($roundBorder == true): ?>
	border-radius: 4px !important;
	<?php else: ?>
	border-radius: 0 !important;
	<?php endif ?>
	position: absolute;
	text-align: center;
	z-index: 10;
	margin-top: -35px !important;
	opacity: 0;
	min-width: 100px;
	padding: 5px;
	color: white;
	transition: 100ms all ease;
	-o-transition: 100ms all ease;
	-moz-transition: 100ms all ease;
	-webkit-transition: 100ms all ease;
}

.lemon-news-feedback:after {
	top: 100%;
	border: solid transparent;
	content: " ";
	height: 0;
	width: 0;
	position: absolute;
	pointer-events: none;
	border-width: 4px;
	left: 50%;
	margin-left: -4px;
}

.error {
	opacity: 1;
	background: #BD362F;
}

.error:after {
	border-top-color: #BD362F;
}

.success {
	opacity: 1;
	background: #8BA022;
}

.success:after {
	border-top-color: #8BA022;
}

.warning {
	opacity: 1;
	background: #DA8E09;
}

.warning:after {
	border-top-color: #DA8E09;
}
