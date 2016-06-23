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
		break;
	case 'TWITTER' :
		unset($this->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap.min.css']);
		unset($this->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap-responsive.min.css']);
		unset($this->_scripts['/media/jui/js/bootstrap.min.js']);
		$doc->addStyleSheet('templates/'.$this->template . '/bootstrap/css/bootstrap.min.css');
		$doc->addStyleSheet('templates/'.$this->template . '/bootstrap/css/bootstrap-responsive.min.css');
		$doc->addScript('templates/'.$this->template . '/bootstrap/js/bootstrap-fixed.min.js');
		break;
	default :
		break;
}	

// Add Google fonts
for ($i = 1; $i < 6; $i++)
{
	$font = str_replace(' ', '+', trim($this->params->get('googlefont' . $i, '')));
	if ($font)
	{
		$doc->addStyleSheet('http://fonts.googleapis.com/css?family='. $font);
	}
}

// Add template stylesheets
$doc->addStyleSheet('templates/' . $this->template . '/css/template.css' . $css_version_string);
if (file_exists(JPATH_SITE . '/templates/' . $this->template . '/css/custom.css'))
{
	$doc->addStyleSheet('templates/'. $this->template . '/css/custom.css' . $css_version_string);
}
if (file_exists(JPATH_SITE . '/templates/' . $this->template . '/css/bootstrap_' . $bootstrapVersion . 'css'))
{
	$doc->addStyleSheet('templates/'. $this->template . '/css/bootstrap_' . $bootstrapVersion . 'css' . $css_version_string);
}

// Add modernizer.js
$doc->addScript('templates/'.$this->template . '/js/modernizr.js');

$bootstrapVersion = "bs-{$bootstrapVersion}";
$htmlOptions = "lang='{$this->language}' dir='{$this->direction}'";