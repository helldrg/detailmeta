<script>
	$(document).ready(function() {
		var count = <?php echo $count; ?>;
		var total = <?php echo $total; ?>;
		var curCount = count;
		
		$('#info-count-total').html(' ('+curCount+' из '+total+')');

		$(document).on('click','.read-more',function(e){
			e.preventDefault();
			let data = curCount;

			$(".content").append($('<div>').load("/admin/viewBanners",{action:"loadContent", id:data}, function() {
				if(curCount + count <= total)
					curCount = curCount + count;
				else
					curCount = total;
				$('#info-count-total').html(' ('+curCount+' из '+total+')');
			}));
		});
		
		$(document).on('click','#delete-button',function(e){			
			e.preventDefault();
			let json;
			let Data = new FormData();
			Data.append('count', 1);
			let id = $(this).attr('data-id');

			$.ajax({
				url: '/admin/deleteBanner/'+id,
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
			<span class="c-white fs-medium ff-SansNarrow">Баннеры</span>
			<?php if (!empty($total)): ?>
				<span class="c-white fs-medium ff-SansNarrow" id="info-count-total"></span>
			<?php endif; ?> 
			<a href="/admin/addBanner">
				<div class="b-plus-title "></div>
			</a>
		</div>
		<?php if (empty($list)): ?>
			<div class="container-empty-list">
				<span class="fs-medium ff-SansNarrow">Список баннеров пуст</span>
			</div>
        <?php else: ?>
			<div class="d-table ff-SansNarrow">
				<div class="d-tr d-th">
					<span class="d-td fs-medium" style="flex-grow: 3;">
						Изображение
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
				<?php if ($load == true): ?>
					<div class="content"></div>
					<a class="read-more" data-id="0" href="#">Далее</a>
				<?php endif; ?>
			</div>
		<?php endif; ?> 
    </div>
</div>
<?php foreach ($list as $val): ?>
	<a href="/admin/viewBanners#_" class="lightbox" id="img<?php echo $val['id']; ?>">
		<img class="lightbox-img" src="/public/images/banners/<?php echo $val['file']; ?>.png">
	</a>
<?php endforeach; ?>