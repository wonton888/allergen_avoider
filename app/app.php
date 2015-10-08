<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Option.php";

    // Add symfony debug component and turn it on.
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    // Set Silex debug mode in $app object
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=allergen_avoider';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('options' => Option::getAll()));
    });

    $app->post('/options', function() use ($app) {
        $suitable_option_names = $_POST["option_names"];
        $suitable_option_ids = Option::getIdsFromNames($suitable_option_names);
        $options = Option::getObjects($suitable_option_ids);
        $suitable_restaurants = Restaurant::suitableRestaurants($suitable_option_ids);
        return $app['twig']->render('results.html.twig', array('suitable_restaurants' => $suitable_restaurants, 'options' => $options));
    });

    $app->get('/admin', function() use ($app) {
        return $app['twig']->render('admin.html.twig', array('restaurants' => Restaurant::getAll(), 'options' => Option::getAll()));
    });

    $app->post('/add_restaurants', function() use ($app){
        $restaurant_name = new Restaurant($_POST['restaurant_name']);
        $restaurant_name->save();
        return $app['twig']->render('admin.html.twig', array('restaurants' => Restaurant::getAll(), 'options' => Option::getAll()));
    });

    $app->post('/add_options', function() use ($app){
        $option_name = new Option($_POST['option_name']);
        $option_name->save();
        return $app['twig']->render('admin.html.twig', array('restaurants'=> Restaurant::getAll(), 'options' => Option::getAll()));
    });

    $app->post('/add_restaurant_options', function() use ($app) {
        $restaurant = Restaurant::find($_POST['restaurant_id']);
        $option = Option::find($_POST['option_id']);
        $restaurant->addOption($option);
        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'restaurant_options' => $restaurant->getOptions(), 'all_options' => Option::getAll()));
    });

    $app->post('/add_option_restaurants', function() use($app){
        $option = Option::find($_POST['option_id']);
        $restaurant = Restaurant::find($_POST['restaurant_id']);
        $option->addRestaurant($restaurant);
        return $app['twig']->render('option.html.twig', array('option' => $option, 'option_restaurants' => $option->getRestaurants(), 'all_restaurants' => Restaurant::getAll()));
    });

    $app->get('/restaurants/{id}', function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'restaurant_options' => $restaurant->getOptions(), 'all_options' => Option::getAll()));
    });

    $app->get('/options/{id}', function($id) use ($app) {
        $option = Option::find($id);
        return $app['twig']->render('option.html.twig', array('option' => $option, 'option_restaurants' => $option->getRestaurants(), 'all_restaurants' => Restaurant::getAll()));
    });

    $app->post('/restaurants/{id}/delete', function($id) use ($app){
        $restaurant = Restaurant::find($id);
        $restaurant->delete();
        return $app['twig']->render('admin.html.twig', array('restaurants'=> Restaurant::getAll(), 'options'=> Option::getAll()));
    });
    $app->post('/options/{id}/delete', function($id) use ($app){
        $option = Option::find($id);
        $option->delete();
        return $app['twig']->render('admin.html.twig', array('options'=> Option::getAll(), 'restaurants'=> Restaurant::getAll()));
    });

    return $app;

?>
