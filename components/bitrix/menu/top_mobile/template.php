<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult)) return; ?>

<div class="menu__nav">
	<? foreach($arResult as $item) :?>
    	<a href="<?=$item['LINK']?>" class="menu__nav-item text-type-4 <?=$item['SELECTED'] ? 'active' : ''?>">
            <?=$item['TEXT']?>
        </a>
    <? endforeach; ?>
</div>