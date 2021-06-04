<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/jquery.min.js");
$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/jquery.fancybox-1.3.4.pack.js");
$APPLICATION->SetAdditionalCSS("/bitrix/templates/.default/js/jquery.fancybox-1.3.4.css");
?>
<script>
    if (jQuery.fancybox) {
        $('.fancy').fancybox();
    }
</script>
