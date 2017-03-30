<?php
/**
 * PDO Database Class
 * 
 * @category Database Access
 * @package PDO_Access
 * @author Defri Fajar Utomo <defriblackertz@gmail.com>
 * @copyright (c) 2014
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version 1.0
 */
class Database {
    /**
     * Config database 
     * host dan nama database
     * 
     * @var string
     */
    private static $dsn = 'mysql:host=127.0.0.1;dbname=surat'; 
     /**
     * Config database
     * Nama untuk mengakses ke database
     * 
     * @var string
     */
    private static $username = 'root';
    /**
     * Config database
     * Password untuk mengakses ke database
     *
     * @var string
     */
    private static $password = '';
    /**
     * Variabel untuk mengakses koneksi PDO
     *
     * @var string
     */
    protected static $_db;
    /**
     * Query sql untuk mengambil data dari database dan dieksekusi
     * 
     * @var string
     */
    protected static $_query;
    /**
     * Cari integer didalam data
     * 
     * @var int
     */
    private static $_search;
    /**
     * Ganti integer didalam data diganti dengan string
     * 
     * @var string
     */
    private static $_replace;
    /**
     * Variabel yang berisi data string untuk dieksekusi dan disimpan kedalam database
     *
     * @var string
     */
    private static $_datatable;
    /**
     * Variabel yang berisi data array dimana kondisinya 'fieldname' => 'value'
     * 
     * @var array
     */
    private static $_where = array();
    /**
     * Static instance untuk membuat method menjadi anggota class
     * 
     * @var PDO_Access
     */
    private static $PDOInstance = NULL;

    private static $waktu;
    private static $tanggal;
    private static $bulan;
    private static $tahun;

    protected function __construct() {
        try {
            static::$_db = new PDO(static::$dsn, static::$username, static::$password);
            static::$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            static::$_db->exec('SET CHARACTER SET utf8');

            return static::$_db;
        } catch (Exception $ex) {
            static::errormessage($ex);
        }
    }

    /**
     * Singleton Pattern
     * 
     * @return PDO Connection
     */
    protected static function getConnection() {
        if (static::$PDOInstance === NULL) {
            static::$PDOInstance = new static;
        }

        return static::$PDOInstance;
    }
    
    /**
     * @param string $query Tergantung inputan query dari user
     * 
     * @return PDO Connection
     */
    public static function query($query) {
        static::$_query = $query;

        return static::getConnection();
    }
    
    /**
     * @param string $table     Nama tabel didalam database yang akan digunakan
     * 
     * @return PDO Connection
     */
    public static function get($table, $field = array()) {
        if($field) {
            static::$_query = "SELECT ". implode(',', $field). " FROM ". $table;
        }else{
            static::$_query = "SELECT * FROM ". $table;  
        } 

        return static::getConnection();
    }
    
    /**
     * @param string $field     Nama kolom tabel didatabase
     * @param string $operator  Operator perbandingan
     * @param string $value     Nilai didalam kolom tabel didatabase
     * 
     * @return \StaticDatabase anggota didalam class
     */
    public function where($field, $operator, $value) {
        static::$_query .= " WHERE " . $field . " ".$operator." :" . $field;
        
        
        static::$_where[$field] = $value;

        return $this;
    }
    
    /**
     * @param string $field     Nama kolom tabel didatabase
     * @param string $sort      Urutkan berdasarkan ASC atau DESC
     * 
     * @return \StaticDatabase Agar menjadi anggota didalam class
     */
    public function orderby($field, $sort = NULL) {
        static::$_query .= " ORDER BY " . $field . " " . $sort;

        return $this;
    }
    
    /**
     * @param integer $numRows Jumlah data yang ingin ditampilkan
     * 
     * @return \StaticDatabase Agar menjadi anggota didalam class
     */
    public function limit($numRows) {
        static::$_query .= " LIMIT " . (int) $numRows;

        return $this;
    }
    
    /**
     * @param string $field     Tampilkan group berdasarkan nama kolom tabel didalam class
     * 
     * @return \StaticDatabase
     */
    public function groupby($field) {
        static::$_query .= " GROUP BY " . $field;

        return $this;
    }
    
    /**
     * @param string $table     Nama tabel yang akan digunakan
     * @param array $datatable  Data yang akan diinputkan kedalam database berupa array
     * 
     * @return PDOConnection
     * 
     */
    public static function insert($table, $datatable) {
        try {
            static::getConnection();
            static::$_query = "INSERT INTO $table";

            $stmt = static::buildQuery($datatable);

            return $stmt->execute();
        } catch (Exception $ex) {
            static::errormessage($ex);
        }
    }

    /**
     * @param  string $table     Nama tabel yang akan digunakan
     * @param  array $datatable  Data yang akan diinputkan kedalam database berupa array
     * 
     * @return PDOConnection            
     */
    public static function update($table, $datatable) {
        static::$_query = "UPDATE $table SET ";
        foreach ($datatable as $field => $value) {
            $fields[] = $field . ' = :' . $field;
        }

        $data = implode(", ", $fields);

        static::$_query .= $data;
        static::$_datatable = $datatable;

        return static::getConnection();
    }

    /**
     * @param  string $table    Nama tabel yang akan digunakan
     * 
     * @return PDOConnection
     */
    public static function delete($table) {
        static::$_query = "DELETE FROM $table";

        return static::getConnection();
    }

