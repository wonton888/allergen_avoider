<?php
    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/Allergen.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost; dbname=allergens_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AllergenTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            FoodAllergy::deleteAll();
            Restaurant::deleteAll();

        }

        function testGetAllergenName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new FoodAllergy($name);

            //act
            $result = $test_allergy->getName();


            //assert
            $this->assertEquals($name, $result);

        }

        function testSetAllergenName()
        {
            //arrange
            $name = "peanut allergy";
            $test_allergy = new FoodAllergy($name);

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
            $test_allergy = new FoodAllergy($name, $id);

            //act
            $result = $test_allergy->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //arrange
            $name = "gluten allergy";
            $test_allergy = new FoodAllergy($name);
            $test_allergy->save();

            //act
            $result = FoodAllergy::getAll();

            //assert
            $this->assertEquals($test_allergy, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $name = "peanut allergy";
            $id = null;
            $test_allergy = new FoodAllergy($name, $id);
            $test_allergy->save();

            $name2 = "gluten allergy";
            $test_allergy2 = new FoodAllergy($name2, $id);
            $test_allergy2->save();

            //act
            $result = FoodAllergy::getAll();

            //assert
            $this->assertEquals([$test_allergy, $test_allergy2], $result);

        }


    }






 ?>
