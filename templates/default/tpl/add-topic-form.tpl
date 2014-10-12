    <div class="h1 margin-bottom">{{:title}}:</div>
    <input type="text" id="topic-name" />
    <br />
    <br />
    <div class="h1 margin-bottom">{{:blog}}:</div>
    <select id="topic-blog">
        {{OPTIONS}}
    </select>
    <br />
     <br />
    <div class="h1 margin-bottom">{{:text}}:</div>
    <textarea class="ckeditor" id="createtopic" placeholder="Текст топика.."></textarea>
    <button class="create-topic-b margin-top" onclick="addTopic();" id="create-topic">{{:create_topic}}</button>
    <br />
    <br />