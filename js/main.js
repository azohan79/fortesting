$(document).ready(function () {
    $('body').on('click', function (e) {
        $('*').removeClass('select-active');
    });
    $('.header__burger').on('click', function () {
        $(this).toggleClass('active');
        $('.menu').toggleClass('active');
        $('.header').toggleClass('active');
        $('body').toggleClass('.menu-active');
    });
    $('.side-menu__cont, .side-menu__main-link').on('click', function () {
        $('.side-menu').toggleClass('active');
    });
    function dropDownSelect (e, item) {
        if (item.parent().hasClass('select-active')) {
            item.parent().removeClass('select-active');
            $('*').removeClass('select-active');
        }else {
            $('*').removeClass('select-active');
            item.parent().addClass('select-active');
        }
        e.stopPropagation();
    }
    // $('.fp-sr-only').on('click', function () {
    //     alert();
    //
    //     // $(this).click();
    //
    // });
    $(".select-option").on('click', function(e) {
        $('.select-option').removeClass('option-active');
        $(this).addClass('option-active');
        var optionValue = $(this).children('label').text();
        $(this).parent().parent('.select-body').siblings('.select-head').children('.select-value').text(optionValue);
        $(this).parent().parent().parent().removeClass('select-active');
        // if ($(this).children($('.catalog__filter-block-option-text')).children($('svg'))) {
        //     var $img = $(this).children($('.catalog__filter-block-option-text')).children($('svg')).clone();
        //     $(this).parent().parent('.select-body').siblings('.select-head').children('.select-side').children(".catalog__filter-block-head-logo").html($img);
        // }
        e.stopPropagation();
    });
    $('.select-head').on('click', function(e) {
        dropDownSelect(e, $(this));
    });
    $('.tool-link').on('click', function(e) {
        let tools = $(".tool-block-" + $(this).attr('data-tool-link'));
        $(this).siblings($('.tool-link')).removeClass('active');
        $(this).addClass('active');
        tools.siblings($('.tool-block')).removeClass('active');
        tools.addClass('active');
        e.preventDefault();
    });
    if ($('#fullpage').length) {
        checkFullpage();
        $(document).on('resize', function () {
            checkFullpage();
        });
    }
    if ($(window).width() < 1400) {
        $('.mainPage-section-5__slider').slick({
            infinite: false,
            dots: true,
            arrows: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            variableWidth: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: false,
                        dots: true
                    }
                },
            ]
        });
    }
    $('.product-card__slider-small').slick({
        infinite: false,
        dots: false,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        variableWidth: true,
        focusOnSelect: true,
        asNavFor: '.product-card__slider-big',
        responsive: [
            {
                breakpoint: 1399,
                settings: {
                    variableWidth: false
                }
            },
        ]
    });
    $('.about-section9__slider').slick({
        infinite: true,
        dots: true,
        arrows: false,
        centerMode: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        variableWidth: true,
        focusOnSelect: true,
    });
    $('.product-card__slider-big').slick({
        infinite: false,
        dots: false,
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        variableWidth: false,
        asNavFor: '.product-card__slider-small',
    });
    function checkFullpage() {
        if ($(document).width() < 1280) {
            fullpage_api.destroy();
        } else {
            fullpage_api.reBuild();
        }
    }
    $('.fancybox-link').fancybox({
        arrows : false,
        opacity: 0.2,
    });
    $('.business-section6__bg-mobile').each(function () {
        $('.business-section6__bg-mobile').width($('.business-section6__bg-mobile').height() / 0.6);
    });

    $('[type="tel"]').inputmask("+7 (999) 999 - 99 - 99");

    function imageProportion(currentElement, proportion) {
        $(currentElement).each(function () {
            $(this).height($(this).width() / proportion);
        });
    }
    imageProportion('.product-card__certificates-item', 1.3);
    imageProportion('.product-card__reviews-item-gallery-item', 1.11);
    imageProportion('.product-card__videos-item iframe', 1.54);
    imageProportion('.business-section9__block-img', 1.632);
    imageProportion('.business-section8__img', 1);
    if ($(window).width() < 1400) {
        imageProportion('.product-card__images-top-main', 0.9);
    }




    $('.js-feedback-form').on('submit', function(e) {
        e.preventDefault();

        var error = false;
        var _this = this;

        $(this).find('input[type=text]').each(function() {console.log($(this))
            if ($(this).val().length == 0) {
                $(this).parent().addClass('error');
                error = true;
            } else {
                $(this).parent().removeClass('error');
            }
        })

        $(this).find('input[type=tel]').each(function() {
            if ($(this).val().replace(/\D/g,'').length < 11) {
                $(this).parent().addClass('error');
                error = true;
            } else {
                $(this).parent().removeClass('error');
            }
        })

        if (!error) {
            $.ajax({
                url: '/ajax/form.php',
                data: $(this).serialize(),
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    $.fancybox.close();
                    $.fancybox.open($('#popupSuccess').html());

                    $(_this).find('input[type=text]').val('');
                    $(_this).find('input[type=tel]').val('');
                    $(_this).find('textarea').val('');
                }
            })
        }
    })


    $(document).on('click', '.load_more', function(){
        var targetContainer = $('.js-paginate-list'), 
            url =  $('.load_more').attr('data-url');

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){

                    //  Удаляем старую навигацию
                    $('.load_more').remove();

                    var elements = $(data).find('.js-paginate-item'),
                        pagination = $(data).find('.load_more');

                    targetContainer.append(elements);
                    targetContainer.append(pagination);

                }
            })
        }
    });
});