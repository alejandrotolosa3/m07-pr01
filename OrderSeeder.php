<?php
require_once 'vendor/autoload.php';
include_once 'DBconn.php';

class OrderSeeder  extends DBconn
{

    public function fillOrders()
    {
        $orders = [];

        for ($i = 0; $i < 1000; $i++) {
            $faker = Faker\Factory::create();
            $date = $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = 'UTC');

            $order = [
                "date" => $date->format('Y/m/d'),
                "company" => $faker->regexify('[A-Za-z]{15}'),
                "qty" => $faker->randomDigit(),
            ];
            $sql = 'INSERT INTO orders (`date`, `company`, `qty`) VALUES ("' . $order["date"] . '","' . $order["company"] . '","' . $order["qty"] . '")';
            $this->connect()->query($sql);
            $this->disconnect();
            array_push($orders, $order);
        }

        print_r($orders);
    }

    public function getOrders()
    {
        if ("" == trim($_REQUEST['date']) && "" == trim($_REQUEST['company'])) {
            return "Debes enviar company o date en la request";
        }

        if ("" != trim($_REQUEST['date']) && "" != trim($_REQUEST['company'])) {
            return "Solo puedes enviar company o date";
        }

        if ("" != trim($_REQUEST['company'])) {

            $company = $_REQUEST['company'];
            $conn = $this->connect();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare('SELECT * FROM orders WHERE company LIKE "' . $company . '%"');
            $stmt->execute();

            $resultArray = [];
            foreach ($stmt->fetchAll() as $k => $v) {
                array_push($resultArray, [
                    "id_order" => $v['id_order'],
                    "date"     => $v['date'],
                    "company"  => $v['company'],
                    "qty"      => $v['qty'],
                ]);
            }
            return $resultArray;
        }

        if ("" != trim($_REQUEST['date'])) {
            $date = $_REQUEST['date'];
            $conn = $this->connect();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM `orders` WHERE `date` < '$date'");
            $stmt->execute();

            $resultArray = [];
            foreach ($stmt->fetchAll() as $k => $v) {
                array_push($resultArray, [
                    "id_order" => $v['id_order'],
                    "date"     => $v['date'],
                    "company"  => $v['company'],
                    "qty"      => $v['qty'],
                ]);
            }
            return $resultArray;
        }
    }
}


// //Llenar la DB.
// $seeder = new OrderSeeder();
// $seeder->fillOrders();

