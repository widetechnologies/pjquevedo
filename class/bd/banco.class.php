<?php

class banco {

    public static function con() {
        try {
            $base = parse_ini_file('config/conf.ini', true);
            $base = $base['db'];

            $link = new mysqli($base['host'], $base['user'], $base['password'], $base['database']);
            return $link;
        } catch (Exception $ex) {
            die("Não foi possível conectar em " . DB_HOST . ":" . DB_BASE . "\n");
        }
    }

    public static function pdoCon() {
        try {
            $base = parse_ini_file('config/conf.ini', TRUE);
            $base = $base['db'];
          //  var_dump($base);
            //    die("died");
//            $base['user'] = 'widet532_escola';
//            $base['host'] = 'localhost';
//            $base['password'] = 'Escola123!';
//            $base['charset'] = 'utf8';
//            $base['driver'] = 'mysql';
//            $base['database'] = 'widet532_pjquevedo';

            $drivers = PDO::getAvailableDrivers();
            //var_dump($drivers);
            //die();

            if (in_array('dblib', $drivers)) {

                die($base);
                $link = new PDO("dblib:host={$base['host']};dbname={$base['database']}", $base['user'], $base['password']);

                $query = "SET ANSI_NULLS ON;";
                $stmt = $link->query($query);

                $query = "SET ANSI_WARNINGS ON;";
                $stmt = $link->query($query);
            } else if (in_array('mysql', $drivers)) {
                $link = new PDO("mysql:host={$base['host']};dbname={$base['database']}", $base['user'], $base['password']);
            } else if (in_array('sqlsrv', $drivers)) {
                $link = new PDO("sqlsrv:server={$base['host']};database={$base['database']}", $base['user'], $base['password']);
            } else {
                throw new Exception('Driver PDO não encontrado.');
            }
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $link;
        } catch (PDOException $ex) {
            die("Não foi possível conectar em " . $ex->getMessage() . "\n");
        }
    }

}
