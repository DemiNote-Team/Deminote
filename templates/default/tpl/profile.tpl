	<div class="h1">{{:profile}}: {{LOGIN}}</div>
	<div class="gray">
		{?online=1?}
			<span class="green">{{:online}}</span>
		{??}
		{?online=0?}
			<span class="red">{{:offline}}</span>
		{??}
	</div>
	<br />
	<div class="sub">
		<b class="h2">{{:info}}</b>

		<br />
		<br />

		<b>{{:reg_date}}</b>: {{REG_DATE}}<br />
		<b>{{:last_click}}</b>: {{LAST_CLICK}}<br />
		<b>{{:topics_count}}</b>: {{TOPICS_COUNT}}<br />
		<b>{{:comments_count}}</b>: {{COMMENTS_COUNT}}<br />
	</div>

	<div class="sub">
		<b class="h2">{{:blogs}} ({{BLOGS_COUNT}})</b>

		<br />
		<br />

		{{BLOGS}}
	</div>

	<div class="sub">
		<b class="h2">{{:topics}} ({{TOPICS_COUNT}})</b>

		<br />
		<br />

		{{TOPICS}}
	</div>
