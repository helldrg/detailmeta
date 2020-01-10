<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
		<base href="/">
		<meta name="Description" content="Описание сайта">
		<meta name="Keywords" content="Ключевые слова">
		
		<link href="/public/styles/default.css" rel="stylesheet">
        <script src="/public/scripts/jquery.js"></script>
		<script src="/public/scripts/search.js"></script>
        <script src="/public/scripts/form.js"></script>
		<script src="/public/scripts/menu.js"></script>
		<script src="/public/scripts/pageUp.js"></script>
    </head>
    <body>
		<header>
			<div class="toolbar-top">
				<div class="container main-menu">
					<div class="menu-logo">
						<a href="/"><img src="public/images/logo.png" alt="Главная"></a>
					</div>
					<div class="menu-wrap">
						<div class='menu-icon'>
							<b>Меню</b>
						</div>
						<ul class="menu">
							<li>
								<a href="/catalog">Каталог</a>
							</li>
							<li>
								<a href="/about">О нас</a>
							</li>
							<li>
								<a href="/contact">Контакты</a>
							</li>
							<li>
								<a href="/downloads/1">Прайс лист</a>
							</li>
						</ul>
					</div>
					<div class="menu-login">
						<a href="/admin/login">Войти</a>
					</div>
				</div>
			</div>
			<div class="container main-panel">
				<div class="panel-num">
					<?php echo $vars['mainNumPhone']; ?>
				</div>
				<div class="panel-search">
					<input class="search" name="search" placeholder="Поиск" type="search">
					<div class="mini-button-1">
						<a class="toSearch btn-1" href="">Найти</a>
					</div>
				</div>
				<div class="panel-basket">
					<div class="mini-button-1">
						<a class="btn-1" href="/feedback">Отправить сообщение</a>
					</div>
				</div>
			</div>
		</header>
		<main>
			<?php echo $content; ?>
		</main>
        <footer>
			<div class="toTop fs-medium" >Наверх</div>
            <div class="footer-bottom-level">
                <div class="footer-text">
					<span class="c-gray-l">&copy; <?php echo date("Y"); ?>, <?php echo $vars['orgName']; ?></span>
				</div>
				<div class="footer-icon">
					<a href="http://<?php echo $vars['vkGroup'];?>"><span class="icon-vk-social-network-logo"></span></a>
				</div>
            </div>
        </footer>
    </body>
</html>