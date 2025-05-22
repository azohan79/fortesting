<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if ($APPLICATION->GetCurDir() != SITE_DIR) :?>
        </div>
        <div class="site__bottom">
            <div class="footer__helper">
                <div class="footer__bg" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/img/footer_bg.png)"></div>
                <footer class="footer">
                    <div class="cont">
                        <div class="footer__cont">
                            <div class="footer__col">
                                <div class="footer__left">
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:menu",
                                        "bottom",
                                        array(
                                            "ROOT_MENU_TYPE" => "top",
                                            "MENU_CACHE_TYPE" => "A",
                                            "MENU_CACHE_TIME" => "3600",
                                            "MENU_CACHE_USE_GROUPS" => "N",
                                            "MENU_CACHE_GET_VARS" => array(),
                                            "MAX_LEVEL" => "1",
                                            "USE_EXT" => "N",
                                        ),
                                        false
                                    ); ?>

                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:news.list", 
                                        "payments", 
                                        array(
                                            "COMPONENT_TEMPLATE" => "socv",
                                            "IBLOCK_TYPE" => "content",
                                            "IBLOCK_ID" => "5",
                                            "NEWS_COUNT" => "10",
                                            "SORT_BY1" => "SORT",
                                            "SORT_ORDER1" => "ASC",
                                            "SORT_BY2" => "ID",
                                            "SORT_ORDER2" => "DESC",
                                            "FILTER_NAME" => "",
                                            "FIELD_CODE" => array(
                                                0 => "DETAIL_PICTURE",
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
                                            "MESSAGE_404" => ""
                                        ),
                                        false
                                    );?>

                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:menu",
                                        "bottom_dop",
                                        array(
                                            "ROOT_MENU_TYPE" => "bottom",
                                            "MENU_CACHE_TYPE" => "A",
                                            "MENU_CACHE_TIME" => "3600",
                                            "MENU_CACHE_USE_GROUPS" => "N",
                                            "MENU_CACHE_GET_VARS" => array(),
                                            "MAX_LEVEL" => "1",
                                            "USE_EXT" => "N",
                                        ),
                                        false
                                    ); ?>
                                    <div class="footer__left-bottom">
                                        <div class="footer__copyright">
                                            VERBALIFE | <?=date('Y')?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="footer__col">
                                <div class="footer__right">
                                    <div class="footer__right-top">
                                        <a href="<?=SITE_DIR?>personal/" class="footer__btn">
                                            <? $APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                Array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "PATH" => "/include/" . SITE_ID . "/text1.php"
                                                )
                                            );?>
                                        </a>

                                        <div class="footer__info">
                                            <div class="menu__contacts">
                                                <a href="tel:<? $APPLICATION->IncludeComponent(
                                                        "bitrix:main.include",
                                                        "",
                                                        Array(
                                                            "AREA_FILE_SHOW" => "file",
                                                            "PATH" => "/include/" . SITE_ID . "/phone.php"
                                                        )
                                                    );?>" class="menu__phone text-type-6">
                                                    <? $APPLICATION->IncludeComponent(
                                                        "bitrix:main.include",
                                                        "",
                                                        Array(
                                                            "AREA_FILE_SHOW" => "file",
                                                            "PATH" => "/include/" . SITE_ID . "/phone.php"
                                                        )
                                                    );?>
                                                </a>
                                                <a href="mailto:<? $APPLICATION->IncludeComponent(
                                                        "bitrix:main.include",
                                                        "",
                                                        Array(
                                                            "AREA_FILE_SHOW" => "file",
                                                            "PATH" => "/include/" . SITE_ID . "/email.php"
                                                        )
                                                    );?>" class="menu__email text-type-3">
                                                    <? $APPLICATION->IncludeComponent(
                                                        "bitrix:main.include",
                                                        "",
                                                        Array(
                                                            "AREA_FILE_SHOW" => "file",
                                                            "PATH" => "/include/" . SITE_ID . "/email.php"
                                                        )
                                                    );?>
                                                </a>
                                            </div>

                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:news.list", 
                                                "socv", 
                                                array(
                                                    "COMPONENT_TEMPLATE" => "socv",
                                                    "IBLOCK_TYPE" => "content",
                                                    "IBLOCK_ID" => "1",
                                                    "NEWS_COUNT" => "6",
                                                    "SORT_BY1" => "SORT",
                                                    "SORT_ORDER1" => "ASC",
                                                    "SORT_BY2" => "ID",
                                                    "SORT_ORDER2" => "DESC",
                                                    "FILTER_NAME" => "",
                                                    "FIELD_CODE" => array(
                                                        0 => "DETAIL_PICTURE",
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
                                                    "MESSAGE_404" => ""
                                                ),
                                                false
                                            );?>
                                        </div>
                                    </div>
                                    <div class="footer__right-bottom">
                                        <div class="footer__copyright">
                                            ARS Infinitum | <?=date('Y')?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
