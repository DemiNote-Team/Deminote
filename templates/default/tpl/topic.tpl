    <div class="blog">
        <a href="/view/{{ID}}/{{NAME}}.html" class="{{NOT_A_LINK}}">
            <div class="blog-title {{BIG_TEXT}}">
                {{TITLE}}
            </div>
        </a>
        <br />
        <a class="blogname" href="/blog/{{BLOG_ID}}/{{BLOG_TRANSLIT}}.html">{{BLOG}}</a>

        <div class="blog-text">
            {{TEXT}}
			<div class="read-more" style="display: {{READ_MORE}}">
				<a href="/view/{{ID}}/{{NAME}}.html">
					{{:read_more}}...
				</a>
			</div>
        </div>

        <div class="blog-info {{TOUCHABLE}}">
            <a href="/profile/{{LOGIN}}"><img src="{{DIR}}/theme/icons/user.png" class="user-icon" /> {{LOGIN}}</a><span class="gray">, {{DATE}}</span>

            <span class="right-text">
				{?moderator=1?}
				<span class="edit-link">
						<img src="{{DIR}}/theme/icons/edit.png" id="edit-img" />

						<a href="/edit/topic/{{ID}}/{{NAME}}.html">
							{{:edit}}
						</a>
					</span>
				{??}
                <img onclick="rating(0, '{{ID}}', 1, this);" src="{{DIR}}/theme/icons/plus_circle{{PLUS_PASSIVE}}.png" class="rating-img plus-rating-img" />
                <span class="rating {{RATING_CLASS}}">{{RATING}}</span>
                <img onclick="rating(0, '{{ID}}', -1, this);" src="{{DIR}}/theme/icons/minus_circle{{MINUS_PASSIVE}}.png" class="rating-img minus-rating-img" />
            </span>
        </div>
    </div>