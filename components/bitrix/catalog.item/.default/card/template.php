<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
?>

<div class="product-item__helper-inside">
	<div class="product-item">
		<div class="product-item__img">
            <div class="product-item__img-bg">
                <svg width="144" height="363" viewBox="0 0 144 363" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M144 60.5881V363L0 167.17V10.993C0 4.13342 6.74891 -0.689661 13.2387 1.53199L130.478 41.6661C138.566 44.435 144 52.0389 144 60.5881Z" fill="<?=$item['PROPERTIES']['CARD_COLOR']['VALUE_XML_ID']?>"/>
                </svg>
            </div>
            <a href="<?=$item['DETAIL_PAGE_URL']?>" class="product-item__img-main">
                <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>">
            </a>
        </div>

        <div class="product-item__price">
            <? if (!empty($price)) :?>
				<?=str_replace('&#8381;', '<span class="font-inter">₽</span>', $price['PRINT_RATIO_PRICE'])?>
			<? endif; ?>
        </div>

        <a href="<?=$item['DETAIL_PAGE_URL']?>" class="product-item__title">
        	<?=$productTitle?>
        </a>

        <div class="product-item__description">
            <?=$item['PREVIEW_TEXT']?>
        </div>

        <div class="product-item__bottom">
            <a href="<?=SITE_DIR?>personal/" class="product-item__link btn-type-1">
                Заказать
            </a>
        </div>
	</div>
</div>