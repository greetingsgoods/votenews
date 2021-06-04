<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");
?><? $APPLICATION->IncludeComponent(
	"bitrix:main.profile",
	"",
	array(
		"SET_TITLE" => "Y",
	)
); ?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
