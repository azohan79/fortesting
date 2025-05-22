<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['SECTIONS'])) return; ?>

<? foreach($arResult['SECTIONS'] as $section) :?>
    <div class="sec3__form-select-option form-select-option">
        <input id="service<?=$section['ID']?>" name="service" type="radio" class="sec3__form-select-option-input" name="service" value="<?=$section['NAME']?>">
        <label for="service<?=$section['ID']?>" class="sec3__form-select-option-text"><?=$section['NAME']?></label>
    </div>
<? endforeach; ?>