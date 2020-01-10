<?php

namespace controllers;

use core\Controller;
use lib\Pagination;
use models\MainModel;

class AdminController extends Controller
{
	public function __construct($route) 
	{
		parent::__construct($route);
		$this->view->layout = 'admin';
	}
	
	public function loginAction()
	{
		if (isset($_SESSION['admin'])) 
		{
			$this->view->redirect('admin/starting');
		}
		if (!empty($_POST)) 
		{
			$path = "config/settingsSecurityConfig.ini";
			$keys = array("login", "password");
			
			if (!$this->model->loginValidate($_POST, $path, $keys)) 
			{
				$this->view->message('error', $this->model->error);
			}
			$_SESSION['admin'] = true;
			$this->view->location('admin/starting');
		}
		
		$this->view->render('Вход');
	}
	
	public function logoutAction()
	{
		unset($_SESSION['admin']);
		$this->view->redirect('admin/login');
	}
	
	public function adminAction()
	{
		$this->view->redirect('admin/starting');
	}
	
	public function startingAction()
	{
		if (!empty($_POST)) 
		{
			if (!$this->model->productValidate($_POST, 'add')) 
			{
				$this->view->message('error', $this->model->error);
			}
			
			$id = $this->model->productAdd($_POST);
			if (!$id) 
			{
				$this->view->message('error', 'Ошибка обработки запроса');
			}
			$this->model->productUploadImage($_FILES['img']['tmp_name'], $id);
			$this->view->message('success', 'Товар добавлен');
		}
		
		$this->view->render('Стартовая страница');
	}
	
	public function viewBannersAction() 
	{
		$mainMod = new MainModel;
		$count = 10;
		$total = $mainMod->bannersCount();
	
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
			'list' => $mainMod->bannersList($start, $count),
		);

