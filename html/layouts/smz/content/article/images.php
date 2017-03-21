<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

// "Images and links" should die a cruel death.

$image = "image_{$type}";
$float = "float_{$type}";
$alt = "image_{$type}_alt";
$caption = "image_{$type}_caption";

if (!empty($images->{$image}))
{
	$class = empty($images->{$float}) ? $params->get($float) : $images->{$float};
	$class = $class == 'none' ? '' : " pull-{$class}";

	echo "<figure class='{$type}{$class}'>";
	// This is curious: we MUST use double quotes for the "src" attribute value as Joomla! corrects for the lack of the leading slash
	// in references to image files (they lack it when picked by the media manager) only if the value is expressed between double quotes!!!
	echo "<img src=\"" . htmlspecialchars($images->{$image}) . "\" alt='" . htmlspecialchars($images->{$alt}) . "'";
	if ($images->{$alt})
	{
		echo " title='" . htmlspecialchars($images->{$alt}) . "'";
	}
	echo " />";
	if ($images->{$caption})
	{
		echo "<figcaption> " . htmlspecialchars($images->{$caption}) . "</figcaption>";
	}
	echo "</figure>";
}
