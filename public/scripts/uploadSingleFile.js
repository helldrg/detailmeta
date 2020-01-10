var $ = jQuery.noConflict();

$(document).ready(function() {
	var dropZone = $('.upload-container');
	var Data = new FormData();
	var count = 0;
	var maxCount = 1;
	var maxFiles = 6;
	
	
	jQuery.event.props.push('dataTransfer');
	var dataArray = [];
	// Оповещение по умолчанию
	var errMessage = 0;

	// Отменить все действия по умолчанию на события Drag-and-Drop. 
	// Например, одно из таких событий — открытие кинутого файла браузером
	dropZone.on('drag dragstart dragend dragover dragenter dragleave drop', function(){
		return false;
	});

	// Меняем стиль области при наведении
	dropZone.on('dragover dragenter', function() {
		dropZone.addClass('dragover');
	});
	
	// Возвращаем стиль
	dropZone.on('dragleave', function(e) {
		let dx = e.pageX - dropZone.offset().left;
		let dy = e.pageY - dropZone.offset().top;
		if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
			dropZone.removeClass('dragover');
		}
	});

	// Сохраняем перенесенные файлы
	dropZone.on('drop', function(e) {
		dropZone.removeClass('dragover');
		// Для функции sendFiles
		//let files = e.originalEvent.dataTransfer.files;
		//sendFiles(files);
		
		// Для функции loadInView
		let files = e.dataTransfer.files;
		loadInView(files);
	});
	
	// Сохраняем файлы, выбранные через кнопку
	$('#upload-btn').change(function() {
		let files = this.files;
		//sendFiles(files);
		
		loadInView(files);
		
		// Не потребовалось
		// Очищаем инпут файл путем сброса формы
        //$('form').each(function(){
	    //    this.reset();
	});

	// file[] - скобки обозначают, что все записывается в массив 
	// на сервере первый элемент выглядит так $_FILES['file']['tmp_name'][0]
	function sendFiles(files) {
		$(files).each(function(index, file) {
			Data.append('file[]', file);
		});
	}
	
	// Функция загрузки изображений на предросмотр
	function loadInView(files) {
		// Показываем обасть предпросмотра
		$('.uploaded-holder').show();
		
		// Для каждого файла
		$.each(files, function(index, file) {
						
			// Несколько оповещений при попытке загрузить не изображение
			if (!files[index].type.match('image/png')) {
				
				if(errMessage == 0) {
					$('.upload-container span').html('Ошибка!');
					++errMessage
				} else {
					$('.upload-container span').html('Снова ошибка!');
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
						dataArray.push({name : file.name, value : this.result, file:file });
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
			start = ind; end = ind+1; 
		} 
		// Оповещения о загруженных файлах
		if(dataArray.length == 0) {
			$('.uploaded-holder').hide();
		}
		// Цикл для каждого элемента массива
		for (i = start; i < end; i++) {
			// размещаем загруженные изображения
			if($('.dropped-container > .image').length <= maxFiles) { 
				$('.dropped-container').append('<div class="image container-drop-img" id="drop"><a href="#img'+i+'"><img class="d-table-img" src="'+dataArray[i].value+'"></a><a href="#" id="drop-'+i+'"><div class="b-cross"></div></a></div>'); 
				$('.dropped-lightbox').append('<div class="drop-lightbox"><a href="#_" class="lightbox" id="img'+i+'"><img class="lightbox-img" src="'+dataArray[i].value+'"></a></div>');
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
		$('.dropped-container > .image').remove();
		$('.dropped-lightbox > .drop-lightbox').remove();
		// Обновляем эскизи в соответсвии с обновленным массивом
		addImage(-1);		
	});
	
	function sendFilesFromFileReader() {
		// $(dataArray).each(function(index, file) {
			// Data.append('file[]', file);
		// });
		for (var i = 0; i < dataArray.length; i++) {
			Data.append('file[]', dataArray[i].file);
		}
	}
	
	$('#btn-form').click(function(event) { 
		sendFilesFromFileReader();
		
		maxCount = $('#upload-btn').attr('data-count');

		// Блок для проверки содержимого dataForm
		// Data.forEach((value,key) => {
			// alert(key+" "+value.name)
		// });
		
		//alert(dataArray.length)
		if(dataArray.length > maxCount) {
			alert('Ошибка! Выбрано '+ dataArray.length +' файлов. Необходимо '+ maxCount);
			
			for (var key of Data.keys()) {
				Data.delete(key)
			};
			
			return false;
		}
		
		if(!$("*").is("input[name='title']"))
		{
			if(dataArray.length == 0) {
				alert('Ошибка! Файл не выбран');
				
				return false;
			}
		}
		else
		{
			Data.append('title', $("input[name='title']").val());
		}
		
		// Передаем кол-во изображений 
		Data.append('count', dataArray.length);

		
		
		// Проверка реализована на сервере
		//if(!Data.has('file')) {
		//	alert('Ошибка! Файл не выбран');
		//	return false;
		//} 
		
		let json;
		event.preventDefault();
		$.ajax({
			url: $('form').attr('action'),
			type: $('form').attr('method'),
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
			}
		});
		
		for (var key of Data.keys()) {
			Data.delete(key)
		};
	});

	
	$('.img-banner').on('click', function (e) {
		e.preventDefault();
		$('.lightbox').attr('id', $(this).attr('href').replace('#', ''));
	});
});