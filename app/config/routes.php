<?php

/** List of routes */
/** website */
$r->get('/', 'WebsiteController@index');
$r->get('/about', "WebsiteController@about");
$r->get('/services', 'WebsiteController@services');
$r->get('/service/:id', 'WebsiteController@service');
$r->get('/prices', "WebsiteController@prices");
$r->get('/promotions', "WebsiteController@promotions");
//$r->get('/cabinets', 'WebsiteController@cabinets');
//$r->get('/cabinets/:id', 'WebsiteController@cabinet');
$r->get('/contact', 'WebsiteController@contact');

/** login register */
$r->get('/login', 'login/LoginController@index', "Session@notLogin");
$r->post('/login', 'login/LoginController@login', "Session@notLogin");
$r->get('/register', 'login/LoginController@index', "Session@notLogin");
$r->post('/register', 'login/LoginController@register', "Session@notLogin");
/** client panel */
$r->get('/panel', 'client/HomeController@index', ["Session@isLogin",'Session@isAdmin']);

$r->get('/panel/profile', 'client/UserController@index');
$r->put('/panel/profile', 'client/UserController@update');
$r->get('/panel/visits', 'client/VisitsController@index');
/** admin panel */
$r->get('/admin', 'admin/HomeController@index', ["Session@isLogin", 'Session@isAdmin']);
/** standardowa piątka cruda */
//USERS
$r->get('/admin/users', 'admin/UsersController@index', ["Session@isLogin", 'Session@isAdmin'] );
$r->get('/admin/users/:id', 'admin/UsersController@show', ["Session@isLogin", 'Session@isAdmin'] );
$r->post('/admin/users', 'admin/UsersController@store', ["Session@isLogin", 'Session@isAdmin'] );
$r->patch('/admin/users/:id', 'admin/UsersController@update', ["Session@isLogin", 'Session@isAdmin'] );
$r->delete('/admin/users/:id', 'admin/UsersController@destroy', ["Session@isLogin", 'Session@isAdmin'] );
$r->get('/admin/adduser', 'admin/UsersController@create', ["Session@isLogin", "Session@isAdmin"]);
$r->get("/admin/users/modal/:id", "admin/UsersController@modal", ["Session@isLogin", 'Session@isAdmin']);
//CABINETS
$r->crud("/admin/cabinets", 'admin/CabinetsController', ["Session@isLogin", "Session@isAdmin:3"]);
$r->get('/admin/addcabinet', 'admin/CabinetsController@create', ["Session@isLogin", "Session@isAdmin:3"]);
//SERVICES
$r->crud("/admin/services", 'admin/ServicesController', ["Session@isLogin", "Session@isAdmin:3"]);
$r->get('/admin/addservice', 'admin/ServicesController@create', ["Session@isLogin", "Session@isAdmin:3"]);
//VISITS
$r->crud('/admin/visits', 'admin/VisitsController', ["Session@isLogin", "Session@isAdmin"]);
$r->get('/admin/addvisit', 'admin/VisitsController@create', ["Session@isLogin", "Session@isAdmin"]);
/** reszta stron */
//VISITS AJAX
$r->get('/admin/ajax/visits/getServicesForCabinet/:id', 'admin/ajax/VisitsAjaxController@getServicesForCabinet', ["Session@isLogin", "Session@isAdmin"]);
//PRICES AJAX
$r->crud('/admin/prices', 'admin/ajax/PricesController', ["Session@isLogin", "Session@isAdmin:3"]);
//VARIANTS AJAXX
$r->crud('/admin/ajax/variants', 'admin/ajax/VariantsController', ["Session@isLogin", "Session@isAdmin:3"]);
//ASSIGNMENT AJAX
$r->get('/admin/ajax/assignment', 'admin/ajax/AssignerController@get', ["Session@isLogin", "Session@isAdmin:3"]);
$r->delete('/admin/ajax/assignment', 'admin/ajax/AssignerController@destroy', ["Session@isLogin", "Session@isAdmin:3"]);
$r->post('/admin/ajax/assignment', 'admin/ajax/AssignerController@store', ["Session@isLogin", "Session@isAdmin:3"]);
/**  CLIENT PANEL */
$r->get('/panel', 'client/HomeController@index', ['Session@isLogin']);

$r->get('/test', 'TestController@index');
$r->post('/test', 'TestController@post');
$r->put('/test', 'TestController@put');
$r->delete('/test', 'TestController@delete');