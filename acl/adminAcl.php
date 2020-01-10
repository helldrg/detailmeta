<?php

return array(
	'all' => array('login', 'logout',),
	'authorize' => array(),
	'guest' => array(),
	'admin' => array('admin', 'starting','logout',
		'addProduct','editProduct','deleteProduct',
		'addCatalog', 'editCatalog', 'deleteCatalog', 'viewCatalogs',
		'addBanner', 'editBanner', 'deleteBanner', 'viewBanners',
		'editAbout','editContact',
		'settings', 'settingsSecurity', 'settingsAbout', 'settingsContact',
	),
);