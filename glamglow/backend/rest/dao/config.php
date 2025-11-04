<?php
class Config {
    const DB_HOST = 'localhost';
    const DB_NAME = 'glamglow';
    const DB_USER = 'root';
    const DB_PASSWORD = 'root1234';
    const DB_PORT = '3306';

    public static function DB_HOST() { return self::DB_HOST; }
    public static function DB_NAME() { return self::DB_NAME; }
    public static function DB_USER() { return self::DB_USER; }
    public static function DB_PASSWORD() { return self::DB_PASSWORD; }
    public static function DB_PORT() { return self::DB_PORT; }
}
?>

