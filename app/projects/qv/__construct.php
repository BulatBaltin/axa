<?php

if(!str_has(ROUTER::getRouteSlug(), 'login')) {

    $boss = User::GetUser();
    if (!$boss) {
        return UrlHelper::RedirectRoute('qv.user.login');
    }
    $company = User::getCompany($boss);
    if (!$company) {
        return UrlHelper::RedirectRoute('qv.user.login');
    }
}
