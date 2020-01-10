<div class="container fw-container">
<?php foreach ($list as $val): ?>
	<div class="catalog-block" id="delete-block" data-id="<?php echo $val['id']; ?>">
		<div class="catalog-img-block">
			<?php if (isset($_SESSION['admin'])): ?>
				<div class="admin-panel-item" id="">
					<div class="delete-item">
						<a class="delete-item-action" href="" id="delete-button" data-id="<?php echo $val['id']; ?>">Удалить</a>
					</div>
					<div class="delete-item">
						<a class="delete-item-action" href="/admin/editCatalog/<?php echo $val['id']; ?>">Редактировать</a>
					</div>
				</div>
			<?php endif; ?>
			<a class="" href="/catalog/<?php echo $val['id']; ?>">
				<img src="public/images/catalogs/<?php echo $val['file']; ?>.png" alt="Изображение">
			</a>
		</div>
		<div class="catalog-info-title">
			<a href="/catalog/<?php echo $val['id']; ?>"><?php echo htmlspecialchars($val['title'], ENT_QUOTES); ?></a>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php if ($load == false):?>
	<script>
		$noauth = $(".read-more").hide();
	</script>
<?php endif; ?>