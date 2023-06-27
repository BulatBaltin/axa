<li class="nav-item">

    <a href="<? path($item['href'])?>" class="nav-link" title="<?=$item['title'] ?? ''?>">
        <i class="<?=$item['icon']?>"></i>
        <?=$item['name'] . $item['href']?>
    </a>
</li>
