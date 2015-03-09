<?php
/*******************************************************************
@A small web application in PHP 5. * OO to demonstrate how
@made the connection to the postgresql (in this case the postgreSQL 9.3) and
@an example of generic CRUD with PDO.
@Developed by Daniel Mello Siqueira: http://danielsiqueira.net
********************************************************************/
require_once 'DAO.php';
class CrudDAO extends DAO {

    public function __construct() {

        parent::__construct(); //Faz a Conexão com o banco através da do construtor da classe Pai Conexão
    }
    
        
    /**Criar tabela**/
      public function createTable($query) {
    try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $this->db->exec($query);
            $this->db->commit();
            $this->db = null;//Fecha conexão
           //echo"Tabela Criada com sucesso!";
        } catch (Exception $e) {
            echo "Não houve Criação! <br> Ocorreu um erro! <hr/>";
            echo $e->getMessage() . "<br>Error na linha:  ";
            echo "<b>" . $e->getTraceAsString() . "</b>";
            $this->db = null;
        }

 
    }
    
    
/********************Insere os dados**********************************/
    public function insert($tabela, Array $dados) {
  

        foreach ($dados as $inds => $vals) {
            $campos[] = $inds;
            $valores[] = $vals;
        }
        $campos = implode(",", $campos);
         
        $valores = "'" . implode("','", $valores) . "'";
            
        
        try {
            $this->db->beginTransaction();
            $sql = $this->db->exec("insert into {$tabela} ({$campos})"
            . " values({$valores})");
            if (!$sql) {
                $this->db->rollBack();
                throw new Exception("Não houve Inserção! <br> Ocorreu um erro! ");
            } else {
                $this->db->commit();
               // echo"Inserido com sucesso!";
                $this->db = null;//fecha conexão
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>Error na linha:  ";
            echo "<b>" . $e->getTraceAsString() . "</b>";
            $this->db = null;
        }
    }
/********************Insere os dados em Loop**********************************/    
        public function insertFree($tabela, Array $dados) {
  

        foreach ($dados as $inds => $vals) {
            $campos[] = $inds;
            $valores[] = $vals;
        }
        $campos = implode(",", $campos);
         
        $valores = "'" . implode("','", $valores) . "'";
            
        
        try {
            $this->db->beginTransaction();
            $sql = $this->db->exec("insert  into {$tabela} ({$campos}) values({$valores})");
            if (!$sql) {
                $this->db->rollBack();
                //throw new Exception("Não houve Inserção! <br> Ocorreu um erro! ");
            } else {
                $this->db->commit();
              // echo"Inserido com sucesso!";
            }
        } catch (Exception $e) {
          
           echo "<b>" . $e->getTraceAsString() . "</b>";
            $this->db = null;
        }
    }

    /* Chamo método dessa forma:
     * $db = new Model(); 
     * $db->conecta();//Faz a conexão com o banco
     * $db->insert('tabela', array('campo1'=>'valor1', 'campo2'=>'valor2'));
     */
/********************Le os dados do banco(Retorna os dados)**********************************/
    public function read($tabela, $campos=null, $criterio=null) {
        
        ($campos == null) ? $campos = "*" : $campos = $campos;
        ($criterio == null) ? $criterio = "" : $criterio = $criterio;
        try{
         $this->db->beginTransaction();
         //echo "select {$campos} from {$tabela} {$criterio}";
         $sql=$this->db->query("select {$campos} from {$tabela} {$criterio}");
             if (!$sql) {
                $this->db->rollBack();
                throw new Exception("Não é possível consultar! <br> Ocorreu um erro!");
            } else {
                $this->db->commit();
                return $sql;
                $this->db = null;
            }
        }
 catch (Exception $e){
      echo $e->getMessage() . "<br>Error na linha:  "; //Pega a mensagem de erro definida
            echo "<b>" . $e->getTraceAsString()."</b>"; //Mostra a linha do  erro! 
            $this->db = null;
 }
    }
/********************Atualiza os dados**********************************/
    public function update($tabela, Array $dados, $criterio) {

        foreach ($dados as $inds => $vals) {
            ////Se for inteiro atualiza como inteiro, senão acrescenta '' e atualiza como string
            (is_int($vals)) ? $vals = $vals : $vals = "'{$vals}'";
            $campos[] = "{$inds} ={$vals}";
        }
        $campos = implode(", ", $campos);
        try {
            $this->db->beginTransaction();
            $sql = $this->db->exec("update {$tabela} set {$campos} where {$criterio}");
            if (!$sql) {
                $this->db->rollBack();
                throw new Exception("Não houve Atualização! <br> Ocorreu um erro!");
            } else {
                $this->db->commit();
                $this->db = null;
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>Error na linha:  "; //Pega a mensagem de erro definida
            echo "<b>" . $e->getTraceAsString() . "</b>"; //Mostra a linha do  erro!  
            $this->db = null;
        }
    }
    
    public function updatefree($tabela, Array $dados, $criterio) {

        foreach ($dados as $inds => $vals) {
            ////Se for inteiro atualiza como inteiro, senão acrescenta '' e atualiza como string
            (is_int($vals)) ? $vals = $vals : $vals = "'{$vals}'";
            $campos[] = "{$inds} ={$vals}";
        }
        $campos = implode(", ", $campos);
        try {
            $this->db->beginTransaction();
            $sql = $this->db->exec("update {$tabela} set {$campos} where {$criterio}");
             $this->db->commit();
        
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>Error na linha:  "; //Pega a mensagem de erro definida
            echo "<b>" . $e->getTraceAsString() . "</b>"; //Mostra a linha do  erro!  
            $this->db = null;
        }
    }
    


    
    /********************Deleta os dados**********************************/
    public function delete($tabela, $criterio) {
        try {
           $this->db->beginTransaction();
            $sql = $this->db->exec("delete from {$tabela}  where {$criterio}");
            if (!$sql) {
            $this->db->rollBack();
                throw new Exception("A linha não foi excluída! <br> Ocorreu um erro!");
            } else {
           
              $this->db->commit();
                $this->db = null;
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "<br>Error na linha:  "; //Pega a mensagem de erro definida
            echo "<b>" . $e->getTraceAsString() . "</b>"; //Mostra a linha do  erro!
             $this->db = null;
        }
    }
    
    
    
    
    public function deletefree($tabela, $criterio) {
        try {
     
            $sql = $this->db->exec("delete from {$tabela}  where {$criterio}");
            if (!$sql) {
          
                throw new Exception("A linha não foi excluída! <br> Ocorreu um erro!");
            } 
        } catch (Exception $e) {           
             $this->db = null;
        }
    }   

}

?>
