<?
include_once('header.man.php');
?>

<header id="header" class="header-bar">

<!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> -->
    <div class="menu_wrap">
        <div class="wrap">
            <ul id="header_menu" class="">

                <!-- <li class="menu_item">
                <span class="business-name" onclick="openNav()">
                    <i class="fas fa-bars" style='cursor: pointer;'></i>    
                </span>
                </li> -->
                <a href="#" onclick="openNav()" class="logo"></a>


    <!-- <div style='border-bottom: 4px solid red;margin-bottom: 3px;'> -->
                <li class="menu_item" <?= $is_home ?>>

                <a href="<? path('home') ?>" class="business-name" style="margin: 0px;" >
                    <?l('Home')?>
                </a>
                </li>
                <li class="menu_item" <?= $is_blog ?>>

                <a href="<? path('blog') ?>" class="business-name" style="margin: 0px;" >
                    <?// $project ?>
                    <?l('Blog')?>
                </a>
                </li>
    <!-- </div> -->
                <li class="menu_item dropdown_toggle"  <?= $is_project ?>>
                    <a href="javascript:void(0)" 
                    <? if(isset($projects)) :?> 
                        class='current_item' 
                    <? endif ?>>
                    Projects
                    </a>
                    <div class="dropdown">
                        <div class="dropdown_inner_wrap">

                            <a href="<? path('admin-fancy-home') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clock"></use>
                                </svg>
                                (Fancy home) Import hours
                            </a>

                            <a href="<? path('test.tests.survey-1') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clock"></use>
                                </svg>
                                Survey
                            </a>
                            <a href="<? path('test.tests.survey-2') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#feed"></use>
                                </svg>
                                Survey (Ultimate)
                            </a>
                            <a href="<? path('shop.index') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#feed"></use>
                                </svg>
                                Comfi house shopping
                            </a>
                            <a href="<? path('rehab.trans') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#feed"></use>
                                </svg>
                                Rehab translation
                            </a>
                        </div>
                    </div>
                </li>
                <li class="menu_item" <?= $is_contact ?>>
                <a href="<? path('contacts') ?>" class="business-name" style="margin: 0px;" >
                    <?// $project ?>
                    <? l('Contacts') ?>
                </a>
                </li>

                <!-- <li class="menu_item">
                    <a href="<? path('test.tests.test-cats')?>" 
                    <? if(isset($lessons)) :?> 
                        class='current_item' 
                    <? endif ?> 
                    >Lessons</a>
                </li> -->
            </ul>
        </div>
        <!-- right part -->
        <div class="navbar_right">

            <? 
            $user = User::GetUser(); 
            if($user) : ?>

            <div class="dropdown_toggle user_dropdown_toggle">

                <a href="<? path('qv.dashboard')?>" class='round-btn' style="margin-right:1rem;" >
                    <!-- <div style="border: 2px solid grey; background-color: #ffc; border-radius: 20px; padding: 4px 25px 4px 10px;"> -->
<img style="max-height: 24px;" src="/images/qv/favicon.png" alt="">
&nbsp;Quickvoice
                    <!-- </div> -->
                </a>

                <a href="<? path('qv.user.login') ?>" class="toggle_user_dropdown">

                <? if (isset($user['avatarfile'])): ?>
                    <div class="photo" style="background: url(<? l($user['avatarfile']) ?>) center / cover no-repeat">
                    </div>
                <? else: ?>
                    <div class="photo">
                        Logo
                    </div>
                <? endif ?>

                    <div class="business-name" ><?= $user['username'] ?></div>
                </a>
            </div>

            <a href="<? path('qv.user.logout')?>" class="icon_wrap" title="Logout">
                <svg class="help_icon">
                    <use xlink:href="/images/icons/sprite.svg#logout"></use>
                </svg>
            </a>

            <? else:  ?>

                <a href="<? path('qv.user.login')?>" class='round-btn' 
                style="margin-right:2rem;width:100px; background-color: lightcyan;text-align: center;font-weight:bold;color: #999;" 
                >
<?l('Login')?>
                </a>
                <a href="<? path('qv.user.signup')?>" class='round-btn' style="margin-right:1rem;width:140px;text-align: center;font-weight:bold;color: #999;" >
<?l('Sign up')?>
                </a>
            <? endif ?>

            <div class="wrap">
            <ul>
                <li class="menu_item dropdown_toggle">
                    <a href="javascript:void(0)" style="text-decoration: none;">
                    <?= $lang ?> 
                    <svg class="help_icon">
                        <use xlink:href="/images/icons/sprite.svg#globe"></use>
                    </svg>
                    </a>
                    <div class="dropdown">
                        <div class="dropdown_inner_wrap">

<? foreach( $langs as $lang) :?>

<div class="dropdown_list_item" style='width: 10rem;'>

<span style="width:8rem"><?= $lang['name']?></span>
<?= ($lang['code'] ?? $lang['name'])?>

</div>
<? endforeach ?>
                        </div>
                    </div>
                </li>
            </ul>
            </div>


            <a href="<? path('test.tests.test-cats')?>" class="icon_wrap">
                <svg class="help_icon">
                    <use xlink:href="/images/icons/sprite.svg#question-circle"></use>
                </svg>
            </a>
        </div>

        <!-- </div> -->
    </div>
<!-- </nav> -->
    <div class="burger-wrap">
        <div class="burger"><span></span></div>
    </div>

</header>

