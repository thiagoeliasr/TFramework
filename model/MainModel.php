<?php

class MainModel
{
    /**
     * @todo: Passar as configurações do banco de dados p/ um arquivo config
     */    
    private $database;
    private $hostname;
    private $username;
    private $password;
    private $connection;
    protected $model;
    
    public function __construct()
    {
        $this->database = 'tf_example';
        $this->hostname = 'localhost';
        $this->username = 'root';
        $this->password = 'root';
        
        $modelName = strtolower(get_called_class());
        $this->model = $modelName;
        
    }
    
    /**
     * Abre uma conexão com o banco mysql
     * @throws Exception
     */
    private function connectDb()
    {
        $this->connection = mysqli_connect(
            $this->hostname,
            $this->username,
            $this->password,
            $this->database
        );
        
        if (mysqli_connect_errno())
        {
            throw new Exception('Erro ao conectar ao banco: ' 
                    . mysqli_connect_error());
        }
    }
    
    /**
     * Fecha a conexão com o banco
     */
    private function closeDb()
    {
        mysqli_close($this->connection);
    }
    
    /**
     * Efetua uma query
     * @param string $query
     * @param boolean $insert[optional] Indica se a operação é de inserção ou não.
     * @return mixed
     */
    public function execSql($query, $insert = false)
    {
        try {
            $this->connectDb();
            
            $resultSet = mysqli_query($this->connection, $query);
            
            if (!$insert) {
                $results = array();
                while ($result = mysqli_fetch_array($resultSet)) {
                    $results[] = $result;
                }

                return $results;
            } else {
                return $resultSet;
            }
            
            $this->closeDb();
            
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    /**
     * Inserts an array into the database.
     * @param mixed $fields Fields corresponding the database.
     * @return mixed
     */
    public function insert($fields)
    {
        $query = "
            INSERT INTO
                {$this->model}
            SET\n
        ";
                
        $length = count($fields);
        $i = 0;
        foreach ($fields as $key => $value) {
            $query.= "\t{$key} = '{$value}'";
            if (($i + 1) < $length)
                $query.= ",\n";
            
            $i++;
        }
        
        try {
            return $this->execSql($query, true);
        } catch (Exception $e) {
            die('An error ocurred: ' . $e->getMessage());
        }
    }
    
    /**
     * Fetch data from database
     * @param mixed $fields Array with the name of fields you want to fetch
     * @param mixed $args Extra params related to your query
     *        array('where' => array('field' => 'condition')),
     *        array('order' => array('field' => 'order')),
     *        array('limit' => [limit value]),
     *        array('offset' => [offset value])
     * @return mixed
     */
    public function fetch($fields = array(), $args = array())
    {
        
        $strFields = '';
        
        if (count($fields) > 0) {
            $i = 0;
            $length = count($fields);
            foreach ($fields as $field) {
                $strFields.= "{$field}";
                if (($i + 1) < $length)
                    $strFields.= ",";
                    
                $i++;
            }
        } else {
            $strFields = "*";
        }
        
        $query = "
            SELECT
                {$strFields}
            FROM
                {$this->model}
        ";

        if (isset($args['where']) && is_array($args['where'])) {
            $query.= "
                WHERE
            ";
            
            $i = 0;
            $length = count($args['where']);
            foreach ($args['where'] as $condition => $value) {
                $query.= "{$condition} {$value}";
                if (($i + 1) < $length)
                    $query.= " AND \n\t";
                $i++;
            }
        }
        
        if (isset($args['order']) && is_array($args['order'])) {
            
            $query.= "
                ORDER BY
            ";
            
            $i = 0;
            $length = count($args['order']);
            foreach ($args['order'] as $field => $order) {
                $query.= "{$field} {$order}";
                if (($i + 1) < $length)
                    $query.= ",";
            }
        }
        
        if (isset($args['limit']) && !empty($args['limit'])) {
            $query.= "
                LIMIT {$args['limit']}
            ";
        }
        
        if (isset($args['offset']) && !empty($args['offset'])) {
            $query.= "
                OFFSET {$args['offset']}
            ";
        }
        
        try {
            return $this->execSql($query);
        } catch (Exception $e) {
            die('An error ocurred: ' + $e->getMessage());
        }
    }
    
}

