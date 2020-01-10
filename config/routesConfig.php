<?php

return array(
	// MainController
	'' => array(
		'controller' => 'main',
		'action' => 'index',
	),
	'about' => array(
		'controller' => 'main',
		'action' => 'about',
	),
	'contact' => array(
		'controller' => 'main',
		'action' => 'contact',
	),
	'downloads/{id:\d+}' => array(
		'controller' => 'main',
		'action' => 'downloads',
	),
	'feedback' => array(
		'controller' => 'main',
		'action' => 'feedback',
	),
	'catalog' => array(
		'controller' => 'main',
		'action' => 'catalog',
	),
	'catalog/{id:\d+}' => array(
		'controller' => 'main',
		'action' => 'catalog',
	),
	'product/{id:\d+}' => array(
		'controller' => 'main',
		'action' => 'product',
	),
	//"#^search/(?P\w+)/u$#"
	'search/{text:\w+}' => array(
		'controller' => 'main',
		'action' => 'search',
	),
	// AdminController
	'admin/login' => array(
		'controller' => 'admin',
		'action' => 'login',
	),
	'admin/logout' => array(
		'controller' => 'admin',
		'action' => 'logout',
	),
	'admin' => array(
		'controller' => 'admin',
		'action' => 'admin',
	),
	'admin/starting' => array(
		'controller' => 'admin',
		'action' => 'starting',
	),
	'admin/viewBanners' => array(
		'controller' => 'admin',
		'action' => 'viewBanners',
	),
	'admin/addBanner' => array(
		'controller' => 'admin',
		'action' => 'addBanner',
	),
	'admin/editBanner/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'editBanner',
	),
	'admin/deleteBanner/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'deleteBanner',
	),
	'admin/viewCatalogs' => array(
		'controller' => 'admin',
		'action' => 'viewCatalogs',
	),
	'admin/viewCatalogs/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'viewCatalogs',
	),
	'admin/addCatalog' => array(
		'controller' => 'admin',
		'action' => 'addCatalog',
	),
	'admin/editCatalog/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'editCatalog',
	),
	'admin/deleteCatalog/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'deleteCatalog',
	),
	'admin/addProduct/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'addProduct',
	),
	'admin/editProduct/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'editProduct',
	),
	'admin/deleteProduct/{id:\d+}' => array(
		'controller' => 'admin',
		'action' => 'deleteProduct',
	),
	'admin/settings' => array(
		'controller' => 'admin',
		'action' => 'settings',
	),
	'admin/settingsSecurity' => array(
		'controller' => 'admin',
		'action' => 'settingsSecurity',
	),
	'admin/settingsAbout' => array(
		'controller' => 'admin',
		'action' => 'settingsAbout',
	),
	'admin/settingsContact' => array(
		'controller' => 'admin',
		'action' => 'settingsContact',
	),
);