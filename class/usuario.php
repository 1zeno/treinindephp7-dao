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
            
        $this ->setData($results[0]);

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

        $this ->setData($results[0]);

        } else {

            throw new Exception("Login e/ou senha inválidos.");
        }

    }

    public function setData($data){
      
        $this -> setidusuario($data['id']);
        $this -> setdeslogin($data['deslogin']);
        $this -> setdessenha($data['dessenha']);
        $this -> setdtcadastro(new DateTime ($data['dtcadastro']));

    }

    public function insert(){

        $sql = new Sql();
        
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha()
            ));
        
        if (count($results) > 0){
            
            $this -> setData($results[0]);

        }
    }


    public function update($login,$password){

        $this -> setdeslogin($login);
        $this -> setdessenha($password);

        $sql = new Sql();

        $sql -> query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE id = :ID", array(":LOGIN" => $this -> getdeslogin(), ":PASSWORD" => $this -> getdessenha(), ":ID" => $this ->getidusuario() 
        ));
    }

    public function delete(){

        $sql = new Sql();

        $sql -> query("DELETE FROM tb_usuarios WHERE id = :ID", array(":ID" => $this -> getidusuario() 
        ));

        $this -> setidusuario(NULL);
        $this -> setdeslogin(NULL);
        $this -> setdessenha(NULL);
        $this -> setdtcadastro(new DateTime());
    
    }

    public function __construct($login = "", $password = ""){

        $this -> setdeslogin($login);
        $this -> setdessenha($password);

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