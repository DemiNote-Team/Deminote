        <div class="comment {{TOUCHABLE}}" id="comment-{{ID}}" deep="{{DEEP}}">
            <div class="comment-info">
                <a href="/profile/{{LOGIN}}" class="{{BOLD}} {{ME}}"><img src="{{DIR}}/theme/icons/user.png" class="user-icon" /> {{LOGIN}}</a>,
				<span class="gray">{{TIME}}</span>
				<a href="#comment-{{ID}}">
					#
				</a>

				<span class="right-text">
                    <img onclick="rating(1, '{{ID}}', 1, this);" src="{{DIR}}/theme/icons/plus_circle{{PLUS_PASSIVE}}.png" class="rating-img plus-rating-img" />
                    <span class="rating {{RATING_CLASS}}">{{RATING}}</span>
                    <img onclick="rating(1, '{{ID}}', -1, this);" src="{{DIR}}/theme/icons/minus_circle{{MINUS_PASSIVE}}.png" class="rating-img minus-rating-img" />
                </span>
            </div>

            <div class="comment-content">
                {{TEXT}}
            </div>

            <div class="comment-links">
                <a class="comment-link" onclick="openReplyForm('{{ID}}');">{{:answer}}</a>

				<div class="hidden-controls">
					{?access=commentRemove?}
						<a class="comment-link" onclick="removeComment('{{ID}}');">
							{{:remove}}
						</a>
					{??}
					{?moderator=1?}
						<a class="comment-link" onclick="removeComment('{{ID}}');">
							{{:remove}}
						</a>
					{??}
				</div>
            </div>
        </div>