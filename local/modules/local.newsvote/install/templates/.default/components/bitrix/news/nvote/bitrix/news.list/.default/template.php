<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="conteiner">

    <div class="contentbox">

        <div class="content content-library">

			<? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
				<?= $arResult["NAV_STRING"] ?>
			<? endif; ?>

            <div class="news-list clearfix">

				<? foreach ($arResult["ITEMS"] as $i => $arItem): ?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>

					<? if ($i % 2 == 0): ?><div class="news-container clearfix"><? endif ?>

                    <div class="col-<? if ($i % 2 == 0): ?>left<? else: ?>right<? endif ?>"
                         id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                        <div class="inner">

                            <div class="news-item clearfix">
                                <div class="news-item-date"><?= $arItem["DISPLAY_ACTIVE_FROM"] ?></div>
								<? if (!empty($arItem["PREVIEW_PICTURE"])): ?>
                                    <div class="news-item-photo">
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                                 style="max-width: 110px; max-height: 130px;" alt="">
                                        </a>
                                    </div>
								<? endif ?>
                                <div class="news-item-content">
                                    <div class="inner">
                                        <div class="news-item-content-title">
                                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= $arItem["NAME"] ?></a>
                                        </div>
                                        <a href="<?= $arItem["SECTION"]["SECTION_PAGE_URL"] ?>">
                                            <div class="news-item-content-category"><?= $arItem["SECTION"]["NAME"] ?></div>
                                        </a>
                                        <div class="news-item-content-info">
                                            <span class="news-item-icon news-item-like"><?= count($arItem["DISPLAY_PROPERTIES"]["LIKE"]["VALUE"]) ?></span>
                                            <span class="news-item-icon news-item-dislike"><?= count($arItem["DISPLAY_PROPERTIES"]["DISLIKE"]["VALUE"]) ?></span>
                                            <span class="news-item-icon news-item-view"><?= GetMessage("READ") ?> <?= $arItem["SHOW_COUNTER"] ?> <?= GetMessage("PEOPLES") ?></span>
                                            <a href=""
                                               class="news-item-icon news-item-comments"><?= empty($arItem["PROPERTIES"]["FORUM_MESSAGE_CNT"]["VALUE"]) ? "0" : $arItem["PROPERTIES"]["FORUM_MESSAGE_CNT"]["VALUE"] ?> <?= GetMessage("COMMENTS") ?></a>
                                        </div>
                                        <div class="news-item-content-anons">
											<?= $arItem["PREVIEW_TEXT"] ?>
                                        </div>
										<? if (!empty($arItem["TAGS"])): ?>
											<? $arTags = explode(",", $arItem["TAGS"]) ?>
                                            <div class="news-item-content-tags">
												<? if (is_array($arTags) && count($arTags) > 0): ?>
													<? foreach ($arTags as $tag): ?>
                                                        <a href="<?= $APPLICATION->GetCurPage(false) ?>?TAG=<?= $tag ?>"><?= $tag ?></a>,
													<? endforeach ?>
												<? elseif (!is_array($arTags)): ?>
                                                    <a href="<?= $APPLICATION->GetCurPage(false) ?>?TAG=<?= $arTags ?>"><?= $arTags ?></a>,
												<? endif ?>
                                            </div>
										<? endif ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
					<? if (($i + 1) % 2 == 0): ?></div><? endif ?>
				<? endforeach ?>


            </div>

			<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
				<?= $arResult["NAV_STRING"] ?>
			<? endif; ?>

        </div>
    </div>


</div>
