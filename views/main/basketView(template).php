<main>
	<div  class="main-page-title">
		<h1 class="page-title">Новости</h1>
	</div>
	
	<?php if (empty($list)): ?>
		<p>Список постов пуст</p>
	<?php else: ?>
		<?php foreach ($list as $val): ?>
			<div  class="main-post-container">
				<div class="post-container">
					<div class="post-img-block">
						<a class="" href="/">
							<img src="public/images/1.jpg" alt="Деталь">
						</a>
					</div>
					<div class="post-info-block">
						
							<div class="post-info-title">
								<a href="/product/<?php echo $val['id']; ?>"><?php echo htmlspecialchars($val['name'], ENT_QUOTES); ?>Пластмассовая ручка типа замок</a>
							</div>
							<div class="post-info-meta">
								<span class="post-info-meta-first-span">Артикул: 1</span>
								<span class="post-info-meta-span">0 отзывов</span>
								<span class="post-info-meta-span">Под заказ, 8 дней</span>
								<span class="post-info-meta-span">Оптом и в розницу</span>
							</div>
							<div class="post-info-description">
								<p><?php echo htmlspecialchars($val['description'], ENT_QUOTES); ?>Типа описание: Цена договорная в зависимости от объёма заказанной партии, применяемого материла. Цена 3 р. при партии в 100 тыс. штук.</p>
							</div>
							
							
							
							<div class="post-info-price-block">
								<div class="post-info-price">
									<span>800 руб.</span>
								</div>
							
								<div class="products-view-buttons-cell">
									<div class="mini-button-2">
										<a  class="btn-2" href="/">В корзину</a>
									</div>
								</div>
							</div>
						
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<div class="clearfix">
			<?php echo $pagination; ?>
		</div>
    <?php endif; ?>
</main>	