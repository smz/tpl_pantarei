<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

$blockPosition = $params->get('info_block_position', 0);
$more = '';
$html = '';

if ($position == 'above')
{
	switch ($blockPosition)
	{
		case 0:
			$showpart1 = true;
			$showpart2 = true;
			break;
		case 1:
			$showpart1 = false;
			$showpart2 = false;
			break;
		case 2:
			$showpart1 = true;
			$showpart2 = false;
			break;
	}
}
else //if ($position == 'below')
{
	switch ($blockPosition)
	{
		case 0:
			$showpart1 = false;
			$showpart2 = false;
			break;
		case 1:
			$showpart1 = true;
			$showpart2 = true;
			break;
		case 2:
			$showpart1 = false;
			$showpart2 = true;
			$more = ' more';
			break;
	}
}

if ($showpart1)
{
	if ($params->get('show_author') && !empty($item->author ))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.author', $displayData);
	}

	if ($params->get('show_parent_category') && !empty($item->parent_slug))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.parent_category', $displayData);
	}

	if ($params->get('show_category'))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.category', $displayData);
	}

	if ($params->get('show_publish_date'))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.publish_date', $displayData);
	}
}

if ($showpart2)
{
	if ($params->get('show_create_date'))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.create_date', $displayData);
	}

	if ($params->get('show_modify_date'))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.modify_date', $displayData);
	}

	if ($params->get('show_hits'))
	{
		$html .= JLayoutHelper::render('smz.content.article.info.hits', $displayData);
	}
}

if (!empty($html))
{
	$html = "<dl class='article-info'>{$html}</dl>";

	if (!$raw)
	{
		$html =  "<section class='info {$position}{$more}'>{$header}{$html}</section>";
	}

	echo $html;
}
