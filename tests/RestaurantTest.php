<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

     require_once "src/Restaurant.php";


     $server = 'mysql: host= localhost; dbname=allergens_test';
     $username = 'root';
     $password = 'root';
     $DB = new PDO($server, $username, $password);

     class RestaurantTest extends PHPUnit_Framework_TestCase
     {
        //  protected function tearDown()
        //  {
        //      Restaurant::deleteAll();
        //
        //  }

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
     }

 ?>
