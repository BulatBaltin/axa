<!DOCTYPE html>
<html lang="<? echo Local::getLang() ?>">
<head>

    <? include(LAYOUT . 'base-qv-head.html.php') ?>
    <? include(LAYOUT . 'base-auto-head.html.php') ?>

</head>
<body class="page-label-<? echo ROUTER::ActionName() ?>">

    <? include_once("header.php") ?>

    <section class="left-menu">
        <? include_once('partials/left-sidebar.view.php') ?>
    </section>
    <section id="main-right" class="main-content">
        <? 
$view = ROUTER::ViewFile();
$view and file_exists($view) and include($view);
        ?>
    </section>

    <? include( "footer.php" ) ?>

<? HTML::LinkLocalJS(); ?>
</body>
</html>

