<div class="container">
	<h1 class="page-title c-gray-l fw-normal"><a href="/">Новости</a> > <a href="/catalog">Каталог</a> > <a href="/catalog/<?php echo $catalog[0]['id']; ?>"><?php echo $catalog[0]['title']; ?></a> > <?php echo htmlspecialchars($data[0]['title'], ENT_QUOTES); ?></h1>
</div>
<div class="container">
	<div class="product-page-block">
		<div class="product-page-img">
			<img tabindex="0" src="public/images/products/<?php echo $data[0]['file1']; ?>.png" alt="Изображение">
			<?php if (!empty($data[0]['file2'])): ?>
				<img tabindex="0" src="public/images/products/<?php echo $data[0]['file2']; ?>.png" alt="Изображение">
			<?php endif; ?>
			<?php if (!empty($data[0]['file3'])): ?>
				<img tabindex="0" src="public/images/products/<?php echo $data[0]['file3']; ?>.png" alt="Изображение">
			<?php endif; ?>
			<div></div>
		</div>
		<div class="product-page-description">
			<span class="fs-big"><?php echo $data[0]['title']; ?></span>
			<p><b>Цена:</b> <?php echo $data[0]['price']; ?> руб.</p>
			<span><b>Материал:</b> <i><?php echo $data[0]['materials']; ?></span></i><br/>
			<span><b>Технические характеристики:</b> <i><?php echo $data[0]['specifications']; ?></span></i><br/>
			<span>Доставка <?php echo $data[0]['delivery']; ?></span><br/>
			<span>Оптовые поставки: <?php echo $data[0]['amount']; ?></span>
			<p>Для заказа или более подробной информации свяжитесь с нами: <nobr>+ 7 915 961 8361</nobr> <nobr>ya.texpolimer@yandex.ru</nobr></p>
		</div>
	</div>
</div>