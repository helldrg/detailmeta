<?php

namespace controllers;

use core\Controller;
use lib\Pagination;
use models\AdminModel;

class MainController extends Controller
{
	public function indexAction()
	{
		$count = 10;
		$total = $this->model->bannersCount();
	
		if (array_key_exists("id", $_POST)) 
		{
			$start = (int)$_POST['id'];
		}
		else
		{
			$start = 0;
		}
		
		if($total-$count > $start)
		{
			$visibleButtonLoad = true;
		}
		else
		{
			$visibleButtonLoad = false;
		}
		
		$vars = array(
			'total' => $total,
			'count' => ($total > $count) ? $count : $total,
			'load' => $visibleButtonLoad,
			'list' => $this->model->bannersList($start, $count),
		);

		if (array_key_exists("action", $_POST)) 
		{
			if($total > $start)
			{
				$this->view->renderBannersMainAjax($vars);
			}
		}
		else
		{
			$this->view->render('Главная страница', $vars);
		}
	}
	
	public function aboutAction()
	{
		$adminMod = new AdminModel;
		
		$path = "config/settingsAboutConfig.ini";
		$keys = array("description");
		$vars = $adminMod->settingsRead($path, $keys);
		
		$this->view->render('О нас', $vars);
	}
	
	public function contactAction()
	{
		$adminMod = new AdminModel;
		
		$path = "config/settingsContactConfig.ini";
		$keys = array("numPhone", "email", "operatingMode", "address", "getThere");
		$vars = $adminMod->settingsRead($path, $keys);
		
		$this->view->render('Контакты', $vars);
	}
	
	public function downloadsAction()
	{
		if ($this->route['id'] == 1) 
		{
			$file = 'public/downloads/Prays_list.xlsx';
			
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
				ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			readfile($file);
			exit;
		}
		if ($this->route['id'] == 2) 
		{
			$file = 'public/downloads/Blank_zakaza.doc';
			
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
				ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			readfile($file);
			exit;
		}				
	}
	
	public function feedbackAction()
	{
		$adminMod = new AdminModel;
		
		$path = "config/settingsContactConfig.ini";
		$keys = array("numPhone", "email", "operatingMode", "address", "getThere");
		$vars = $adminMod->settingsRead($path, $keys);
		
		if (!empty($_POST)) 
		{
			if (!$this->model->contactValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			mail($vars['email'], 'Сообщение с сайта от '.$_POST['name'], 'Номер телефона: '.$_POST['numPhone'].'         Электранная почта: '.$_POST['email'].'        Текст сообщения: '.$_POST['text']);
			$this->view->message('success', 'Сообщение отправлено Администратору');
		}
		$this->view->render('Обратная связь', $vars);
	}
	
	public function searchAction()
	{
		$adminMod = new AdminModel;
		if (array_key_exists("id", $_POST)) 
		{
			$start = (int)$_POST['id']; 
		}
		else
		{
			$start = 0;
		}
		// при подгрузке изделий
		if (array_key_exists("text", $_POST))
		{
			$text = $this->model->testInput($_POST['text']);
			$count = 10;
			$total = $this->model->searchCount($text);
			
			if($total-$count > $start)
			{
				$visibleButtonLoad = true;
			}
			else
			{
				$visibleButtonLoad = false;
			}

			$vars = array(
				'total' => $total,
				'count' => ($total > $count) ? $count : $total,
				'load' => $visibleButtonLoad,
				'text' => $text,
				'list' => $this->model->searchProducts($start, $count, $text),
			);
			
			
			
			if($total > $start)
			{
				$this->view->renderSearchMainAjax($vars);
			}
		}
		else
		{	
			// начальная страница изделий
			if (array_key_exists("text", $this->route)) 
			{
				$text = $this->model->testInput(urldecode($this->route['text']));
				
				$pattern_name = '/^[a-zA-Zа-яА-ЯЁё0-9\_\-\s\.\,]{1,}$/u';
				if(!preg_match($pattern_name, $text)) {
					$text = "Ошибка ввода. Некорректные символы!!!!!!!!!!!!!!!!!!!";
				}

				$count = 10;

				$total = $this->model->searchCount($text);

				if($total-$count > $start)
				{
					$visibleButtonLoad = true;
				}
				else
				{
					$visibleButtonLoad = false;
				}
				
				$vars = array(
					'total' => $total,
					'count' => ($total > $count) ? $count : $total,
					'load' => $visibleButtonLoad,
					'text' => $text,
					'list' => $this->model->searchProducts($start, $count, $text),
				);
				
				$this->view->render('Поиск '.$text, $vars);
			}
		}		
	}
	
	public function productAction()
	{
		$adminMod = new AdminModel;
		if (!$adminMod->isProductExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		$vars = array(
			'catalog' => $this->model->getCatalogByProduct($this->route['id']),
			'data' => $adminMod->productData($this->route['id'])
		);
		$this->view->render('Изделия', $vars);
	}
	
	public function catalogAction()
	{
		if (array_key_exists("id", $_POST)) 
		{
			$start = (int)$_POST['id'];
		}
		else
		{
			$start = 0;
		}
		// при подгрузке изделий
		if (array_key_exists("idCatalog", $_POST))
		{
			$idCatalog = (int)$_POST['idCatalog'];
			
			$count = 10;
			$total = $this->model->productsCount($idCatalog);
			
			if($total-$count > $start)
			{
				$visibleButtonLoad = true;
			}
			else
			{
				$visibleButtonLoad = false;
			}

			$vars = array(
				'total' => $total,
				'count' => ($total > $count) ? $count : $total,
				'catalog' => $this->model->getCatalogById($idCatalog),
				'load' => $visibleButtonLoad,
				'list' => $this->model->productsList($start, $count, $idCatalog),
			);
			
			if($total > $start)
			{
				$this->view->renderProductsMainAjax($vars);
			}
		}
		else
		{	
			// начальная страница изделий
			if (array_key_exists("id", $this->route)) 
			{
				$idCatalog = $this->route['id'];
				
				$count = 10;
				$total = $this->model->productsCount($idCatalog);
				
				if($total-$count > $start)
				{
					$visibleButtonLoad = true;
				}
				else
				{
					$visibleButtonLoad = false;
				}

				$vars = array(
					'total' => $total,
					'count' => ($total > $count) ? $count : $total,
					'catalog' => $this->model->getCatalogById($idCatalog),
					'load' => $visibleButtonLoad,
					'list' => $this->model->productsList($start, $count, $idCatalog),
				);
				
				$this->view->renderProductsList('Изделия', $vars);
			}
			else
			{	
				$count = 12;
				$total = $this->model->catalogsCount();
				
				if($total-$count > $start)
				{
					$visibleButtonLoad = true;
				}
				else
				{
					$visibleButtonLoad = false;
				}
				
				$vars = array(
					'total' => $total,
					'count' => ($total > $count) ? $count : $total,
					'load' => $visibleButtonLoad,
					'list' => $this->model->catalogsList($start, $count),
				);
				
				if (array_key_exists("action", $_POST)) 
				{
					if($total > $start)
					{
						$this->view->renderCatalogsMainAjax($vars);
					}
				}
				else
				{
					$this->view->render('Каталоги', $vars);
				}
			}
		}
	}
}