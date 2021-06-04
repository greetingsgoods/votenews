<?
if (!(bool)$_POST["elementID"]) {
	return;
	error_reporting(0);
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {  // } && !check_bitrix_sessid()){
	return;
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
$elementID = htmlspecialcharsbx($_POST["elementID"]);
$userID = htmlspecialcharsbx($_POST["userID"]);
$type = htmlspecialcharsbx($_POST["type"]);//like or dislike
$iblockID = htmlspecialcharsbx($_POST["iblockID"]);
$remoteIP = htmlspecialcharsbx($_SERVER['REMOTE_ADDR']);
$boolVote = function () {
	return !empty($_POST['type']);
};
$boolExistRecords = false;

if (!$boolExistRecords) {
	$result = $obj::add([
		'elementID' => $elementID,
		'iblocktID' => $iblockID,
		'IP' => $remoteIP,
		'vote' => 'Y'
	]);

	$arElement = CIBlockElement::GetByID($elementID)->GetNextElement();
	$arFields = $arElement->GetProperties();

	if (is_array($arFields["LIKE"]["VALUE"]) && in_array($userID, $arFields["LIKE"]["VALUE"])) {
		if ($type == "dislike") {
			//add to dislike

			$arProperty = $arFields["DISLIKE"]["VALUE"];
			$arProperty[] = $userID;
			CIBlockElement::SetPropertyValueCode($elementID, "DISLIKE", $arProperty);

			//remove from like
			$arProperty = $arFields["LIKE"]["VALUE"];
			$key = array_search($userID, $arProperty);
			if ($key !== false) {
				unset($arProperty[$key]);
			}
			CIBlockElement::SetPropertyValueCode($elementID, "LIKE", $arProperty);
		}
		//if type==like - do nothing. He already click like
	} elseif (is_array($arFields["DISLIKE"]["VALUE"]) && in_array($userID, $arFields["DISLIKE"]["VALUE"])) {
		if ($type == "like") {
			//add to like

			$arProperty = $arFields["LIKE"]["VALUE"];
			$arProperty[] = $userID;
			CIBlockElement::SetPropertyValueCode($elementID, "LIKE", $arProperty);

			//remove from dislike
			$arProperty = $arFields["DISLIKE"]["VALUE"];
			$key = array_search($userID, $arProperty);
			if ($key !== false) {
				unset($arProperty[$key]);
			}
			CIBlockElement::SetPropertyValueCode($elementID, "DISLIKE", $arProperty);
		}
	} else {
		//new vote
		if ($type == "like") {
			$arProperty = $arFields["LIKE"]["VALUE"];
			$arProperty[] = $userID;
			CIBlockElement::SetPropertyValueCode($elementID, "LIKE", $arProperty);
		} elseif ($type == "dislike") {
			$arProperty = $arFields["DISLIKE"]["VALUE"];
			$arProperty[] = $userID;
			CIBlockElement::SetPropertyValueCode($elementID, "DISLIKE", $arProperty);
		}
	}

	$dbProperty = CIBlockElement::GetProperty($iblockID, $elementID, array("SORT" => "ASC"), array("CODE" => "LIKE"));
	$arProperty = $dbProperty->Fetch();
	if (empty($arProperty["VALUE"]))
		$arResult["LIKE"] = 0;
	else
		$arResult["LIKE"] = intval($dbProperty->SelectedRowsCount());

	$dbProperty = CIBlockElement::GetProperty($iblockID, $elementID, array("SORT" => "ASC"), array("CODE" => "DISLIKE"));
	$arProperty = $dbProperty->Fetch();
	if (empty($arProperty["VALUE"]))
		$arResult["DISLIKE"] = 0;
	else
		$arResult["DISLIKE"] = intval($dbProperty->SelectedRowsCount());

	echo $arResult["LIKE"] . "/" . $arResult["DISLIKE"];


}

