<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Headings
$h6_info = JText::_('SMZ_CATEGORY_INFO_HEADER');
$h6_tags = JText::_('SMZ_CATEGORY_TAGS_HEADER');
$h6_items = JText::_('SMZ_CATEGORY_ITEMS_HEADER');
$h6_sub = JText::_('SMZ_CATEGORY_SUB_HEADER');

$params = $this->params;
$extension = $this->get('category')->extension;
$canEdit = $params->get('access-edit');
$componentName = substr($extension, 4);
if (substr($componentName, -1) == 's')
{
	$componentName = rtrim($componentName, 's');
}

// Suppose we don't have a "Page title" (from menu) title...
$articles_heading_level = 1;
$category_heading_level = 1;

// Fair enough , I guess
echo "<div class='span12'>";

// Page title (from menu)
if ($this->params->get('show_page_heading'))
{
	echo "<h1 class='page-header{$this->pageclass_sfx}'>" . $this->escape($params->get('page_heading')) . "</h1>";
	$articles_heading_level++;
	$category_heading_level++;
}

echo "<section class='{$componentName}-category{$this->pageclass_sfx}'>";

// Category title
if ($this->params->get('show_category_title', 1))
{
	$category_title = $this->params->get('show_category_title') ? $this->category->title : '';
	$subheading = $this->escape($this->params->get('page_subheading'));
	$subheading = $subheading == '' ? '' : "<span class='subheading'>{$subheading}</span>";
	echo "<h{$category_heading_level} class='category-title'>{$subheading}{$category_title}</h{$category_heading_level}>";
	$articles_heading_level++;
}

// Category image and description
$havedescription = $this->params->get('show_description', 1) && !empty($description = $this->category->description);
$haveimage = $this->params->def('show_description_image', 1) && !empty($image = $this->category->getParams()->get('image'));
if ($haveimage || $havedescription)
{
	echo JLayoutHelper::render('smz.content.category.details', array(
		'description' => $description,
		'image' => $image,
		'alt' => $this->escape($this->category->getParams()->get('image_alt')),
		'raw' => false,
		'header' => $h6_info
		));
}

// Category tags
if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags))
{
	echo JLayoutHelper::render('smz.tags.list', array(
		'tags' => $this->category->tags->itemTags,
		'header' => $h6_tags,
		'raw' => false
		));
}

// "default_articles" sub-template
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));


echo "<section class='category-items'>{$h6_items}";


