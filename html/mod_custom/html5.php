<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('_JEXEC') or die;

{
	$moduleTag = $params->get('module_tag');
	$moduleClass = $this->escape($params->get('moduleclass_sfx'));
	$bootstrapSize = $params->get('bootstrap_size');
	$spanClass = !empty($bootstrapSize) ? ' span' . (int) $bootstrapSize . '' : '';
	$headerTag = $this->escape($params->get('header_tag'));
	$headerClass = trim($params->get('header_class'));
	$backgroundimage = $params->get('backgroundimage');

	$class = '';
	if (!empty($moduleClass) || !empty($spanClass))
	{
		$class = " class='{$moduleClass}{$spanClass}'";
	}

	$style = '';
	if (!empty($backgroundimage))
	{
		$style = " style=\"background-image:url({$backgroundimage})\"";
	}

	if (!empty ($module->content))
	{
		echo "<{$moduleTag}{$class}{$style}>";

		if ((bool) $module->showtitle)
		{
			echo "<{$headerTag} class=\"{$headerClass}\">{$module->title}</{$headerTag}>";
		}

		echo $module->content;
		echo "</{$moduleTag}>";
	}
}

