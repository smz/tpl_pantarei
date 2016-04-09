<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

$html = '';

if ($params->get('show_print_icon'))
{
	$html .= "<li class='print-icon'>" . JHtml::_('icon.print_popup', $item, $params) . "</li>";
}

if ($params->get('show_email_icon'))
{
	$html .= "<li class='email-icon'>" . JHtml::_('icon.email', $item, $params) . "</li>";
}

if ($params->get('access-edit'))
{
	$html .= "<li class='edit-icon'>" . JHtml::_('icon.edit', $item, $params) . "</li>";
}

if (!empty($html))
{
	echo "<div class='actions btn-group pull-right'>";
	echo "<a class='btn dropdown-toggle' data-toggle='dropdown' href='#'><span class='icon-cog'></span><span class='caret'></span></a>";
	echo "<ul class='dropdown-menu'>{$html}</ul></div>";
}
