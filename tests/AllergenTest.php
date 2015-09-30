<?php
    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Allergen.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost; dbname=allergen_avoider_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AllergenTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Allergen::deleteAll();
            Restaurant::deleteAll();
        }

        function testGetAllergenName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Allergen($name);

            //act
            $result = $test_allergy->getName();


            //assert
            $this->assertEquals($name, $result);

        }

        function testSetAllergenName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Allergen($name);

            //act
            $test_allergy->setName("peanut allergy");
            $result = $test_allergy->getName();

            //assert
            $this->assertEquals("peanut allergy", $result);
        }

        function testGetId()
        {
            //arrange
            $id = 1;
            $name = "gluten allergy";
            $test_allergy = new Allergen($name, $id);

            //act
            $result = $test_allergy->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //arrange
            $name = "gluten allergy";
            $test_allergy = new Allergen($name);
            $test_allergy->save();

            //act
            $result = Allergen::getAll();

            //assert
            $this->assertEquals($test_allergy, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $name = "peanut allergy";
            $id = null;
            $test_allergy = new Allergen($name, $id);
            $test_allergy->save();

            $name2 = "gluten allergy";
            $test_allergy2 = new Allergen($name2, $id);
            $test_allergy2->save();

            //act
            $result = Allergen::getAll();

            //assert
            $this->assertEquals([$test_allergy, $test_allergy2], $result);

        }

        function test_addRestaurant()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Allergen($name);
            $test_allergy->save();

            $restaurant_name = "Restaurant A";
            $test_restaurant = new Restaurant($restaurant_name);
            $test_restaurant->save();

            //act
            $test_allergy->addRestaurant($test_restaurant);
            $result = $test_allergy->getRestaurants();

            //assert
            $this->assertEquals([$test_restaurant], $result);

        }

        function test_getRestaurants()
        {
            //arrange
            $name = "peanuts";
            $test_allergen = new Allergen($name);
            $test_allergen->save();

            $test_allergen_id = $test_allergen->getId();

            $restaurant_name = "Taco Hell";
            $test_restaurant = new Restaurant($restaurant_name);
            $test_restaurant->save();

            $restaurant_name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($restaurant_name2);
            $test_restaurant2->save();

            //act

            //addRestaurant and getRestaurant are dependent on each other!
            $test_allergen->addRestaurant($test_restaurant);
            $test_allergen->addRestaurant($test_restaurant2);
            $result = $test_allergen->getRestaurants();

            //assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }


    }






 ?>
