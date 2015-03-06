<?php

class DAO {
  
     protected $db ;
     private   $host="localhost";//seu host
     private   $dbname="agenda";//o nome do seu banco
     private   $user="daniel";//seu usuário
     private   $senha="123";//sua senha
     
    public function __construct() {

        try {
           $con = $this->db = new PDO("pgsql:host=".$this->host."; dbname=".$this->dbname."; user=".$this->user."; password=".$this->senha."");
            if (!$con) {
                throw new Exception("Não foi possível conectar ao banco!");
            } //else{ echo"Conectado ao PostgreSQL com sucesso!<hr/>";}
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>Error na linha:  ";
            echo "<b>" . $e->getLine() . "</b>";
            $this->db = null;
        }
    }
    
    public function fechar(){
         $this->db = null;
        
    }

}


 ?>
