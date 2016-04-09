<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<ol class='nav nav-tabs nav-stacked'>";
foreach ($link_items as &$item)
{
	echo "<li><a href='" . JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)) . "'>{$item->title}</a></li>";
}
echo "</ol>";
