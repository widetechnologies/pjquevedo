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

    public static function rmcon() {
        try {
            $base = parse_ini_file('config/conf.ini', true);
            $base = $base['db'];
            //Linux
            if (function_exists('mssql_connect')) {
                $link = mssql_connect($base['host'], $base['user'], $base['password']);
                mssql_select_db($base['database'], $link);
                if (!$link) {
                    die('Erro de conexao com servidor.');
                }
            }
            //Windows
            else {
                if (function_exists('sqlsrv_connect')) {

                    $info_rm = array("Database" => $base['database'], "UID" => $base['user'], "PWD" => $base['password'], "CharacterSet" => 'UTF-8');
                    $link = sqlsrv_connect($base['host'], $info_rm);

                    if (!$link) {
                        die('Erro de conexao com servidor.' . print_r(sqlsrv_errors()));
                    }
                }
            }
            return $link;
        } catch (Exception $ex) {
            die("Não foi possível conectar em " . DB_HOST . ":" . DB_BASE . "\n");
        }
    }

    public static function leccon() {
        try {
            $base = parse_ini_file('config/conf.ini', true);
            $base = $base['dblec'];
            //Linux
            if (function_exists('mssql_connect')) {
                $link = mssql_connect($base['host'], $base['user'], $base['password']);
                mssql_select_db($base['database'], $link);
                if (!$link) {
                    die('Erro de conexao com servidor RM.');
                }
            }
            //Windows
            else {
                if (function_exists('sqlsrv_connect')) {

                    $info_rm = array("Database" => $base['database'], "UID" => $base['user'], "PWD" => $base['password'], "CharacterSet" => 'UTF-8');
                    $link = sqlsrv_connect($base['host'], $info_rm);

                    if (!$link) {
                        die('Erro de conexao com servidor RM.' . print_r(sqlsrv_errors()));
                    }
                }
            }
            return $link;
        } catch (Exception $ex) {
            die("Não foi possível conectar em " . DB_HOST . ":" . DB_BASE . "\n");
        }
    }

    public static function pdoCon() {
        try {
         //   $base = parse_ini_file('../config/conf.ini', true);
           // $base = $base['db'];
            $base['db']['user'] = 'widet532_escola';
            $base['db']['host'] = 'localhost';
            $base['db']['password'] = 'Escola123!';
            $base['db']['charset'] = 'utf8';
            $base['db']['driver'] = 'mysql';

            $drivers = PDO::getAvailableDrivers();
            //var_dump($drivers);
            //die();
            if (in_array('dblib', $drivers)) {

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
