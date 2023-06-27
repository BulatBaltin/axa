<header class="navbar">
  <a href="<?path('home')?>">
      <!-- <img
      srcset="/images/icons/flower.png 100v, /images/icons/eye.png 50v"
      sizes="(min-width: 900px) 600px, (min-width: 600px) 300px, 100vw"
      src="/images/icons/flower.png"
      alt="Описание изображения для всех версий"
      > -->

    <img id="logo-img" height="100" src="/images/icons/flower.png" alt="Логотип">
  </a>
  <!-- <img id="logo-flower" src="/images/icons/flower.png" alt="Логотип"> -->
  <!-- <picture>
    <source srcset="https://picsum.photos/id/237/400/600" media="(max-width: 600px)">
    <source srcset="https://picsum.photos/id/237/800/400" media="(min-width: 601px)">
    <img src="https://picsum.photos/id/237/300/200" alt="Cute puppy">
  </picture> -->

<div class="flex">
  <? 
if(str_has(ROUTER::getRouteSlug(),'cats')) :
  include('cats-css/header-cats.html.php');
elseif (str_has(ROUTER::getRouteSlug(),'css')) :  
  include('cats-css/header-css.html.php');
else :  
  include('cats-css/header-3.html.php');
endif  
?>
</div>
</header>

<style>
.main-content {
  margin-top: 2rem;
}  
.logo-img-shift {
  transform-origin: left middle;
  animation: scale-img 500ms ease-in-out forwards;
}
@keyframes scale-img {
  to {
    transform: scale(0.7);
  }
}
.logo-img-back {
  transform-origin: left middle;
  animation: scale-img-back 500ms ease-in-out forwards;
}
@keyframes scale-img-back {
  from {
    transform: scale(0.7);
  }
  to {
    transform: scale(1.0);
  }
}

.navbar {
    /* position: absolute; */
    position: fixed;
    /* height: 7rem; */
    height: 5rem;
    width: 100%;
    padding: 30px 60px;
    /* background: transparent!important; */
    background: rgba(0,0,0,0.1);
    border-bottom: 1px dashed rgba(256,256,256,.2);
    transition: .5s;
    /* transition-property: all;
    transition-duration: 0.5s;
    transition-timing-function: ease;
    transition-delay: 0s; */
    z-index: 9;
    display: flex;
    align-items: center;

    flex-flow: row nowrap;
    /* justify-content: flex-start; */
    justify-content: space-between;

}
.navbar-small {
  background: white;
  box-shadow: 0 0 10px rgba(0,0,0,0.5);
  height: 3rem;
}
/* * {
  box-sizing: border-box;
} */

body {
  font-family: 'Montserrat',sans-serif;
  background-color: #f9f9fd;
}
.t-page-header
 {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  background-color: #607d8b;
  border-radius: 4px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.t-logo
 {
  padding: 15px;
  border-radius: 4px;
  background-color: #ff5722;
  text-decoration: none;
  color: #fff;
}

.t-menu
 {
  display: flex;
  padding: 5px 15px;
  margin: 0;
  list-style: none;
  border-radius: 4px;
  background-color: #2196f3;
}

.t-menu > .t-item:not(:last-child) {
  margin-right: 10px;
}

.t-menu
 .t-link
 {
  display: block;
  padding: 5px 10px;
  border-radius: 4px;
  text-decoration: none;
  color: black;
  background-color: #fff;
}

.t-menu
 .t-link
:hover,
.t-menu
 .t-link
:focus,
.t-logo
:hover,
.t-logo
:focus {
  text-decoration: underline;
}
li {
  padding-bottom: 0px;
}

</style>

<script>
    $(document).ready(function() {
        $(window).scroll(function(){
            if( $(this).scrollTop() > 0 ) {
              // $('.navbar').css('height','5rem');
              // $('#logo-img').attr('src','/images/icons/eye.png');
              // This animation does not work due to 
    //           $('#logo-flower').animate(
    //             { width: 50, height: 50 },500, function() {
    // // Animation complete.
    //             }
    //             // {
    //             //     duration: 1000,
    //             //     step: function(value, properties) { $(this).attr("src", now); }
    //             // }                
    //           );
              
              $('#logo-img').removeClass('logo-img-back');
              $('#logo-img').removeClass('logo-img-shift');
              $('#logo-img').addClass('logo-img-shift');
              $('.navbar').addClass('navbar-small');
              // $('#logo-img').attr('src','/images/icons/eye.png');

            } else {
              // $('.navbar').removeClass('height','7rem');
              $('#logo-img').addClass('logo-img-back');
              $('.navbar').removeClass('navbar-small');
  //             // $('#logo-img').attr('src','/images/icons/flower.png');
  //             $('#logo-flower').animate(
  //               { width: 158, height: 158 }, 500, function() {
  //   // Animation complete.
  // }
  //               // {
  //               //     duration: 1000,
  //               //     step: function(value, properties) { $(this).attr("src", now); }
  //               // }                
  //             );

            }
        });
    });
</script>
