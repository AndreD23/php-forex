<?php

//Define a paridade desejada
$pair = "EURUSD";

//Recebe a data e hora como parâmetro
$date = $_GET['date'];
$time = $_GET['time'];

//Formata a data e hora em um timestamp
$timestamp = strtotime($date . " " . $time);

//Adiciona 5 minutos ao timestamp
$endTimestamp = $timestamp + (5 * 60);
var_dump($endTimestamp);
die();

//Faz a requisição para a API de cotações de Forex
$url = "https://api.exchangerate-api.com/v4/latest/$pair";
$response = file_get_contents($url);
$data = json_decode($response, true);

var_dump($data['rates']);

//Captura a cotação do par na data e hora especificadas
$startPrice = $data['rates'][$pair];

//Faz a requisição para a API de cotações de Forex novamente com o timestamp final
$url = "https://api.exchangerate-api.com/v4/" . $endTimestamp . "/$pair";
$response = file_get_contents($url);
$data = json_decode($response, true);

//Captura a cotação do par no final do período de 5 minutos
$endPrice = $data['rates'][$pair];

//Verifica se o preço subiu ou desceu
if ($endPrice > $startPrice) {
    echo "O preço da paridade $pair subiu em 5 minutos.";
} else if ($endPrice < $startPrice) {
    echo "O preço da paridade $pair desceu em 5 minutos.";
} else {
    echo "O preço da paridade $pair não sofreu variação em 5 minutos.";
}
