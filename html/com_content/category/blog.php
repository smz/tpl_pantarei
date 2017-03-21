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
$h6_articles = JText::_('SMZ_CATEGORY_ARTICLES_HEADER');
$h6_links = JText::_('SMZ_CATEGORY_LINKS_HEADER');
$h6_sub = JText::_('SMZ_CATEGORY_SUB_HEADER');
$h6_navigation = JText::_('SMZ_CATEGORY_NAVIGATION_HEADER');

// Suppose we don't have a "Page title" (from menu) title...
$articles_heading_level = 1;
$category_heading_level = 1;

// Fair enough , I guess, and just in case as we have div.span inside this...
echo "<div class='span12'>";

// Page title (from menu)
if ($this->params->get('show_page_heading'))
{
	echo "<h1 class='page-header{$this->pageclass_sfx}'>" . htmlspecialchars($this->params->get('page_heading')) . "</h1>";
	$articles_heading_level++;
	$category_heading_level++;
}

echo "<section class='category-blog{$this->pageclass_sfx}'>";

	// Category title
	if ($this->params->get('show_category_title', 1) || $this->params->get('page_subheading'))
	{
		$category_title = $this->params->get('show_category_title') ? $this->category->title : '';
		$subheading = htmlspecialchars($this->params->get('page_subheading'));
		$subheading = $subheading == '' ? '' : "<span class='subheading'>{$subheading}</span>";
		echo "<h{$category_heading_level} class='blog-header'>{$subheading}{$category_title}</h{$category_heading_level}>";
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
			'alt' => htmlspecialchars($this->category->getParams()->get('image_alt')),
			'raw' => false,
			'header' => $h6_info
			));
	}

	// Category tags
	if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags))
	{
		echo JLayoutHelper::render('smz.tags.list', array(
			'tags' => $this->category->tags->itemTags,
			'raw' => false,
			'header' => $h6_tags
			));
	}


	// Articles section
	echo "<section class='category-articles'>{$h6_articles}";

	// No articles message
	if ($this->params->get('show_no_articles', 1) && empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items))
	{
		echo "<p>" . JText::_('COM_CONTENT_NO_ARTICLES') . "</p>";
	}

	// Leading Articles
	if (!empty($this->lead_items))
	{
		$counter = 0;
		foreach ($this->lead_items as $item)
		{
			$counter++;
			$item->article_class = "leading leading-{$counter} clearfix";
			$item->title_heading = 'h' . $articles_heading_level;
			echo JLayoutHelper::render('smz.content.article.article', array('item' => $item, 'single_article' => false));
		}
	}

	// Intro Articles
	if ($introcount = count($this->intro_items))
	{
		if ($columns = $this->columns < 2)
		{
			foreach ($this->intro_items as $item)
			{
				$item->title_heading = 'h' . $articles_heading_level;
				echo JLayoutHelper::render('smz.content.article.article', array('item' => $item, 'single_article' => false));
			}
		}
		else
		{
			$columns = $this->columns;
			$span = round((12 / $columns));
			$counter = 0;
			foreach ($this->intro_items as $item)
			{
				if ($counter % $columns == 0)
				{
					echo "<div class='row-fluid clearfix'>";
				}
				echo "<div class='span{$span}'>";
				$item->title_heading = 'h' . $articles_heading_level;
				echo JLayoutHelper::render('smz.content.article.article', array('item' => $item, 'single_article' => false));
				echo "</div>"; // end "div.span""
				$counter++;
				if ($counter % $columns == 0 || $counter == $introcount)
				{
					echo "</div>"; // end div.row-fluid
				}
			}
		}
	}

	// End of articles section
	echo "</section>";

	// Links
	if (!empty($this->link_items))
	{
		echo "<section class='category-links'>";
		echo $h6_links;
		echo JLayoutHelper::render('smz.content.category.links', array('link_items' => $this->link_items));
		echo "</section>";
	}

	// Children
//	if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0)
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

	// Pagination
	if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1))
	{
		echo "<div class='pagination'>";
		if ($this->params->def('show_pagination_results', 1))
		{
			echo "<p class='counter pull-right'>" . $this->pagination->getPagesCounter() . "</p>";
		}
		echo $this->pagination->getPagesLinks() . "</div>";
	}
echo "</section>";
echo "</div>"; // span12
