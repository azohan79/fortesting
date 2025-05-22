<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult)) return; ?>

<div class="header__nav">
	<? foreach($arResult as $item) :?>
    	<a href="<?=$item['LINK']?>" class="header__nav-item text-type-1 <?=$item['SELECTED'] ? 'active' : ''?>">
            <?=$item['TEXT']?>
        </a>
    <? endforeach; ?>
</div>