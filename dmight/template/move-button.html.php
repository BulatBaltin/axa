<style>
a.no-text-decor {
display:inline-block;
border: 2px solid #ddd;
padding: 0.2rem 1rem;
border-radius:1.2rem;
}
a.no-text-decor:hover {
    text-decoration: none;
    color: #333;
    background:#eee; 
    border-color: grey;
}
</style>

<? if (! isset($url_title)): ?>
    <? $url_title = '' ?>
<? endif ?>
<? if (! isset($url_class)): ?>
    <? $url_class = '' ?>
<? endif ?>
<? if (! isset($url_text)): ?>
    <? $url_text = 'Back to list' ?>
<? endif ?>
<a title= "<?= $url_title ?>" class="no-text-decor <?= $url_class ?>" href="<?= $url_back ?>">
&#171;&nbsp; <? l($url_text) ?>
</a>
