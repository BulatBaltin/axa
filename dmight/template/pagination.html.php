    <? if (isset($pagination) and $pagination == 1): ?>
    <div class="fx-pagination d-flex">
        <? if( isset($params) and $params != null) : ?>
        <? elseif (isset($search) and $search) : ?>
            <? $params = [ 'search' => $search]; ?>
        <? else : ?>
            <? $params = [] ?>
        <? endif ?>

        <? if ($page > 1) : ?>
            <div class="fx-page-arrow">
            <a class="fx-page-link" href="<?path($rootpages, array_merge($params,['page'=> 1 ]))?>" style="color:grey;">
            <i class="fas fa-angle-double-left"></i>
            </a></div>
            <div class="fx-page-arrow">
            <a class="fx-page-link" href="<?path($rootpages,array_merge($params,['page'=> ($page - 1) ]))?>" style="color:grey;">
            <i class="fas fa-angle-left"></i>
            </a></div>
        <? endif ?> 
        <? for( $ipage = 1; $ipage <= $pages; $ipage++ ) : // in 1.. ?>
            <div class="fx-page-item  
            <? if( $ipage == $page ): ?>
            active
            <? endif ?>
            ">
            <a class="fx-page-link" href="<?path($rootpages,array_merge($params,['page'=> $ipage ]))?>" 
            <? if ($ipage == $page): ?>
            style="color:white;"
            <? endif ?>
            >
            <?=$ipage ?>
            </a></div>
        <? endfor ?>   
        <? if ($page < $pages): ?>
            <div class="fx-page-arrow">
            <a class="fx-page-link" href="<?path($rootpages,array_merge($params,['page'=> ($page + 1) ]))?>" style="color:grey;">
            <i class="fas fa-angle-right"></i>
            </a></div>
            <div class="fx-page-arrow">
            <a class="fx-page-link" href="<?path($rootpages,array_merge($params,['page'=> $pages ]))?>" style="color:grey;">
            <i class="fas fa-angle-double-right"></i>
            </a></div>
        <? endif ?>    
        <div class="fx-page-arrow ml-3">
        <a title="<?l('All in one page')?>" class="fx-page-link" 
        href="<?path($rootpages,array_merge($params,['page'=>'202020']))?>">
        <i class="fas fa-arrows-alt" style='color:green;'></i>
        </a></div>
    </div>
    <? elseif (isset($pagination) and $pagination == 2) : ?>
    <div class="fx-pagination d-flex">
        <? if (isset($params) and $params != null): ?>
        <? elseif (isset($search) and $search) : ?>
            <? $params = [ 'search' => $search ] ?>
        <? else :?>
            <? $params = [] ?>
        <? endif ?>
        <div class="fx-page-arrow" style='padding:3px;border: 2px solid lightgrey; border-radius: 3px;'>
        <a title="<?l('Paginate')?>" class="fx-page-link" 
        href="<?path($rootpages,array_merge($params,['page'=> 1 ]))?>">
        <i class="fas fa-columns" style='color:green;'></i>
        </a></div>
    </div>
    <? endif ?>
