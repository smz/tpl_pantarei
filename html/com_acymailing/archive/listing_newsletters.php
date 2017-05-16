<?php
/**
 * @package	AcyMailing for Joomla!
 * @version	5.7.0
 * @author	acyba.com
 * @copyright	(C) 2009-2017 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php if($this->values->filter){ ?>
	<input placeholder="<?php echo acymailing_translation('ACY_SEARCH'); ?>" type="text" name="search" id="acymailingsearch" value="<?php echo $this->escape($this->pageInfo->search); ?>" class="inputbox"/>
	<button class="btn btn-primary button buttongo" onclick="this.form.submit();"><?php echo acymailing_translation('JOOMEXT_GO'); ?></button>
	<button class="btn btn-primary button buttonreset" onclick="document.getElementById('acymailingsearch').value='';this.form.submit();"><?php echo acymailing_translation('JOOMEXT_RESET'); ?></button>
<?php }
echo '</td></tr></table>';
$k = 1;
for($i = 0, $a = count($this->rows); $i < $a; $i++){
	$row =& $this->rows[$i];
	$row->subject = Emoji::Decode($row->subject);
	echo '<div class="row-fluid cols-2 clearfix archiveRow archiveRow'.$k.$this->values->suffix.'">';

	echo '<div class="acyarchivetitle span9"><a '.($this->config->get('open_popup', 1) ? 'class="modal" rel="{handler: \'iframe\', size: {x: '.intval($this->config->get('popup_width', 750)).', y: '.intval($this->config->get('popup_height', 550)).'}}"' : '').'href="'.acymailing_completeLink('archive&task=view&listid='.$row->listid.'&mailid='.$row->mailid.'-'.strip_tags($row->alias).$this->item, (bool)$this->config->get('open_popup', 1)).'">';
	echo acymailing_dispSearch($row->subject, $this->pageInfo->search).'</a>';
	echo '</div>';
	if($this->values->show_senddate && !empty($row->senddate)){
		echo '<div class="sentondate span3">'. ltrim(acymailing_translation_sprintf(acymailing_getDate($row->senddate, acymailing_translation('DATE_FORMAT_LC3'))), '0') . '</div>';
	}
	echo '</div>';
	$k = 3 - $k;
}
?>
<table><tr><td>
