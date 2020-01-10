<script>
	$(document).ready(function() {
		var count = <?php echo $count; ?>;
		var total = <?php echo $total; ?>;
		var curCount = count;
		
		$(document).on('click','.read-more',function(e){
			e.preventDefault();
			let data = curCount;

			$(".content").append($('<div>').load("/catalog/",{action:"loadContent", id:data}, function() {
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
					}
				}
			});
		});
	});
</script>
<div  class="container">
	<h1 class="page-title c-gray-l fw-normal"><a href="/">Главная</a> > Каталог</h1>
</div>
<?php if (empty($list)): ?>
	<div class="container">
		<p><span class="fs-medium">Каталоги ненайдены</span></p>
	</div>
<?php else: ?>
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
	
	<?php if ($load == true): ?>
		<div class="content"></div>
		<a class="read-more" data-id="0" href="#">Далее</a>
	<?php endif; ?>
<?php endif; ?>