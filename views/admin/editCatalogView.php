<script src="/public/scripts/uploadSingleFile.js"></script>
<div class="container">
    <div class="panel settings-panel">
		<div class="title-panel">
			<span class="c-white fs-medium ff-SansNarrow">Редактирование каталога</span>
			<a href="/admin/viewCatalogs">
				<div class="b-arrow-left"></div>
			</a>
		</div>
		<div class="d-table ff-SansNarrow">
			<form action="/admin/editCatalog/<?php echo $data[0]['id']; ?>" method="post" enctype="multipart/form-data">
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
						Название каталога:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="title" value="<?php echo $data[0]['title']; ?>">
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
								<a href="#img<?php echo $data[0]['id']; ?>">
									<img class="d-table-img" src="/public/images/catalogs/<?php echo $data[0]['file']; ?>.png" style="opacity:.3;">
								</a>
							</div>
						</div>
					</span>
					<span class="d-td">
					<div>
						<div class="upload-container">
							<img class="upload-container-img" src="/public/images/upload-icon.png">
							<input id="upload-btn" type="file" name="file" data-count="1" multiple>
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
		<a href="/admin/editCatalog/<?php echo $data[0]['id']; ?>#_" class="lightbox" id="img<?php echo $data[0]['id']; ?>">
			<img class="lightbox-img" src="/public/images/catalogs/<?php echo $data[0]['file']; ?>.png">
		</a>
	</div>
</div>