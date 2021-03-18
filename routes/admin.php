<?php

Route::prefix('/admin')->group(function(){
	Route::get('/', 'Admin\DashboardController@getDashboard');
	Route::get('/users', 'Admin\UserController@getUsers');

	//Module Products
	Route::get('/products', 'Admin\ProductController@getHome');
	Route::get('/products/add', 'Admin\ProductController@getProductAdd');
	Route::get('/products/{id}/edit', 'Admin\ProductController@getProductEdit');
	Route::post('/products/add', 'Admin\ProductController@postProductAdd');
	Route::post('/products/{id}/edit', 'Admin\ProductController@postProductEdit');
	Route::post('/products/{id}/gallery/add', 'Admin\ProductController@postProductGalleryAdd');

	// Categorias
	Route::get('/categories/{module}', 'Admin\CategoriesController@getHome');
	Route::post('/category/add', 'Admin\CategoriesController@postCategoryAdd');
	Route::get('/category/{id}/edit', 'Admin\CategoriesController@getCategoryEdit');
	Route::post('/category/{id}/edit', 'Admin\CategoriesController@postCategoryEdit');
	Route::get('/category/{id}/delete', 'Admin\CategoriesController@getCategoryDelete');
});

?>