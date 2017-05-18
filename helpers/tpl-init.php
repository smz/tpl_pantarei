<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined( '_JEXEC' ) or die;

// Get the document object
$doc = JFactory::getDocument();

// Remove the "generator" meta
$doc->setGenerator('');

// See if it is the full-screen variant...
$fullWidth = $this->params->get('fullWidth', 0) ? ' fullwidth' : '';

// Remove Mootools
if ($this->params->get('removeMootols', 0))
{
	unset($this->_scripts['/media/system/js/mootools-core.js']);
	unset($this->_scripts['/media/system/js/mootools-more.js']);
}

// See which Boostrap version we want to use
$bootstrapVersion = $this->params->get('bootstrapVersion', 'JUI');

// Calculate mainColumnWidth
$mainColumnWidth = 12;
$leftColumnWidth = $this->params->get('leftColumnWidth', 3);
$rightColumnWidth = $this->params->get('rightColumnWidth', 3);
if ($this->countModules('left')) {
    $mainColumnWidth -= $leftColumnWidth;
}
if ($this->countModules('right')) {
    $mainColumnWidth -= $rightColumnWidth;
}

// Build the CSS cache defeating string
$css_version_string = trim($this->params->get('css_version_string',''));
if ($css_version_string)
{
	if ($css_version_string == '@random')
	{
		$css_version_string = '?' . mt_rand();
	}
	else
	{
		$css_version_string = '?' . $css_version_string;
	}
}

// Add selected Bootstrap version
switch ($bootstrapVersion)
{
	case 'JUI' :
		JHtml::_('bootstrap.framework');
		JHtmlBootstrap::loadCSS('true', $this->direction);
		$menuOptions = " class='js'";
		break;
	case 'TWITTER' :
		unset($this->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap.min.css']);
		unset($this->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap-responsive.min.css']);
		unset($this->_scripts['/media/jui/js/bootstrap.min.js']);
		$doc->addStyleSheet('templates/'.$this->template . '/bootstrap/css/bootstrap.min.css');
		$doc->addStyleSheet('templates/'.$this->template . '/bootstrap/css/bootstrap-responsive.min.css');
		$doc->addScript('templates/'.$this->template . '/bootstrap/js/bootstrap-fixed.min.js');
		if ($this->params->get('affixMenu', 0))
		{
			$affixOffset = max($this->params->get('affixOffset', 0), 0.5);  // Offset 0 does not work!
			$menuOptions =  " class='js affix-top' style='width:100%; z-index:100000;' data-spy='affix' data-offset-top='{$affixOffset}'";
			$doc->addScript('templates/'.$this->template . '/bootstrap/js/bootstrap-affix.min.js');
		}
		break;
}	

// Add Google fonts
for ($i = 1; $i < 6; $i++)
{
	$font = str_replace(' ', '+', trim($this->params->get('googlefont' . $i, '')));
	if ($font)
	{
		$doc->addStyleSheet('https://fonts.googleapis.com/css?family='. $font);
	}
}

// Count modules
$above_menu = $this->countModules('above-menu');
$menu = $this->countModules('menu');
$hero = $this->countModules('hero');
$above = $this->countModules('above');
$left = $this->countModules('left');
$before_content = $this->countModules('before-content');
$after_content = $this->countModules('after-content');
$right = $this->countModules('right');
$below = $this->countModules('below');
$breadcrumbs = $this->countModules('breadcrumbs');
$footer = $this->countModules('footer');
$footer_left = $this->countModules('footer-left');
$footer_right = $this->countModules('footer-right');
$has_footer = $footer + $footer_left + $footer_right;

// Count "nicona" modules
$phone_menu = $this->countModules('phone-menu');
$logo = $this->countModules('logo');
$top_right = $this->countModules('top-right');
$menu_1 = $this->countModules('menu-1');
$menu_2 = $this->countModules('menu-2');
$menu_3 = $this->countModules('menu-3');
$nicona_modules = $logo + $top_right + $menu_1 + $menu_2 + $menu_3;

// Add template stylesheet
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css' . $css_version_string);

// Add 'nicona' stylesheet if needed
if ($nicona_modules && file_exists(JPATH_SITE . '/templates/' . $this->template . '/css/nicona.css'))
{
	$doc->addStyleSheet('templates/'. $this->template . '/css/nicona.css' . $css_version_string);
}

// Prepare to load custom stylesheet
if (file_exists(JPATH_SITE . '/templates/' . $this->template . '/css/custom.css'))
{
	$customStyleSheet = "\t<link href='/templates/" . $this->template . '/css/custom.css' . $css_version_string . "' rel='stylesheet' type='text/css' />\n";
}
else
{
	$customStyleSheet = '';
}

// Add modernizer.js
$doc->addScript('templates/'.$this->template . '/js/modernizr.js');

$bootstrapVersion = "bs-{$bootstrapVersion}";
$htmlOptions = "lang='{$this->language}' dir='{$this->direction}'";
