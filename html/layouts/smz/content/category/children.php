<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

/**
 * Layout variables
 * ------------------
 * @param   object    $category   JCategoryNode object, current category.
 * @param   array     $children   array of JCategoryNode objects, children of current category.
 * @param   int       $maxLevel   Maximum number of sub-categories to display.
 * @param   object    $params     Joomla Registry Object.
 *
 */

defined('_JEXEC') or die;

extract($displayData);

if (count($children[$category->id]) > 0 && $maxLevel != 0)
{
	foreach ($children[$category->id] as $id => $child)
	{
		if ($params->get('show_empty_categories') || $child->numitems || count($child->getChildren()))
		{
			echo "<ul class='nav nav-list'>";
			{
				echo "<li><a href='" . JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)) . "'>";
				echo htmlspecialchars($child->title);
				if ( $params->get('show_cat_num_articles', 1))
				{
					$n = $child->getNumItems($params->get('count_is_inclusive'));
					switch ($n)
					{
						case 0:
							$format = JText::_('SMZ_ARTICLE_0');
							break;
						case 1:
							$format = JText::_('SMZ_ARTICLE_1');
							break;
						case 2:
							$format = JText::_('SMZ_ARTICLE_2');
							break;
						default:
							$format = JText::_('SMZ_ARTICLE_N');
							break;
					}
					echo sprintf($format, $n);
				}
				echo "</a></li>";
			}
			if (count($child->getChildren()) > 0 && $maxLevel > 1)
			{
				$children[$child->id] = $child->getChildren();
				$category = $child;
				$maxLevel--;
				echo "<li>";
				echo JLayoutHelper::render('smz.content.category.children', array('params' => $params, 'category' => $category, 'children' => $children, 'maxLevel' => $maxLevel));
				echo "</li>";
				$category = $child->getParent();
				$maxLevel++;
			}
			echo "</ul>";
		}
	}
}
