{?authorized=1?}
        <div id="add-comment-form">
            <div class="h1 add-comment-l">{{:add_comment}}</div>
            <br />
            <textarea class="ckeditor" id="newcomment"></textarea>
            <button class="add-comment-b" onclick="addComment();" id="add-comment">{{:add_comment}}</button>
        </div>
{??}
{?authorized=0?}
	<div class="h1">{{:not_registered}}</div>
{??}