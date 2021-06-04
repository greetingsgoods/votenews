<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

//echo "<pre>"; print_r($arResult);echo "</pre>";

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");

?>
<div class="sort-conteiner pager-conteiner clearfix">
    <ul class="pager">
		<? if ($arResult["NavPageNomer"] > 2): ?>
            <li>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                   class="page page-prev"></a></li>
		<? else: ?>
            <li><a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" class="page page-prev">
                </a></li>
		<? endif ?>

		<? while ($arResult["nStartPage"] <= $arResult["nEndPage"]): ?>
            <li>
				<? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"
                       class="page current"><?= $arResult["nStartPage"] ?></a>
				<? elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
                    <a class="page"
                       href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $arResult["nStartPage"] ?></a>
				<? else: ?>
                    <a class="page"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
				<? endif ?>
            </li>
			<? $arResult["nStartPage"]++ ?>
		<? endwhile ?>

        <li>
			<? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
                <a class="page page-next"
                   href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"></a>
			<? else: ?>
                <a class="page page-next" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"></a>
			<? endif ?>
        </li>
    </ul>

    <div class="cb"></div>
</div>
