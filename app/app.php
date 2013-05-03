<?php
use \Http\Request;

/*
GET 	/locations 		=> 	show all the cities
GET 	/locations/id 		=> 	show one city which id corresponds
POST 	/locations		=>	add a new city
DELETE 	/locations/id		=>	delete the city corresponding
PUT 	/locations/id		=>	update the city
*/

//require __DIR__ . '/../autoload.php';
require __DIR__ . '/../vendor/autoload.php';

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 */
$app->get('/', function (Request $request) use ($app) {
    return $app->render('index.php');
});

$app->get('/locations', function (Request $request) use ($app) {
    $model = new \Model\Locations();
    
    $location = $model->findAll();
    
    switch($request->guessBestFormat()) {
		case 'json' :
			return new JsonResponse($location);
		default :
	}
	
    return $app->render('locations.php', array(
       'locations' => $location, 
    ));
});

$app->get('/locations/(\d+)', function (Request $request, $id) use ($app) {
    $model = new \Model\Locations();
    $city = $model->findOneById($id);
    
    if(false === isset($city)) {
        throw new \Exception\NotFoundException(404, "Location not found");   
    }

	switch($request -> guessBestFormat()) { 
        case 'json' :
            return new \Http\JsonResponse(["id" => $id, "location" => $city]);
        default :
    }
    return $app->render('location.php', array(
	   'id' => $id,
       'location' => $city
    ));
});

$app->post('/locations', function(Request $request) use ($app) {
	$request = new Request($_GET, $_POST);
	$model = new \Model\Locations();

    $name = $request->getParameter("name");
    if(true === empty($name)) {
        throw new \Exception\HttpException(400, "Empty field !");
    }

    $model->create($name);
    
    switch($request -> guessBestFormat()) { 
        case 'json' :
            return new \Http\JsonResponse($name, 201);
        
        default :
    }
    
	$app->redirect('/locations');
});

$app->put('/locations/(\d+)', function (Request $request, $id) use ($app) {
	$model = new \Model\Locations();
    $city = $model->findOneById($id);
    $name = $request->getParameter('name');

	if(false === isset($city)) {
        throw new \Exception\NotFoundException(404, "Location not found");   
    }

    if(true === empty($name)) {
        throw new \Exception\HttpException(400, "Empty field !");
    }
    
    $model->update($id, $name);
    
    switch($request -> guessBestFormat()) {
        case 'json' :
            return new \Http\JsonResponse(["id" => $id, "location" => $city]);

        default :
    }
        
    return $app->redirect('/locations');
});

$app->delete('/locations/(\d+)', function (Request $request, $id) use ($app) {
	//une fois qu'on a supprimé on envoie une response avec contenu vide
	$model = new \Model\Locations();
    $city = $model->findOneById($id);

    if(null === $city) {
        throw new \Exception\NotFoundException(404, "Location not found");
    }   

    $model->delete($id);

	switch($request -> guessBestFormat()) {
        case 'json' :
            return new JsonResponse($id, 204);
            
        default :
    }
 
    return $app->redirect('/locations');
});

return $app;
