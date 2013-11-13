<?php
/**
 * User: s.zheleznitskij
 * Date: 11/13/13
 * Time: 4:52 PM
 */

    $mysqli = new mysqli('localhost', 'root', 'abcABC123', 'one_or_one_vulnerable');
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    echo 'Success... ' . $mysqli->host_info. "<br>";

    if ($mysqli->query(
            "CREATE TABLE `test_data` (
            `id` int(10) unsigned NOT NULL,
            `name` varchar(255) CHARACTER SET utf8 NOT NULL,
            `score` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        ) === true) {
        printf("Table test_data successfully created" . "<br>");
    }

    $mysqli->query("INSERT INTO `test_data` (`id`, `name`, `score`) VALUES (1, 'Slava', 1), (2, 'Serg', 3);");

    $argv[] = '1 OR 1=1'; //chr(0xbf) . chr(0x27) . " OR 1=1 /*"
    $input = mysql_real_escape_string($argv[0]);

    $res = $mysqli->query("SELECT * FROM `test_data` WHERE `score` = $input");
    while ($row = $res->fetch_assoc()) {
        echo " id = " . $row['id'] . "<br>";
    }

    $mysqli->close();