<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/jquery.min.js");
$APPLICATION->AddHeadScript("/bitrix/templates/.default/js/vote.js");
?>
<style>
    .vote-form a {
        display: inline-block !important;
        text-decoration: none !important;
        cursor: pointer;
        padding-left: 20px;
        margin: 0 20px;
    }

    .vote-form .like {
        background: url(/bitrix/components/local.newsvote/news.vote/templates/.default/images/like.png) 0 center no-repeat !important;
    }

    .vote-form .dislike {
        background: url(/bitrix/components/local.newsvote/news.vote/templates/.default/images/dislike.png) 0 center no-repeat !important;
    }

</style>
