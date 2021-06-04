<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class NewsVoteComponent extends CBitrixComponent
{


	public function executeComponent()
	{
		if ($this->startResultCache()) {

			if (!empty($arParams["ELEMENT_ID"])) {

				CModule::IncludeModule("iblock");

				$dbProperty = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], array("SORT" => "ASC"), array("CODE" => "LIKE"));
				$arProperty = $dbProperty->Fetch();
				if (empty($arProperty["VALUE"]))
					$arResult["LIKE"] = 0;
				else
					$arResult["LIKE"] = intval($dbProperty->SelectedRowsCount());

				$dbProperty = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $arParams["ELEMENT_ID"], array("SORT" => "ASC"), array("CODE" => "DISLIKE"));
				$arProperty = $dbProperty->Fetch();
				if (empty($arProperty["VALUE"]))
					$arResult["DISLIKE"] = 0;
				else
					$arResult["DISLIKE"] = intval($dbProperty->SelectedRowsCount());

				$this->IncludeComponentTemplate();

			}

			$this->includeComponentTemplate();
		}
	}
}

?>
