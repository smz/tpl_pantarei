<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<dt class='category-name'>" . JText::sprintf('COM_CONTENT_CATEGORY', '') . "</dt>";

$title = $this->escape($item->category_title);

if ($params->get('link_category') && $item->catslug)
{
	echo "<dd><a href='" . JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)) . "'>" . $title . "</a></dd>";
}
else
{
	echo "<dd>{$title}</dd>";
}
