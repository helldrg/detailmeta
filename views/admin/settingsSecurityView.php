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
			<span class="c-white fs-medium ff-SansNarrow">Настройки логина и пароля</span>
			<a href="/admin/starting">
				<div class="b-arrow-left"></div>
			</a>
		</div>
		<div class="d-table ff-SansNarrow">
			<form id="form" action="/admin/settingsSecurity" method="post">
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
						Введите старый логин:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="login" value="">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Введите старый пароль:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="password" name="password" value="">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Введите новый логин:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="text" name="newLogin" value="">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Введите новый пароль:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="password" name="newPass1" value="">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td fs-medium">
						Введите новый пароль еще раз:
					</span>
					<span class="d-td fs-medium" style="flex-grow: 3;">
						<input class="fs-medium"  type="password" name="newPass2" value="">
					</span>
				</div>
				<div class="d-tr">
					<span class="d-td">
						<button class="read-more  fs-medium ff-SansNarrow" type="submit">Сохранить</button>
					</span>
				</div>
			</form>
		</div>
    </div>
</div>