{?authorized=1?}
    <div class="sidebar">
        <img title="{{TITLE}}" src="{{DIR}}/logo.png" id="sidebar-logo" />
        <br />
        <a class="sidebar-link" href="/">
            <img title="{{:to_home}}" src="{{DIR}}/theme/icons/home.png" class="sidebar-icon">
        </a>
        <br />
        <a class="sidebar-link" href="/events/">
            <img title="{{:events}}" src="{{DIR}}/theme/icons/alert.png" class="sidebar-icon">
        </a>
        <br />
        <a class="sidebar-link" href="/mail-new/">
            <img title="{{:mail}}" src="{{DIR}}/theme/icons/mail.png" class="sidebar-icon">
        </a>
        <div class="bottom">
            <div class="sidebar-menu-button">
                <img title="{{:menu}}" src="{{DIR}}/theme/icons/menu.png" class="sidebar-icon">
                <div class="sidebar-menu">
                    <a href="/profile/{{LOGIN}}">
						<div class="p-menu">
                    		<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/profile.png" /> {{:profile}}
                		</div>
					</a>
					<a href="/settings/">
						<div class="p-menu">
							<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/settings.png" /> {{:settings}}
						</div>
					</a>
					<a href="/security/">
						<div class="p-menu">
							<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/security.png" /> {{:security}}
						</div>
					</a>
					<a href="/donate/">
						<div class="p-menu">
							<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/donate.png" /> {{:donate}}
						</div>
					</a>
                </div>
            </div>
        </div>
    </div>
{??}
{?authorized=0?}
	<div class="sidebar">
		<img title="{{TITLE}}" src="{{DIR}}/logo.png" id="sidebar-logo" />
		<br />
		<a class="sidebar-link" href="/">
			<img title="{{:to_home}}" src="{{DIR}}/theme/icons/home.png" class="sidebar-icon">
		</a>

		<div class="bottom">
			<a class="sidebar-link" href="/donate/">
				<img title="{{:donate}}" src="{{DIR}}/theme/icons/donate.png" class="sidebar-icon">
			</a>
			<br />
			<div class="sidebar-menu-button">
				<img title="Меню" src="{{DIR}}/theme/icons/menu.png" class="sidebar-icon">
				<div class="sidebar-menu">
					<a href="#" onclick="openAuthWindow();"><div class="p-menu">
							<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/auth.png" /> {{:authorization}}
						</div></a><a href="#" onclick="openRegWindow();"><div class="p-menu">
							<img class="sidebar-menu-icon" src="{{DIR}}/theme/icons/reg.png" /> {{:registration}}
						</div></a>
				</div>
			</div>
		</div>
	</div>
{??}