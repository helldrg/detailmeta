<script>
	$(document).ready(function() {
		var count = <?php echo $count; ?>;
		var total = <?php echo $total; ?>;
		var curCount = count;
		
		$('#info-count-total').html(' ('+curCount+' из '+total+')');
		
		$(document).on('click','.read-more',function(e){
			e.preventDefault();
			
			let data = curCount;
			$(".content").append($('<div>').load("/admin/viewCatalogs",{action:"loadContent", id:data}, function() {
				if(curCount + count <= total)
					curCount = curCount + count;
				else
					curCount = total;
				$('#info-count-total').html(' ('+curCount+' из '+total+')');
			}));
		});
		
		$(document).on('click','#delete-button',function(e){			
			event.preventDefault();
			let json;
			let Data = new FormData();
			Data.append('count', 1);
			let id = $(this).attr('data-id');
			
			$.ajax({
				url: '/admin/deleteCatalog/'+id,
				type: 'post',
				data: Data,
				contentType: false,
				processData: false,
				success: function(result) {
					json = jQuery.parseJSON(result);
					
					if (json.url && json.status && json.message) {
						alert(json.status + ' - ' + json.message);
						window.location.href = '/' + json.url;
					} else if (json.url) {
						window.location.href = '/' + json.url;
					} else {
						alert(json.status + ' - ' + json.message);
					}
					
					if(json.status != 'error')
					{
						$('[id = "delete-block"][data-id = "'+id+'"]').remove();
						curCount--;
						total--;
						$('#info-count-total').html(' ('+curCount+' из '+total+')');
					}
				}
			});
		});
	});
</script>
<div class="container">
    <div class="panel settings-panel">
		<div class="title-panel">
			<span class="c-white fs-medium ff-SansNarrow">Каталоги</span>
			<?php if (!empty($total)): ?>
				<span class="c-white fs-medium ff-SansNarrow" id="info-count-total"></span>
			<?php endif; ?> 
			<a href="/admin/addCatalog">
				<div class="b-plus-title "></div>
			</a>
		</div>
		<?php if (empty($list)): ?>
			<div class="container-empty-list">
				<span class="fs-medium ff-SansNarrow">Список каталогов пуст</span>
			</div>
        <?php else: ?>
			<div class="d-table ff-SansNarrow">
				<div class="d-tr d-th">
					<span class="d-td fs-medium" style="flex-grow: 3;">
						Название каталога
					</span>
					<span class="d-td fs-medium">
						Редактировать
					</span>
					<span class="d-td fs-medium">
						Удалить
					</span>
				</div>
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
				<?php if ($load == true): ?>
					<div class="content"></div>
					<a class="read-more" data-id="0" href="#">Далее</a>
				<?php endif; ?>
			</div>
		<?php endif; ?> 
    </div>
</div>