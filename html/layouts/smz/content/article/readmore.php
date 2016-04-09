<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<p class='readmore'><a class='btn' href='{$link}'>";
echo "<span class='icon-chevron-right'></span>";

if (!$params->get('access-view'))
{
	echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
}
elseif ($readmore = $params->alternative_readmore)
{
	echo $readmore;
	if ($params->get('show_readmore_title', 0) != 0)
	{
		echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
	}
}
elseif ($params->get('show_readmore_title', 0) == 0)
{
	echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
}
else
{
	echo JText::_('COM_CONTENT_READ_MORE');
	echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
}

echo "</a></p>";
