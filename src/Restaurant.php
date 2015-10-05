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

        static function suitableRestaurants($option_ids)
        {
            // $all_options_restaurants is an array of arrays containing returned restaurant objects based off of each of the $option_ids
            $all_options_restaurants = array();
            $restaurants = array();
            foreach($option_ids as $option_id) {
                $returned_restaurants = $GLOBALS['DB']->query("SELECT restaurants.* FROM options JOIN restaurants_options ON (options.id = restaurants_options.option_id) JOIN restaurants ON (restaurants_options.restaurant_id = restaurants.id) WHERE options.id = {$option_id};");
                foreach($returned_restaurants as $restaurant) {
                    $name = $restaurant['name'];
                    $id = $restaurant['id'];
                    $new_restaurant = new Restaurant($name, $id);
                    array_push($restaurants, $new_restaurant);
                }

                array_push($all_options_restaurants, $restaurants);
            }

            // generate $search_array_with_duplicates that includes all values of the $returned_restaurants arrays
            $search_array_with_duplicates = array();
            foreach($all_options_restaurants as $returned_restaurants) {
                foreach($returned_restaurants as $restaurant) {
                    array_push($search_array_with_duplicates, $restaurant->getId());
                }
            }

            // count duplicates in $search_array_with_duplicates for values equal to the number of elements in the $option_ids array
            $suitable_restaurants = array();
            $options_count = count($option_ids);
            $counted_duplicates = array_count_values($search_array_with_duplicates);
            foreach($counted_duplicates as $restaurant_id => $count) {
                if ($options_count == $count) {
                    $restaurant = Restaurant::find($restaurant_id);
                    array_push($suitable_restaurants, $restaurant);
                }
            }
            return $suitable_restaurants;
        }
    }




 ?>
