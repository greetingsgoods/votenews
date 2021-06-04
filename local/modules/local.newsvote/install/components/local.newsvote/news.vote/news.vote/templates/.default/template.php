<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<div class="vote-form">

    <input type="hidden" name="sessid" id="sessid" value="<?= bitrix_sessid() ?>"/>
    <input type="hidden" id="selffolder" value="<?= $componentPath ?>"/>
    <input type="hidden" id="user" value="<?= $USER->GetID() ?>"/>
    <input type="hidden" id="elementID" value="<?= $arParams["ELEMENT_ID"] ?>"/>
    <input type="hidden" id="iblockID" value="<?= $arParams["IBLOCK_ID"] ?>"/>

    <a href="#" class="like"><?= $arResult["LIKE"] ?></a>
    <a href="#" class="dislike"><?= $arResult["DISLIKE"] ?></a>

</div>
