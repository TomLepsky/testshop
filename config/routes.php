<?php

return array(
			
		'admin/category/create'			  => 'adminCategory/create',
		'admin/category/update/([\d]+)' => 'adminCategory/update/$1',
		'admin/category/delete/([\d]+)' => 'adminCategory/delete/$1',
		'admin/category'					  => 'adminCategory/index',	
		
		'admin/product/create'			  => 'adminProduct/create',
		'admin/product/update/([\d]+)'  => 'adminProduct/update/$1',
		'admin/product/delete/([\d]+)'  => 'adminProduct/delete/$1',
		'admin/product'					  => 'adminProduct/index',
		
		'admin/order/update/([\d]+)'	  => 'adminOrder/update/$1',
		'admin/order/delete/([\d]+)'	  => 'adminOrder/delete/$1',
		'admin/order/view/([\d]+)'	  	  => 'adminOrder/view/$1',
		'admin/order'						  => 'adminOrder/index',
		
		'admin'								  => 'admin/index', 
		
		'cabinet/edit'						  => 'cabinet/edit',
		'cabinet/history'					  => 'cabinet/history',
		'cabinet' 							  => 'cabinet/index',

		'cart/add/([\d]+)' 			     => 'cart/add/$1',
		'cart/addAjax/([\d]+)'			  => 'cart/addAjax/$1',
		'cart/checkout'					  => 'cart/checkout',
		'cart/delete/([\d]+)'			  => 'cart/delete/$1',
		'cart'								  => 'cart/index',
		
		'catalog'			 				  => 'catalog/index',
		
		'category/([\d]+)/page-([\d]+)' => 'catalog/category/$1/$2',
		'category/([\d]+)' 				  => 'catalog/category/$1',

		'contacts'							  => 'site/contact',
		
		'product/([\d]+)'  				  => 'product/view/$1',
		
		'user/register'					  => 'user/register',
		'user/login' 						  => 'user/login',
		'user/logout' 						  => 'user/logout',
		
		'.+'									  => 'site/index',
		
		'' 					 				  => 'site/index'
		
		);

?>