<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (array_key_exists("PHOTOGALLERY", $arResult["DISPLAY_PROPERTIES"]) && !empty($arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"])) {
	CModule::IncludeModule("iblock");
	$arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["DISPLAY_VALUE"] = array();
	$dbElements = CIBlockElement::GetList(array(), array("ID" => $arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["VALUE"]), false, false, array("DETAIL_PICTURE"));
	while ($arElement = $dbElements->GetNext()) {
		if (!empty($arElement["DETAIL_PICTURE"])) {
			$arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["DISPLAY_VALUE"]["PREVIEW_PICTURE"][] = CFile::ResizeImageGet($arElement["DETAIL_PICTURE"], array("width" => 150, "height" => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
			$arResult["DISPLAY_PROPERTIES"]["PHOTOGALLERY"]["DISPLAY_VALUE"]["DETAIL_PICTURE"][] = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
		}

	}
}

?>
