<?php foreach ($list as $val): ?>
	<div class="d-tr" id="delete-block" data-id="<?php echo $val['id']; ?>">
		<span class="d-td" style="flex-grow: 3;">
			<a class="d-td-action" href="/admin/viewCatalogs/<?php echo $val['id']; ?>">
				<?php echo $val['title']; ?>
			</a>
		</span>
		<span class="d-td">
			<a class="d-td-action" href="/admin/editCatalog/<?php echo $val['id']; ?>">Редактировать</a>
		</span>
		<span class="d-td">
			<a class="d-td-action" href="" id="delete-button" data-id="<?php echo $val['id']; ?>">Удалить</a>
		</span>
	</div>
<?php endforeach; ?>
<?php if ($load == false): ?>
	<script>
		$noauth = $(".read-more").hide();
	</script>
<?php endif; ?>