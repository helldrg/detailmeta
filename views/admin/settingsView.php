<script>
	$(document).ready(function() {
		$('form').submit(function(event) {
			var json;
			event.preventDefault();
			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: new FormData(this),
				contentType: false,
				cache: false,
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
				}
			});
		});
	});
</script>
<div class="container">
    <div class="panel settings-panel">
		<div class="title-panel">
			<span class="c-white fs-medium ff-SansNarrow">Настройки</span>
			<a href="/admin/starting">
				<div class="b-arrow-left"></div>
			</a>
		</div>
		<div class="d-table ff-SansNarrow">
			<form id="form" action="/admin/settings" method="post">
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
						Адрес сайта http://
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="domen" value="<?php echo $vars['domen']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Адрес группы вк http://
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="vkGroup" value="<?php echo $vars['vkGroup']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Название организации:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="orgName" value="<?php echo htmlspecialchars($vars['orgName']); ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Основной номер телефона:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="mainNumPhone" value="<?php echo $vars['mainNumPhone']; ?>">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td">
						<button class="read-more fs-medium ff-SansNarrow" type="submit">Сохранить</button>
					</span>
				</div>
			</form>
		</div>
    </div>
</div>