<?php foreach ($list as $val): ?>
	<div class="container post-container" id="delete-block" data-id="<?php echo $val['id']; ?>">
		<div class="post-img-block">
			<a class="" href="product/<?php echo $val['id']; ?>">
				<img src="public/images/products/<?php echo $val['file1']; ?>.png" alt="Изображение">
			</a>
		</div>
		<div class="post-info-block">
			
				<div class="post-info-title">
					<a href="/product/<?php echo $val['id']; ?>"><?php echo htmlspecialchars($val['title'], ENT_QUOTES); ?></a>
				</div>
				<div class="post-info-meta">
					<span class="post-info-meta-first-span">Материал: <?php echo $val['materials']; ?></span>
					<!--<span class="post-info-meta-span">0 отзывов</span>-->
				</div>
				<div class="post-info-description">
					<p>Технические характеристики: <?php echo htmlspecialchars($val['specifications'], ENT_QUOTES); ?></p>
				</div>
				
				
				
				<div class="post-info-price-block">
					<div class="post-info-price">
						<span><?php echo $val['price']; ?> руб.</span>
					</div>
				
					<div class="products-view-buttons-cell">
						<div class="mini-button-2">
							<a class="btn-2" href="/product/<?php echo $val['id']; ?>">Подробнее</a>
						</div>
					</div>
					<?php if (isset($_SESSION['admin'])): ?>
						<div class="products-view-buttons-cell">
							<div class="mini-button-2">
								<a class="btn-2" href="/admin/editProduct/<?php echo $val['id']; ?>">Редактировать</a>
							</div>
						</div>
						<div class="products-view-buttons-cell">
							<div class="mini-button-2">
								<a class="btn-2" href="" id="delete-button" data-id="<?php echo $val['id']; ?>">Удалить</a>
							</div>
						</div>
					<?php endif; ?>
				</div>
			
		</div>
	</div>
<?php endforeach; ?>
<?php if ($load == false): ?>
	<script>
		$noauth = $(".read-more").hide();
	</script>
<?php endif; ?>