<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="menu__social">
    <? foreach($arResult['ITEMS'] as $item) :?>
        <?
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        
        <a href="<?=$item['CODE']?>" target="_blank" class="menu__social-link" id="<?=$this->GetEditAreaId($item['ID']);?>">
            <img src="<?=CFile::GetPath($item['PROPERTIES']['ICON']['VALUE'])?>" width="30">
        </a>
    <? endforeach; ?>
</div>