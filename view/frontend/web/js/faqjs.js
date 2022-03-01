require(
    [
        'jquery',
        'jquery/ui'
    ],
    function ($) {
        $(document).ready(function () {
            $('#faqgroup-1').show();
            $('a[href*="#faqgroup-1"]').addClass('active faqgroup-faq-active');
            $('.faq-section-title').click(function (e) {
                var currentAttrvalue = $(this).attr('href');
                if ($(e.target).is('.active')) {
                    $(this).removeClass('active');
                    $('.faq-section-content:visible').slideUp(300);
                } else {
                    $('.faq-section-title').removeClass('active').filter(this).addClass('active');
                    $('.faq-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
                }
            });

            $('.faqgroup-section-title').click(function (e) {
                var currentAttrvalue = $(this).attr('href');
                if ($(e.target).is('.active')) {
                    $(this).removeClass('active');
                    $('.faqgroup-section-content:visible').slideUp(300);
                } else {
                    $('.faqgroup-section-title').removeClass('active faqgroup-faq-active').filter(this).addClass('active faqgroup-faq-active');
                    $('.faqgroup-section-content').slideUp(300).filter(currentAttrvalue).slideDown(300);
                }
            });

            $('.faq-ask-ques').click(function (e) {
                $('.faq-add-new').toggle('slow');
            });

            $('#submit').click(function (e) {
                e.preventDefault();
                var url = $('#url').val();
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: $('#frm_add_faq').serialize(),
                    success: function (result) {
                            console.log(result.message);
                            $("#msg").html(result.message).show().hide(10000);
                            $('#new_ques').val('');
                    }
                });
            });
        });
    }
);
