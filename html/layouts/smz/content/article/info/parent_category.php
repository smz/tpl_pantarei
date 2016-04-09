<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<dt class='parent-category-name'>" . JText::sprintf('COM_CONTENT_PARENT', '') . "</dt>";

$title = $this->escape($item->parent_title);

if ($params->get('link_parent_category') && $item->parent_slug)
{
	echo "<dd><a href='" . JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)) . "'>" . $title . "</a></dd>";
}
else
{
	echo "<dd>{$title}</dd>";
}
