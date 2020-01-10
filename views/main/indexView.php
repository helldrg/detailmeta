<script>
	$(document).ready(function() {
		var count = <?php echo $count; ?>;
		var total = <?php echo $total; ?>;
		var curCount = count;
		
		$(document).on('click','.read-more',function(e){
			e.preventDefault();
			let data = curCount;

			$(".content").append($('<div>').load("/",{action:"loadContent", id:data}, function() {
				if(curCount + count <= total)
					curCount = curCount + count;
				else
					curCount = total;
			}));
		});
		
		$(document).on('click','#delete-button',function(e){			
			event.preventDefault();
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
					}
				}
			});
		});
	});
</script>
<div  class="container">
	<h1 class="page-title c-gray-l fw-normal">Баннеры</h1>
</div>
<?php if (empty($list)): ?>
	<div class="container">
		<p><span class="fs-medium">Баннеры не найдены</span></p>
	</div>
<?php else: ?>
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
	<?php if ($load == true): ?>
		<div class="content"></div>
		<a class="read-more" data-id="0" href="#">Далее</a>
	<?php endif; ?>
<?php endif; ?>