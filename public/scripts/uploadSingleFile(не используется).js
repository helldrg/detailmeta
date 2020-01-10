var $ = jQuery.noConflict();

$(document).ready(function() {
	// В dataTransfer помещаются изображения которые перетащили в область div
	jQuery.event.props.push('dataTransfer');
	// Максимальное количество загружаемых изображений за одни раз
	var maxFiles = 1;

	// Оповещение по умолчанию
	var errMessage = 0;
	
	// Кнопка выбора файлов
	var defaultUploadBtn = $('.upload-btn');
	
	// Массив для всех изображений
	var dataArray = [];
	// Метод при падении файла в зону загрузки
	$('.upload-container').on('drop', function(e) {	
		// Передаем в files все полученные изображения
		var files = e.dataTransfer.files;
		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
		} else {
			alert('Вы не можете загружать изображения больше '+maxFiles+'!'); 
			files.length = 0; return;
		}
	});
	
	// При нажатии на кнопку выбора файлов
	defaultUploadBtn.on('change', function() {
   		// Заполняем массив выбранными изображениями
   		var files = $(this)[0].files;
   		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
			// Очищаем инпут файл путем сброса формы
            $('.upload-form').each(function(){
	        	    this.reset();
			});
		} else {
			alert('Вы не можете загружать изображения больше '+maxFiles+'!'); 
			files.length = 0;
		}
	});
	
	// Функция загрузки изображений на предросмотр
	function loadInView(files) {
		// Показываем обасть предпросмотра
		$('.uploaded-holder').show();
		
		// Для каждого файла
		$.each(files, function(index, file) {
						
			// Несколько оповещений при попытке загрузить не изображение
			if (!files[index].type.match('image.*')) {
				
				if(errMessage == 0) {
					$('.upload-container span').html('Ошибка!');
					++errMessage
				}
				return false;
			}
			else {
				$('.upload-container span').html("или перетащите");
			}
			
			// Проверяем количество загружаемых элементов
			if((dataArray.length+files.length) > maxFiles) {
				alert('Вы не можете загружать изображения больше '+maxFiles+'!'); return; 
			}
			
			// Создаем новый экземпляра FileReader
			var fileReader = new FileReader();
				// Инициируем функцию FileReader
				fileReader.onload = (function(file) {
					
					return function(e) {
						// Помещаем URI изображения в массив
						dataArray.push({name : file.name, value : this.result});
						addImage((dataArray.length-1));
					}; 
						
				})(files[index]);
			// Производим чтение картинки по URI
			fileReader.readAsDataURL(file);
		});
		return false;
	}
		
	// Процедура добавления эскизов на страницу
	function addImage(ind) {
		// Если индекс отрицательный значит выводим весь массив изображений
		if (ind < 0 ) { 
		start = 0; end = dataArray.length; 
		} else {
		// иначе только определенное изображение 
		start = ind; end = ind+1; } 
		// Оповещения о загруженных файлах
		if(dataArray.length == 0) {
			$('.uploaded-holder').hide();
		}
		// Цикл для каждого элемента массива
		for (i = start; i < end; i++) {
			// размещаем загруженные изображения
			if($('.dropped-container > .image').length <= maxFiles) { 
				$('.dropped-container').append('<a href="#img'+i+'" class="img-banner"><img class="d-table-img" src="'+dataArray[i].value+'"></a><a href="/admin/addBanner/#_" class="lightbox" id="img'+i+'"><img class="lightbox-img" src="'+dataArray[i].value+'"></a>'); 
			}
		}
		return false;
	}

	
	// Удаление только выбранного изображения 
	$(".dropped-container").on("click","a[id^='drop']", function() {
		// получаем название id
 		var elid = $(this).attr('id');
		// создаем массив для разделенных строк
		var temp = new Array();
		// делим строку id на 2 части
		temp = elid.split('-');
		// получаем значение после тире тоесть индекс изображения в массиве
		dataArray.splice(temp[1],1);
		// Удаляем старые эскизы
		$('.dropped-files > .image').remove();
		// Обновляем эскизи в соответсвии с обновленным массивом
		addImage(-1);		
	});
	
	
	$('.upload-container').on('drop', function() {
		$(this).css({'box-shadow' : 'none', 'border' : '2px dashed rgba(0,0,0,0.2)'});
		return false;
	});
	
	// next script
	
	var dropZone = $('.upload-container');

	$('.upload-btn').focus(function() {
		$('label').addClass('focus');
	})
	.focusout(function() {
		$('label').removeClass('focus');
	});


	dropZone.on('drag dragstart dragend dragover dragenter dragleave drop', function(){
		return false;
	});

	dropZone.on('dragover dragenter', function() {
		dropZone.addClass('dragover');
	});

	dropZone.on('dragleave', function(e) {
		let dx = e.pageX - dropZone.offset().left;
		let dy = e.pageY - dropZone.offset().top;
		if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
			dropZone.removeClass('dragover');
		}
	});

	dropZone.on('drop', function(e) {
		dropZone.removeClass('dragover');
		let files = e.originalEvent.dataTransfer.files;
		console.log('Start');
		console.log(files);
		sendFiles(files);
	});

	$('.upload-btn').change(function() {
		let files = this.files;
		console.log('Start2');
		console.log(files);
		sendFiles(files);
	});
	
	// $('form').submit(function(event) {
		// var json;
		// var Data = new FormData(this);
		// Data.append('images[]', file);
		// event.preventDefault();
		// $.ajax({
			// type: $(this).attr('method'),
			// url: $(this).attr('action'),
			// data: Data,
			// contentType: false,
			// cache: false,
			// processData: false,
			// success: function(result) {
				// json = jQuery.parseJSON(result);
				// if (json.url) {
					// window.location.href = '/' + json.url;
				// } else {
					// alert(json.status + ' - ' + json.message);
				// }
			// },
			// //error: function(jqXHR, textStatus, errorThrown)
			// //{
			// // Handle errors here
			// //alert('ERRORS: ' + textStatus);
			// //},
		// });
	// }
	
	function sendFiles(files) {
		var json;
		let Data = new FormData();
		Data.append('text', 'fdgd');
		$(files).each(function(index, file) {
			Data.append('file', file);
		});

		$.ajax({
			url: '/admin/addBanner',
			type: 'post',
			data: Data,
			contentType: false,
			processData: false,
			success: function(result) {
				json = jQuery.parseJSON(result);
				 if (json.url) {
					 window.location.href = '/' + json.url;
				 } else {
					 alert(json.status + ' - ' + json.message);
				 }
			}
		});
	}
	
	$('form').submit(function(event) {
	}
	
	$('.img-banner').on('click', function (e) {
		e.preventDefault();
		$('.lightbox').attr('id', $(this).attr('href').replace('#', ''));
	});
});