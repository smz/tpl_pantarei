<?php
/**
 * @copyright   Copyright (C) 2016 Sergio Manzi. All rights reserved.
 * @license     GNU General Public License (GNU GPL) Version 3; See http://www.gnu.org/licenses/gpl.html
 *
 * Part of this code might be Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 */

defined('_JEXEC') or die;

include_once __DIR__ . '/helpers/tpl-init.php';

?>
<!DOCTYPE html>
<html <?php echo $htmlOptions; ?>>
<head>
<jdoc:include type="head" />
</head>
<body class="print">
	<jdoc:include type="component" />
</body>
</html>
