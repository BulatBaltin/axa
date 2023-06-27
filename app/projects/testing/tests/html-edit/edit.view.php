<!--Include the JS & CSS-->
<link rel="stylesheet" href="/richtexteditor/rte_theme_default.css" />
<script type="text/javascript" src="/richtexteditor/rte.js"></script>
<script type="text/javascript" src='/richtexteditor/plugins/all_plugins.js'></script>
<div id="div_editor1">
	<p>This is a default toolbar demo of Rich text editor.</p>
	<p><img src='/images/editor-image.png' /></p>
    <p><?=$text?></p>
</div>

<script>
	var editor1 = new RichTextEditor("#div_editor1");
	//editor1.setHTMLCode("Use inline HTML or setHTMLCode to init the default content.");
</script>