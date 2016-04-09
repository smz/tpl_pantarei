<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<dt class='createdby'>" . JText::sprintf('COM_CONTENT_WRITTEN_BY', '') . "</dt>";

$author = ($item->created_by_alias ? $item->created_by_alias : $item->author);

if (!empty($item->contact_link ) && $params->get('link_author') == true)
{
	echo "<dd>" . JHtml::_('link', $item->contact_link, $author, array()) . "</dd>";
}
else
{
	echo "<dd>{$author}</dd>";
}
