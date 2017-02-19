{include 'inc_head.tpl'}
<h1>{$gui->title}</h1>

<form method="post" enctype="multipart/form-data">
	<input type='file' name='csvFile'/><br/>
	<input name="submit" type="submit" value="{$gui->labelHeaderMessage}"/>
</form>