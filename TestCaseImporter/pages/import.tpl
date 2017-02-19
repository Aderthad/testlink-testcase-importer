{include 'inc_head.tpl'}
<p>{$gui->title}</p>

<form method="post" enctype="multipart/form-data">
	<input type='file' name='csvFile'/><br/>
	<input name="submit" type="submit" value="{$gui->labelHeaderMessage}"/>
</form>