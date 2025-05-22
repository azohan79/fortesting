<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Main\Page\Asset;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/fav.svg">

  	<title><?$APPLICATION->ShowTitle()?></title>

  	<?
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery-3.6.0.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/slick.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/fancy.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/wow.js");

    if ($APPLICATION->GetCurDir() == SITE_DIR) {
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main_page/style.css");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/fullpage.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/fullpage.extensions.min.js");
    }

    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.inputmask.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");

    $APPLICATION->ShowHead();
  	?>
	
</head>

<body>
	<div id="panel" style="position: absolute; width: 100%"><?$APPLICATION->ShowPanel();?></div>

    <? if ($APPLICATION->GetCurDir() != SITE_DIR) :?>
        <div class="site <?if ($APPLICATION->GetCurDir() == SITE_DIR . 'catalog/'):?>light-light-grey-bg<?else:?><?if (stripos($APPLICATION->GetCurDir(), '/catalog/') !== false):?>white-bg<?else:?><?if ($APPLICATION->GetCurDir() != SITE_DIR . 'contacts/'):?><?=$APPLICATION->GetCurDir() == SITE_DIR . 'about/' || $APPLICATION->GetCurDir() == SITE_DIR . 'business/' || ERROR_404 == 'Y' ? 'dark-dark-grey-bg' : 'light-grey-bg'?><?endif;?><?endif;?><?endif;?>" <?if($APPLICATION->GetCurDir() == SITE_DIR . 'personal/'):?>style="background: #EAEDF3"<?endif;?>>
            <div class="site__top">
    <? endif; ?>

	<div class="menu">
        <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "top_mobile",
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

        <a href="<?=SITE_DIR?>personal/" class="btn-type-1 menu__btn">
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/" . SITE_ID . "/text1.php"
                )
            );?>
        </a>

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
    
    <header class="header">
        <div class="header__big">
            <div class="header__big-cont">
                <a href="<?=SITE_DIR?>" class="header__logo">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/logo_header2.svg" alt="">
                </a>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top",
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
            </div>
        </div>

        <div class="header__small">
            <div class="header__small-cont">
                <div class="header__language">
                    <div class="site__lang select-block">
                        <div class="site__lang-head select-head">
                            <div class="site__lang-head-value text-type-9 select-value">
                                <? if (SITE_ID == 's1') :?>
                                    RU
                                <? elseif (SITE_ID == 'kz') :?>
                                    KZ
                                <? elseif (SITE_ID == 'en') :?>
                                    EN
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="site__lang-body select-body">
                            <div class="site__lang-list">
                                <div class="site__lang-option select-option <?=SITE_ID == 's1' ? 'option-active' : ''?>" onclick="window.location.href = '/'">
                                    <input id="lang3" name="ln" type="radio" class="site__lang-option-input">
                                    <label for="lang3" class="site__lang-option-text text-type-9">RU</label>
                                </div>
                                <div class="site__lang-option select-option <?=SITE_ID == 'kz' ? 'option-active' : ''?>" onclick="window.location.href = '/kz/'">
                                    <input id="lang4" name="ln" type="radio" class="site__lang-option-input">
                                    <label for="lang4" class="site__lang-option-text text-type-9">KZ</label>
                                </div>
                                <div class="site__lang-option select-option <?=SITE_ID == 'en' ? 'option-active' : ''?>" onclick="window.location.href = '/en/'">
                                    <input id="lang5" name="ln" type="radio" class="site__lang-option-input">
                                    <label for="lang5" class="site__lang-option-text text-type-9">EN</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="https://lk.ars-infinitum.com/" class="header__profile">
                    <div class="header__profile-img">
                        <img src="<?=SITE_TEMPLATE_PATH?>/img/icon_profile.svg" alt="">
                    </div>
                    <div class="header__profile-text text-type-9">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/" . SITE_ID . "/text2.php"
                            )
                        );?>
                    </div>
                </a>
            </div>

            <div class="header__burger">
                <div class="header__burger-line"></div>
                <div class="header__burger-line"></div>
                <div class="header__burger-line"></div>
                <div class="header__burger-line"></div>
            </div>
        </div>
    </header>

    <div class="side-menu">
        <div class="side-menu__main">
            <a href="javascript:jivo_api.open()" class="side-menu__main-link">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/" . SITE_ID . "/text3.php"
                    )
                );?>
            </a>
            <a href="#popupEmail" class="side-menu__main-link fancybox-link">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/" . SITE_ID . "/text4.php"
                    )
                );?>
            </a>
        </div>
        <div class="side-menu__cont">
            <div class="side-menu__cont-img">
                <svg width="21" height="42" viewBox="0 0 21 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.79744 41.5L21 20.7846L7 -6.11959e-07L0 1.49807e-06L14 20.7846L5.81537e-06 41.5L6.79744 41.5Z" fill="#FF015C"/>
                </svg>
            </div>
            <div class="side-menu__cont-btn">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/" . SITE_ID . "/text5.php"
                    )
                );?>
            </div>
        </div>
    </div>

    <? if ($APPLICATION->GetCurDir() != SITE_DIR) :?>
        <div class="site__content">
    <? endif; ?>