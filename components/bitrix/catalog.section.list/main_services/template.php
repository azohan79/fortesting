<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['SECTIONS'])) return; ?>

<div class="sec1-services" style="background-image: url(<?=SITE_DEFAULT_TEMPLATE_PATH?>/img/services.png)">
    <div class="sec1-services__title">
        УСЛУГИ
    </div>
    <div class="sec1-services__list-helper">
        <div class="sec1-services__list">
            <? foreach($arResult['SECTIONS'] as $section) :?>
                <a href="<?=$section['SECTION_PAGE_URL']?>" class="sec1-services__link">
                    <?=$section['NAME']?>
                </a>
            <? endforeach; ?>
        </div>
    </div>
</div>