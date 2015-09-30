<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

     require_once "src/Restaurants.php";


     $server = 'mysql: host= localhost; dbname=allergen_avoider_test';
     $username = 'root';
     $password = 'root';
     $DB = new PDO($server, $username, $password);

     class RestaurantTest extends PHPUnit_Framework_TestCase
     {
         protected function tearDown()
         {
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

            //assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
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
            $result = Restaurant::getAll();
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


     }

 ?>
