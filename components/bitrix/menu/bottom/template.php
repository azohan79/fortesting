<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult)) return; ?>

<div class="footer__nav">
	<? foreach($arResult as $item) :?>
    	<a href="<?=$item['LINK']?>" class="footer__nav-item <?=$item['SELECTED'] ? 'active' : ''?>">
            <?=$item['TEXT']?>
        </a>
    <? endforeach; ?>
</div>