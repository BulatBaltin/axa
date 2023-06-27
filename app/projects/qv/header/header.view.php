<!-- Main header -->
<header id="header">
    <a href="<? path('home')?>" class="logo"></a>
    <div class="menu_wrap">
        <div class="wrap">
            <ul id="header_menu" class="">
                <li class="menu_item">
                    <a href="<? path('qv.dashboard.main')?>" 
                        <? if (isset($dashboard_tag)) : ?> 
                            class='current_item' 
                        <? endif ?>
                        > <? l('Dashboard')?>
                    </a>
                </li>
                <li class="menu_item dropdown_toggle">
                    <a href="javascript:void(0)" 
                    <? if (isset($hours_tag)) : ?> 
                        class='current_item' 
                    <? endif ?>
                    ><? l('Hours')?> </a>
                    <div class="dropdown">
                        <div class="dropdown_inner_wrap">
                            <a href="<? path ('qv.t-time.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clock"></use>
                                </svg>
                                <? l('Tracked hours') ?>
                            </a>
                            <a href="<? path ('qv.task.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#feed"></use>
                                </svg>
                                <? l('Tasks') ?>
                            </a>
                            <a href="<? path ('qv.task.index-opened')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#feed"></use>
                                </svg>
                                <? l('Opened tasks') ?>
                            </a>
                            <a href="<? path ('qv.task.index-not-mapped')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#cube"></use>
                                </svg>
                                <? l('Not mapped tasks') ?>
                            </a>
                            <a href="<? path ('qv.rules.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#gavel"></use>
                                </svg>
                                <? l('Import rules') ?>
                                
                            </a>
                            <a href="<? path ('qv.rules.index-tw')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#gavel"></use>
                                </svg>
                                <? l('Import TW-Projects rules') ?>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="menu_item">
                    <a href="<? path ('qv.invoice.index')?>" 
                    <? if (isset($invoices_tag)): ?> 
                    class='current_item' 
                    <? endif ?>><? l( 'Invoices')?></a>
                </li>
                <li class="menu_item dropdown_toggle">
                    <a href="javascript:void(0)" 
                    <? if (isset($downpayment_tag)): ?> 
                        class='current_item' 
                    <? endif ?>><? l('Downpayment')?></a>

                    <div class="dropdown">
                        <div class="dropdown_inner_wrap">
                            <a href="<? path ('qv.downpayment.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clipboard-check"></use>
                                </svg>
                                <? l( 'Downpayments')?>
                            </a>
                            <a href="<? path ('test.mollie.pay')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clipboard-check"></use>
                                </svg>
                                <? l( 'Mollie payment')?>
                            </a>
                        </div>
                    </div>

                </li>
                <li class="menu_item">
                    <a href="<? path ('qv.report.index')?>" 
                    <? if (isset($report_tag)): ?> 
                        class='current_item' 
                    <? endif ?>
                    ><? l('Reports')?></a>
                </li>
                <li class="menu_item dropdown_toggle">
                    <a href="javascript:void(0)" 
                    <? if(isset($company_tag)): ?> 
                        class='current_item' 
                    <? endif ?> ><? l( 'Company')?></a>

                    <div class="dropdown">
                        <div class="dropdown_inner_wrap">
                            <a href="<? path ('qv.customer.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#cuttlefish"></use>
                                </svg>
                                <? l( 'Customers')?>
                            </a>
                            <a href="<? path ('qv.project.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clipboard-check"></use>
                                </svg>
                                <? l( 'Projects')?>
                            </a>
                            <a href="<? path ('qv.tasklist.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#clipboard-check"></use>
                                </svg>
                                <? l( 'Task lists')?>
                            </a>
                            <a href="<? path ('qv.product.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#cube"></use>
                                </svg>
                                <? l( 'Products')?>
                            </a>
                            <a href="<? path ('qv.user.index') ?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
                                    <use xlink:href="/images/icons/sprite.svg#user-tie"></use>
                                </svg>
                                <? l( 'Employees')?>
                            </a>

                            <a href="<? path ('qv.transaction.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon">