if (empty($this->items))
{
	if ($this->params->get('show_no_articles', 1))
	{
		echo "<p>" . JText::_('COM_CONTENT_NO_ARTICLES') . "</p>";
	}

}
else
{
	// Check for at least one editable article
	$isEditable = false;
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}

	echo "<form action='" . $this->escape(JUri::getInstance()->toString()) . "' method='post' name='adminForm' id='adminForm' class='form-inline'>";
	if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit'))
	{
		echo "<fieldset class='filters clearfix'>";
		if ($this->params->get('filter_field') != 'hide')
		{
			echo "<div class='control-group span6'>";
			echo "<div class='controls'>";
			echo "<input type='text' name='filter-search' id='filter-search' value='" . $this->escape($this->state->get('list.filter')) . "' class='inputbox' onchange='document.adminForm.submit();' title='" . JText::_('COM_CONTENT_FILTER_SEARCH_DESC') . "' placeholder='" . JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . "' />";
//			echo "<span class='help-inline'>&#160;" . JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL') . '</span>';
			echo "</div>";
			echo "</div>";
		}
		if ($this->params->get('show_pagination_limit'))
		{
			echo "<div class='control-group span6'>";
			echo "<div class='controls pull-right-desktop'>";
			echo "<span class='help-inline'>" . JText::_('JGLOBAL_DISPLAY_NUM') ."&#160;</span>";
			echo $this->pagination->getLimitBox();
			echo "</div>";
			echo "</div>";
		}

		echo "<input type='hidden' name='filter_order' value='' />";
		echo "<input type='hidden' name='filter_order_Dir' value='' />";
		echo "<input type='hidden' name='limitstart' value='' />";
		echo "<input type='hidden' name='task' value='' />";
		echo "</fieldset>";
	}

	echo "<table class='items table table-striped table-bordered table-hover'>";

	$headerTitle    = '';
	$headerDate     = '';
	$headerAuthor   = '';
	$headerHits     = '';
	$headerEdit     = '';

	if ($this->params->get('show_headings'))
	{
		echo "<thead>";
		echo "<tr>";
		echo "<th id='categorylist_header_title'>";
		echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder);
		echo "</th>";
		if ($date = $this->params->get('list_show_date'))
		{
			echo "<th class='list-title>";
			if ($date == 'created')
			{
				echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.created', $listDirn, $listOrder);
			}
			elseif ($date == 'modified')
			{
				echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.modified', $listDirn, $listOrder);
			}
			elseif ($date == 'published')
			{
				echo JHtml::_('grid.sort', 'COM_CONTENT_' . $date . '_DATE', 'a.publish_up', $listDirn, $listOrder);
			}
			echo "</th>";
		}
		if ($this->params->get('list_show_author'))
		{
			echo "<th class='list-author'>";
			echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder);
			echo "</th>";
		}
		if ($this->params->get('list_show_hits'))
		{
			echo "<th class='list-hits'>";
			echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder);
			echo "</th>";
		}
		if ($isEditable)
		{
			echo "<th class='list-edit'>" . JText::_('COM_CONTENT_EDIT_ITEM') . "</th>";
		}
		echo "</tr>";
		echo "</thead>";
	}
	echo "<tbody>";
	foreach ($this->items as $i => $article)
	{
		if ($this->items[$i]->state == 0)
		{
			echo "<tr class='system-unpublished'>";
		}
		else
		{
			echo "<tr>";
		}
		echo "<td class='list-title'>";
		if (in_array($article->access, $this->user->getAuthorisedViewLevels()))
		{
			echo "<a href='" . JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)) . "'>";
			echo $this->escape($article->title);
			echo "</a>";
		}
		else
		{

			echo $this->escape($article->title) . ' : ';
			$menu   = JFactory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language), false)));

			echo "<a href='" . $link . "' class='register'>";
			echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
			echo "</a>";
		}
		if ($article->state == 0)
		{
			echo "<span class='list-published label label-warning'>";
			echo JText::_('JUNPUBLISHED');
			echo "</span>";
		}
		if (strtotime($article->publish_up) > strtotime(JFactory::getDate()))
		{
			echo "<span class='list-published label label-warning'>";
			echo JText::_('JNOTPUBLISHEDYET');
			echo "</span>";
		}
		if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != JFactory::getDbo()->getNullDate())
		{
			echo "<span class='list-published label label-warning'>" . JText::_('JEXPIRED') . "</span>";
		}
		echo "</td>";
		if ($this->params->get('list_show_date'))
		{
			echo "<td " . $headerDate . " class='list-date small'>";
			echo JHtml::_('date', $article->displayDate,	$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3'))));
			echo "</td>";
		}
		if ($this->params->get('list_show_author', 1))
		{
			echo "<td class='list-author'>";
			if (!empty($article->author) || !empty($article->created_by_alias))
			{
				$author = ($article->created_by_alias ? $article->created_by_alias : $article->author);
				if (!empty($article->contact_link) && $this->params->get('link_author') == true)
				{
					echo JHtml::_('link', $article->contact_link, $author);
				}
				else
				{
					echo $author;
				}
			}
			echo "</td>";
		}
		if ($this->params->get('list_show_hits', 1))
		{
			echo "<td class='list-hits'>";
			echo $article->hits;
			echo "</td>";
		}
		if ($isEditable)
		{
			echo "<td class='list-edit'>";
			if ($article->params->get('access-edit'))
			{
				echo JHtml::_('icon.edit', $article, $params); // <--- Check this $params!
			}
			echo "</td>";
		}
		echo "</tr>";
	} // foreach

	echo "</tbody>";
	echo "</table>";
	echo "</form>";
}

// Code to add a link to submit an article.
if ($this->category->getParams()->get('access-create'))
{
	echo JHtml::_('icon.create', $this->category, $this->category->params);
}

echo "</section>";

// Add pagination links
if (!empty($this->items))
{
	if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1))
	{
		echo "<div class='pagination'>";
		if ($this->params->def('show_pagination_results', 1))
		{
			echo "<p class='counter pull-right'>" . $this->pagination->getPagesCounter() . "</p>";
		}
		echo $this->pagination->getPagesLinks();
		echo "</div>";
	}
}

// END OF "default_articles" sub-template

// Children
if ($this->maxLevel > 0 && $this->get('children'))
{
	echo "<section class='category-children'>";
	if ($this->params->get('show_category_heading_title_text', 1) == 1)
	{
		echo "<h3>" . JText::_('JGLOBAL_SUBCATEGORIES') . "</h3>";
	}
	else
	{
		echo $h6_sub;
	}
	$this->params->set('count_is_inclusive', true);
	echo "<ul class='nav nav-list'><li>";
	echo JLayoutHelper::render('smz.content.category.children',
		array('params' => $this->params, 'category' => $this->category, 'children' => $this->children, 'maxLevel' => $this->maxLevel));
	echo "</li></ul>";
	echo "</section>";
}

// END OF OLD "category_default" Layout

echo "</section>";
echo "</div>";
