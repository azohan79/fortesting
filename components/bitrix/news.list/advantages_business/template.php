<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<?
$green = [];
$red = [];
$yellow = [];

foreach($arResult['ITEMS'] as $item) {
    if ($item['PROPERTIES']['COLOR']['VALUE_XML_ID'] == 'RED') {
        $red[] = $item;
    } elseif ($item['PROPERTIES']['COLOR']['VALUE_XML_ID'] == 'GREEN') {
        $green[] = $item;
    } elseif ($item['PROPERTIES']['COLOR']['VALUE_XML_ID'] == 'YELLOW') {
        $yellow[] = $item;
    }
}
?>

<div class="mainPage-section-6__main-body">
    <? if (!empty($green)) :?>
        <div class="mainPage-section-6__main-block green">
            <? foreach($green as $item) :?>
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
    <? endif; ?>

    <? if (!empty($red)) :?>
        <div class="mainPage-section-6__main-block red">
            <? foreach($red as $item) :?>
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
    <? endif; ?>

    <? if (!empty($yellow)) :?>
        <div class="mainPage-section-6__main-block yellow">
            <? foreach($yellow as $item) :?>
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
    <? endif; ?>
</div>