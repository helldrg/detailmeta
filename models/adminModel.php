<?php

namespace models;

use core\Model;
use Imagick;

class AdminModel extends Model
{
	public $error;

	public function loginValidate($post, $path, $keys) 
	{
		$vars = $this->settingsRead($path, $keys);
		
		if ($vars['login'] != $post['login'] or $vars['password'] != $post['password']) 
		{
			$this->error = 'Логин или пароль указан неверно';
			return false;
		}
		return true;
	}

	public function bannerValidate($post) 
	{
		if($post['count'] > 1)
		{
			$this->error = 'Выбрано '.$post['count'].' файлa(ов). Необходимо выбрать 1 изображение.';
			return false;
		}
		
		//$this->error = debug($_FILES['file']['tmp_name'][0]);
		
		if (!empty($_FILES['file']['tmp_name'][0]))
		{
			//Array
			//(
			//	[name]     => picture.jpg                // оригинальное имя файла
			//	[type]     => image/jpeg                 // MIME-тип файла
			//	[tmp_name] => home\user\temp\phpD07E.tmp // бинарный файл
			//	[error]    => 0                          // код ошибки
			//	[size]     => 17170                      // размер файла в байтах
			//)
			
			// Перезапишем переменные для удобства
			$filePath  = $_FILES['file']['tmp_name'][0];
			$errorCode = $_FILES['file']['error'][0];
			
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) 
			{
	
				// Массив с названиями ошибок
				$errorMessages = array(
					UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
				);
			
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
			
				// Выведем название ошибки
				$this->error = $outputMessage;
				return false;
			}
		}
		else
		{
			$this->error = 'Изображение не выбрано';
			return false;
		}
		
