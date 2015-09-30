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
            $id = null;
            $returned_restaurants = $GLOBALS['DB']->query("SELECT restaurants.* FROM allergens
                            JOIN restaurants_allergens ON (allergens.id = restaurants_allergens.allergen_id)
                            JOIN restaurants ON (restaurants_allergens.restaurant_id = restaurants.id)
                            WHERE allergens.id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant($name, $id);
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
