<?php
    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Option.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost; dbname=allergen_avoider_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class OptionTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Option::deleteAll();
            Restaurant::deleteAll();
        }

        function testGetOptionName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Option($name);

            //act
            $result = $test_allergy->getName();


            //assert
            $this->assertEquals($name, $result);

        }

        function testSetOptionName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Option($name);

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
            $test_allergy = new Option($name, $id);

            //act
            $result = $test_allergy->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //arrange
            $name = "gluten allergy";
            $test_allergy = new Option($name);
            $test_allergy->save();

            //act
            $result = Option::getAll();

            //assert
            $this->assertEquals($test_allergy, $result[0]);
        }

        function test_find()
        {
            //arrange
            $name = "Peanut-free";
            $test_allergy = new Option($name);
            $test_allergy->save();

            $name2 = "Gluten-free";
            $test_allergy2 = new Option($name2);
            $test_allergy2->save();

            //act
            $result = Option::find($test_allergy2->getId());

            //assert
            $this->assertEquals($test_allergy2, $result);
        }

        function test_getAll()
        {
            //arrange
            $name = "peanut allergy";
            $id = null;
            $test_allergy = new Option($name, $id);
            $test_allergy->save();

            $name2 = "gluten allergy";
            $test_allergy2 = new Option($name2, $id);
            $test_allergy2->save();

            //act
            $result = Option::getAll();

            //assert
            $this->assertEquals([$test_allergy, $test_allergy2], $result);
        }

        function test_getObjects()
        {
            //arrange
            $name = "Peanut-free";
            $test_allergy = new Option($name);
            $test_allergy->save();

            $name2 = "Gluten-free";
            $test_allergy2 = new Option($name2);
            $test_allergy2->save();

            //act
            $option_ids = array();
            array_push($option_ids, $test_allergy->getId(), $test_allergy2->getId());
            $result = Option::getObjects($option_ids);

            //assert
            $this->assertEquals([$test_allergy, $test_allergy2], $result);

        }

        function test_addRestaurant()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new Option($name);
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
            $test_option = new Option($name);
            $test_option->save();

            $test_option_id = $test_option->getId();

            $restaurant_name = "Taco Hell";
            $test_restaurant = new Restaurant($restaurant_name);
            $test_restaurant->save();

            $restaurant_name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($restaurant_name2);
            $test_restaurant2->save();

            //act

            //addRestaurant and getRestaurant are dependent on each other!
            $test_option->addRestaurant($test_restaurant);
            $test_option->addRestaurant($test_restaurant2);
            $result = $test_option->getRestaurants();

            //assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_getIdsFromNames()
        {
            //arrange
            $name = "peanut-free";
            $test_option = new Option($name);
            $test_option->save();

            $name2 = "soy-free";
            $test_option2 = new Option($name2);
            $test_option2->save();



            //act
            $suitable_options_names = array($test_option->getName(), $test_option2->getName());
            $result = Option::getIdsFromNames($suitable_options_names);


            //assert
            $this->assertEquals([$test_option->getId(), $test_option2->getId()], $result);
        }


    }

    // $suitable_option_ids = Option::get_ids($suitable_option_names);






 ?>
