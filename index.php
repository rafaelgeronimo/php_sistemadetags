<?php
    try {
        $pdo = new PDO("mysql:dbname=php_tags;host=localhost", "root", "");
    }catch(PDOException $e) {
        echo "ERRO: ".$e->getMessage();
        exit;
    }

    $sql = "SELECT tags FROM usuarios";
    $sql = $pdo->query($sql);
    if($sql->rowCount() > 0) {
        $lista = $sql->fetchAll();
        $tags = array();

        foreach($lista as $usuario) {
            $palavras = explode(",", $usuario['tags']);
            foreach($palavras as $palavra) {
                $palavra = trim($palavra);
                if(isset($tags[$palavra])) {
                    $tags[$palavra]++;
                } else {
                    $tags[$palavra] = 1;
                }
            }
        }

        arsort($tags);

        $palavras = array_keys($tags);
        $contagens = array_values($tags);
        $maior = max($contagens);
        $tamanhos = array(11, 15, 20, 30);
        for($i=0;$i<count($palavras);$i++){
            $n = $contagens[$i] / $maior;
            $h = ceil($n * count($tamanhos));

            echo "<p style='font-size:".$tamanhos[$h-1]."px'>".$palavras[$i]." (".$contagens[$i].")</p>";
        }
    }
?>