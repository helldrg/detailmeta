<script src="/public/scripts/uploadSingleFile.js"></script>
<div class="container">
    <div class="panel settings-panel">
		<div class="title-panel">
			<span class="c-white fs-medium ff-SansNarrow">Добавление баннера</span>
			<a href="/admin/viewBanners">
				<div class="b-arrow-left"></div>
			</a>
		</div>
		<div class="d-table ff-SansNarrow">
			<form action="/admin/addBanner" method="post" enctype="multipart/form-data">
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
							<!--<a href="#img1">
								<img class="d-table-img" src="/public/images/banners/74.jpg">
							</a>-->
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
<div class="dropped-lightbox"></div>