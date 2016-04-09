<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

use Joomla\Registry\Registry;
JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

extract($displayData);

$links = array(
	(object) array('id' => 'targeta', 'url' => $links->urla, 'text' => $links->urlatext, 'target' => $links->targeta),
	(object) array('id' => 'targetb', 'url' => $links->urlb, 'text' => $links->urlbtext, 'target' => $links->targetb),
	(object) array('id' => 'targetc', 'url' => $links->urlc, 'text' => $links->urlctext, 'target' => $links->targetc)
	);

// Check if we have something to do...
$have_links = false;
foreach ($links as $link)
{
	if (!empty($link->url) && !empty($link->text))
	{
		$have_links = true;
		break;
	}
}

if ($have_links)
{
	// init $html
	$html ='';

	// width and height for modal/pop-up
	$width = isset($width) ? $width : '600';
	$height = isset($height) ? $height : '600';

	foreach ($links as $i => $link)
	{
		if (empty($link->url))
		{
			continue;
		}

		// If no label is present, take the link
		$link->text = $link->text ? $link->text : $link->url;

		// If no target is present, use the default
		$link->target = $link->target ? $link->target : $params->get($link->id);

		switch ($link->target)
		{
			case 1:
				// Open in a new window
				$link_html = JLayoutHelper::render('smz.elements.link.new_window', array('url' => $link->url, 'text' => $link->text));
				break;
			case 2:
				// Open in a popup window
				$link_html = JLayoutHelper::render('smz.elements.link.popup', array('url' => $link->url, 'text' => $link->text, 'width' => $width, 'height' => $height));
				break;
			case 3:
				// Open in a modal window
				$link_html = JLayoutHelper::render('smz.elements.link.mootools_modal', array('url' => $link->url, 'text' => $link->text, 'width' => $width, 'height' => $height));
				break;
			default:
				// Open in parent window
				$link_html = JLayoutHelper::render('smz.elements.link.parent_window', array('url' => $link->url, 'text' => $link->text));
				break;
		}
			$html .= "<li>{$link_html}</li>";
	}

	$html = "<ul>{$html}</ul>";

	if (!$raw)
	{
		$html = "<section class='links'>{$header}{$html}</section>";
	}

	echo $html;
}
