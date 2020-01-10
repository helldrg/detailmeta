<?php foreach ($list as $val): ?>
	<div class="container post-container" id="delete-block" data-id="<?php echo $val['id']; ?>">
		<div class="container banner-img-block">
			<?php if (isset($_SESSION['admin'])): ?>
				<div class="admin-panel-item" id="">
					<div class="delete-item">
						<a class="delete-item-action" href="" id="delete-button" data-id="<?php echo $val['id']; ?>">Удалить</a>
					</div>
					<div class="delete-item">
						<a class="delete-item-action" href="/admin/editBanner/<?php echo $val['id']; ?>">Редактировать</a>
					</div>
				</div>
			<?php endif; ?>
			<img src="public/images/banners/<?php echo $val['file']; ?>.png" alt="Изображение">
		</div>
	</div>
<?php endforeach; ?>
<?php if ($load == false): ?>
	<script>
		$noauth = $(".read-more").hide();
	</script>
<?php endif; ?>