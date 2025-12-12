<?php 
// config.php utilizando orientaçao a objetos agora

class Config {
    private static $instancia; // variável estática que irá realizar a conexão com o banco de dados 
    // é o pdo mas dentro da classe chamamos ele por meio do self
    
    public static function getConexao() {
        // se não tiver a instância aí a gente realiza a conexão se não ele passa direto
        if (!isset(self::$instancia)) {
            $caminho_banco = __DIR__ . '/banco.sqlite';

            try {
                self::$instancia = new PDO('sqlite:' . $caminho_banco);

                // aparecer logs dos erros com a conexão do banco
                self::$instancia->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);

                $query = "CREATE TABLE IF NOT EXISTS usuarios (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nome TEXT NOT NULL,
                    email TEXT NOT NULL, 
                    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
                )"; 

                self::$instancia->exec($query);

            } catch (PDOException $e) {
                echo "Erro fatal na conexão: " . $e->getMessage();
            }
        }
        
        //passa direto, isso evita da gente solicitar várias vezes a conexão...
        return self::$instancia;
    }
}

?>