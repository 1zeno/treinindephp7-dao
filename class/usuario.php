<?php 

class Usuario{

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getidusuario(){
        
        return $this -> idusuario;
    }

    public function setidusuario($value){

        $this -> idusuario = $value;

    }

    public function getdeslogin(){
        
        return $this -> deslogin;
    }

    public function setdeslogin($value){

        $this -> deslogin = $value;

    }

    public function getdessenha(){
        
        return $this -> dessenha;
    }

    public function setdessenha($value){

        $this -> dessenha = $value;

    }

    public function getdtcadastro(){
        
        return $this -> dtcadastro;
    }

    public function setdtcadastro($value){

        $this -> dtcadastro = $value;

    }

    public function loadbyid($id){

        $sql = new Sql();

        $results = $sql -> select("SELECT * FROM tb_usuarios WHERE id = :ID", array(":ID" => $id
        ));

        if(count($results) > 0){

        $row = $results[0];
            
        $this -> setidusuario($row['id']);
        $this -> setdeslogin($row['deslogin']);
        $this -> setdessenha($row['dessenha']);
        $this -> setdtcadastro(new DateTime ($row['dtcadastro']));

        }

    }

    public static function getList(){

        $sql = new Sql();

        return $sql -> select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

    public static function search($login){

        $sql = new Sql();

        return $sql -> select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin ", array(':SEARCH' => "%".$login."%"));

    }

    public function login($login,$password){

        $sql = new Sql();

        $results = $sql -> select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN", array(
        ":LOGIN" => $login
        ));
        //print_r($results);

        if(count($results) > 0){

        $row = $results[0];
          
        $this -> setidusuario($row['id']);
        $this -> setdeslogin($row['deslogin']);
        $this -> setdessenha($row['dessenha']);
        $this -> setdtcadastro(new DateTime ($row['dtcadastro']));

        } else {

            throw new Exception("Login e/ou senha inválidos.");
        }

    }

    public function __toString(){
              
         $result = json_encode(array(
            "id" => $this -> getidusuario(),
            "deslogin" => $this -> getdeslogin(),
            "dessenha" => $this -> getdessenha(),
            "dtcadastro" => $this -> getdtcadastro() ->format("d-m-y H:i:s")
            
            )                
        );

        return $result;

    }
}

?>