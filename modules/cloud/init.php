<?php

Route::set('cloud', 'cloud')
	 ->defaults(array(
			'action'     => 'index',
			'controller' => 'Cloud'
		));

Route::set('cloud', 'cloud/create')
	 ->defaults(array(
			'action'     => 'create',
			'controller' => 'Cloud'
		));