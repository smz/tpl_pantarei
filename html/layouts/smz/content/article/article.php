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
 * @param   object    $item             "article" object;
 * @param   boolean   $single_article   Flag that telles if the article should be generated in the context of a
 *                                      "single article" view or a "multiples articles" ("blog") view
 *
 */

defined('JPATH_BASE') or die;

extract($displayData);

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$user = JFactory::getUser();

// Create shortcuts to some parameters.
// N.B.: $params are parameters defined at the component level.
//			$attribs are parameters defined at the article level.
//
//			$params comes from options defined at the:
//				a) Global settings
//				b) Article level
//				c) Menu item level
//			They are "merged" into one at the "model" and "view" level (but something seems to be missing there...)
//
$params = $item->params;
$attribs = json_decode($item->attribs);

// Access rights
$teaser = $params->get('show_noauth') && $user->get('guest'); // This is for the "Show unauthorized links" options.
$access = $params->get('access-view');

// See what we should diplay, fulltext or intro, based on access rights and "Single Article" or "Category Blog" mode
$full_article = $access ? ($single_article ? true : false) : false;

if ($access || $teaser)
{
	// Article CSS class
	$class = empty($item->article_class) ? '' : $item->article_class;
	if ($item->state == 0)
	{
		$class = empty($class) ? "unpublished" : "{$class} unpublished}";
	}
	$class = empty($class) ? '' : " class='{$class}'";

	// Get the article "path"
	$data_article_path = " data-article-path='" . trim(str_replace('/',' ' , $item->parent_route) . ' ' . $item->category_alias . ' ' . $item->alias) . "'";

	//Start the article...
	echo "<article{$class}{$data_article_path}>";

	// The dreaded "alternative_readmore" (That should be in the params, but isn't)
	$params->alternative_readmore = $attribs->alternative_readmore;

	// Headings
	$h6_info = JText::_('SMZ_ARTICLE_INFO_HEADER');
	$h6_info_more = JText::_('SMZ_ARTICLE_INFO_MORE_HEADER');
	$h6_tags = JText::_('SMZ_ARTICLE_TAGS_HEADER');
	$h6_rating = JText::_('SMZ_ARTICLE_RATING_HEADER');
	$h6_links = JText::_('SMZ_ARTICLE_LINKS_HEADER');
	$h6_navigation = JText::_('SMZ_ARTICLE_NAVIGATION_HEADER');

	// Todo: Not that elegant: it would be nice to group the params.
	// Probably unneeded now that most (all?) of the logic is performed at the "info.block JLayout" level.
	// Todo: check if this is still needed...
	$have_info_to_show = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
		|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') );

	$info_block_position = $params->get('info_block_position', 0);

	// Prepare the "Links"
	$links = JLayoutHelper::render('smz.content.article.links', array('params' => $params, 'links' => json_decode($item->urls), 'raw' => false, 'header' => $h6_links));

	// Prepare the Image:
	// If the user is authorized I set the image type as 'fulltext' for "Single Article" view and 'intro' for "Category Blog" view.
	// If instead the user is not authorized I force the 'intro' image.
	$image = JLayoutHelper::render('smz.content.article.images', array('params' => $params, 'images' => json_decode($item->images), 'type' => ($full_article ? 'fulltext' : 'intro' )));


	// Icons (Actions: Print/email/edit), but not when we are in "print preview"
	if (empty($item->print))
	{
		echo JLayoutHelper::render('smz.content.article.actions', array('params' => $params, 'item' => $item));
	}

	// Article title
	if ($params->get('show_title'))
	{
		// Link title (not when in "single article" view)
		$title = htmlspecialchars($item->title);
		if ($access && !$single_article && $params->get('link_titles'))
		{
			$title = "<a href='" . JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)) . "'>{$title}</a>";
		}
		echo "<{$item->title_heading} class='article-header'>{$title}</{$item->title_heading}>";
	}

	if ($access)
	{
		// Admin info (published/unpblished/etc.)
		$admin_info = '';
		if ($item->state == 0)
		{
			$admin_info .= "<span class='label label-important'>" . JText::_('JUNPUBLISHED') . "</span>";
		}
		if ($item->state == -2)
		{
			$admin_info .= "<span class='label label-important'>" . JText::_('JTRASHED') . "</span>";
		}
		if (strtotime($item->publish_up) > strtotime(JFactory::getDate()))
		{
			$admin_info .= "<span class='label label-warning'>" . JText::_('JNOTPUBLISHEDYET') . "</span>";
		}
		if ((strtotime($item->publish_down) < strtotime(JFactory::getDate())) && $item->publish_down != JFactory::getDbo()->getNullDate())
		{
			$admin_info .= "<span class='label label-warning'>" . JText::_('JEXPIRED') . "</span>";
		}
		if (!empty($admin_info))
		{
			echo "<section class='admin-info'>{$admin_info}</section>";
		}
	}

	// Info block above
	if ($have_info_to_show && ($info_block_position == 0 || $info_block_position == 2))
	{
		echo JLayoutHelper::render('smz.content.article.info.block', array('params' => $params, 'item' => $item, 'position' => 'above', 'raw' => false, 'header' => $h6_info));
	}

	// Tags above
	if ($info_block_position == 0 && $params->get('show_tags', 1) && !empty($item->tags->itemTags))
	{
		echo JLayoutHelper::render('smz.tags.list', array('tags' => $item->tags->itemTags, 'raw' => false, 'header' => $h6_tags));
	}

	// Content generated by the "onContentAfterTitle" event
	// Unfortunate names "show_intro" and "afterDisplayTitle", IMHO...
	if (!$params->get('show_intro'))
	{
		echo $item->event->afterDisplayTitle;
	}

	// See if we have the rights for this article...
	if ($access)
	{
		// Content generated by  the "onContentBeforeDisplay" event
		// "Voting" plugin is here
		$rating = $params->get('show_vote', 0) ? $item->event->beforeDisplayContent : '';
		if (!empty($rating))
		{
			echo "<aside class='rating'>{$h6_rating}{$rating}</aside>";
		}

		// Links above
		if (!empty($links) && $params->get('urls_position', 0) == 0)
		{
			echo $links;
		}

		// This comes from the crappy "pagebreak" plugin
		if (isset($item->toc))
		{
			echo $item->toc;
		}

		// Navigation above article text
		if ($single_article && !empty($item->pagination) && $item->pagination && !$item->paginationposition && !$item->paginationrelative)
		{
			echo "<nav class='navigation abovearticle'>{$h6_navigation}{$item->pagination}</nav>";
		}

		// The article body!! (image + text)
		echo "<section class='article-body'>{$image}{$item->text}</section>";

		// Navigation below article text
		if ($single_article && !empty($item->pagination) && $item->pagination && $item->paginationposition && !$item->paginationrelative)
		{
			echo "<nav class='navigation belowarticle'>{$h6_navigation}{$item->pagination}</nav>";
		}

		// Links below
		if (!empty($links) && $params->get('urls_position', 0) == 1)
		{
			echo $links;
		}

		// Info & tags below, only for full article
		if ($full_article && ($info_block_position == 1 || $info_block_position == 2))
		{
			// Info below
			if ($have_info_to_show)
			{
				$header = $info_block_position == 1 ? $h6_info : $h6_info_more;
				echo JLayoutHelper::render('smz.content.article.info.block', array('params' => $params, 'item' => $item, 'position' => 'below', 'raw' => false, 'header' => $header));
			}

			// ... and tags below
			if ($params->get('show_tags', 1) && !empty($item->tags->itemTags))
			{
				echo JLayoutHelper::render('smz.tags.list', array('tags' => $item->tags->itemTags, 'header' => $h6_tags, 'raw' => false));
			}
		}

		// Readmore
		if (!empty($item->readmore) && $params->get('show_readmore'))
		{
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
			echo JLayoutHelper::render('smz.content.article.readmore', array('params' => $params, 'item' => $item, 'link' => $link));
		}

	}
	else // if ($teaser)
	{
		// We are here when the article is protected, the user is guest and the "Show unauthorized links" option is in effect.

		// Optional teaser intro text for guests
		// N.B.: AFAIK $item->introtext == $item->text (at most differing for a trailing blank)
		echo "<section class='intro'>{$image}{$item->introtext}</section>";

		// Optional link to let them register to see the whole article.
		// Is there a case here that $item->fulltext can be empty? Readmore break at the end of the article??
		if (!empty($item->fulltext) && $params->get('show_readmore'))
		{
			$menu = JFactory::getApplication()->getMenu();
			$active = $menu->getActive();
			$itemId = $active->id;
			$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
			$link->setVar('return', base64_encode(JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language), false)));
			echo JLayoutHelper::render('smz.content.article.readmore', array('params' => $params, 'item' => $item, 'link' => $link));
		}
	}

	// Content generated by content plugin event "onContentAfterDisplay"
	echo $item->event->afterDisplayContent;

	// Close the article
	echo "</article>";

}
