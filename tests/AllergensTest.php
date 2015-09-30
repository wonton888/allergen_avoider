<?php
    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Allergens.php";
    require_once "src/Restaurants.php";

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

        function test_getRestaurants()
        {
            //arrange
            $name = "Restaurant A";
            $id = null;
            $test_restaurant = new Restaurant($name, $id);
            $test_restaurant->save();

            $test_restaurant_id = $test_restaurant($test_restaurant->getId();

            $allergen_name = "peanut allergy";
            $test_allergy = new Allergen($allergen_name, $id, $test_restaurant_id);
            $test_allergy->save();

            $allergen_name2 = "gluten allergy";
            $test_allergy2 = new Allergen($allergen_name2, $id, $test_restaurant_id);
            $test_allergy2->save();

            //act
            $result = $test_restaurant->getName();

            //assert
            $this->assertEquals([$test_allergy, $test_allergy2], $result);
        }


    }






 ?>
