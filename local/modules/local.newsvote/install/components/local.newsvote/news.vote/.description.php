<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("LOCAL_NEWS.VOTE_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("LOCAL_NEWS.VOTE_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/regions.gif",
	"SORT" => 500,
	"PATH" => array(
		"ID" => "local_newsvote_components",
		"SORT" => 500,
		"NAME" => GetMessage("LOCAL_NEWS.VOTE_COMPONENTS_FOLDER_NAME"),
	),
);

?>
