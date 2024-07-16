<?php

define("BASE_URL", "http://tienda:81/");
define('CARPETA_IMAGENES', $_SERVER["DOCUMENT_ROOT"] . '/public/build/img/');

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function validarORedireccionar(string $url)
{
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) {
        header('Location: ${url}');
    }
    return $id;
}

function crearLog($tipo, $mensaje) {
    session_start();
    $log  = "Host: ". $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
        "Tipo: " . $tipo .PHP_EOL.
        "Mensaje: " . $mensaje .PHP_EOL.
        "Usuario: ". $_SESSION['nombre'] . PHP_EOL.
        "-------------------------" . PHP_EOL;
    file_put_contents('./log_'.date("Y_m_d").'.log', $log, FILE_APPEND);
}

function crearMensajeResultado($estado = false, $mensaje = "", $data = []): array {
    $resultado = [
        'estado' => $estado,
        'mensaje' => $mensaje,
        'data' => $data
    ];
    return $resultado;
}

function generarStringAleatorio($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}


function NumerosALetras($monto) 
{
    $maximo = pow(10,9);
	$unidad            = array(1=>"UNO", 2=>"DOS", 3=>"TRES", 4=>"CUATRO", 5=>"CINCO", 6=>"SEIS", 7=>"SIETE", 8=>"OCHO", 9=>"NUEVE");
	$decena            = array(10=>"DIEZ", 11=>"ONCE", 12=>"DOCE", 13=>"TRECE", 14=>"CATORCE", 15=>"QUINCE", 20=>"VEINTE", 30=>"TREINTA", 40=>"CUARENTA", 50=>"CINCUENTA", 60=>"SESENTA", 70=>"SETENTA", 80=>"OCHENTA", 90=>"NOVENTA");
	$prefijo_decena    = array(10=>"DIECI", 20=>"VEINTI", 30=>"TREINTA Y ", 40=>"CUARENTA Y ", 50=>"CINCUENTA Y ", 60=>"SESENTA Y ", 70=>"SETENTA Y ", 80=>"OCHENTA Y ", 90=>"NOVENTA Y ");
	$centena           = array(100=>"CIEN", 200=>"DOSCIENTOS", 300=>"TRESCIENTOS", 400=>"CUANTROCIENTOS", 500=>"QUINIENTOS", 600=>"SEISCIENTOS", 700=>"SETECIENTOS", 800=>"OCHOCIENTOS", 900=>"NOVECIENTOS");	
	$prefijo_centena   = array(100=>"CIENTO ", 200=>"DOSCIENTOS ", 300=>"TRESCIENTOS ", 400=>"CUANTROCIENTOS ", 500=>"QUINIENTOS ", 600=>"SEISCIENTOS ", 700=>"SETECIENTOS ", 800=>"OCHOCIENTOS ", 900=>"NOVECIENTOS ");
	$sufijo_miles      = "MIL";
	$sufijo_millon     = "UN MILLON";
	$sufijo_millones   = "MILLONES";
 
	//echo var_dump($monto); die;
 
	$base         = strlen(strval($monto));
	$pren         = intval(floor($monto/pow(10,$base-1)));
	$prencentena  = intval(floor($monto/pow(10,3)));
	$prenmillar   = intval(floor($monto/pow(10,6)));
	$resto        = $monto%pow(10,$base-1);
	$restocentena = $monto%pow(10,3);
	$restomillar  = $monto%pow(10,6);
 
	if (!$monto) return "";
 
    if (is_int($monto) && $monto>0 && $monto < abs($maximo)) 
    {            
		switch ($base) {
			case 1: return $unidad[$monto]; 
			case 2: return array_key_exists($monto, $decena)  ? $decena[$monto]  : $prefijo_decena[$pren*10]   . NumerosALetras($resto);
			case 3: return array_key_exists($monto, $centena) ? $centena[$monto] : $prefijo_centena[$pren*100] . NumerosALetras($resto);
			case 4: case 5: case 6: return ($prencentena>1) ? NumerosALetras($prencentena). " ". $sufijo_miles . " " . NumerosALetras($restocentena) : $sufijo_miles. " " . NumerosALetras($restocentena);
			case 7: case 8: case 9: return ($prenmillar>1)  ? NumerosALetras($prenmillar). " ". $sufijo_millones . " " . NumerosALetras($restomillar)  : $sufijo_millon. " " . NumerosALetras($restomillar);
		}
    } else {
        echo "ERROR con el numero - $monto<br/> Debe ser un numero entero menor que " . number_format($maximo, 0, ".", ",") . ".";
    }
 
	//return $texto;
}

function MontoMonetarioEnLetras($monto) 
{
 
	$monto = str_replace(',','',$monto); //ELIMINA LA COMA
 
	$pos = strpos($monto, '.');
 
	if ($pos == false)	{
		$monto_entero = $monto;
		$monto_decimal = '00';
	}else{
		$monto_entero = substr($monto,0,$pos);
		$monto_decimal = substr($monto,$pos,strlen($monto)-$pos);
		$monto_decimal = $monto_decimal * 100;
	}
 
	$monto = (int)($monto_entero);
 
	$texto_con = " CON $monto_decimal/100 SOLES";
 
	return NumerosALetras($monto).$texto_con; 
 
}

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}