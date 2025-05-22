<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("Загрузка навигации");
?>

<? if ($arResult["NavPageCount"] > 1) :?>
    <? if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]) :?>
        <?
        $plus = $arResult["NavPageNomer"]+1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus;
        ?>

        <div class="product-card__reviews-bottom load_more" data-url="<?=$url?>">
            <div class="product-card__reviews-bottom-button" style="cursor: pointer;">
                Показать еще
            </div>
        </div>
    <? endif ?>
<? endif ?>