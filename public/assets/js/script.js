
(function($){

    $(window).scroll(function(){ lookingSpecialOffer(); }).load(function(){ lookingSpecialOffer(); });

    /**
     * Looking for Special Offers
     */
    function lookingSpecialOffer(){
        $('.special-offer').each(function(){
            var $this = $(this);
            if($this.visible(true) && $this.attr('data-loaded')==0){
                $this.attr('data-loaded', 1);
                setTimeout(function(){
                    loadSpecialOffer($this.attr('data-id'));
                }, 600);
            }
        });
    }

    /**
     * Load Special Offer content
     *
     * @param id
     */
    function loadSpecialOffer(id){
        var data = {
            'action': 'load_special_offer',
            'id': id
        };
        var $soID = $('#so_'+id);
        var $soIDLoader = $('#so_'+id+' .special-offer__loader');

        $.ajax({
            url:      ajaxurl,
            data:     data,
            type:     'POST',
            dataType: 'html',

            beforeSend: function(){
                $soIDLoader.show();
                $soID.css({opacity: 0});
            },
            complete: function(){
                $soIDLoader.hide();
            },
            success: function(data){
                $soID.html(data).animate({opacity: 1}, 300, 'linear');
            },
            error: function(xhr, status, thrown){
                console.log(xhr);
                console.log(status);
                console.log(thrown);
            }
        });
    }

})(jQuery);