<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class NewsVoteComponent extends CBitrixComponent
{


	public function executeComponent()
	{
		if ($this->startResultCache()) {

			if (!empty($this->arParams["ELEMENT_ID"])) {

				CModule::IncludeModule("iblock");

				$dbProperty = CIBlockElement::GetProperty($this->arParams["IBLOCK_ID"], $this->arParams["ELEMENT_ID"], array("SORT" => "ASC"), array("CODE" => "LIKE"));
				$arProperty = $dbProperty->Fetch();
				if (empty($arProperty["VALUE"]))
					$this->arResult["LIKE"] = 0;
				else
					$this->arResult["LIKE"] = (int)$dbProperty->SelectedRowsCount();

				$dbProperty = CIBlockElement::GetProperty($this->arParams["IBLOCK_ID"], $this->arParams["ELEMENT_ID"], array("SORT" => "ASC"), array("CODE" => "DISLIKE"));
				$arProperty = $dbProperty->Fetch();
				if (empty($arProperty["VALUE"]))
					$this->arResult["DISLIKE"] = 0;
				else
					$this->arResult["DISLIKE"] = (int)$dbProperty->SelectedRowsCount();

				$this->IncludeComponentTemplate();

			}

			$this->includeComponentTemplate();
		}
	}
}

?>
