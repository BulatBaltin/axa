<ul class="nav-dropdown-items" style="margin-left:<?=$x_shift?>px;">
    <li class="nav-item">
        <a href="javasript:void(0)" class="nav-link">
            <i class="<?=$item['icon']?>"></i>
            <?=$item['name']?>
        </a>
        <ul class="nav-dropdown-items" style="margin-left:<?=$x_shift+=15?>px;">
            <? foreach($item['items'] as $item) :

                if( isset($item['items'])) {
                    include_view($root_dir.'item-array',['item'=>$item,'root_dir'=>$root_dir, 'x_shift'=>$x_shift ]);
                } else {
                    include_view($root_dir.'item-item',['item'=>$item ]);
                }
            endforeach ?>
        </li>
    </li>
</ul>