    /**
     * Method buildQuery berguna untuk menambahkan query dengan awal query.
     * 
     * @param  boolean $datatable Data yang akan diinputkan kedalam database berupa array jika ada
     * 
     * @return string 
     */
    protected static function buildQuery($datatable = FALSE) {
        try {
            if (strpos(static::$_query, 'INSERT') !== false || strpos(static::$_query, 'UPDATE') !== false) {
                if (count($datatable) == count($datatable, COUNT_RECURSIVE)) {
                    foreach ($datatable as $field => $value) {
                        $fields[] = ':' . $field;
                    }

                    $values = implode(", ", $fields);
                    $nama_field = implode(", ", array_keys($datatable));

                    static::$_query .= " ($nama_field) VALUES ($values)";
                } else {

                    static::$_search = range(0, count($datatable));
                    static::$_replace = array_slice(range('A', 'Z', count($datatable)), 0, count($datatable));

                    for ($i = 0; $i < count($datatable); $i++) {
                        foreach ($datatable[$i] as $field => $value) {
                            $fields[] = str_replace(static::$_search, static::$_replace, ':' . $field . $i);
                        }
                    }

                    for ($i = 0; $i < count($datatable); $i++) {
                        $vali[$i] = "(" . implode(", ", array_slice($fields, $i * count($datatable[0]), count($datatable[0]))) . ")";
                    }

                    $nama_field = implode(", ", array_keys($datatable[0]));
                    $values = implode(", ", $vali);
                    static::$_query .= " ($nama_field) VALUES $values";
                }
            }

            $output = filter_var(static::$_query, FILTER_SANITIZE_STRING);
            $stmt = static::$_db->prepare($output);

            static::bindValues($datatable, $stmt);

            return $stmt;
        } catch (Exception $ex) {
            echo static::errormessage($ex);
        }
    }

    /**
     * Methods bindValues berguna untuk mengikat nilai kedalam parameter sebelum dieksekusi kedalam database
     * 
     * @param  array $datatable  Data yang akan diinputkan kedalam database berupa array
     * @param  string $stmt      Parameter untuk mengikat query SQL
     * @return string            
     */
    protected static function bindValues($datatable, $stmt) {
        if (count($datatable) == count($datatable, COUNT_RECURSIVE)) {
            foreach ($datatable as $f => $v) {
                $results[] = $stmt->bindValue(':' . $f, $v);
            }
        } else {
            for ($i = 0; $i < count($datatable); $i++) {
                foreach ($datatable[$i] as $f => $v) {
                    $results[] = $stmt->bindValue(str_replace(static::$_search, static::$_replace, ':' . $f . $i), $v);
                }
            }
        }

        return $results;
    }

    /**
     * Hasil data dari query sql berupa array
     * 
     * @return array 
     */
    public static function result($hasil = NULL) {
        try {
            $countdata = substr_count(static::$_query, "WHERE");
            $string = static::$_query;
            $output = "";
            do {
                $result = preg_split("/(WHERE)/", static::$_query, 2, PREG_SPLIT_DELIM_CAPTURE); 
                static::$_query = preg_replace("/WHERE/", "AND", array_pop($result), $countdata, $count);
                $output .= implode($result); 
            } while ($count || !($output.=static::$_query));

            //$output = filter_var($output, FILTER_SANITIZE_STRING);
            $stmt = static::$_db->prepare($output);


            if (strpos($output, 'WHERE')) {
                foreach (static::$_where as $where => $value) {
                    $stmt->bindValue(":" . $where, $value);
                }
                
                if (strpos($output, 'UPDATE') !== false) {
                    if(is_array(static::$_datatable)){
                        foreach (static::$_datatable as $f => $v) {
                            if(is_array($v)){
                                foreach ($v as $keys => $values) {
                                    var_dump($values);
                                    $stmt->bindValue(':' . $keys, $values);
                                }
                            }else{
                                $stmt->bindValue(':' . $f, $v);
                            }
                        }
                        return $stmt->execute();
                    }else{
                        return $stmt->execute();
                    }
                } else if (strpos($output, 'DELETE') !== false) {
                    return $stmt->execute();
                } 
            }

            $stmt->execute();
            if (empty($hasil))
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->fetchAll($hasil);
            
        } catch (Exception $ex) {
            echo static::errormessage($ex);
        }
    }

    /**
     * Method errormessage berguna untuk menampilkan tampilan pesan error didalam area lingkup PDO
     * 
     * @param  PDOException $ex Menjalankan/memanggil blok catch apabila terjadi error
     * @return string          
     */
    public static function errormessage(PDOException $ex) {
        $kodeerror  = sprintf("%0.0f", strstr($ex->getMessage(), '1'));
        $regex      = preg_replace("#[^\w()/.%\-&/']#", " ", $ex->getMessage());
        $kesalahan  = substr($regex, strpos($regex, '1') + strlen($ex->getCode()));

        switch ($ex->getCode()) {
            case '1045':
            case '1049':
                echo "<div class='container'><h1>Terjadi Kesalahan Database</h1>
                      <p>Kode Error : " . $kodeerror . "</p>
                      <p>Kesalahan : " . $kesalahan . "</p>
                      <p>Nama File : " . $ex->getFile() . "</p> 
                      <p>Baris : " . $ex->getLine() . "</p></div>";
                break;
            case '42S02':
            case '42S22':
            case '42000':
            case '23000':
                echo "<div class='container'><h1>Terjadi Kesalahan Database</h1>
                      <p>Kode Error : " . $kodeerror . "</p>
                      <p>Kesalahan : " . $kesalahan . "</p>
                      <p>Nama File : " . $ex->getTrace(). "</p> 
                      <p>Baris : " . $ex->getTrace()[1]['line'] . "</p></div>";
                break;//$ex->getTrace()[1]['file']
        }
    }
}

?>