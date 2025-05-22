<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="mainPage-section-7__col-body">
    <div class="mainPage-section-7__list">
        <? foreach($arResult['ITEMS'] as $item) :?>
            <?
            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="mainPage-section-7__list-item" id="<?=$this->GetEditAreaId($item['ID']);?>">
                <div class="mainPage-section-7__list-head">
                    <?=$item['NAME']?>
                </div>
                <div class="mainPage-section-7__list-text text-type-1">
                    <?=$item['PREVIEW_TEXT']?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>