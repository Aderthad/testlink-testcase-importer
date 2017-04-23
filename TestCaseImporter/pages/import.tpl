{include 'inc_head.tpl'}
<h1 class="title">{$gui->title}</h1>

<div class="workBack">
    <form method="post" enctype="multipart/form-data">
            <input type='file' name='csvFile'/><br/>
            <input name="submit" type="submit" value="{$gui->labelHeaderMessage}"/>
    </form>
</div>