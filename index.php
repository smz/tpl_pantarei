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
<?php
if (file_exists(JPATH_SITE . '/images/favicons/favicons.php'))
{
 include_once JPATH_SITE . '/images/favicons/favicons.php';
}
?>
<jdoc:include type="head" />
</head>

<body>
<div class='hidden no-js container' style='margin-top:40px;text-align:center;'>
<span class='alert alert-error'><?php echo JText::_('SMZ_NOJAVASCRIPT_ALERT') ?></span>
</div>
<?php if($this->countModules('above-menu')) : ?>
<div id='above-menu' class='js fullwidth'>
<jdoc:include type="modules" name="above-menu" />
</div>
<?php endif; ?>
<div class='js'>
<jdoc:include type="modules" name="menu" />
</div>
<?php if($this->countModules('hero')) : ?>
<div id='hero' class='js fullwidth'>
<jdoc:include type="modules" name="hero" />
</div>
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
<?php	if($this->countModules('above')) : ?>
		<div id='above' class='row-fluid'>
<jdoc:include type="modules" name="above" />
		</div>
<?php	endif; ?>
		<div id='middle' class='row-fluid'>
<?php		if($this->countModules('left')) : ?>
			<div id='left' class='span<?php echo $leftColumnWidth; ?>'>
<jdoc:include type="modules" name="left" />
			</div>
<?php		endif; ?>
			<div id='center' class='span<?php echo $mainColumnWidth; ?>'>
<?php			if($this->countModules('before-content')) : ?>
				<div id='before-content'>
<jdoc:include type="modules" name="before-content" />
				</div>
<?php			endif; ?>
				<div id='content'>
<jdoc:include type="component" />
				</div>
<?php			if($this->countModules('after-content')) : ?>
				<div id='after-content'>
<jdoc:include type="modules" name="after-content" />
				</div>
<?php			endif; ?>
			</div>
<?php		if($this->countModules('right')) : ?>
			<div id='right' class='span<?php echo $rightColumnWidth; ?>'>
<jdoc:include type="modules" name="right" />
			</div>
<?php		endif; ?>
		</div>
<?php	if($this->countModules('below')) : ?>
		<div id='below' class='row-fluid'>
<jdoc:include type="modules" name="below" />
		</div>
<?php	endif; ?>
	</div>
<?php if($this->countModules('breadcrumbs')) : ?>
	<div id='breadcrumbs' class='row-fluid'>
<jdoc:include type="modules" name="breadcrumbs" />
	</div>
<?php endif; ?>
<?php if($this->countModules('footer-left') || $this->countModules('footer-right')) : ?>
	<footer id='footer' class='footer row-fluid'>
		<div id='footer-right' class='pull-right'>
<jdoc:include type="modules" name="footer-right" />
		</div>
		<div id='footer-left' class='pull-left'>
<jdoc:include type="modules" name="footer-left" />
		</div>
	</footer>
<?php endif; ?>
<jdoc:include type="modules" name="debug" />
</div>
</div>
</body>
</html>
