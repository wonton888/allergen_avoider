<?php

    class Restaurant
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

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

        function getOptionId()
        {
            return $this->option_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function addOption($option)
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants_options (restaurant_id, option_id) VALUES ({$this->getId()}, {$option->getId()});");
        }

        function getOptions()
        {
            $returned_options = $GLOBALS['DB']->query("SELECT options.* FROM restaurants JOIN restaurants_options ON (restaurants.id = restaurants_options.restaurant_id) JOIN options ON (restaurants_options.option_id = options.id) WHERE restaurants.id = {$this->getId()};");
            $options =  array();
            foreach ($returned_options as $option){
                $name = $option['name'];
                $id = $option['id'];
                $new_option = new Option ($name, $id);
                array_push($options, $new_option);
            }
            return $options;
        }


        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant($name, $id);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }
    }




 ?>