		return true;
	}
	
	public function isBannerExists($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->column('SELECT id FROM banners WHERE id = :id', $params);
	}
	
	public function bannerUploadImage($path, $fileName) 
	{
		// Переместим картинку с новым именем в папку
		if (!move_uploaded_file($path, 'public/images/banners/'.$fileName.'.png'))
		{
			$this->error = 'При записи изображения на диск произошла ошибка.';
			return false;
		}
	}
	
	public function bannerAdd($fileName) 
	{
		$params = array(
			'file' => $fileName,
		);
		$this->db->query('INSERT INTO banners VALUES (NULL, :file)', $params);
		return $this->db->lastInsertId();
	}
	
	public function bannerEdit($id, $fileName) 
	{
		$vars = array(
			'data' => $this->bannerData($id),
		);
		
		if(!empty($vars['data'][0]['file']))
		{
			$path = 'public/images/banners/'.$vars['data'][0]['file'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		$params = array(
			'id' => $id,
			'file' => $fileName,
		);
		$this->db->query('UPDATE banners SET file = :file WHERE id = :id', $params);
	}
	
	public function bannerDelete($id) 
	{
		$vars = array(
			'data' => $this->bannerData($id),
		);
		
		if(!empty($vars['data'][0]['file']))
		{
			$path = 'public/images/banners/'.$vars['data'][0]['file'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		$params = array(
			'id' => $id,
		);
		$this->db->query('DELETE FROM banners WHERE id = :id', $params);
	}

	
	public function bannerData($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->row('SELECT * FROM banners WHERE id = :id', $params);
	}
	
	public function catalogValidateAdd($post) 
	{
		if($post['count'] > 1)
		{
			$this->error = 'Выбрано '.$post['count'].' файлa(ов). Необходимо выбрать 1 изображение.';
			return false;
		}
		
		//$this->error = debug($_FILES['file']['tmp_name'][0]);
		
		if (!empty($_FILES['file']['tmp_name'][0]))
		{
			//Array
			//(
			//	[name]     => picture.jpg                // оригинальное имя файла
			//	[type]     => image/jpeg                 // MIME-тип файла
			//	[tmp_name] => home\user\temp\phpD07E.tmp // бинарный файл
			//	[error]    => 0                          // код ошибки
			//	[size]     => 17170                      // размер файла в байтах
			//)
			
			// Перезапишем переменные для удобства
			$filePath  = $_FILES['file']['tmp_name'][0];
			$errorCode = $_FILES['file']['error'][0];
			
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) 
			{
	
				// Массив с названиями ошибок
				$errorMessages = array(
					UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
				);
			
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
			
				// Выведем название ошибки
				$this->error = $outputMessage;
				return false;
			}
		}
		else
		{
			$this->error = 'Изображение не выбрано';
			return false;
		}
		
		$titleLen = iconv_strlen($post['title']);

		if ($titleLen < 1 or $titleLen > 80) 
		{
			$this->error = 'Название должно содержать от 1 до 80 символов';
			return false;
		} 
		
		return true;
	}
	
	public function catalogValidateEdit($post) 
	{		
		//$this->error = debug($_FILES['file']['tmp_name'][0]);
		
		if (!empty($_FILES['file']['tmp_name'][0]))
		{
			//Array
			//(
			//	[name]     => picture.jpg                // оригинальное имя файла
			//	[type]     => image/jpeg                 // MIME-тип файла
			//	[tmp_name] => home\user\temp\phpD07E.tmp // бинарный файл
			//	[error]    => 0                          // код ошибки
			//	[size]     => 17170                      // размер файла в байтах
			//)
			
			// Перезапишем переменные для удобства
			$filePath  = $_FILES['file']['tmp_name'][0];
			$errorCode = $_FILES['file']['error'][0];
			
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) 
			{
	
				// Массив с названиями ошибок
				$errorMessages = array(
					UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
				);
			
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
			
				// Выведем название ошибки
				$this->error = $outputMessage;
				return false;
			}
		}
		
		$titleLen = iconv_strlen($post['title']);

		if ($titleLen < 1 or $titleLen > 80) 
		{
			$this->error = 'Название должно содержать от 1 до 80 символов';
			return false;
		} 
		
		return true;
	}
	
	public function isCatalogExists($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->column('SELECT id FROM catalogs WHERE id = :id', $params);
	}
	
	public function catalogUploadImage($path, $fileName) 
	{
		// Переместим картинку с новым именем в папку
		if (!move_uploaded_file($path, 'public/images/catalogs/'.$fileName.'.png'))
		{
			$this->error = 'При записи изображения на диск произошла ошибка.';
			return false;
		}
	}
	
	public function catalogAdd($fileName, $post) 
	{
		$params = array(
			'title' => $post['title'],
			'file' => $fileName,
		);
		$this->db->query('INSERT INTO catalogs VALUES (NULL, :title, :file)', $params);
		return $this->db->lastInsertId();
	}
	
	public function catalogEditImage($id, $fileName) 
	{
		$vars = array(
			'data' => $this->catalogData($id),
		);
		
		if(!empty($vars['data'][0]['file']))
		{
			$path = 'public/images/catalogs/'.$vars['data'][0]['file'].'.png';
			
			if(file_exists($path))
				unlink($path);
		}
		
		$params = array(
			'id' => $id,
			'file' => $fileName,
		);
		$this->db->query('UPDATE catalogs SET file = :file WHERE id = :id', $params);
	}
	
	public function catalogEditText($id, $post) 
	{
		$vars = array(
			'data' => $this->catalogData($id),
		);
		
		$params = array(
			'id' => $id,
			'title' => $post['title'],
		);
		$this->db->query('UPDATE catalogs SET title = :title WHERE id = :id', $params);
	}
	
	public function catalogDelete($id) 
	{
		$vars = array(
			'data' => $this->catalogData($id),
		);
		
		if(!empty($vars['data'][0]['file']))
		{
			$path = 'public/images/catalogs/'.$vars['data'][0]['file'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		$params = array(
			'id' => $id,
		);
		$this->db->query('DELETE FROM catalogs WHERE id = :id', $params);
	}

	
	public function catalogData($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->row('SELECT * FROM catalogs WHERE id = :id', $params);
	}
	
	
	
	public function productValidateAdd($post) 
	{
		//$this->error = debug($_FILES['file']['tmp_name'][0]);
		
		if (!empty($_FILES['file']['tmp_name'][0]))
		{
			//Array
			//(
			//	[name]     => picture.jpg                // оригинальное имя файла
			//	[type]     => image/jpeg                 // MIME-тип файла
			//	[tmp_name] => home\user\temp\phpD07E.tmp // бинарный файл
			//	[error]    => 0                          // код ошибки
			//	[size]     => 17170                      // размер файла в байтах
			//)
			
			// Перезапишем переменные для удобства
			$filePath  = $_FILES['file']['tmp_name'][0];
			$errorCode = $_FILES['file']['error'][0];
			
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) 
			{
	
				// Массив с названиями ошибок
				$errorMessages = array(
					UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
				);
			
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
			
				// Выведем название ошибки
				$this->error = $outputMessage;
				return false;
			}
		}

		$titleLen = iconv_strlen($post['title']);
		if ($titleLen < 1 or $titleLen > 80) 
		{
			$this->error = 'Наименование изделия должно содержать от 1 до 80 символов';
			return false;
		} 
		
		$idCatalogLen = iconv_strlen($post['idCatalog']);
		if ($idCatalogLen < 1) 
		{
			$this->error = 'Должен быть выбран каталог';
			return false;
		} 
		
		$priceLen = iconv_strlen($post['price']);
		if ($priceLen < 1 or $priceLen > 20) 
		{
			$this->error = 'Цена изделия должно содержать от 1 до 20 символов';
			return false;
		} 
		
		$materialsLen = iconv_strlen($post['materials']);
		if ($materialsLen < 3 or $materialsLen > 80) 
		{
			$this->error = 'Материалы изделия должны содержать от 3 до 80 символов';
			return false;
		} 
		
		$specificationsLen = iconv_strlen($post['specifications']);
		if ($specificationsLen < 3 or $specificationsLen > 80) 
		{
			$this->error = 'Тех. харак. должны содержать от 3 до 80 символов';
			return false;
		} 
		
		$deliveryLen = iconv_strlen($post['delivery']);
		if ($deliveryLen < 3 or $deliveryLen > 80) 
		{
			$this->error = 'Доставка должна содержать от 3 до 80 символов';
			return false;
		} 
		
		$amountLen = iconv_strlen($post['amount']);
		if ($amountLen < 1 or $amountLen > 80) 
		{
			$this->error = 'Оптовые поставки должны содержать от 1 до 80 символов';
			return false;
		} 
		
		return true;
	}
	
	
	public function productValidateEdit($post) 
	{
		//$this->error = debug($_FILES['file']['tmp_name'][0]);
		
		if (!empty($_FILES['file']['tmp_name'][0]))
		{
			//Array
			//(
			//	[name]     => picture.jpg                // оригинальное имя файла
			//	[type]     => image/jpeg                 // MIME-тип файла
			//	[tmp_name] => home\user\temp\phpD07E.tmp // бинарный файл
			//	[error]    => 0                          // код ошибки
			//	[size]     => 17170                      // размер файла в байтах
			//)
			
			// Перезапишем переменные для удобства
			$filePath  = $_FILES['file']['tmp_name'][0];
			$errorCode = $_FILES['file']['error'][0];
			
			// Проверим на ошибки
			if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) 
			{
	
				// Массив с названиями ошибок
				$errorMessages = array(
					UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
					UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
					UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
					UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
					UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
					UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
					UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
				);
			
				// Зададим неизвестную ошибку
				$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
			
				// Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
				$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
			
				// Выведем название ошибки
				$this->error = $outputMessage;
				return false;
			}
		}

		$titleLen = iconv_strlen($post['title']);
		if ($titleLen < 1 or $titleLen > 80) 
		{
			$this->error = 'Наименование изделия должно содержать от 1 до 80 символов';
			return false;
		} 

		$idCatalogLen = iconv_strlen($post['idCatalog']);
		if ($idCatalogLen < 1) 
		{
			$this->error = 'Должен быть выбран каталог';
			return false;
		} 
		
		$priceLen = iconv_strlen($post['price']);
		if ($priceLen < 1 or $priceLen > 20) 
		{
			$this->error = 'Цена изделия должно содержать от 1 до 20 символов';
			return false;
		} 
		
		$materialsLen = iconv_strlen($post['materials']);
		if ($materialsLen < 3 or $materialsLen > 80) 
		{
			$this->error = 'Материалы изделия должны содержать от 3 до 80 символов';
			return false;
		} 
		
		$specificationsLen = iconv_strlen($post['specifications']);
		if ($specificationsLen < 3 or $specificationsLen > 80) 
		{
			$this->error = 'Тех. харак. должны содержать от 3 до 80 символов';
			return false;
		} 
		
		$deliveryLen = iconv_strlen($post['delivery']);
		if ($deliveryLen < 3 or $deliveryLen > 80) 
		{
			$this->error = 'Доставка должна содержать от 3 до 80 символов';
			return false;
		} 
		
		$amountLen = iconv_strlen($post['amount']);
		if ($amountLen < 1 or $amountLen > 80) 
		{
			$this->error = 'Оптовые поставки должны содержать от 1 до 80 символов';
			return false;
		} 
		
		return true;
	}

	public function isProductExists($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->column('SELECT id FROM products WHERE id = :id', $params);
	}
	
	public function productUploadImage($path, $fileName) 
	{
		// Переместим картинку с новым именем в папку
		if (!move_uploaded_file($path, 'public/images/products/'.$fileName.'.png'))
		{
			$this->error = 'При записи изображения на диск произошла ошибка.';
			return false;
		}
	}
	
	public function productAdd($post, $fileName) 
	{
		$emptyName = '';
		if(empty($fileName[1]))
		{
			$fileName[1] = $emptyName;
		}
		if(empty($fileName[2]))
		{
			$fileName[2] = $emptyName;
		}
		
		$params = array(
			'idCatalog' => $post['idCatalog'],
			'title' => $post['title'],
			'price' => $post['price'],
			'materials' => $post['materials'],
			'specifications' => $post['specifications'],
			'delivery' => $post['delivery'],
			'amount' => $post['amount'],
			'file1' => $fileName[0],
			'file2' => $fileName[1],
			'file3' => $fileName[2],
		);
		$this->db->query('INSERT INTO products VALUES (NULL, :idCatalog, :title, :price, :materials, :specifications, :delivery, :amount, :file1, :file2, :file3)', $params);
		return $this->db->lastInsertId();
	}
	
	public function productEditImage($id, $fileName, $pos) 
	{
		$vars = array(
			'data' => $this->productData($id),
		);

		if(!empty($vars['data'][0]['file'.$pos]))
		{
			$path = 'public/images/products/'.$vars['data'][0]['file'.$pos].'.png';
			
			if(file_exists($path))
				unlink($path);
		}
		
		$params = array(
			'id' => $id,
			'file' => $fileName,
		);
		$this->db->query('UPDATE products SET file'.$pos.' = :file WHERE id = :id', $params);
	}
	
	public function productEditText($id, $post) 
	{
		$vars = array(
			'data' => $this->productData($id),
		);
		
		$params = array(
			'id' => $id,
			'title' => $post['title'],
			'idCatalog' => $post['idCatalog'],
			'price' => $post['price'],
			'materials' => $post['materials'],
			'specifications' => $post['specifications'],
			'delivery' => $post['delivery'],
			'amount' => $post['amount'],
		);
		$this->db->query('UPDATE products SET title = :title, idCatalog = :idCatalog, price = :price, materials = :materials, specifications = :specifications, delivery = :delivery, amount = :amount WHERE id = :id', $params);
	}
	
	public function productDelete($id) 
	{
		$vars = array(
			'data' => $this->productData($id),
		);
		
		if(!empty($vars['data'][0]['file1']))
		{
			$path = 'public/images/products/'.$vars['data'][0]['file1'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		if(!empty($vars['data'][0]['file2']))
		{
			$path = 'public/images/products/'.$vars['data'][0]['file2'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		if(!empty($vars['data'][0]['file3']))
		{
			$path = 'public/images/products/'.$vars['data'][0]['file3'].'.png';
		
			if(file_exists($path))
				unlink($path);
		}
		
		$params = array(
			'id' => $id,
		);
		$this->db->query('DELETE FROM products WHERE id = :id', $params);
	}

	public function productData($id) 
	{
		$params = array(
			'id' => $id,
		);
		return $this->db->row('SELECT * FROM products WHERE id = :id', $params);
	}
	
	public function settingsEdit($post, $path, $keys) 
	{
		$handle=fopen($path,"w");
		
		foreach ($keys as $value) {
			$buffer = $value."= '".str_replace("'", '', $post[$value])."';";
			fwrite($handle, $buffer."\r\n");
		}

		fclose($handle);
	}
	
	public function settingsRead($path, $keys) 
	{
		$buffer = array();
		$handle=fopen($path,"r");
		
		$i = 0;
		while (!feof($handle)) 
		{
			$buffer[$i++] = explode("'", fgets($handle, 1024));//preg_match('/".*"/', $buffer[$i], $matches);
		}
		fclose($handle);
		
		$vars = array();

		$i = 0;
		foreach ($keys as $value) {
			 $vars[$value] = $buffer[$i++][1];
		}
		
		return $vars;
	}
	
	public function settingsSecurityValidate($post, $path, $keys) 
	{
		$vars = $this->settingsRead($path, $keys);
		
		if ($post['newPass1'] != $post['newPass2']) 
		{
			$this->error = 'Пароли не совпадают';
			return false;
		}
		return true;
	}
}

?>