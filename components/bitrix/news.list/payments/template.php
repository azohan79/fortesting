<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="footer__cards">
    <? foreach($arResult['ITEMS'] as $item) :?>
        <?
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="footer__cards-item" id="<?=$this->GetEditAreaId($item['ID']);?>">
            <img src="<?=CFile::GetPath($item['PROPERTIES']['ICON']['VALUE'])?>" alt="">
        </div>
    <? endforeach; ?>
</div>