<? else :?>
    <script type="text/javascript">
        var myFullpage = new fullpage('#fullpage', {
            autoScrolling:true,
            scrollHorizontally: false,
            slidesNavigation: true,
            slidesNavPosition: 'bottom',
            scrollOverflow: false,
            scrollingSpeed: 700,
            navigation: true,
            navigationPosition: 'right',
            navigationTooltips:['1','2','3','4','5','6','7','8'],
        });
    </script>
<? endif; ?>

<div style="display: none">
    <div class="popupEmail" id="popupEmail">
        <form class="popupEmail__form js-feedback-form">
            <input type="hidden" name="IBLOCK_ID" value="18">
            <input type="hidden" name="SOURCE_URL" value="https://<?=$_SERVER['HTTP_HOST'] . $APPLICATION->GetCurDir()?>">

            <div class="popupEmail__head">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/" . SITE_ID . "/text6.php"
                    )
                );?>
            </div>

            <div class="popupEmail__body">
                <div class="input-block">
                    <div class="input-block__head">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/" . SITE_ID . "/form1.php"
                            )
                        );?>
                    </div>
                    <input type="text" class="input-block__input" placeholder="<? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/form5.php"
                        )
                    );?>" name="name">
                </div>
                <div class="input-block">
                    <div class="input-block__head">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/" . SITE_ID . "/form2.php"
                            )
                        );?>
                    </div>
                    <input type="tel" class="input-block__input" placeholder="+__ (___) ___ - __ - __" name="phone">
                </div>
                <div class="input-block">
                    <div class="input-block__head">
                        Email
                    </div>
                    <input type="text" class="input-block__input" placeholder="<? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/form5.php"
                        )
                    );?>" name="email">
                </div>
                <div class="input-block">
                    <div class="input-block__head">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/" . SITE_ID . "/form3.php"
                            )
                        );?>
                    </div>
                    <textarea class="input-block__textarea" placeholder="<? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/form5.php"
                        )
                    );?>" name="message"></textarea>
                </div>
            </div>
            <div class="popupEmail__bottom">
                <button type="submit" onclick="$(this).parents('form').submit()" class="popupEmail__bottom-btn btn-type-1">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/form4.php"
                        )
                    );?>
                </button>
            </div>
        </form>
    </div>
    <div id="popupSuccess">
        <div class="popupEmail">
            <div class="form-result" style="display: block;">
                <!--В случае ошибки .red (.form-result__head.red)-->
                <div class="form-result__head yellow">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/popupSuccess1.php"
                        )
                    );?>
                </div>
                <div class="form-result__body">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/" . SITE_ID . "/popupSuccess2.php"
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(93805141, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/93805141" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    <!-- MissoffDesign counter -->
<noscript>
<div>
<style>
a {
    text-decoration: none;
       }
</style>
<p><a href="https://missoff.ru">MissoffDesign - веб разработка и продвижение</a>
</div>
</noscript>
<noscript><div><img src="https://missoff.ru/missoffdesign_point.gif" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /MissoffDesign counter -->
<script src="//code.jivo.ru/widget/dOtHLGAHjK" async></script>
<script>
function jivo_onLoadCallback() {
const jivo_custom_widget = true;
}
</script>
</body>
</html>