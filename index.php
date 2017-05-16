<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined( '_JEXEC' ) or die;

include_once __DIR__ . '/helpers/tpl-init.php';

?>
<!DOCTYPE html>
<html class='no-js <?php echo $bootstrapVersion; ?>' <?php echo $htmlOptions; ?>>

<head>
  <meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no' />
<jdoc:include type="head" />
</head>

<body>
<div class='hidden no-js container' style='margin-top:40px;text-align:center;'>
<span class='alert alert-error'><?php echo JText::_('SMZ_NOJAVASCRIPT_ALERT') ?></span>
</div>

<!-------------- START NICONA COMPAT -------------->
<!-- Phone menu-->
<?php if($phone_menu) : ?>
<div class="navbar navbar-fixed-top navbar-inverse visible-phone"><div class="container navbar-inner"><div class="btn-container"><a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a></div><div class="nav-collapse collapse"><jdoc:include type="modules" name="phone-menu" /></div></div></div>
<?php endif;?>

<!-- Top (logo, language switcher, search) -->
<?php if($nicona_modules) : ?>
<div id="top" class="container-fluid">
	<div class="row-fluid">
		<?php if($logo) : ?>
		<div id="logo" class="span6"><div id="logo-inner"><jdoc:include type="modules" name="logo" /></div></div>
		<?php endif;?>
		<?php if($top_right) : ?>
		<div id="top-right" class="span6"><div id="top-right-inner"><jdoc:include type="modules" name="top-right" /></div></div>
		<?php endif; ?>
	</div>
</div>

<!-- Desktop menu -->
<div id="menus" class="hidden-phone js">
	<div id="menus-inner">
		<!-- Menu 1 (desktop)-->
		<?php if($menu_1) : ?>
		<div id="menu1" class="row"><div class="navbar"><div class="navbar-inner"><div class="nav"><jdoc:include type="modules" name="menu-1" /></div></div></div></div>
		<?php endif; ?>
		<!-- Menu 2 (desktop)-->
		<?php if($menu_2) : ?>
		<div id="menu2" class="row"><div class="navbar"><div class="navbar-inner"><div class="nav"><jdoc:include type="modules" name="menu-2" /></div></div></div></div>
		<?php endif; ?>
		<!-- Menu 3 (desktop)-->
		<?php if($menu_3) : ?>
		<div id="menu3" class="row"><div class="navbar"><div class="navbar-inner"><div class="nav"><jdoc:include type="modules" name="menu-3" /></div></div></div></div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<!--------------- END NICONA COMPAT --------------->

<?php if($above_menu) : ?>
<div id='above-menu' class='js fullwidth'><jdoc:include type="modules" name="above-menu" /></div>
<?php endif; ?>
<?php if($menu) : ?>
<div id='menu' class='js'><jdoc:include type="modules" name="menu" /></div>
<?php endif; ?>
<?php if($hero) : ?>
<div id='hero' class='js fullwidth'><jdoc:include type="modules" name="hero" /></div>
<?php endif; ?>
<div id='external' class='js'>
<div id='internal' class='container-fluid<?php echo $fullWidth; ?>'>
<!--[if lt IE 9)]>
	<div class='alert alert-error' style='margin-top:40px;text-align:center;'>
	<?php echo JText::_('SMZ_OLDBROWSER_ALERT') ?>
	</div>
<![endif]-->
<jdoc:include type="message" />
	<div id='main'>
<?php	if($above) : ?>
<div id='above' class='row-fluid'><jdoc:include type="modules" name="above" /></div>
<?php	endif; ?>
		<div id='middle' class='row-fluid'>
<?php		if($left) : ?>
			<div id='left' class='span<?php echo $leftColumnWidth; ?>'><jdoc:include type="modules" name="left" /></div>
<?php		endif; ?>
			<div id='center' class='span<?php echo $mainColumnWidth; ?>'>
<?php			if($before_content) : ?>
				<div id='before-content'><jdoc:include type="modules" name="before-content" /></div>
<?php			endif; ?>
				<div id='content'><jdoc:include type="component" /></div>
<?php			if($after_content) : ?>
				<div id='after-content'><jdoc:include type="modules" name="after-content" /></div>
<?php			endif; ?>
			</div>
<?php		if($right) : ?>
			<div id='right' class='span<?php echo $rightColumnWidth; ?>'><jdoc:include type="modules" name="right" /></div>
<?php		endif; ?>
		</div>
<?php	if($below) : ?>
		<div id='below' class='row-fluid'><jdoc:include type="modules" name="below" /></div>
<?php	endif; ?>
	</div>
<?php if($breadcrumbs) : ?>
	<div id='breadcrumbs' class='row-fluid'><jdoc:include type="modules" name="breadcrumbs" /></div>
<?php endif; ?>
<?php if($has_footer) : ?>
	<footer id='footer' class='footer row-fluid'>
<?php if($footer) : ?>
<jdoc:include type="modules" name="footer" />
<?php endif; ?>
<?php if($footer_right) : ?>
		<div id='footer-right' class='pull-right'><jdoc:include type="modules" name="footer-right" /></div>
<?php endif; ?>
<?php if($footer_left) : ?>
		<div id='footer-left' class='pull-left'><jdoc:include type="modules" name="footer-left" /></div>
<?php endif; ?>
	</footer>
<?php endif; ?>
<jdoc:include type="modules" name="debug" />
</div>
</div>
</body>
</html>
