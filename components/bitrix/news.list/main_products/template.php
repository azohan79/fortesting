<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="mainPage-section-5__body">
    <div class="mainPage-section-5__slider">
        <? foreach($arResult['ITEMS'] as $item) :?>
            <?
            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="mainPage-section-5__helper" id="<?=$this->GetEditAreaId($item['ID']);?>">
                <div class="mainPage-section-5__item" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/backgrounds/<?=str_replace('#', '', $item['PROPERTIES']['CARD_COLOR']['VALUE_XML_ID'])?>.png)">
                    <div class="mainPage-section-5__main">
                        <div class="mainPage-section-5__main-info">
                            <!-- <div class="mainPage-section-5__main-title">
                                ФГК
                            </div> -->
                            <div class="mainPage-section-5__main-link">
                                <a href="<?=$item['DETAIL_PAGE_URL']?>" class="mainPage-section-2__link link-type-1">
                                    <span class="link-type-1__text">
                                        <?=$item['NAME']?>
                                    </span>
                                    <span class="link-type-1__img">
                                        <img src="<?=SITE_TEMPLATE_PATH?>/img/icon_arrow.svg" alt="">
                                    </span>
                                </a>
                            </div>
                        </div>
                        <a href="<?=$item['DETAIL_PAGE_URL']?>" class="mainPage-section-5__main-img">
                            <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="">
                        </a>
                    </div>
                    <div class="mainPage-section-5__block">
                        <? if ($item['PROPERTIES']['ICON']['VALUE'] || $item['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                            <div class="mainPage-section-5__block-top">
                                <? if ($item['PROPERTIES']['ICON']['VALUE']) :?>
                                    <div class="mainPage-section-5__block-top-img">
                                        <?=str_replace('stroke', 'stroke="' . $item['PROPERTIES']['CARD_COLOR']['VALUE_XML_ID'] . '" stroke-width="3"', file_get_contents($_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($item['PROPERTIES']['ICON']['VALUE'])))?>
                                    </div>
                                <? endif; ?>

                                <? if ($item['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                                    <div class="mainPage-section-5__block-top-title">
                                        <?=$item['PROPERTIES']['ICON_TEXT']['VALUE']?>
                                    </div>
                                <? endif; ?>
                            </div>
                        <? endif; ?>

                        <div class="mainPage-section-5__block-text text-type-8">
                            <p>
                                <?=$item['DETAIL_TEXT']?>
                            </p>
                        </div>

                        <? if ($item['DISPLAY_PROPERTIES']) :?>
                            <div class="mainPage-section-5__block-bottom">
                                <? foreach($item['DISPLAY_PROPERTIES'] as $prop) :?>
                                    <div class="mainPage-section-5__block-info" style="border-color: <?=$item['PROPERTIES']['CARD_COLOR']['VALUE_XML_ID']?>">
                                        <div class="mainPage-section-5__block-info-title text-type-1">
                                            <?=$prop['DISPLAY_VALUE']?>
                                        </div>
                                        <div class="mainPage-section-5__block-info-text text-type-8">
                                            <?=$prop['NAME']?>
                                        </div>
                                    </div>
                                <? endforeach; ?>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>