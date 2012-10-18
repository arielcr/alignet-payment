<?php

session_start();

include "vpos_plugin.php";

$llave_pub_signature_vpos = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $_SESSION['alignet_vpos_pub_signature_key']);
$llave_priv_cifrado_lyg = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $_SESSION['alignet_com_prv_crypto_key']);

$arrayIn = array();
$arrayIn['IDACQUIRER'] = $_SESSION['POST']['IDACQUIRER'];
$arrayIn['IDCOMMERCE'] = $_SESSION['POST']['IDCOMMERCE'];
$arrayIn['XMLRES'] = $_SESSION['POST']['XMLRES'];
$arrayIn['DIGITALSIGN'] = $_SESSION['POST']['DIGITALSIGN'];
$arrayIn['SESSIONKEY'] = $_SESSION['POST']['SESSIONKEY'];

$arrayOut = array();

$status = VPOSResponse($arrayIn, $arrayOut, $llave_pub_signature_vpos, $llave_priv_cifrado_lyg, $_SESSION['alignet_vinit']);

$_SESSION['arrayOut'] = $arrayOut;
$_SESSION['VPOSResponse'] = $status;

header("Location: ".$_SESSION['payment_alignet_process']);

?>