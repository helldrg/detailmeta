<?php foreach ($list as $val): ?>
	<div class="d-tr" id="delete-block" data-id="<?php echo $val['id']; ?>">
		<span class="d-td" style="flex-grow: 3;">
			<a href="#img<?php echo $val['id']; ?>">
				<img class="d-table-img" class="d-table-img" src="/public/images/banners/<?php echo $val['file']; ?>.png">
			</a>
		</span>
		<span class="d-td">
			<a class="d-td-action" href="/admin/editBanner/<?php echo $val['id']; ?>">Редактировать</a>
		</span>
		<span class="d-td">
			<a class="d-td-action" href="" id="delete-button" data-id="<?php echo $val['id']; ?>">Удалить</a>
		</span>
	</div>
<?php endforeach; ?>
<?php foreach ($list as $val): ?>
	<a href="/admin/viewBanners#_" class="lightbox" id="img<?php echo $val['id']; ?>">
		<img class="lightbox-img" src="/public/images/banners/<?php echo $val['file']; ?>.png">
	</a>
<?php endforeach; ?>
<?php if ($load == false): ?>
	<script>
		$noauth = $(".read-more").hide();
	</script>
<?php endif; ?>