<?php


namespace core;
use PDO;
/**
 * Description of Model
 *
 * @author Admin
 */
class Model {

    /**
     *
     * @var mysqli
     */
    protected $db;

    /**
     *
     * @var string
     */
    protected $table;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PWD,array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => TRUE
        ));
    }

}