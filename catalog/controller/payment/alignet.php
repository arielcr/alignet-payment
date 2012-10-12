<?php

class ControllerPaymentAlignet extends Controller {

    protected function index() {

        $this->load->language('payment/alignet');

        $this->data['confirmar'] = $this->url->link('payment/alignet/request', '', 'SSL');
        $this->data['text_confirmar'] = $this->language->get('text_confirmar');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/alignet.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/alignet.tpl';
        } else {
            $this->template = 'default/template/payment/alignet.tpl';
        }

        $this->render();
    }

    public function request() {

        include $_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_plugin');

        $this->load->model('checkout/order');

        $orden = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $llave_pub_crypto_vpos = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_vpos_pub_crypto_key'));
        $llave_priv_firma_lyg = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_com_prv_signature_key'));

        $array_send['acquirerId'] = $this->config->get('alignet_adquiriente');
        $array_send['commerceId'] = $this->config->get('alignet_comercio');
        $array_send['purchaseOperationNumber'] = $orden['order_id'];
        $array_send['purchaseAmount'] = round($orden['total']) . "00";
        $array_send['purchaseCurrencyCode'] = $this->config->get('alignet_moneda');
        $array_send['commerceMallId'] = $this->config->get('alignet_mall');
        $array_send['language'] = $this->config->get('alignet_idioma');
        $array_send['terminalCode'] = $this->config->get('alignet_terminal');
        $array_send['billingFirstName'] = $orden['firstname'];
        $array_send['billingLastName'] = $orden['lastname'];
        $array_send['billingEMail'] = $orden['email'];
        $array_send['billingAddress'] = "";
        $array_send['billingZIP'] = "";
        $array_send['billingCity'] = "";
        $array_send['billingState'] = "";
        $array_send['billingCountry'] = "";
        $array_send['billingPhone'] = $orden['telephone'];

        $array_get['XMLREQ'] = "";
        $array_get['DIGITALSIGN'] = "";
        $array_get['SESSIONKEY'] = "";

        VPOSSend($array_send, $array_get, $llave_pub_crypto_vpos, $llave_priv_firma_lyg, $this->config->get('alignet_vinit'));

        $this->data['url_vpos'] = $this->config->get('alignet_url');
        $this->data['codigo_adquiriente'] = $this->config->get('alignet_adquiriente');
        $this->data['codigo_comercio'] = $this->config->get('alignet_comercio');
        $this->data['array_get'] = $array_get;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . "/template/payment/alignet_post.tpl")) {
            $this->template = $this->config->get('config_template') . "/template/payment/alignet_post.tpl";
        } else {
            $this->template = 'default/template/payment/alignet_post.tpl';
        }

        $this->response->setOutput($this->render());
    }

    public function response() {

        include $_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_plugin');

        $this->load->language('payment/alignet');

        $llave_pub_signature_vpos = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_vpos_pub_signature_key'));
        $llave_priv_cifrado_lyg = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $this->config->get('alignet_com_prv_crypto_key'));

        $arrayIn = array();
        $arrayIn['IDACQUIRER'] = $_POST['IDACQUIRER'];
        $arrayIn['IDCOMMERCE'] = $_POST['IDCOMMERCE'];
        $arrayIn['XMLRES'] = $_POST['XMLRES'];
        $arrayIn['DIGITALSIGN'] = $_POST['DIGITALSIGN'];
        $arrayIn['SESSIONKEY'] = $_POST['SESSIONKEY'];

        $arrayOut = array();

        if (VPOSResponse($arrayIn, $arrayOut, $llave_pub_signature_vpos, $llave_priv_cifrado_lyg, $this->config->get('alignet_vinit'))) {

            if ($this->config->get('alignet_mode') == "1") {
                $this->session->data['result_pruebas'] = "<pre>".print_r($arrayOut, true)."</pre>";
                $this->pruebas();
            } else {
                if ($arrayOut['errorCode'] == "00") {
                    $this->load->model('checkout/order');
                    $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('alignet_order_status_id'));
                    $this->redirect($this->url->link('checkout/success', '', 'SSL'));
                } else {
                    $this->session->data['error_alignet'] = $arrayOut['errorMessage'];
                    $this->redirect($this->url->link('payment/alignet/failure', '', 'SSL'));
                }
            }
        } else {
            $this->session->data['error_alignet'] = $this->language->get('text_error_alignet');
            $this->redirect($this->url->link('payment/alignet/failure', '', 'SSL'));
        }
    }

    public function failure() {

        $this->load->language('payment/alignet');

        $this->document->setTitle($this->language->get('heading_title_failure'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/cart'),
            'text' => $this->language->get('text_basket'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/checkout', '', 'SSL'),
            'text' => $this->language->get('text_checkout'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('payment/alignet/failure'),
            'text' => $this->language->get('text_failure'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title_failure'] = $this->language->get('heading_title_failure');
        $this->data['text_message_failure'] = $this->language->get('text_message_failure');

        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] = $this->url->link('checkout/cart');

        $this->data['error_alignet'] = $this->session->data['error_alignet'];

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . "/template/payment/alignet_failure.tpl")) {
            $this->template = $this->config->get('config_template') . "/template/payment/alignet_failure.tpl";
        } else {
            $this->template = 'default/template/payment/alignet_failure.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

    public function pruebas() {

        $this->load->language('payment/alignet');

        $this->document->setTitle($this->language->get('heading_title_pruebas'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/cart'),
            'text' => $this->language->get('text_basket'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('checkout/checkout', '', 'SSL'),
            'text' => $this->language->get('text_checkout'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'][] = array(
            'href' => $this->url->link('payment/alignet/pruebas'),
            'text' => $this->language->get('text_pruebas'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title_failure'] = $this->language->get('heading_title_pruebas');
        $this->data['text_message_failure'] = "";

        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] = $this->url->link('checkout/cart');

        $this->data['error_alignet'] = $this->session->data['result_pruebas'];

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . "/template/payment/alignet_failure.tpl")) {
            $this->template = $this->config->get('config_template') . "/template/payment/alignet_failure.tpl";
        } else {
            $this->template = 'default/template/payment/alignet_failure.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());
    }

}

?>