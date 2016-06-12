<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
	Router::connect('/index2/*', array('controller' => 'homes', 'action' => 'index2'));
	Router::connect('/detail/*', array('controller' => 'homes', 'action' => 'detail'));
	Router::connect('/result/*', array('controller' => 'homes', 'action' => 'result'));
	Router::connect('/confirm/*', array('controller' => 'homes', 'action' => 'confirm'));
	Router::connect('/expectations/complete', array('controller' => 'homes', 'action' => 'complete'));
	Router::connect('/mypage', array('controller' => 'homes', 'action' => 'mypage'));
	Router::connect('/race_result_list', array('controller' => 'homes', 'action' => 'mypage_result'));
	Router::connect('/favorite', array('controller' => 'homes', 'action' => 'favorite'));
	Router::connect('/kojiharu_list', array('controller' => 'homes', 'action' => 'kojiharu_list'));
	Router::connect('/about', array('controller' => 'homes', 'action' => 'about'));
	Router::connect('/contact', array('controller' => 'homes', 'action' => 'contact'));
	Router::connect('/contact_confirm', array('controller' => 'homes', 'action' => 'contact_confirm'));
	Router::connect('/contact_complete', array('controller' => 'homes', 'action' => 'contact_complete'));
	Router::connect('/other/*', array('controller' => 'homes', 'action' => 'other'));

	Router::connect('/regist', array('controller' => 'users', 'action' => 'regist'));
	Router::connect('/regist_confirm', array('controller' => 'users', 'action' => 'regist_confirm'));
	Router::connect('/regist_complete', array('controller' => 'users', 'action' => 'regist_complete'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/twitter_login', array('controller' => 'users', 'action' => 'twitter_login'));



/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
