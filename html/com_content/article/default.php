<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$h6_navigation = JText::_('SMZ_ARTICLE_NAVIGATION_HEADER');

// Page Class "suffix" (from menu)
if (!empty ($this->pageclass_sfx))
{
	$class = " class='" . $this->pageclass_sfx . "'";
}

// The print icon for when we are in "print preview"
if ($this->print)
{
 	echo "<div id='pop-print' class='btn hidden-print pull-right'>" . JHtml::_('icon.print_screen', $this->item, $this->params) . "</div><div class='clearfix'></div>";
}

// Suppose we don't have a "Page title" (from menu) title...
$this->item->title_heading = 'h1';
$this->item->article_class = $this->pageclass_sfx;

// Page title (from menu)
if ($this->params->get('show_page_heading'))
{
	echo "<h1 class='page-header{$this->pageclass_sfx}'>" . htmlspecialchars($this->params->get('page_heading')) . "</h1>";
	$this->item->title_heading = 'h2';
	$this->item->article_class ="";
}

// Navigation above
if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
{
	echo "<nav class='navigation above'>{$h6_navigation}{$this->item->pagination}</nav>";
}

// Bring forward the "print" flag
$this->item->print = $this->print;

echo JLayoutHelper::render('smz.content.article.article', array('item' => $this->item, 'single_article' => true));

// Navigation below
if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative)
{
	echo "<nav class='navigation below'>{$h6_navigation}{$this->item->pagination}</nav>";
}
