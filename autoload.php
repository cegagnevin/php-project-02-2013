<?php

$mapFolders = array('src/', 'tests/');

// your autoloader
spl_autoload_register(function ($class) use($mapFolders){
	$class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
	$class = str_replace("_", DIRECTORY_SEPARATOR, $class);
	$class .= ".php";

	foreach($mapFolders as $folder)
	{
		if(file_exists(__DIR__.'/'.$folder.$class))
		{
       			require __DIR__.'/'.$folder.$class;
			break;
		}
	}
});


