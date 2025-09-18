<?php
class Usuario{
    public $id_usuario;
    public $nome_usuario;
    public $email_usuario;
    private $senha_usuario;
    public $tipo_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;


        public function __construct($db){
        $this->db = $db;
    }
    
    // Buscar todos os usuários não excluídos
    function buscarUsuarios(){
        $sql = "SELECT * FROM usuarios WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetvchAll(PDO::FETCH_ASSOC);
    }
    }