<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("COMP_NAME"),
	"DESCRIPTION" => GetMessage("COMPONENT_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"SORT" => 10,
	"PATH" => array(
		"ID" => GetMessage("COMPANY_NAME"),
		"CHILD" => array(
			"ID" => "Iblock",
			"NAME" => GetMessage("COMPONENT_SECTION"),
			"SORT" => 10
		)
	),
	"CACHE_PATH" => "Y"
);
?>
