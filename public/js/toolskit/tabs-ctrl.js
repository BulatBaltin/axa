jQuery( function ( $ ) {

    $(".tabs_wrapper .tab").click(function() {
        $(".tabs_wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".tab_item").hide().eq($(this).index()).fadeIn()
    }).eq(0).addClass("active");

    /*accordion*/
    $('.toggle').click(function(e) {
        e.preventDefault();

        $this = $(this);

        if ($this.next().hasClass('show')) {
            $this.find('.arrow_down').removeClass('down');
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $('.arrow_down').removeClass('down');
            $this.find('.arrow_down').addClass('down');
            $this.parent().parent().find('li .inner').removeClass('show');
            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
        }
    });
    /*END accordion*/
} );
