<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Страница не найдена</title>
        <link href="/public/styles/errors.css" rel="stylesheet">
    </head>
    <body>
		<main>
			<div class="container">
				<p><b>Ошибка 404</b>. Страница не найдена</p>
				<?php if (array_key_exists("admin", $_SESSION)): ?>
					<p><a href="/admin/starting">Перейти на стартовую</a></p>
				<?php else: ?>
					<p><a href="/">Перейти на главную</a></p>
				<?php endif; ?>
			</div>
		</main>
    </body>
</html>