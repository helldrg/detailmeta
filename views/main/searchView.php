<script>
	$(document).ready(function() {
		var count = <?php echo $count; ?>;
		var total = <?php echo $total; ?>;
		var curCount = count;
		
		$(document).on('click','.read-more',function(e){
			e.preventDefault();
			let data = curCount;

			$(".content").append($('<div>').load("/search/<?php echo $text; ?>",{action:"loadContent", id:data, text:"<?php echo $text; ?>"}, function() {
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
				url: '/admin/deleteProduct/'+id,
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
	<h1 class="page-title c-gray-l fw-normal"><a href="/">Главная</a> > <a href="/catalog">Поиск</a>: <?php echo $text; ?></h1>
</div>

<?php if (empty($list)): ?>
	<div class="container">
		<p><span class="fs-medium">Изделия не найдены</span></p>
	</div>
<?php else: ?>
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
	<?php if ($load == true): ?>
		<div class="content"></div>
		<a class="read-more" data-id="0" href="#">Далее</a>
	<?php endif; ?>
<?php endif; ?>