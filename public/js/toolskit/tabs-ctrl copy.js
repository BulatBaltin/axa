jQuery( function ( $ ) {
    const $document = $( this ),
            $rightNavBar = $( '.navbar_right' );

    $document.on( 'click', '.dropdown_toggle > a', function ( event ) {
        const $this = $( this ),
            $dropdown = $this.siblings( '.dropdown' ),
            $anotherDropdowns = $( '.dropdown_toggle .dropdown' ).not( $dropdown );

        if ( $( window ).width() <= '1023' ) {
            if ( $dropdown.length > 0 ) {
                $anotherDropdowns.addClass( 'hidden' );

                $dropdown.toggleClass( 'hidden' );

                if ( $this.hasClass( 'toggle_user_dropdown' ) && !$rightNavBar.hasClass( 'user_menu_opened' ) ) {
                    $rightNavBar.addClass( 'user_menu_opened' );
                } else {
                    $rightNavBar.removeClass( 'user_menu_opened' );
                }

                return false;
            }
        }
    } );

    $document.on( 'click', '.burger-wrap', function () {
        const $this = $( this ),
                $burger = $this.children( '.burger' ),
                $menuWrap = $this.siblings( '.menu_wrap' );

        if ( $burger.hasClass( 'opened' ) ) {
            $burger.removeClass( 'opened' );
            $menuWrap.removeClass( 'active' );
        } else {
            $burger.addClass( 'opened' );
            $menuWrap.addClass( 'active' );
        }
    } );

    $document.on( 'click', function ( event ) {
        const $target = $( event.target );
        if ( !$target.hasClass( 'dropdown' ) && !$target.hasClass( 'dropdown_inner_wrap' ) ) {
            $( '.dropdown' ).addClass( 'hidden' );
            $rightNavBar.removeClass( 'user_menu_opened' );
        }
    } );

    $(".tabs_wrapper .tab").click(function() {
        $(".tabs_wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
        $(".tab_item").hide().eq($(this).index()).fadeIn()
    }).eq(0).addClass("active");


    // $('.custom_select select').select2();
    // $('.custom_select_wrap select').select2();
    // $('.select_no_search select').select2({
    //     minimumResultsForSearch: -1
    // });

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

    // $( ".datepicker" ).datepicker();
    // $( ".datepicker_range" ).daterangepicker({
    //     locale: {
    //         format: 'DD MMMM Y'
    //     }
    // });
} );
