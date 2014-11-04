{?authorized=1?}
    <div class="right">
		<div class="sub top-sub">
            Joxinote
            <div class="language-picker">
                <a onclick="void(0);" href="?lang=ru">
                    <img src="{{DIR}}/theme/icons/flag_russia.png" class="flag" />
                </a>
                <a onclick="void(0);" href="?lang=en">
                    <img src="{{DIR}}/theme/icons/flag_usa.png" class="flag" />
                </a>
            </div>
		</div>
		<div class="sub" id="userbar">
            <div class="userbar">
                <a href="/profile/{{LOGIN}}"><img src="{{DIR}}/theme/icons/user.png" class="user-icon" /> <span class="username">{{LOGIN}}</span></a>
                <span class="right-text">
                    <a href="/exit/" onclick="void(0);"><img title="{{:exit}}" src="{{DIR}}/theme/icons/exit.png" /></a>
                </span>
            </div>
        </div>

		<div class="right-create-d">
			<div class="add-new-t-p">
				<a href="/create/topic" class="add-new-t">
					<img src="{{DIR}}/theme/icons/plus_topic.png" class="add-new-img" />
					<br />
					{{:add_new_topic}}
				</a>
			</div>

			<div class="add-new-t-p">
				<a href="/create/blog" class="add-new-t">
					<img src="{{DIR}}/theme/icons/plus_blog.png" class="add-new-img" />
					<br />
					{{:add_new_blog}}
				</a>
			</div>
		</div>

        <div class="b-content">
            <div class="b-title">
                {{:blog_list}}
            </div>

            <div class="b-text">
                {{BLOG_LIST}}
            </div>
        </div>

        <div class="b-content">
            <div class="b-title">
                {{:last_comments}}
            </div>

            <div class="b-text new-comments">
                {{LAST_COMMENTS}}
            </div>
        </div>
    </div>
{??}
{?authorized=0?}
	<div class="right">
		<div class="sub" id="userbar">
			Joxinote
			<div class="language-picker">
				<a href="?lang=ru&return={{URI}}">
					<img src="{{DIR}}/theme/icons/flag_russia.png" class="flag" />
				</a>
				<a href="?lang=en&return={{URI}}">
					<img src="{{DIR}}/theme/icons/flag_usa.png" class="flag" />
				</a>
			</div>

			<br />
			<br />
			<div class="userbar">
				<div class="right-button">
					<a href="#" class="right-auth-link" onclick="openAuthWindow();">
						<div class="right-auth-form">
							<img src="{{DIR}}/theme/icons/auth.png" class="right-icon" /> {{:authorization}}
						</div>
					</a>
				</div>
				<div class="right-button">
					<a href="#" class="right-auth-link"  onclick="openRegWindow();">
						<div class="right-auth-form">
							<img src="{{DIR}}/theme/icons/reg.png" class="right-icon" /> {{:registration}}
						</div>
					</a>
				</div>
			</div>
		</div>

		<div class="b-content">
			<div class="b-title">
				{{:blog_list}}
			</div>

			<div class="b-text">
				{{BLOG_LIST}}
			</div>
		</div>

		<div class="b-content">
			<div class="b-title">
				{{:last_comments}}
			</div>

			<div class="b-text new-comments">
				{{LAST_COMMENTS}}
			</div>
		</div>
	</div>
{??}