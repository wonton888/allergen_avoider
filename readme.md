# Allergen Avoider

##### Allergen Avoider using MySQL join table, 9/28/2015

#### By Adam Won, Julian Stewart, Will Swanson, Marcos Moncivais, Ben Pritchard

## Description


## Setup
_This project makes use of a PHP dependency manager. Full details and installation instructions can be found at https://getcomposer.org/_

_Your computer must also be set up to support PDO (PHP Data Objects) and MySQL._

_To run the application:_

* _Start your MySQL server from the root level of the project folder, being sure to adjust the port number if needed_
* _Import the databases included in this repository in the sql/ directory, or run the following commands:_
<pre>
CREATE DATABASE allergens;
USE allergens;
CREATE TABLE restaurants (id serial PRIMARY KEY, name VARCHAR (255));
</pre>
* _Start your PHP server from the web/ directory within the project folder_
* _Point your browser to your localhost server address_

## Technologies Used

PHP, phpMyAdmin, MySQL, PHPUnit, Silex, Twig, HTML, CSS, Bootstrap

### Legal

Copyright (c) 2015 Adam Won, Julian Stewart, Will Swanson, Marcos Moncivais, Ben Pritchard

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