<use xlink:href="/images/icons/sprite.svg#book"></use>
                                </svg>
                                <? l( 'Transactions')?>
                            </a>

                            <a href="<? path ('qv.language.index')?>" class="dropdown_list_item">
                                <svg class="dropdown_link_icon" style='height:23px;'>
                                    <use xlink:href="/images/icons/sprite2.svg#globe"></use>
                                </svg>
                                <? l( 'Language')?>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="navbar_right">

            <div class="dropdown_toggle user_dropdown_toggle">
                <a href="javascript:void(0);" class="toggle_user_dropdown">

                <? if (isset($app_user_avatarfile)): ?>
                    <div class="photo" style="background-size:contain;background-image: url(<?=$app_user_avatarfile ?>)">
                    </div>
                <? else: ?>
                    <div class="photo">
                        MT
                    </div>
                <? endif ?>

                    <div class="name"><? l( $app_user_name )?></div>
                    <svg class="arrow_down">
                        <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                    </svg>
                </a>
                <div class="dropdown">
                    <div class="dropdown_inner_wrap">
                        <a href="<? path('qv.company.profile',['id' => $company['admin_id']]) ?>" class="dropdown_list_item">
                            <svg class="dropdown_link_icon">
                                <use xlink:href="/images/icons/sprite.svg#user-circle"></use>
                            </svg>
                            <? l( 'Profile')?>
                        </a>
                        <a href="<? path ('qv.user.app_user')?>" class="dropdown_list_item">
                            <svg class="dropdown_link_icon">
                                <use xlink:href="/images/icons/sprite.svg#feed"></use>
                            </svg>
                            <? l( 'Subscription')?>
                        </a>
                        <a href="<? path ('qv.app_logout')?>" class="dropdown_list_item">
                            <svg class="dropdown_link_icon">
                                <use xlink:href="/images/icons/sprite.svg#logout"></use>
                            </svg>
                            <? l( 'Logout')?>
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown_toggle">
                <a href="<? path ('qv.language.index')?>" class="icon_wrap notifications_icon_wrap">
                    <svg class="icon">
                        <use xlink:href="/images/icons/sprite2.svg#globe"></use>
                    </svg>
                    <span class="counter"><? l($app_user_name) ?></span>
                </a>
                <? if ($lingoQty != 0 ): ?>
                <div class="dropdown">
                    <div class="dropdown_inner_wrap">
                        <? l($getLingoes) ?>
                    </div>
                </div>
                <? endif ?>
            </div>
            <div class="dropdown_toggle notifications_dropdown_toggle">
                <a href="<? path ('notification.index')?>" class="icon_wrap notifications_icon_wrap">
                    <svg class="icon">
                        <use xlink:href="/images/icons/sprite.svg#notification"></use>
                    </svg>
                    <? if ($noticeQty) : ?>
                    <span class="counter"><? $noticeQty ?></span>
                    <? endif ?>
                </a>
                <? if ($noticeQty): ?>
                <div class="dropdown">

                    <div class="dropdown_inner_wrap">
                        <div id="noties">
                            <?= '5' ?>
                        </div>
                        <!--<a href="" class="btn">Clear messages</a>-->
                        <div class='mb-3 mt-3 d-flex justify-content-center'>
                            <a class="btn" href="<? path ('notification.index')?>">
                                &nbsp;<? l( 'View all')?></a>
                            <a id='clear-notes' class="ml-2 btn" href="<? path ('notification.clear')?>">
                                &nbsp;<? l( 'Clear all')?></a>
                        </div>
                    </div>
                </div>
                <? endif ?>
            </div>

            <a href="<? path('qv.company.general') ?>" class="icon_wrap">
                <svg class="icon settings_icon">
                    <use xlink:href="/images/icons/sprite.svg#settings"></use>
                </svg>
            </a>

            <a href="<? path('qv.company.general') ?>" class="icon_wrap">
                <svg class="help_icon">
                    <use xlink:href="/images/icons/sprite.svg#question-circle"></use>
                </svg>
            </a>
            <a href="<? path('qv.user.logout')?>" class="icon_wrap" title="Logout">
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
