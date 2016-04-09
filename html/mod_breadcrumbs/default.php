<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('_JEXEC') or die;

$moduleclass_sfx = empty($moduleclass_sfx) ? '' : ' ' . $moduleclass_sfx;

echo "<ul class='breadcrumb'{$moduleclass_sfx}>";
$here ='';
if ($params->get('showHere', 1))
{
	$here = "<li>&#160;" . JText::_('MOD_BREADCRUMBS_HERE') . "&#160;</li>";
}
echo "<li><span class='divider icon-home'></span></li>{$here}";

// Get rid of duplicated entries on trail including home page when using multilanguage
for ($i = 0; $i < $count; $i++)
{
	if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
	{
		unset($list[$i]);
	}
}

// Find last and penultimate items in breadcrumbs list
end($list);
$last_item_key = key($list);
prev($list);
$penult_item_key = key($list);

// Make a link if not the last item in the breadcrumbs
$show_last = $params->get('showLast', 1);

// Generate the trail
foreach ($list as $key => $item)
{
	if ($key != $last_item_key)
	{
		// Render all but last item - along with separator
		echo "<li>";
			if (!empty($item->link))
			{
				echo "<a href='{$item->link}' class='pathway'><span>{$item->name}</span></a>";
			}
			else
			{
				echo "<span>{$item->name}</span>";
			}

			if (($key != $penult_item_key) || $show_last)
			{
				echo "<span class='divider icon-arrow-right'></span>";
			}
		echo "</li>";
	}
	elseif ($show_last)
	{
		// Render last item if reqd.
		echo "<li class='active'><span>{$item->name}</span></li>";
	}
}
echo "</ul>";

