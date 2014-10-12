	<input type="hidden" id="topic-id" value="{{ID}}" />
	<div class="h1 margin-bottom">{{:title}}:</div>
	<input type="text" id="topic-name" value="{{NAME}}" />
	<br />
	<br />
	<div class="h1 margin-bottom">{{:blog}}:</div>
	<select id="topic-blog">
		{{OPTIONS}}
	</select>
	<br />
	<br />
	<div class="h1 margin-bottom">{{:text}}:</div>
	<textarea class="ckeditor" id="edittopic" placeholder="Текст топика..">{{TEXT}}</textarea>
	<button class="create-topic-b margin-top" onclick="editTopic();" id="create-topic">{{:save}}</button>
	<br />
	<br />