<?php

use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

$module_id = 'local.newsvote';

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight($module_id) < "S") {
	$APPLICATION->AuthForm(Loc::getMessage("ACCESS_DENIED"));
}

Loader::includeModule($module_id);

$request = HttpApplication::getInstance()->getContext()->getRequest();


$aTabs = array(
	array(
		'DIV' => 'OSNOVNOE',
		'TAB' => Loc::getMessage('LOCAL_NEWSVOTE_TAB_OSNOVNOE'),
		'OPTIONS' => array(
			array('MODULE_NAME', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_MODULE_NAME_TITLE'), '', array('text', 0)),
			array('MODULE_DESC', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_MODULE_DESC_TITLE'), '', array('text', 0)),
			array('novosti', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_NOVOSTI_TITLE'), '', array('text', 0)),
			array('IBLOCK_TYPE_NAME', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_IBLOCK_TYPE_NAME_TITLE'), '', array('text', 0)),
			array('razdely', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_RAZDELY_TITLE'), '', array('text', 0)),
			array('IBLOCK_TYPE_SECTION_NAME', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_IBLOCK_TYPE_SECTION_NAME_TITLE'), '', array('text', 0)),
			array('IBLOCK_TYPE_ELEMENTS_NAME', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_IBLOCK_TYPE_ELEMENTS_NAME_TITLE'), '', array('text', 0)),
			array('IBLOCK_NAME', Loc::getMessage('LOCAL_NEWSVOTE_OPTION_IBLOCK_NAME_TITLE'), '', array('text', 0)),),
	),

	array(
		"DIV" => "rights",
		"TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
		"TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS"),
		"OPTIONS" => array()
	),
);
#Сохранение

if ($request->isPost() && $request['Apply'] && check_bitrix_sessid()) {

	foreach ($aTabs as $aTab) {
		foreach ($aTab['OPTIONS'] as $arOption) {
			if (!is_array($arOption))
				continue;

			if ($arOption['note'])
				continue;


			$optionName = $arOption[0];

			$optionValue = $request->getPost($optionName);

			Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
		}
	}
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

?>
<? $tabControl->Begin(); ?>
<form method='post'
      action='<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialcharsbx($request['mid']) ?>&amp;lang=<?= $request['lang'] ?>'
      name='local_newsvote_settings'>

	<? foreach ($aTabs as $aTab):
		if ($aTab['OPTIONS']):?>
			<? $tabControl->BeginNextTab(); ?>
			<? __AdmSettingsDrawList($module_id, $aTab['OPTIONS']); ?>

		<? endif;
	endforeach; ?>

	<?
	$tabControl->BeginNextTab();

	require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/admin/group_rights.php");

	$tabControl->Buttons(); ?>

    <input type="submit" name="Apply" value="<? echo GetMessage('MAIN_SAVE') ?>">
    <input type="hidden" name="Update" value="Y">
    <input type="reset" name="reset" value="<? echo GetMessage('MAIN_RESET') ?>">
	<?= bitrix_sessid_post(); ?>
</form>
<? $tabControl->End(); ?>

