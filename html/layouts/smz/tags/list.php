<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

use Joomla\Registry\Registry;

extract($displayData);

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');

if (!empty($tags))
{
	if (!$raw)
	{
		echo "<section class='tags'>{$header}";
	}

	echo "<ul class='tags inline'>";
	foreach ($tags as $i => $tag)
	{
		if (in_array($tag->access, JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'))))
		{
			$tagParams = new Registry($tag->params);
			$link_class = $tagParams->get('tag_link_class', 'label label-info');
			echo "<li class='tag-{$tag->tag_id} tag-list{$i}'>";
			echo "<a href='" . JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias)) . "' class='{$link_class}'>";
			echo htmlspecialchars($tag->title);
			echo "</a></li>";
		}
	}
	echo "</ul>";

	if (!$raw)
	{
		echo "</section>";
	}
}
