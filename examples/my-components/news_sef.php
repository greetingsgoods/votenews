<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новости"); ?><? $APPLICATION->IncludeComponent(
	"demo:news",
	"",
	array(
		"SEF_MODE" => "Y",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "3",
		"NEWS_COUNT" => "5",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"SET_TITLE" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_FOLDER" => "/examples/my-components/news/",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"detail" => "#ELEMENT_ID#/"
		),
		"VARIABLE_ALIASES" => array(
			"news" => array(),
			"detail" => array(),
		)
	)
); ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
