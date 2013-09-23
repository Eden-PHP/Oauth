<<<<<<< HEAD
<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2012-2013 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
require_once __DIR__.'/../../Core/library/Eden/Core/Loader.php';
Eden\Core\Loader::i()
	->addRoot(true, 'Eden\\Core')
	->addRoot(realpath(__DIR__.'/../../Oauth/library'), 'Eden\\Oauth')
	->addRoot(realpath(__DIR__.'/../../Curl/library'), 'Eden\\Curl')
	->register()
=======
<?php //-->
/*
 * This file is part of the Oauth package of the Eden PHP Library.
 * (c) 2012-2013 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
require_once __DIR__.'/../../Core/library/Eden/Core/Loader.php';
Eden\Core\Loader::i()
	->addRoot(true, 'Eden\\Core')
	->addRoot(realpath(__DIR__.'/../../Oauth/library'), 'Eden\\Oauth')
	->register()
>>>>>>> e7c7a60f61a44dfffc40cf69a2c30337d5ce2131
	->load('Controller');