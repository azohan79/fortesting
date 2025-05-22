<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (empty($arResult['ITEMS'])) return; ?>

<div class="product-card__reviews-body js-paginate-list">
    <? foreach($arResult['ITEMS'] as $item) :?>
        <?
        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>

        <div class="product-card__reviews-item js-paginate-item" id="<?=$this->GetEditAreaId($item['ID']);?>">
            <div class="product-card__reviews-item-head">
                <div class="product-card__reviews-item-head-title">
                    <?=$item['NAME']?>
                </div>
                <div class="product-card__reviews-item-head-bottom">
                    <div class="product-card__reviews-item-head-date">
                        <?=date('d.m.Y', strtotime($item['DATE_CREATE']))?>
                    </div>
                    <div class="product-card__reviews-item-head-place">
                        <?=$item['PROPERTIES']['CITY']['VALUE']?>
                    </div>
                </div>
            </div>
            <div class="product-card__reviews-item-body">
                <div class="product-card__reviews-item-text">
                    <p>
                        <?=$item['DETAIL_TEXT']?>
                    </p>
                </div>
 
                <? if ($item['PROPERTIES']['PHOTOS']['VALUE']) :?>
                    <div class="product-card__reviews-item-gallery">
                        <? foreach($item['PROPERTIES']['PHOTOS']['VALUE'] as $photo) :?>
                            <div class="product-card__reviews-item-gallery-helper">
                                <a href="<?=CFile::GetPath($photo)?>" class="fancybox-link product-card__reviews-item-gallery-item">
                                    <img src="<?=CFile::GetPath($photo)?>" alt="">
                                </a>
                            </div>
                        <? endforeach; ?>
                    </div>
                <? endif; ?>
            </div>
        </div>
    <? endforeach; ?>
</div>

<?=$arResult["NAV_STRING"]?>
