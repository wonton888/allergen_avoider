<?php

    class Option
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

        function addRestaurant($new_restaurant)
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants_options (restaurant_id,  option_id) VALUES ({$new_restaurant->getId()}, {$this->getId()});");
        }

        function getRestaurants()
        {
            $restaurants = array();
            $id = null;
            $returned_restaurants = $GLOBALS['DB']->query("SELECT restaurants.* FROM options
                            JOIN restaurants_options ON (options.id = restaurants_options.option_id)
                            JOIN restaurants ON (restaurants_options.restaurant_id = restaurants.id)
                            WHERE options.id = {$this->getId()};");
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
            $GLOBALS['DB']->exec("INSERT INTO options (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM options WHERE id = {$this->getId()};");
        }

        static function find($option_id)
        {
            $found_option = null;
            $options = Option::getAll();
            foreach ($options as $option) {
                if ($option->getId() == $option_id) {
                    $found_option = $option;
                }
            }
            return $found_option;
        }

        static function getAll()
        {
            $returned_allergies = $GLOBALS['DB']->query("SELECT * FROM options;");
            //lower table name only
            $allergies = array();
            foreach($returned_allergies as $allergy){
                $name = $allergy['name'];
                $id = $allergy['id'];
                $new_allergy = new Option($name, $id);
                array_push($allergies, $new_allergy);
            }
            return $allergies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM options;");
        }

        static function getObjects($option_ids)
        {
            $options = array();
            foreach($option_ids as $option_id) {
                array_push($options, Option::find($option_id));
            }
            return $options;
        }

        static function getIdsFromNames($suitable_option_names)
        {
            $suitable_options_ids = array();
            foreach($suitable_option_names as $name) {
                $statement = $GLOBALS['DB']->query("SELECT * FROM options WHERE name = '{$name}';");
                $returned_option = $statement->fetchAll(PDO::FETCH_ASSOC);
                $id = $returned_option[0]['id'];
                array_push($suitable_options_ids, $id);
            }
            return $suitable_options_ids;
        }


    }



 ?>
