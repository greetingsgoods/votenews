<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (!empty($arResult["ITEMS"])) {
	CModule::IncludeModule("iblock");
	$arSections = array();
	foreach ($arResult["ITEMS"] as $arItem) {
		if (!empty($arItem["IBLOCK_SECTION_ID"])) {
			$arSections[] = $arItem["IBLOCK_SECTION_ID"];
		}
	}
	$arSections = array_unique($arSections);
	$dbSections = CIBlockSection::GetList(array(), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arSections), false, array("ID", "NAME", "SECTION_PAGE_URL"));
	$arSections = array();
	while ($arSection = $dbSections->GetNext()) {
		$arSections[$arSection["ID"]] = $arSection;
	}
	foreach ($arResult["ITEMS"] as $i => $arItem) {
		$arResult["ITEMS"][$i]["SECTION"] = $arSections[$arItem["IBLOCK_SECTION_ID"]];
	}
}
?>
