<?php

    class Allergen
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        //Getters and Setters
        function getName()
        {
            return $this->name;

        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function getRestaurants()
        {
            $restaurants = Array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE allergen_id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $allergen_id = $restaurant['allergen_id'];
                $new_restaurant = new Restaurant($name, $id, $allergen_id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        //Database methods

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO allergens (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_allergies = $GLOBALS['DB']->query("SELECT * FROM allergens;");
            //lower table name only
            $allergies = array();
            foreach($returned_allergies as $allergy){
                $name = $allergy['name'];
                $id = $allergy['id'];
                $new_allergy = new Allergen($name, $id);
                array_push($allergies, $new_allergy);
            }
            return $allergies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM allergens;");
        }




    }



 ?>
