<?php
//Cái này mình chia route của view ra CreateView('tên route mình muốn');
Route::set('login', function(){
	login::CreateView('login');
	});

Route::set('register', function(){
	register::CreateView('register');
	});

Route::set('home', function(){
	home::CreateView('home');
	});
Route::set('index.php', function(){
	home::CreateView('home');
});
Route::set('/', function(){
	home::CreateView('home');
});
Route::set('tree', function(){
	TreeHandler::CreateView('draw_tree');
});
/*Route::set('logout', function(){
	home::logOut('logout');
	home::CreateView('home');
	});*/
?>