<header id="header">
    <a href="<?path('home')?>" class="logo"></a>
    <div class="menu_wrap">
        <div class="wrap">
            <ul id="header_menu" class="">
                <li class="menu_item">
                    <a href="<?path('qv.dash-dev.site',['id' => $dev_hash ])?>" 
                    <? if (isset($dashboard)): ?> 
                        class='current_item' 
                    <? endif ?>><?=l('Dashboard')?></a>
                </li>
                <li class="menu_item">
                    <a href="#" <? if (isset($hours)): ?> class='current_item' <? endif ?>><?l('Hours')?></a>
                </li>
            </ul>
        </div>
        <div class="navbar_right">
            <div class="dropdown_toggle user_dropdown_toggle">
                <a href="<? path('qv.dash-dev.site',['id' => $dev_hash ]) ?>" class="toggle_user_dropdown">

                <? if (isset($avatarfile)): ?>
                    <div class="photo" style="background: url(<?=$avatarfile ?>) center / cover no-repeat">
                    </div>
                <? else :?>
                <? endif ?>

                    <div class="business-name" ><?=$developer['name'] ?></div>
                </a>
            </div>

            <div class="dropdown_toggle">
                <a href="javascript:void(0)" class="icon_wrap notifications_icon_wrap">
                    <svg class="icon">
                        <use xlink:href="/images/icons/sprite2.svg#globe"></use>
                    </svg>
                    <span class="counter"><?User::Lingo() ?></span>
                </a>
                <? if (isset($lingoQty)): ?>
                <div class="dropdown">
                    <div class="dropdown_inner_wrap">
                        <?// app.user|getLingoes(hash)|raw ?>
                    </div>
                </div>
                <? endif ?>
            </div>

            <div class="dropdown_toggle notifications_dropdown_toggle">
                <a href="javascript:void(0)" class="icon_wrap notifications_icon_wrap">
                    <svg class="icon">
                        <use xlink:href="/images/icons/sprite.svg#notification"></use>
                    </svg>
                    <? if (isset($noticeQty)) : //(app.user)|raw != 0 ?>
                    <span class="counter"><?=$noticeQty ?></span>
                    <? endif ?>
                </a>
                <? if (isset($noticeQty) and $noticeQty > 0 ): ?>
                <div class="dropdown hidden">

                    <div class="dropdown_inner_wrap">
                        <div id="noties">
                            <?= 5 //5|noticeContent(app.user )|raw ?>
                        </div>
                        <!--<a href="" class="btn">Clear messages</a>-->
                        <div class='mb-3 mt-3 d-flex justify-content-center'>

                        <a class="btn" href="javascript:void(0)">
                                &nbsp;<?l('View all')?></a>
                            <a id='clear-notes' class="ml-2 btn" href="javascript:void(0)">
                                &nbsp;<?l('Clear all')?></a>
                        </div>
                    </div>
                </div>
                <? endif ?>
            </div>
            <a href="javascript:void(0)" class="icon_wrap">
                <svg class="help_icon">
                    <use xlink:href="/images/icons/sprite.svg#question-circle"></use>
                </svg>
            </a>
            <a href="<?path('app_logout')?>" class="icon_wrap" title="<?l('Logout')?>">
                <svg class="help_icon">
                    <use xlink:href="/images/icons/sprite.svg#logout"></use>
                </svg>
            </a>

        </div>
    </div>
    <div class="burger-wrap">
        <div class="burger"><span></span></div>
    </div>
</header>
