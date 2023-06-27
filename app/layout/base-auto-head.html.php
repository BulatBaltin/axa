<? HTML::LinkMetaData(); ?>
<!-- JS -->
<? if (!isset($adminPanel)) : ?>
    <!-- JS public/js/auto Folder-->
    <? HTML::LinkJSAuto(); ?>
    <!-- Styles  public/css/auto Folder-->
    <? HTML::LinkCSSAuto(); ?>
    <? HTML::LinkCSSProject(); ?>
<? endif ?>
