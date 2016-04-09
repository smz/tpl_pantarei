<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('JPATH_BASE') or die;

extract($displayData);

echo "<dt class='hits'><span class='icon-eye-open'></span>" . JText::sprintf('COM_CONTENT_ARTICLE_HITS', '') . "</dt>";
echo "<dd>{$item->hits}</dd>";
