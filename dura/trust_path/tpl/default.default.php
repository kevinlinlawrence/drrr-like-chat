
<?php $this->extend('theme');?>

<?php $this->set('html.title', t(DURA_TITLE).' | '.t(DURA_SUBTITLE));?>

	<style>
.main-box {
	margin: auto;
	max-width: 620px;
	padding: 15px;
}
#page_default .ui-content form > *, #page_default .ui-content > * {
	margin-left: auto;
	margin-right: auto;
	text-align: center;
}
#page_default .ui-content form fieldset {
	margin-left: auto;
	margin-right: auto;
	max-width: 300px;
}
#icons {
	margin-left: auto;
	margin-right: auto;
	max-width: 288px !important;
}
#icons .ui-btn-inner {
	padding: 1px;
}
#icons .icon {
	vertical-align: middle;
}
#icons .ui-radio {
	margin: 5px;
}
.copyright {
	/*
	display: inline;
	display: inline-block;
	*/
	    clear: both;
	color: #8A8A8A;
	font-size: 10px;
	margin: 10px 0;
	text-align: center;
}
#profile div.ui-block-a {
	width: 70%;
	font-weight: normal;
}
#profile div.ui-block-a span {
	font-size: 20px;
	min-width: 50px;
}
#profile div.ui-block-a * {
	vertical-align: middle;
}
#message {
	font-weight: normal;
	padding-top:0px;
	padding-bottom:0px;
}
#message .user {
	font-size: 13px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
	width: 90px;
}
#message .user * {
	font-size: 13px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
	text-align: center;
}
#message .ui-block-b {
	width: 75%;
}
#message .menu {
	text-align: right;
}
#message textarea {
	width: 90%;
}
#page_room .ui-content {
	padding: 0px;
}
#page_room .ui-header {
	border-color: #EEEEEE;
}
.dura-btn-submit {
	text-align: center;
	width: 95%;
}
.dura-btn-submit .ui-btn {
	border-width: 2px;
	min-width: 200px;
}
.dura-btn-submit .ui-btn-inner {
	border-top-width: 1px;
	padding-bottom: 0;
	padding-top: 0;
}
#talks dt, #talks dd {
	margin: 0px;
}
#talks {
}
#talks div.system {
	margin: 10px 0 10px 20px;
	letter-spacing: 3px;
	clear: left;
}
dl.talk {
	clear: both;
	min-height: 80px;/*margin-top: 10px;*/
	}
dl.talk dt {
	min-height: 20px;
	width: 90px;
	padding-top: 58px;
	padding-bottom: 10px;
	text-align: center;
	display: block;
	line-height: 20px;
	float: left;
	background: transparent url('css/icon/setton.png') no-repeat center top;
}
dl.talk dt.select {
	border: 2px solid #ff6600;
}
dl.talk dd {
	display: inline-block;
	max-width: 510px;
	margin-left: 0;
}
dl.talk dd div.bubble p.body {
	float: left;
	clear: left;
	padding: 15px 20px;
	border-radius: 13px;
	border: 4px #fff solid;
	-moz-border-radius: 13px;
	-webkit-border-radius: 13px;
	background: transparent url('css/balloon/gray.png') repeat-x left center;
	font: 1em "lucida grande", "Meiryo", tahoma, verdana, arial, sans-serif;
	letter-spacing: 3px;
	color: white;
	-position: relative;
	margin-top: 0px;
}
/* !begin icon styles */
			#talks .tanaka {
	background-image: url('css/icon/tanaka.png');
}
#talks .kanra {
	background-image: url('css/icon/kanra.png');
}
#talks .setton {
	background-image: url('css/icon/setton.png');
}
#talks .saika {
	background-image: url('css/icon/saika.png');
}
#talks .bakyura {
	background-image: url('css/icon/bakyura.png');
}
#talks .gg {
	background-image: url('css/icon/gg.png');
}
#talks .zawa {
	background-image: url('css/icon/zawa.png');
}
#talks .simon {
	background-image: url('css/icon/simon.png');
}
#talks .koukin {
	background-image: url('css/icon/koukin.png');
}
#talks .shinra {
	background-image: url('css/icon/shinra.png');
}
#talks .sizuo {
	background-image: url('css/icon/sizuo.png');
}
#talks .izaya {
	background-image: url('css/icon/izaya.png');
}
#talks .chinese {
	background-image: url('css/icon/chinese.png');
}
#talks .lady {
	background-image: url('css/icon/lady.png');
}
#talks .lolita {
	background-image: url('css/icon/lolita.png');
}
#talks .woman {
	background-image: url('css/icon/woman.png');
}
#talks ._admin {
	background-image: url('css/icon/_admin.png');
}
/* !end icon styles */

			/* !begin balloon styles */
			#talks .blue {
	background-image: url('css/balloon/blue.png');
}
#talks .gray {
	background-image: url('css/balloon/gray.png');
}
#talks .green {
	background-image: url('css/balloon/green.png');
}
#talks .orange {
	background-image: url('css/balloon/orange.png');
}
#talks .pink {
	background-image: url('css/balloon/pink.png');
}
#talks .red {
	background-image: url('css/balloon/red.png');
}
#talks .purple {
	background-image: url('css/balloon/purple.png');
}
#talks .brown {
	background-image: url('css/balloon/brown.png');
}
#talks .cobalt {
	background-image: url('css/balloon/cobalt.png');
}
#talks .strawberry {
	background-image: url('css/balloon/strawberry.png');
}
#talks .yellow {
	background-image: url('css/balloon/yellow.png');
}
#talks .carrot {
	background-image: url('css/balloon/carrot.png');
}
			/* !begin balloon styles */
