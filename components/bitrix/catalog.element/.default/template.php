<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DESCRIPTION_ID' => $mainId . '_description',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);

$obName = $templateData['JS_OBJ'] = 'ob' . preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);


$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
} else {
    $actualItem = $arResult;
}

$curPrice = $actualItem['MIN_PRICE'];

if ($arResult['PROPERTIES']['OLD_PRICE']['VALUE']) {
    if ($arResult['PROPERTIES']['OLD_PRICE']['VALUE'] > $curPrice['DISCOUNT_VALUE_VAT']) {
        $curPrice['VALUE'] = $arResult['PROPERTIES']['OLD_PRICE']['VALUE'];
        $curPrice['PRINT_VALUE'] = CurrencyFormat($curPrice['VALUE'], $curPrice['CURRENCY']);

        $buffer = $curPrice['VALUE'] - $curPrice['DISCOUNT_VALUE_VAT'];
        $curPrice['DISCOUNT_DIFF_PERCENT'] = ceil(100 / $curPrice['VALUE'] * $buffer);
    }
}
?>
    <div class="cont">
        <div class="product-card" id="<?=$itemIds['ID']?>">
            <div class="product-card__left">
                <div class="product-card__images">
                    <div class="product-card__images-top">
                        <div class="product-card__images-top-main">
                            <div class="product-card__images-top-bg">
                                <svg width="269" height="677" viewBox="0 0 269 677" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M268.059 104.415V676.807L0.181641 312.538V12.3682C0.181641 4.3442 8.07615 -1.29768 15.6677 1.30094L252.241 82.2807C261.703 85.5195 268.059 94.4144 268.059 104.415Z" fill="<?=$arResult['PROPERTIES']['CARD_COLOR']['VALUE_XML_ID']?>"/>
                                </svg>
                            </div>
                            <div class="product-card__slider-big">
                                <? foreach($arResult['PROPERTIES']['GALLERY']['VALUE'] as $img) :?>
                                    <div class="product-card__slider-big-item">
                                        <img src="<?=CFile::GetPath($img)?>" alt="">
                                    </div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-card__images-bottom">
                        <div class="product-card__slider-small">
                            <? foreach($arResult['PROPERTIES']['GALLERY']['VALUE'] as $img) :?>
                                <div class="product-card__slider-small-helper">
                                    <div class="product-card__slider-small-item">
                                        <img src="<?=CFile::GetPath($img)?>" alt="">
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="product-card__right">
                    <div class="product-card__right-main">
                        <div class="product-card__right-info">
                            <div class="product-card__title">
                                <?=$arResult['NAME']?>
                            </div>
                            <div class="product-card__description">
                                <?=$arResult['PREVIEW_TEXT']?>
                            </div>
                            <div class="product-card__line">
                                <div class="product-card__price">
                                    <?=str_replace('&#8381;', '<span class="font-inter">₽</span>', $curPrice['PRINT_DISCOUNT_VALUE'])?>
                                </div>
                                <a href="<?=SITE_DIR?>personal/" class="product-card__btn btn-type-1">
                                    Заказать
                                </a>
                            </div>
                        </div>
                        <div class="product-card__info">
                            <div class="mainPage-section-5__block">
                                <? if ($arResult['PROPERTIES']['ICON']['VALUE'] || $arResult['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                                    <div class="mainPage-section-5__block-top">
                                        <? if ($arResult['PROPERTIES']['ICON']['VALUE']) :?>
                                            <div class="mainPage-section-5__block-top-img">
                                                <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ICON']['VALUE'])?>" width="24" height="24">
                                            </div>
                                        <? endif; ?>

                                        <? if ($arResult['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                                            <div class="mainPage-section-5__block-top-title">
                                                <?=$arResult['PROPERTIES']['ICON_TEXT']['VALUE']?>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                <? endif; ?>

                                <div class="mainPage-section-5__block-text text-type-8">
                                    <?=$arResult['DETAIL_TEXT']?>
                                </div>

                                <? if ($arResult['DISPLAY_PROPERTIES']) :?>
                                    <div class="mainPage-section-5__block-bottom">
                                        <? foreach($arResult['DISPLAY_PROPERTIES'] as $prop) :?>
                                            <div class="mainPage-section-5__block-info">
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

                    <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE'] || $arResult['PROPERTIES']['CERTIFICATES']['VALUE'] || $arResult['PROPERTIES']['COMPOUND']['VALUE'] || $arResult['PROPERTIES']['APPLICATION']['VALUE'] || $arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                        <div class="product-card__right-tools">
                            <div class="product-card__right-tools-head">
                                <div class="product-card__right-tools-head-list">
                                    <? $active = false; ?>

                                    <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE']) :?>
                                        <div data-tool-link="advantages" class="product-card__right-tools-item tool-link active">
                                            Преимущества
                                        </div>
                                        <? $active = true; ?>
                                    <? endif; ?>
                                    <? if ($arResult['PROPERTIES']['CERTIFICATES']['VALUE']) :?>
                                        <div data-tool-link="certificates" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                            Сертификаты (<?=count($arResult['PROPERTIES']['CERTIFICATES']['VALUE'])?>)
                                        </div>
                                        <? $active = true; ?>
                                    <? endif; ?>
                                    <? if ($arResult['PROPERTIES']['COMPOUND']['VALUE']) :?>
                                        <div data-tool-link="structure" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                            Состав
                                        </div>
                                        <? $active = true; ?>
                                    <? endif; ?>
                                    <? if ($arResult['PROPERTIES']['APPLICATION']['VALUE']) :?>
                                        <div data-tool-link="application" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                            Применение
                                        </div>
                                        <? $active = true; ?>
                                    <? endif; ?>
                                    <? if ($arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                                        <div data-tool-link="videos" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                            Видео (<?=count($arResult['PROPERTIES']['VIDEO']['VALUE'])?>)
                                        </div>
                                        <? $active = true; ?>
                                    <? endif; ?>
                                </div>
                            </div>
                            <div class="product-card__right-tools-body">
                                <? $active = false; ?>

                                <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE']) :?>
                                    <div class="product-card__right-tools-block tool-block tool-block-advantages active">
                                        <div class="product-card__text">
                                            <?=html_entity_decode($arResult['PROPERTIES']['ADVANTAGES']['VALUE']['TEXT'])?>
                                        </div>
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['CERTIFICATES']['VALUE']) :?>
                                    <div class="product-card__right-tools-block tool-block tool-block-certificates <?=!$active ? 'active' : ''?>">
                                        <div class="product-card__certificates">
                                            <div class="product-card__certificates-list">
                                                <? foreach($arResult['PROPERTIES']['CERTIFICATES']['VALUE'] as $cert) :?>
                                                    <div class="product-card__certificates-helper">
                                                        <a href="<?=CFile::GetPath($cert)?>" style="background-image: url(<?=CFile::GetPath($cert)?>)" class="fancybox-link product-card__certificates-item" >
                                                            <img src="<?=CFile::GetPath($cert)?>" alt="">
                                                        </a>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['COMPOUND']['VALUE']) :?>
                                    <div class="product-card__right-tools-block tool-block tool-block-structure <?=!$active ? 'active' : ''?>">
                                        <div class="product-card__text">
                                            <?=html_entity_decode($arResult['PROPERTIES']['COMPOUND']['VALUE']['TEXT'])?>
                                        </div>
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['APPLICATION']['VALUE']) :?>
                                    <div class="product-card__right-tools-block tool-block tool-block-application <?=!$active ? 'active' : ''?>">
                                        <div class="product-card__text">
                                            <?=html_entity_decode($arResult['PROPERTIES']['APPLICATION']['VALUE']['TEXT'])?>
                                        </div>
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                                    <div class="product-card__right-tools-block tool-block tool-block-videos <?=!$active ? 'active' : ''?>">
                                        <div class="product-card__videos">
                                            <div class="product-card__videos-list">
                                                <? foreach($arResult['PROPERTIES']['VIDEO']['VALUE'] as $video) :?>
                                                    <div class="product-card__videos-helper">
                                                        <a href="javascript:void(0)" class="product-card__videos-item">
                                                            <?=html_entity_decode($video)?>
                                                        </a>
                                                    </div>
                                                <? endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                            </div>
                        </div>
                    <? endif; ?>
                </div>

                <div class="product-card__reviews">
                    <div class="product-card__reviews-head">
                        <div class="product-card__reviews-head-title">
                            Отзывы о продукте
                        </div>
                        <!-- <a href="javascript:void(0)" class="product-card__reviews-head-button">
                            Оставить отзыв
                        </a> -->
                    </div>

                    <? $GLOBALS['arrReviewsFilter']['PROPERTY_PRODUCT'] = $arResult['ID']; ?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:news.list", 
                        "reviews", 
                        array(
                            "COMPONENT_TEMPLATE" => "socv",
                            "IBLOCK_TYPE" => "content",
                            "IBLOCK_ID" => "8",
                            "NEWS_COUNT" => "2",
                            "SORT_BY1" => "ID",
                            "SORT_ORDER1" => "DESC",
                            "SORT_BY2" => "ID",
                            "SORT_ORDER2" => "DESC",
                            "FILTER_NAME" => "arrReviewsFilter",
                            "FIELD_CODE" => array(
                                0 => "DETAIL_PICTURE",
                                1 => "DATE_CREATE"
                            ),
                            "PROPERTY_CODE" => array(
                                "URL", "ICON"
                            ),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "SET_TITLE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "INCLUDE_SUBSECTIONS" => "N",
                            "STRICT_SECTION_CHECK" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "PAGER_TEMPLATE" => "show_more",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "PAGER_TITLE" => "Новости",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "SET_STATUS_404" => "N",
                            "SHOW_404" => "N",
                            "MESSAGE_404" => ""
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="product-card__right">
                <div class="product-card__right-main">
                    <div class="product-card__right-info">
                        <div class="product-card__title">
                            <?=$arResult['NAME']?>
                        </div>
                        <div class="product-card__description">
                            <?=$arResult['PREVIEW_TEXT']?>
                        </div>
                        <div class="product-card__line">
                            <div class="product-card__price">
                                <?=str_replace('&#8381;', '<span class="font-inter">₽</span>', $curPrice['PRINT_DISCOUNT_VALUE'])?>
                            </div>
                            <a href="<?=SITE_DIR?>personal/" class="product-card__btn btn-type-1">
                                Заказать
                            </a>
                        </div>
                    </div> 
                    <div class="product-card__info">
                        <div class="mainPage-section-5__block">
                            <? if ($arResult['PROPERTIES']['ICON']['VALUE'] || $arResult['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                                <div class="mainPage-section-5__block-top">
                                    <? if ($arResult['PROPERTIES']['ICON']['VALUE']) :?>
                                        <div class="mainPage-section-5__block-top-img">
                                            <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ICON']['VALUE'])?>" width="24" height="24">
                                        </div>
                                    <? endif; ?>

                                    <? if ($arResult['PROPERTIES']['ICON_TEXT']['VALUE']) :?>
                                        <div class="mainPage-section-5__block-top-title">
                                            <?=$arResult['PROPERTIES']['ICON_TEXT']['VALUE']?>
                                        </div>
                                    <? endif; ?>
                                </div>
                            <? endif; ?>

                            <div class="mainPage-section-5__block-text text-type-8">
                                <?=$arResult['DETAIL_TEXT']?>
                            </div>

                            <? if ($arResult['DISPLAY_PROPERTIES']) :?>
                                <div class="mainPage-section-5__block-bottom">
                                    <? foreach($arResult['DISPLAY_PROPERTIES'] as $prop) :?>
                                        <div class="mainPage-section-5__block-info">
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
                <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE'] || $arResult['PROPERTIES']['CERTIFICATES']['VALUE'] || $arResult['PROPERTIES']['COMPOUND']['VALUE'] || $arResult['PROPERTIES']['APPLICATION']['VALUE'] || $arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                    <div class="product-card__right-tools">
                        <div class="product-card__right-tools-head">
                            <div class="product-card__right-tools-head-list">
                                <? $active = false; ?>

                                <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE']) :?>
                                    <div data-tool-link="advantages" class="product-card__right-tools-item tool-link active">
                                        Преимущества
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['CERTIFICATES']['VALUE']) :?>
                                    <div data-tool-link="certificates" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                        Сертификаты (<?=count($arResult['PROPERTIES']['CERTIFICATES']['VALUE'])?>)
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['COMPOUND']['VALUE']) :?>
                                    <div data-tool-link="structure" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                        Состав
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['APPLICATION']['VALUE']) :?>
                                    <div data-tool-link="application" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                        Применение
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                                <? if ($arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                                    <div data-tool-link="videos" class="product-card__right-tools-item tool-link <?=!$active ? 'active' : ''?>">
                                        Видео (<?=count($arResult['PROPERTIES']['VIDEO']['VALUE'])?>)
                                    </div>
                                    <? $active = true; ?>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="product-card__right-tools-body">
                            <? $active = false; ?>

                            <? if ($arResult['PROPERTIES']['ADVANTAGES']['VALUE']) :?>
                                <div class="product-card__right-tools-block tool-block tool-block-advantages active">
                                    <div class="product-card__text">
                                        <?=html_entity_decode($arResult['PROPERTIES']['ADVANTAGES']['VALUE']['TEXT'])?>
                                    </div>
                                </div>
                                <? $active = true; ?>
                            <? endif; ?>
                            <? if ($arResult['PROPERTIES']['CERTIFICATES']['VALUE']) :?>
                                <div class="product-card__right-tools-block tool-block tool-block-certificates <?=!$active ? 'active' : ''?>">
                                    <div class="product-card__certificates">
                                        <div class="product-card__certificates-list">
                                            <? foreach($arResult['PROPERTIES']['CERTIFICATES']['VALUE'] as $cert) :?>
                                                <div class="product-card__certificates-helper">
                                                    <a href="<?=CFile::GetPath($cert)?>" style="background-image: url(<?=CFile::GetPath($cert)?>)" class="fancybox-link product-card__certificates-item" >
                                                        <img src="<?=CFile::GetPath($cert)?>" alt="">
                                                    </a>
                                                </div>
                                            <? endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <? $active = true; ?>
                            <? endif; ?>
                            <? if ($arResult['PROPERTIES']['COMPOUND']['VALUE']) :?>
                                <div class="product-card__right-tools-block tool-block tool-block-structure <?=!$active ? 'active' : ''?>">
                                    <div class="product-card__text">
                                        <?=html_entity_decode($arResult['PROPERTIES']['COMPOUND']['VALUE']['TEXT'])?>
                                    </div>
                                </div>
                                <? $active = true; ?>
                            <? endif; ?>
                            <? if ($arResult['PROPERTIES']['APPLICATION']['VALUE']) :?>
                                <div class="product-card__right-tools-block tool-block tool-block-application <?=!$active ? 'active' : ''?>">
                                    <div class="product-card__text">
                                        <?=html_entity_decode($arResult['PROPERTIES']['APPLICATION']['VALUE']['TEXT'])?>
                                    </div>
                                </div>
                                <? $active = true; ?>
                            <? endif; ?>
                            <? if ($arResult['PROPERTIES']['VIDEO']['VALUE']) :?>
                                <div class="product-card__right-tools-block tool-block tool-block-videos <?=!$active ? 'active' : ''?>">
                                    <div class="product-card__videos">
                                        <div class="product-card__videos-list">
                                            <? foreach($arResult['PROPERTIES']['VIDEO']['VALUE'] as $video) :?>
                                                <div class="product-card__videos-helper">
                                                    <a href="javascript:void(0)" class="product-card__videos-item">
                                                        <?=html_entity_decode($video)?>
                                                    </a>
                                                </div>
                                            <? endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <? $active = true; ?>
                            <? endif; ?>
                        </div>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </div>

    <?php
    if ($haveOffers) {
        $offerIds = array();
        $offerCodes = array();

        $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

        foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer) {
            $offerIds[] = (int)$jsOffer['ID'];
            $offerCodes[] = $jsOffer['CODE'];

            $fullOffer = $arResult['OFFERS'][$ind];
            $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

            $strAllProps = '';
            $strMainProps = '';
            $strPriceRangesRatio = '';
            $strPriceRanges = '';

            if ($arResult['SHOW_OFFERS_PROPS']) {
                if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
                    foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property) {
                        $current = '<dt>' . $property['NAME'] . '</dt><dd>' . (
                            is_array($property['VALUE'])
                                ? implode(' / ', $property['VALUE'])
                                : $property['VALUE']
                            ) . '</dd>';
                        $strAllProps .= $current;

                        if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']])) {
                            $strMainProps .= $current;
                        }
                    }

                    unset($current);
                }
            }

            if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1) {
                $strPriceRangesRatio = '(' . Loc::getMessage(
                        'CT_BCE_CATALOG_RATIO_PRICE',
                        array('#RATIO#' => ($useRatio
                                ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                                : '1'
                            ) . ' ' . $measureName)
                    ) . ')';

                foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range) {
                    if ($range['HASH'] !== 'ZERO-INF') {
                        $itemPrice = false;

                        foreach ($jsOffer['ITEM_PRICES'] as $itemPrice) {
                            if ($itemPrice['QUANTITY_HASH'] === $range['HASH']) {
                                break;
                            }
                        }

                        if ($itemPrice) {
                            $strPriceRanges .= '<dt>' . Loc::getMessage(
                                    'CT_BCE_CATALOG_RANGE_FROM',
                                    array('#FROM#' => $range['SORT_FROM'] . ' ' . $measureName)
                                ) . ' ';

                            if (is_infinite($range['SORT_TO'])) {
                                $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                            } else {
                                $strPriceRanges .= Loc::getMessage(
                                    'CT_BCE_CATALOG_RANGE_TO',
                                    array('#TO#' => $range['SORT_TO'] . ' ' . $measureName)
                                );
                            }

                            $strPriceRanges .= '</dt><dd>' . ($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']) . '</dd>';
                        }
                    }
                }

                unset($range, $itemPrice);
            }

            $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
            $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
            $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
            $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
        }

        $templateData['OFFER_IDS'] = $offerIds;
        $templateData['OFFER_CODES'] = $offerCodes;
        unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

        $jsParams = array(
            'CONFIG' => array(
                'USE_CATALOG' => $arResult['CATALOG'],
                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                'SHOW_PRICE' => true,
                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
                'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
                'OFFER_GROUP' => $arResult['OFFER_GROUP'],
                'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
                'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
                'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
                'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                'USE_STICKERS' => true,
                'USE_SUBSCRIBE' => $showSubscribe,
                'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
                'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
                'ALT' => $alt,
                'TITLE' => $title,
                'MAGNIFIER_ZOOM_PERCENT' => 200,
                'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                    ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                    : null,
                'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
                'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
            ),
            'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
            'VISUAL' => $itemIds,
            'DEFAULT_PICTURE' => array(
                'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
                'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
            ),
            'PRODUCT' => array(
                'ID' => $arResult['ID'],
                'ACTIVE' => $arResult['ACTIVE'],
                'NAME' => $arResult['~NAME'],
                'CATEGORY' => $arResult['CATEGORY_PATH'],
                'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
                'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
                'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
                'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
            ),
            'BASKET' => array(
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'BASKET_URL' => $arParams['BASKET_URL'],
                'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
                'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
            ),
            'OFFERS' => $arResult['JS_OFFERS'],
            'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
            'TREE_PROPS' => $skuProps,
        );
    } else {
        $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
        if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties) {
            ?>
            <div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
                <?php
                if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
                    foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo) {
                        ?>
                        <input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                               value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
                        <?php
                        unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                    }
                }

                $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
                if (!$emptyProductProperties) {
                    ?>
                    <table>
                        <?php
                        foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo) {
                            ?>
                            <tr>
                                <td><?= $arResult['PROPERTIES'][$propId]['NAME'] ?></td>
                                <td>
                                    <?php
                                    if (
                                        $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                        && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                    ) {
                                        foreach ($propInfo['VALUES'] as $valueId => $value) {
                                            ?>
                                            <label>
                                                <input type="radio" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]"
                                                       value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"checked"' : '') ?>>
                                                <?= $value ?>
                                            </label>
                                            <br>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propId ?>]">
                                            <?php
                                            foreach ($propInfo['VALUES'] as $valueId => $value) {
                                                ?>
                                                <option value="<?= $valueId ?>" <?= ($valueId == $propInfo['SELECTED'] ? '"selected"' : '') ?>>
                                                    <?= $value ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
            </div>
            <?php
        }

        $jsParams = array(
            'CONFIG' => array(
                'USE_CATALOG' => $arResult['CATALOG'],
                'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
                'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
                'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
                'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
                'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
                'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
                'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
                'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                'USE_STICKERS' => true,
                'USE_SUBSCRIBE' => $showSubscribe,
                'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
                'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
                'ALT' => $alt,
                'TITLE' => $title,
                'MAGNIFIER_ZOOM_PERCENT' => 200,
                'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                    ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                    : null
            ),
            'VISUAL' => $itemIds,
            'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
            'PRODUCT' => array(
                'ID' => $arResult['ID'],
                'ACTIVE' => $arResult['ACTIVE'],
                'PICT' => reset($arResult['MORE_PHOTO']),
                'NAME' => $arResult['~NAME'],
                'SUBSCRIPTION' => true,
                'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
                'ITEM_PRICES' => $arResult['ITEM_PRICES'],
                'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
                'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
                'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
                'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
                'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
                'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
                'SLIDER' => $arResult['MORE_PHOTO'],
                'CAN_BUY' => $arResult['CAN_BUY'],
                'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
                'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
                'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
                'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
                'CATEGORY' => $arResult['CATEGORY_PATH']
            ),
            'BASKET' => array(
                'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
                'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                'EMPTY_PROPS' => $emptyProductProperties,
                'BASKET_URL' => $arParams['BASKET_URL'],
                'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
                'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
            )
        );
        unset($emptyProductProperties);
    }

    $jsParams["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"] = $arResult["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"];
    ?>
        <script>
            BX.message({
                ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
                TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
                TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
                BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
                BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
                BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
                BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
                BTN_MESSAGE_DETAIL_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
                TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
                COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
                COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
                COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
                BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
                PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
                PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
                RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
                RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
                SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
            });
            var basketList = Object.values(<?= json_encode($arResult['BASKET_LIST'] ?: []); ?>);
            var <?=$obName?> =
            new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
        </script>
    <?php
    unset($actualItem, $itemIds, $jsParams);
    ?>