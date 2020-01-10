<script src="/public/scripts/uploadMultiFile.js"></script>
<div class="container">
    <div class="panel settings-panel">
		<div class="title-panel">
			<span class="c-white fs-medium ff-SansNarrow">Редактирование изделия</span>
			<a href="/admin/viewCatalogs/<?php echo $data[0]['idCatalog']; ?>">
				<div class="b-arrow-left"></div>
			</a>
		</div>
		<div class="d-table ff-SansNarrow">
			<form action="/admin/editProduct/<?php echo $data[0]['id']; ?>" method="post" enctype="multipart/form-data">
				<div class="d-tr d-th">
					<span class="d-td fs-medium">
						Название поля
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						Поле
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Именование изделия:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="title" value="<?php echo $data[0]['title']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Каталог:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<select class="fs-medium" name="idCatalog">
						<?php foreach ($list as $val): ?>
							<?php if($data[0]['idCatalog'] == $val['id']): ?>
								<option value="<?php echo $val['id']; ?>" selected="selected"><?php echo $val['title']; ?></option>
							<?php else: ?>
								<option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
						</select>
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Материал:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="materials" value="<?php echo $data[0]['materials']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Цена:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="price" value="<?php echo $data[0]['price']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Тех. характеристики:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="specifications" value="<?php echo $data[0]['specifications']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Доставка:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="delivery" value="<?php echo $data[0]['delivery']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Оптовые поставки от:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="amount" value="<?php echo $data[0]['amount']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td container-empty-list">
					</span>
				</div>
				<div class="d-tr d-th">
					<span class="d-td fs-medium" style="flex-grow: 3;">
						Изображение
					</span>
					<span class="d-td fs-medium">
						Загрузка
					</span>
					<span class="d-td fs-medium">
						Сохранение
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td-img">
						<div class="dropped-container">
							<div class="container-drop-img">
								<?php if (!empty($data[0]['file1'])): ?>
									<a href="#img1111">
										<img class="d-table-img" src="/public/images/products/<?php echo $data[0]['file1']; ?>.png" style="opacity:.3;">
									</a>
								<?php endif; ?>
								<?php if (!empty($data[0]['file2'])): ?>
								<a href="#img1112">
									<img class="d-table-img" src="/public/images/products/<?php echo $data[0]['file2']; ?>.png" style="opacity:.3;">
								</a>
								<?php endif; ?>
								<?php if (!empty($data[0]['file3'])): ?>
								<a href="#img1113">
									<img class="d-table-img" src="/public/images/products/<?php echo $data[0]['file3']; ?>.png" style="opacity:.3;">
								</a>
								<?php endif; ?>
							</div>
						</div>
					</span>
					<span class="d-td">
					<div>
						<div class="upload-container">
							<img class="upload-container-img" src="/public/images/upload-icon.png">
							<input id="upload-btn" type="file" name="file" data-count="3" multiple>
							<label class="upload-container-label fs-small" for="upload-btn">Выберите файл</label>
							<span>или перетащите</span>
						</div>
					</div>
					</span>
					<span class="d-td">
						<a id="btn-form" class="d-td-action  fs-medium ff-SansNarrow" href="">Сохранить</a>
					</span>
				</div>
			</form>
		</div>
    </div>
</div>
<div class="dropped-lightbox">
	<div class="drop-lightbox">
		<a href="/admin/editProduct/<?php echo $data[0]['id']; ?>#_" class="lightbox lightboxJS" id="img<?php echo $data[0]['id']; ?>">
			<img class="lightbox-img" src="/public/images/products/<?php echo $data[0]['file1']; ?>.png">
		</a>
		<?php if (!empty($data[0]['file1'])): ?>
			<a href="/admin/editProduct/<?php echo $data[0]['id']; ?>#_" class="lightbox" id="img1111">
				<img class="lightbox-img" src="/public/images/products/<?php echo $data[0]['file1']; ?>.png">
			</a>
		<?php endif; ?>
		<?php if (!empty($data[0]['file2'])): ?>
			<a href="/admin/editProduct/<?php echo $data[0]['id']; ?>#_" class="lightbox" id="img1112">
				<img class="lightbox-img" src="/public/images/products/<?php echo $data[0]['file2']; ?>.png">
			</a>
		<?php endif; ?>
		<?php if (!empty($data[0]['file3'])): ?>
			<a href="/admin/editProduct/<?php echo $data[0]['id']; ?>#_" class="lightbox" id="img1113">
				<img class="lightbox-img" src="/public/images/products/<?php echo $data[0]['file3']; ?>.png">
			</a>
		<?php endif; ?>
	</div>
</div>