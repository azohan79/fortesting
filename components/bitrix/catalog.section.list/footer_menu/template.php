<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['SECTIONS'])) return; ?>

<? $count = 0; ?>

<? foreach($arResult['SECTIONS'] as $item) :?>

    <? if ($count == 0) :?>
        <div class="sec3__footer-col">
    <? endif; ?>

    <div class="sec3__block">
        <a href="<?=$item['SECTION_PAGE_URL']?>" class="sec3__block-head">
            <?=$item['NAME']?>
        </a>

        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list", 
            "footer_menu", 
            array(
                "COMPONENT_TEMPLATE" => "opt_advantages",
                "IBLOCK_TYPE" => "content",
                "IBLOCK_ID" => "2",
                "NEWS_COUNT" => "4",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "DESC",
                "FILTER_NAME" => "",
                "FIELD_CODE" => array(
                    0 => "PREVIEW_PICTURE",
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
                "PARENT_SECTION" => $item['ID'],
                "PARENT_SECTION_CODE" => "",
                "INCLUDE_SUBSECTIONS" => "N",
                "STRICT_SECTION_CHECK" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "PAGER_TEMPLATE" => ".default",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Новости",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "SET_STATUS_404" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
            ),
            false
        );?>
    </div>

    <? $count++; ?>

    <? if ($count == 2) :?>
        <? $count = 0; ?>
        </div>
    <? endif; ?>
<? endforeach; ?>

<? if ($count != 0) :?>
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "about",
            array(
                "ROOT_MENU_TYPE" => "about",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS" => array(),
                "MAX_LEVEL" => "1",
                "USE_EXT" => "N",
                "TITLE" => "О компании",
                "URL" => "/about/"
            ),
            false
        ); ?>

        <div class="sec3__block">
            <a href="/about/projects/" class="sec3__block-head">Портфолио</a>
        </div>
    </div>
<? else :?>
    <div class="sec3__footer-col">
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "about",
            array(
                "ROOT_MENU_TYPE" => "about",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "N",
                "MENU_CACHE_GET_VARS" => array(),
                "MAX_LEVEL" => "1",
                "USE_EXT" => "N",
            ),
            false
        ); ?>

        <div class="sec3__block">
            <a href="/about/projects/" class="sec3__block-head">Портфолио</a>
        </div>
    </div>
<? endif; ?>
