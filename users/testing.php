<?php
include('../includes/db.php');
include('../vendor/autoload.php');

$faker = Faker\Factory::create();
// $data = array();
for ($i = 0; $i < 10; $i++) {
  $data[$i]['reference_no'] = $faker->ean8();
  $data[$i]['orders_details'] = $faker->paragraph(10);
  $data[$i]['total_amount'] = $faker->randomFloat(1, 20, 30) . "$";
  $data[$i]['created_at'] = $faker->date();
  $data[$i]['updated_at'] = $faker->time();
  $data[$i]['status'] = $faker->sentence(2);
}
echo(json_encode($data));
?>