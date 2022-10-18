<?php

use Project\Api\Blog\Commands\Arguments;
use Project\Api\Blog\Commands\CreateUserCommand;
use Project\Api\Blog\Exceptions\ArgumentsException;
use Project\Api\Blog\Exceptions\CommandException;
use Project\Api\Blog\User;
use Project\Api\Blog\UUID;
use Project\Api\Person\Name;
use Project\Api\Blog\Repositories\UsersRepositories\SqlLiteUsersRepository;

require __DIR__ . '/vendor/autoload.php';

//spl_autoload_register('load');
//
//function load ($classname)
//{
//
//    $file = str_replace('_',DIRECTORY_SEPARATOR,$classname) . "InvalidArgumentException.php";
//    $file = str_replace(['\\','Project\Api'], [DIRECTORY_SEPARATOR,'src'],$file);
//
//    if(file_exists($file)){
//        require $file;
//    }
//}

$faker = Faker\Factory::create('en_US');

$connection = new PDO('sqlite:'.__DIR__.'/blog.sqlite');

$usersRepository = new SqlLiteUsersRepository($connection);
$commandWatcher = new CreateUserCommand($usersRepository);

$name = new Name ($faker->firstName(),$faker->lastName());
$user = new User (UUID::random(), $faker->userName(), $name);

try {
  $commandWatcher->handle(Arguments::fromArgv($argv));
} catch (CommandException|ArgumentsException $e) {
   echo $e->getMessage();
}


//if ($argv[1] === 'user') {
//    $name = new Name ($faker->firstName(),$faker->lastName());
//    $user = new User ($faker->randomDigitNotNull(), $faker->userName(), $name);
//    echo $user;
//} elseif ($argv[1] === 'post') {
//    $name = new Name ($faker->firstName(),$faker->lastName());
//    $user = new User ($faker->randomDigitNotNull(), $faker->userName(), $name);
//    $post = new Post($faker->randomDigitNotNull(), $user, $faker->sentence(), $faker->paragraph());
//    echo $post;
//} elseif ($argv[1] === 'comment') {
//    $name = new Name ($faker->firstName(),$faker->lastName());
//    $user = new User ($faker->randomDigitNotNull(), $faker->userName(), $name);
//    $post = new Post($faker->randomDigitNotNull(), $user, $faker->sentence(), $faker->paragraph());
//    $comment = new Comment($faker->randomDigitNotNull(), $user, $post, $faker->text());
//    echo $comment;
//}