</style>
	<script type="text/javascript">

(function($){
	var preventDefaultScroll = function(event) {

	if (event) event.preventDefault();

	var _who = $([window, 'html, body']);

	_who
		.scrollTop(0)
		.scrollLeft(0)
	;

	$('#page_default #icons label').addClass('ui-corner-all');

	$.mobile.silentScroll (0) ;
};

	var _resize = function(event) {
		try{
		$('.ui-page-active div.ui-footer-fixed').css('margin-top', $('.ui-page-active div.ui-footer-fixed').height());
		}catch(e){}
	};



$(document)
	.bind("ready, pageinit, pageshow", preventDefaultScroll)
	.bind("updatelayout, pageshow, orientationchange", _resize)
;

$(window).bind('resize', _resize);

$('a#scrolltop')
	.live('click', preventDefaultScroll)
;
})($);

duraUrl = "..";
useComet = 0;

</script>

	<!--script type="text/javascript" src="http://chat.in-here.us/js/jquery.sound.js"></script-->
	<script type="text/javascript" src="<?php e(DURA_URL) ?>/js/SoundManager2/script/soundmanager2-nodebug-jsmin.js"></script>
	<script>
soundManager.url = 'js/SoundManager2/swf/';
soundManager.onready(function() {
	messageSound = soundManager.createSound({
	  id: 'messageSound',
	  url: 'js/sound.mp3',
	  volume: 100
	});
});
</script>
	<script type="text/javascript" src="<?php e(DURA_URL) ?>/js/jquery.corner.js"></script>
	<script type="text/javascript" src="<?php e(DURA_URL) ?>/js/jquery.chat.js"></script>

	<!-- 將此標記放在標頭中，或是結尾內文標記前方 -->
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {parsetags: 'explicit'}
</script>
</head>
<body data-theme="a">
	<div data-role="page" id="page_default" data-theme="a">
		<div data-role="header" data-position="fixed">
			<a href="#page_default" data-icon="home"  data-iconpos="notext" data-direction="reverse"> Home </a>
			<h3> Durarara 聊天室 </h3>
			<a href="#page_default" data-icon="back" data-iconpos="notext"> Logout </a>
		</div>
		<div data-role="content">
			<div id="login" data-theme="c" class="main-box ui-body-c ui-corner-all">
				<form method="post" action="#page_lounge">
					<fieldset data-role="controlgroup">
						<select data-native-menu="false" name="language" data-mini="true">
							<?php foreach ( $dura['languages'] as $langcode => $language ) : ?>
								<option value="<?php e($langcode) ?>"<?php if ( $langcode == $dura['default_language']): ?> selected="selected"<?php endif ?>><?php e($language) ?></option>
							<?php endforeach ?>
						</select>
					</fieldset>
					<fieldset data-role="controlgroup" data-type="horizontal" id="icons">
						<?php foreach ( $dura['icons'] as $icon => $file ) : ?>
							<label class="ui-corner-all"> <img class="icon ui-corner-all" src="<?php echo Dura_Class_Icon::getIconUrl($icon) ?>"/>
								<input type="radio" name="icon" value="<?php echo $icon ?>" />
							</label>
						<?php endforeach ?>
						<input type="hidden" name="token" value="<?php echo $dura['token'] ?>" />
					</fieldset>
					<fieldset data-role="controlgroup">
						<input name="name" placeholder="<?php e(t('YOUR NAME')); ?>" value="" type="text" />
					</fieldset>
					<fieldset data-role="fieldcontain">
						<input name="login" value="<?php e(t("ENTER")) ?>" type="submit" data-theme="d" />
					</fieldset>
				</form>
				<div>
					<?php echo t('Welcome to Durarara-like-chat!'); ?>
				</div>
			</div>
			<?php $this->slot('theme.copyright');?>
		</div>
		<?php $this->slot('theme.footer');?>
	</div>
	<script>
//App custom javascript
</script>