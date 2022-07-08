<?php declare(strict_types = 0);
/*
** Zabbix
** Copyright (C) 2001-2022 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


/**
 * @var CView $this
 * @var array $data
 */
?>
<?= (new CScriptTemplate('valuemap-rename-row-tmpl'))->addItem(
	(new CRow([
		(new CTextBox('valuemap_rename[#{rowNum}][from]', '', false, DB::getFieldLength('valuemap', 'name')))
			->addStyle('width: 100%;'),
		(new CTextBox('valuemap_rename[#{rowNum}][to]', '', false, DB::getFieldLength('valuemap', 'name')))
			->addStyle('width: 100%;'),
		(new CCol(
			(new CButton(null, _('Remove')))
				->addClass(ZBX_STYLE_BTN_LINK)
				->addClass('element-table-remove'))
		)
			->addClass(ZBX_STYLE_TOP)
	]))->addClass('form_row')
); ?>

<script type="text/x-jquery-tmpl" id="macro-row-tmpl">
	<?= (new CRow([
			(new CCol([
				(new CTextAreaFlexible('macros[#{rowNum}][macro]', '', ['add_post_js' => false]))
					->addClass('macro')
					->setAdaptiveWidth(ZBX_TEXTAREA_MACRO_WIDTH)
					->setAttribute('placeholder', '{$MACRO}')
			]))->addClass(ZBX_STYLE_TEXTAREA_FLEXIBLE_PARENT),
			(new CCol(
				new CMacroValue(ZBX_MACRO_TYPE_TEXT, 'macros[#{rowNum}]', '', false)
			))->addClass(ZBX_STYLE_TEXTAREA_FLEXIBLE_PARENT),
			(new CCol(
				(new CTextAreaFlexible('macros[#{rowNum}][description]', '', ['add_post_js' => false]))
					->setMaxlength(DB::getFieldLength('globalmacro', 'description'))
					->setAdaptiveWidth(ZBX_TEXTAREA_MACRO_VALUE_WIDTH)
					->setAttribute('placeholder', _('description'))
			))->addClass(ZBX_STYLE_TEXTAREA_FLEXIBLE_PARENT),
			(new CCol(
				(new CButton('macros[#{rowNum}][remove]', _('Remove')))
					->addClass(ZBX_STYLE_BTN_LINK)
					->addClass('element-table-remove')
			))
				->addClass(ZBX_STYLE_NOWRAP)
				->addClass(ZBX_STYLE_TOP)
		]))
			->addClass('form_row')
			->toString()
	?>
</script>

<script type="text/x-jquery-tmpl" id="tag-row-tmpl">
	<?= renderTagTableRow('#{rowNum}', '', '', ZBX_TAG_MANUAL, ['add_post_js' => false]) ?>
</script>

<script type="text/x-jquery-tmpl" id="custom-intervals-tmpl">
	<tr class="form_row">
		<td>
			<ul class="<?= CRadioButtonList::ZBX_STYLE_CLASS ?>" id="delay_flex_#{rowNum}_type">
				<li>
					<input type="radio" id="delay_flex_#{rowNum}_type_0" name="delay_flex[#{rowNum}][type]" value="0" checked="checked">
					<label for="delay_flex_#{rowNum}_type_0"><?= _('Flexible') ?></label>
				</li><li>
					<input type="radio" id="delay_flex_#{rowNum}_type_1" name="delay_flex[#{rowNum}][type]" value="1">
					<label for="delay_flex_#{rowNum}_type_1"><?= _('Scheduling') ?></label>
				</li>
			</ul>
		</td>
		<td>
			<input type="text" id="delay_flex_#{rowNum}_delay" name="delay_flex[#{rowNum}][delay]" maxlength="255" placeholder="<?= ZBX_ITEM_FLEXIBLE_DELAY_DEFAULT ?>" style="max-width: 100px; width: 100%;">
			<input type="text" id="delay_flex_#{rowNum}_schedule" name="delay_flex[#{rowNum}][schedule]" maxlength="255" placeholder="<?= ZBX_ITEM_SCHEDULING_DEFAULT ?>" style="display: none; max-width: 100px; width: 100%;">
		</td>
		<td>
			<input type="text" id="delay_flex_#{rowNum}_period" name="delay_flex[#{rowNum}][period]" maxlength="255" placeholder="<?= ZBX_DEFAULT_INTERVAL ?>" style="max-width: 110px; width: 100%;">
		</td>
		<td>
			<button type="button" id="delay_flex_#{rowNum}_remove" name="delay_flex[#{rowNum}][remove]" class="<?= ZBX_STYLE_BTN_LINK ?> element-table-remove"><?= _('Remove') ?></button>
		</td>
	</tr>
</script>

<script type="text/x-jquery-tmpl" id="dependency-row-tmpl">
	<tr id="dependency_#{triggerid}" data-triggerid="#{triggerid}">
		<td>
			<input type="hidden" name="dependencies[]" id="dependencies_#{triggerid}" value="#{triggerid}">
			<a href="#{url}" target="_blank" rel="noopener<?= ZBX_NOREFERER ? ' noreferrer' : '' ?>">#{name}</a>
		</td>
		<td class="<?= ZBX_STYLE_NOWRAP ?>">
			<?= (new CButton('remove', _('Remove')))
					->onClick("javascript: removeDependency('#{triggerid}');")
					->addClass(ZBX_STYLE_BTN_LINK)
					->removeId()
			?>
		</td>
	</tr>
</script>
