<?php

header('Content-Type: text/html ; charset=utf-8');
echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\" />";

require_once 'model/CrudDAO.Class.php';
$dao = new CrudDAO();

$contatos = $dao->read("agenda_contato");
echo"<style type='text/css'> th, td{padding:10px;} </style>";
echo"<a href='novoContato.php'>Novo Contato</a><br/><br/>";
echo"<table border='1' cellspacing='0'>"
    ."<tr  style='padding:10px; margin:10px;'><th>Nome</th>  <th>Sobrenome</th>  <th>Gênero</th>  <th>Telefone</th>  <th>Celular</th> <th>E-mail</th><th colspan='2'>Controle</th></tr>";
foreach ($contatos as $contato) {
    echo"<tr >"
        ."<td>".$contato["nome"]."</td>"
        ."<td>".$contato["sobrenome"]."</td>"
        ."<td>".$contato["genero"]."</td>"            
        ."<td>".$contato["telefone"]."</td>"
        ."<td>".$contato["celular"]."</td>"
        ."<td>".$contato["email"]."</td>"
        ."<td><a href='novoContato.php?id=".$contato["id"]."'>Editar</td> <td><a href='controller/excluir.php?id=".$contato["id"]."'>Excluir</a></td>"
        ."</tr>";
}

echo"</table>";
