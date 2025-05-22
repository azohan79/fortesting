<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="mainPage-section-3__block">
    <? foreach($arResult['ITEMS'] as $item) :?>
        <?
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="mainPage-section-3__line" id="<?=$this->GetEditAreaId($item['ID']);?>">
            <div class="mainPage-section-3__block-img">
                <img src="<?=CFile::GetPath($item['PROPERTIES']['ICON']['VALUE'])?>" alt="">
            </div>
            <div class="mainPage-section-3__block-text text-type-3">
                <?=$item['NAME']?>
            </div>
        </div>
    <? endforeach; ?>
</div>