		if (array_key_exists("action", $_POST)) 
		{
			if($total > $start)
			{
				$this->view->renderBannersAdminAjax($vars);
			}
		}
		else
		{
			$this->view->render('Баннеры', $vars);
		}
	}
	
	public function addBannerAction() 
	{
		if (!empty($_POST) or !empty($_FILES)) 
		{
			if (!$this->model->bannerValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}		
			// Сгенерируем новое имя файла
			do {
				$fileName = uniqid();
				$path = 'public/images/banners/'.$fileName.'.png';
			} while (file_exists($path));
			$this->model->bannerUploadImage($_FILES['file']['tmp_name'][0], $fileName);
			$id = $this->model->bannerAdd($fileName);
			if (!$id) 
			{
				$this->view->message('error', 'Ошибка обработки запроса');
			}
			
			$this->view->locationAndMessage('admin/viewBanners', 'success', 'Баннер добавлен');
		}
		
		$this->view->render('Добавление баннера');
	}
	
	public function editBannerAction()
	{
		if (!$this->model->isBannerExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		if (!empty($_POST) or !empty($_FILES))
		{
			if (!$this->model->bannerValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			
			// Сгенерируем новое имя файла
			do {
				$fileName = uniqid();
				$path = 'public/images/banners/'.$fileName.'.png';
			} while (file_exists($path));
			$this->model->bannerUploadImage($_FILES['file']['tmp_name'][0], $fileName);
			$this->model->bannerEdit($this->route['id'], $fileName);
			$this->view->locationAndMessage('admin/viewBanners', 'success', 'Баннер изменен');
		}
		
		$vars = array(
			'data' => $this->model->bannerData($this->route['id']),
		);
		$this->view->render('Редактирование баннера', $vars);
	}
	
	public function deleteBannerAction()
	{
		if (!$this->model->isBannerExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		$this->model->bannerDelete($this->route['id']);
		//$this->view->locationAndMessage('admin/viewBanners', 'success', 'Баннер удален');
		$this->view->message('success', 'Баннер удален');
	}
	
	public function viewCatalogsAction() 
	{
		$mainMod = new MainModel;
	
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
			$total = $mainMod->productsCount($idCatalog);
			$count = 20;
			
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
				'catalog' => $mainMod->getCatalogById($idCatalog),
				'load' => $visibleButtonLoad,
				'list' => $mainMod->productsList($start, $count, $idCatalog),
			);
			

			if($total > $start)
			{
				$this->view->renderProductsListAdminAjax($vars);
			}
		}
		else
		{
			// начальная страница изделий
			if (array_key_exists("id", $this->route)) 
			{
				$idCatalog = $this->route['id'];
				$total = $mainMod->productsCount($idCatalog);
				$count = 20;
				
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
					'catalog' => $mainMod->getCatalogById($idCatalog),
					'load' => $visibleButtonLoad,
					'list' => $mainMod->productsList($start, $count, $idCatalog),
				);
				
				$this->view->renderProductsListAdmin('Изделия', $vars);
			}
			else
			{	
				$total = $mainMod->catalogsCount();
				$count = 20;
				
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
					'list' => $mainMod->catalogsList($start, $count),
				);
		
				if (array_key_exists("action", $_POST)) 
				{
					if($total > $start)
					{
						$this->view->renderCatalogsAdminAjax($vars);
					}
				}
				else
				{
					$this->view->render('Каталоги', $vars);
				}
			}
		}
	}
	
	public function addCatalogAction() 
	{
		if (!empty($_POST) or !empty($_FILES)) 
		{
			if (!$this->model->catalogValidateAdd($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}		
			// Сгенерируем новое имя файла
			do {
				$fileName = uniqid();
				$path = 'public/images/catalogs/'.$fileName.'.png';
			} while (file_exists($path));
			$this->model->catalogUploadImage($_FILES['file']['tmp_name'][0], $fileName);
			$id = $this->model->catalogAdd($fileName, $_POST);
			if (!$id) 
			{
				$this->view->message('error', 'Ошибка обработки запроса');
			}
			
			$this->view->locationAndMessage('admin/viewCatalogs', 'success', 'Каталог добавлен');
		}
		
		$this->view->render('Добавление каталога');
	}
	
	public function editCatalogAction()
	{
		if (!$this->model->isCatalogExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		if (!empty($_POST) or !empty($_FILES))
		{
			if (!$this->model->catalogValidateEdit($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			if(isset($_FILES['file']['tmp_name'][0]))
			{
				// Сгенерируем новое имя файла
				do {
					$fileName = uniqid();
					$path = 'public/images/catalogs/'.$fileName.'.png';
				} while (file_exists($path));
				$this->model->catalogUploadImage($_FILES['file']['tmp_name'][0], $fileName);
				$this->model->catalogEditImage($this->route['id'], $fileName);
			}
			$this->model->catalogEditText($this->route['id'], $_POST);
			$this->view->locationAndMessage('admin/viewCatalogs', 'success', 'Каталог изменен');
		}
		
		$vars = array(
			'data' => $this->model->catalogData($this->route['id']),
		);
		$this->view->render('Редактирование каталога', $vars);
	}
	
	public function deleteCatalogAction()
	{
		$mainMod = new MainModel;
		$result = $mainMod->checkProductInCatalog($this->route['id']);
		
		if (!$this->model->isCatalogExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		if(empty($result))
		{
			$this->model->catalogDelete($this->route['id']);
			//$this->view->locationAndMessage('admin/viewBanners', 'success', 'Баннер удален');
			$this->view->message('success', 'Каталог удален');
		}
		else
		{
			$this->view->message('error', 'Удаление не возможно. В каталоге имеются изделия');
		}
	}
	

	public function addProductAction()
	{
		$mainMod = new MainModel;
		
		if (!$this->model->isCatalogExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		if (!empty($_POST) or !empty($_FILES)) 
		{
			if (!$this->model->productValidateAdd($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			
			if(!empty($_FILES))
			{
				$count = count($_FILES['file']);
			}
			else
			{
				$this->view->message('error', 'Загрузите изображение');
			}
			
			$fileName = array();
			for($i = 0; $i < $count; $i++)
			{
				if(isset($_FILES['file']['tmp_name'][$i]))
				{
					// Сгенерируем новое имя файла
					do {
						$fileName[$i] = uniqid();
						$path = 'public/images/products/'.$fileName[$i].'.png';
					} while (file_exists($path));
					$this->model->productUploadImage($_FILES['file']['tmp_name'][$i], $fileName[$i]);
				}
			}
			$id = $this->model->productAdd($_POST, $fileName);
			if (!$id) 
			{
				$this->view->message('error', 'Ошибка обработки запроса');
			}
			$this->view->locationAndMessage('admin/viewCatalogs/'.$this->route['id'], 'success', 'Изделие добавлено');
		}
		
		$vars = array(
			'list' => $mainMod->fullCatalogsList(),
			'data' => $this->model->catalogData($this->route['id']),
		);

		$this->view->render('Добавить изделие', $vars);
	}
	
	public function editProductAction()
	{
		$mainMod = new MainModel;
		
		if (!$this->model->isProductExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		$vars = array(
			'list' => $mainMod->fullCatalogsList(),
			'data' => $this->model->productData($this->route['id']),
		);
		
		if (!empty($_POST) or !empty($_FILES))
		{
			if (!$this->model->productValidateEdit($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			
			if(!empty($_FILES))
			{
				$count = count($_FILES['file']);
			}
			else
			{
				$count = 0;
			}
			
			for($i = 0; $i < $count; $i++)
			{
				if(isset($_FILES['file']['tmp_name'][$i]))
				{
					$pos = $i + 1;
					
					// Сгенерируем новое имя файла
					do {
						$fileName = uniqid();
						$path = 'public/images/products/'.$fileName.'.png';
					} while (file_exists($path));
					$this->model->productUploadImage($_FILES['file']['tmp_name'][$i], $fileName);
					$this->model->productEditImage($this->route['id'], $fileName, $pos);
				}
			}
			$this->model->productEditText($this->route['id'], $_POST);
			$this->view->locationAndMessage('admin/viewCatalogs/'.$vars['data'][0]['idCatalog'], 'success', 'Описание изделия изменено');
		}
		
		$this->view->render('Редактирование описания изделия', $vars);
	}
	
	public function deleteProductAction()
	{
		if (!$this->model->isProductExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		
		$this->model->productDelete($this->route['id']);

		//$this->view->locationAndMessage('admin/viewBanners', 'success', 'Баннер удален');
		$this->view->message('success', 'Изделие удалено');
	}
	
	public function settingsAction() 
	{	
		$path = "config/settingsConfig.ini";
		$keys = array("domen", "vkGroup", "orgName", "mainNumPhone");
		
		if (!empty($_POST))
		{			
			$this->model->settingsEdit($_POST, $path, $keys);
			$this->view->locationAndMessage('admin/starting', 'success', 'Настройки изменены');
		}
		
		$vars = $this->model->settingsRead($path, $keys);
		
		$this->view->render('Настройки', $vars);
	}
	
	public function settingsSecurityAction() 
	{	
		$path = "config/settingsSecurityConfig.ini";
		$keys = array("login", "password");
		
		if (!empty($_POST)) 
		{
			if (!$this->model->loginValidate($_POST, $path, $keys)) 
			{
				$this->view->message('error', $this->model->error);
			}
			if (!$this->model->settingsSecurityValidate($_POST, $path, $keys)) 
			{
				$this->view->message('error', $this->model->error);
			}
			
			$params = array(
				'login' => $_POST['newLogin'],
				'password' => $_POST['newPass1'],
			);
			
			$this->model->settingsEdit($params, $path, $keys);
			$this->view->locationAndMessage('admin/starting', 'success', 'Настройки изменены');
		}

		$vars = $this->model->settingsRead($path, $keys);
		
		$this->view->render('Настройки', $vars);
	}
	
	public function settingsContactAction() 
	{	
		$path = "config/settingsContactConfig.ini";
		$keys = array("numPhone", "email", "operatingMode", "address", "getThere");
		
		if (!empty($_POST))
		{			
			$this->model->settingsEdit($_POST, $path, $keys);
			$this->view->locationAndMessage('admin/starting', 'success', 'Настройки изменены');
		}
		
		$vars = $this->model->settingsRead($path, $keys);
		
		$this->view->render('Настройки', $vars);
	}
	
	public function settingsAboutAction() 
	{	
		$path = "config/settingsAboutConfig.ini";
		$keys = array("description");
		
		if (!empty($_POST))
		{			
			$this->model->settingsEdit($_POST, $path, $keys);
			$this->view->locationAndMessage('admin/starting', 'success', 'Настройки изменены');
		}
		
		$vars = $this->model->settingsRead($path, $keys);
		
		$this->view->render('Настройки', $vars);
	}
}