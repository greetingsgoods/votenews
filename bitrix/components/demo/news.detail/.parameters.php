<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule("iblock"))
	return;

$arTypes = array();
$db_iblock_type = CIBlockType::GetList(array("SORT" => "ASC"));
while ($arRes = $db_iblock_type->Fetch())
	if ($arIBType = CIBlockType::GetByIDLang($arRes["ID"], LANG))
		$arTypes[$arRes["ID"]] = $arIBType["NAME"];

$arIBlocks = array();
$db_iblock = CIBlock::GetList(array("SORT" => "ASC"), array("SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while ($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypes,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_DETAIL_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => '={$_REQUEST["ID"]}',
		),

		"IBLOCK_URL" => array(
			"PARENT" => "URL_TEMPLATES",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_PAGE_URL"),
			"TYPE" => "STRING",
			"DEFAULT" => "news.php?ID=#IBLOCK_ID#",
		),

		"DISPLAY_PANEL" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PANEL"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),

		"SET_TITLE" => array(),

		"ADD_SECTIONS_CHAIN" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("T_IBLOCK_DESC_ADD_SECTIONS_CHAIN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),

		"CACHE_TIME" => array("DEFAULT" => 3600),
	),
);
?>
