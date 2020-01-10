<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <link href="/public/styles/admin.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.0/jquery-migrate.min.js"></script>
    </head>
    <body>
		<main>
			<?php if ($this->route['action'] != 'login'): ?>
				<input type="checkbox" id="nav-toggle" hidden>
				<nav class="nav">
					<label for="nav-toggle" class="nav-toggle" onclick></label>
					<h3 class="logo"> 
						<a href="/admin/starting">На главную</a> 
					</h3>
					<ul>
						<li><a href="/admin/viewBanners">Баннеры</a>
						<li><a href="/admin/viewCatalogs">Каталоги</a>
						<li><a href="/admin/settingsSecurity">Пароль и логин</a>
						<li><a href="/admin/settingsAbout">"О нас"</a>
						<li><a href="/admin/settingsContact">Контактная информация</a>
						<li><a href="/admin/settings">Настройки</a>
						<li><a href="/admin/logout">Выход</a>
					</ul>
					<h3 class="logo"> 
						<a href="/">Перейти на сайт</a> 
					</h3>
				</nav>
			<?php endif; ?>
			<?php echo $content; ?>
		</main>
		<?php if ($this->route['action'] != 'login'): ?>
		<footer>
            <div class="footer-bottom-level">
                <div class="footer-text">
					<span class="c-white">&copy; <?php echo date("Y"); ?>, <?php echo $vars['orgName']; ?></span>
				</div>
            </div>
        </footer>
        <?php endif; ?>
    </body>
</html>