<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Allergen.php";

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
        return $app['twig']->render('index.html.twig', array('allergens' => Allergen::getAll()));
    });

    $app->post('/allergens', function() use ($app) {
        $filtered_allergen_ids = $_POST["allergen_ids"];
        return $app['twig']->render('results.html.twig', array('filtered_allergen_ids' => $filtered_allergen_ids));
    });

    return $app;

?>
