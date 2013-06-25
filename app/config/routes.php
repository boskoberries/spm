<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
//print_r($this->args);
	Router::connect('/', array('controller' => 'memes', 'action' => 'index'));
	//Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	//Router::connect('/signup/*', array('controller' => 'users', 'action' => 'signup'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
	Router::connect('/teams', array('controller' => 'teams', 'action' => 'index'));
	Router::connect('/teams/*', array('controller' => 'teams', 'action' => 'display'));
	//Router::connect('/tags/*', array('controller' => 'tags', 'action' => 'index'));
	$sport_list = array('football','basketball','baseball','hockey','soccer');
	//$sport_list = array('nfl','NFL','nba','NBA','mlb','MLB','nhl','NHL','ncaaf','ncaab','nascar','golf');
	foreach($sport_list as $sport){	
		Router::connect('/'.$sport.'/*', array('controller' => 'memes', 'action' => 'sport','option'=>$sport));	
	}
	