<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<dt class='created'><span class='icon-calendar'></span>" . JText::sprintf('COM_CONTENT_CREATED_DATE_ON', '') . "</dt>";
echo "<dd><time datetime='" . JHtml::_('date', $item->created, 'c') . "'>";
echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'));
echo "</time></dd>";
