<?php 

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die;

$html = array();

$html[] = '<fieldset>';

$html[] =		'<label id="batch_setposition-lbl" for="batch_setposition">' . JText::_('COM_HELLOWORLD_BATCH_SETPOSITION_LABEL') . '</label>';

$html[] = 		'<select name="batch[position][setposition]">'.

					'<option value="keepPosition" selected>'. JText::_('COM_HELLOWORLD_BATCH_KEEP_POSITION') .'</option>'.
					'<option value="changePosition">'. JText::_('COM_HELLOWORLD_BATCH_CHANGE_POSITION') .'</option>'.

				'</select>';
//LATITUDE
$html[] = 		'<label id="batch_latitude-lbl" for="batch_latitude">' . JText::_('COM_HELLOWORLD_HELLOWORLD_FIELD_LATITUDE_LABEL') . '</label>';
$html[] =		'<input id="batch_latitude" name="batch[position][latitude]" class="inputbox" type="number" step=any min=-90.0 max=90.0 placeholder="0.0" />';

//LOGINTUDE
$html[] = 		'<label id="batch_logintude-lbl" for="batch_longitude">' . JText::_('COM_HELLOWORLD_HELLOWORLD_FIELD_LOGINTUDE_LABEL') . '</label>';
$html[] = 		'<input id="batch_longitude" name="batch[position][longitude]" class="inputbox" type="number" step=any min=-180.0 max=180.0 placeholder="0.0" />';

$html[] = '</fieldset>';

echo implode('', $html);

?>