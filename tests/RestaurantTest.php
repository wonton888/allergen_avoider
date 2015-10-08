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

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Option::deleteAll();
            Restaurant::deleteAll();
        }

        function testGetRestaurantName()
        {
            //arrange
            $name = "Taco Hell";
            $test_restaurant = new Restaurant($name);

            //act
            $result = $test_restaurant->getName();

            //assert
            $this->assertEquals($name, $result);
        }

        function testSetRestaurantName()
        {
            //arrange
            $name = "Taco Hell";
            $test_restaurant = new Restaurant($name);

            //act
            $test_restaurant->setName("Taco Hell");
            $result = $test_restaurant->getName();

            //assert
            $this->assertEquals("Taco Hell", $result);
        }

        function testGetId()
        {
            //arrange
            $id = 1;
            $name = "Taco Hell";
            $test_restaurant = new Restaurant($name, $id);

            //act
            $result = $test_restaurant->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //arrange
            $name = "Taco Hell";
            $id = null;
            $test_restaurant = new Restaurant($name, $id);

            //act
            $test_restaurant->save();
            $result = Restaurant::getAll();

            //assert
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_delete()
        {
            // arrange
            $name = "Taco Hell";
            $test_restaurant = new Restaurant($name);
            $test_restaurant->save();

            $name2 = "Puff the Magic Dragon";
            $test_restaurant2 = new Restaurant($name2);
            $test_restaurant2->save();

            // act
            $test_restaurant2->delete();
            $result = Restaurant::getAll();

            // assert
            $this->assertEquals([$test_restaurant], $result);
        }

        function test_find()
        {
            //arrange
            $name = "Taco Hell";
            $id = null;
            $test_restaurant = new Restaurant($name, $id);
            $test_restaurant->save();

            $name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($name2, $id);
            $test_restaurant2->save();

            //act
            $result = Restaurant::find($test_restaurant2->getId());

            //assert
            $this->assertEquals($test_restaurant2, $result);
        }

        function test_getAll()
        {
            //arrange
            $name = "Taco Hell";
            $id = null;
            $test_restaurant = new Restaurant($name, $id);
            $test_restaurant->save();

            $name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($name2, $id);
            $test_restaurant2->save();


            //act
            $result = Restaurant::getAll();



            //assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            //arrange
            $name = "Taco Hell";
            $id = null;
            $test_restaurant = new Restaurant($name, $id);
            $test_restaurant->save();

            $name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($name2, $id);
            $test_restaurant2->save();

            //act
            Restaurant::deleteAll();

            //assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);
        }

        function test_getOptionsAndAddOptions()
        {
            // Arrange
            $restaurant_name = "Burger Queen";
            $test_restaurant = new Restaurant($restaurant_name);
            $test_restaurant->save();

            $option_name = "Shellfish-free";
            $test_option = new Option($option_name);
            $test_option->save();

            $option_name2 = "Gasoline-free";
            $test_option2 = new Option($option_name2);
            $test_option2->save();

            // Act
            $test_restaurant->addOption($test_option);
            $test_restaurant->addOption($test_option2);
            $result = $test_restaurant->getOptions();

            // Assert
            $this->assertEquals([$test_option, $test_option2], $result);


        }

        function test_suitableRestaurants()
        {
            // arrange
            $restaurant_name = "Taco Hell";
            $test_restaurant = new Restaurant($restaurant_name);
            $test_restaurant->save();

            $restaurant_name2 = "Burger Queen";
            $test_restaurant2 = new Restaurant($restaurant_name2);
            $test_restaurant2->save();

            $option_name = "Shellfish-free";
            $test_option = new Option($option_name);
            $test_option->save();

            $option_name2 = "Gasoline-free";
            $test_option2 = new Option($option_name2);
            $test_option2->save();

            $option_name3 = "Soy-free";
            $test_option3 = new Option($option_name3);
            $test_option3->save();

            // act
            $test_restaurant->addOption($test_option2);
            $test_restaurant->addOption($test_option3);
            $test_restaurant2->addOption($test_option);
            $test_restaurant2->addOption($test_option2);
            $test_restaurant2->addOption($test_option3);
            $option_ids = array();
            array_push($option_ids, $test_option->getId());
            array_push($option_ids, $test_option3->getId());
            $result = Restaurant::suitableRestaurants($option_ids);

            // assert
            $this->assertEquals([$test_restaurant2], $result);
        }

     }
 ?>
