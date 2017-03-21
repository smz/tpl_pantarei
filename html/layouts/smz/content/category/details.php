<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

// Category image and description
if (!empty($description) || !empty($image))
{
	if (!$raw)
	{
		echo "<section class='category-details'>{$header}";
	}

	if (!empty($image))
	{
		echo "<img src=\"{$image}\" alt='" . htmlspecialchars($alt) . "'/>";
	}

	if (!empty($description))
	{
		echo JHtml::_('content.prepare', $description, '', 'com_content.category');
	}

	if (!$raw)
	{
		echo "</section>";
	}
}
