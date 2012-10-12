<?php

class ControllerPaymentAlignet extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('payment/alignet');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('alignet', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');

        $this->data['entry_order_status'] = $this->language->get('entry_order_status');
        $this->data['entry_total'] = $this->language->get('entry_total');
        $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['entry_alignet_mode'] = $this->language->get('entry_alignet_mode');
        $this->data['entry_alignet_url'] = $this->language->get('entry_alignet_url');
        $this->data['entry_alignet_vinit'] = $this->language->get('entry_alignet_vinit');
        $this->data['entry_alignet_adquiriente'] = $this->language->get('entry_alignet_adquiriente');
        $this->data['entry_alignet_comercio'] = $this->language->get('entry_alignet_comercio');
        $this->data['entry_alignet_moneda'] = $this->language->get('entry_alignet_moneda');
        $this->data['entry_alignet_mall'] = $this->language->get('entry_alignet_mall');
        $this->data['entry_alignet_terminal'] = $this->language->get('entry_alignet_terminal');
        $this->data['entry_alignet_idioma'] = $this->language->get('entry_alignet_idioma');
        $this->data['entry_alignet_vpos_pub_crypto_key'] = $this->language->get('entry_alignet_vpos_pub_crypto_key');
        $this->data['entry_alignet_vpos_pub_signature_key'] = $this->language->get('entry_alignet_vpos_pub_signature_key');
        $this->data['entry_alignet_com_prv_crypto_key'] = $this->language->get('entry_alignet_com_prv_crypto_key');
        $this->data['entry_alignet_com_prv_signature_key'] = $this->language->get('entry_alignet_com_prv_signature_key');
        $this->data['entry_alignet_plugin'] = $this->language->get('entry_alignet_plugin');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/alignet', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('payment/alignet', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['alignet_url'])) {
            $this->data['alignet_url'] = $this->request->post['alignet_url'];
        } else {
            $this->data['alignet_url'] = $this->config->get('alignet_url');
        }

        if (isset($this->request->post['alignet_vinit'])) {
            $this->data['alignet_vinit'] = $this->request->post['alignet_vinit'];
        } else {
            $this->data['alignet_vinit'] = $this->config->get('alignet_vinit');
        }

        if (isset($this->request->post['alignet_adquiriente'])) {
            $this->data['alignet_adquiriente'] = $this->request->post['alignet_adquiriente'];
        } else {
            $this->data['alignet_adquiriente'] = $this->config->get('alignet_adquiriente');
        }

        if (isset($this->request->post['alignet_comercio'])) {
            $this->data['alignet_comercio'] = $this->request->post['alignet_comercio'];
        } else {
            $this->data['alignet_comercio'] = $this->config->get('alignet_comercio');
        }

        if (isset($this->request->post['alignet_moneda'])) {
            $this->data['alignet_moneda'] = $this->request->post['alignet_moneda'];
        } else {
            $this->data['alignet_moneda'] = $this->config->get('alignet_moneda');
        }

        if (isset($this->request->post['alignet_mall'])) {
            $this->data['alignet_mall'] = $this->request->post['alignet_mall'];
        } else {
            $this->data['alignet_mall'] = $this->config->get('alignet_mall');
        }

        if (isset($this->request->post['alignet_terminal'])) {
            $this->data['alignet_terminal'] = $this->request->post['alignet_terminal'];
        } else {
            $this->data['alignet_terminal'] = $this->config->get('alignet_terminal');
        }

        if (isset($this->request->post['alignet_idioma'])) {
            $this->data['alignet_idioma'] = $this->request->post['alignet_idioma'];
        } else {
            $this->data['alignet_idioma'] = $this->config->get('alignet_idioma');
        }

        if (isset($this->request->post['alignet_vpos_pub_crypto_key'])) {
            $this->data['alignet_vpos_pub_crypto_key'] = $this->request->post['alignet_vpos_pub_crypto_key'];
        } else {
            $this->data['alignet_vpos_pub_crypto_key'] = $this->config->get('alignet_vpos_pub_crypto_key');
        }

        if (isset($this->request->post['alignet_vpos_pub_signature_key'])) {
            $this->data['alignet_vpos_pub_signature_key'] = $this->request->post['alignet_vpos_pub_signature_key'];
        } else {
            $this->data['alignet_vpos_pub_signature_key'] = $this->config->get('alignet_vpos_pub_signature_key');
        }

        if (isset($this->request->post['alignet_com_prv_crypto_key'])) {
            $this->data['alignet_com_prv_crypto_key'] = $this->request->post['alignet_com_prv_crypto_key'];
        } else {
            $this->data['alignet_com_prv_crypto_key'] = $this->config->get('alignet_com_prv_crypto_key');
        }

        if (isset($this->request->post['alignet_com_prv_signature_key'])) {
            $this->data['alignet_com_prv_signature_key'] = $this->request->post['alignet_com_prv_signature_key'];
        } else {
            $this->data['alignet_com_prv_signature_key'] = $this->config->get('alignet_com_prv_signature_key');
        }

        if (isset($this->request->post['alignet_plugin'])) {
            $this->data['alignet_plugin'] = $this->request->post['alignet_plugin'];
        } else {
            $this->data['alignet_plugin'] = $this->config->get('alignet_plugin');
        }
        
        if (isset($this->request->post['alignet_mode'])) {
            $this->data['alignet_mode'] = $this->request->post['alignet_mode'];
        } else {
            $this->data['alignet_mode'] = $this->config->get('alignet_mode');
        }

        if (isset($this->request->post['alignet_total'])) {
            $this->data['alignet_total'] = $this->request->post['alignet_total'];
        } else {
            $this->data['alignet_total'] = $this->config->get('alignet_total');
        }

        if (isset($this->request->post['alignet_order_status_id'])) {
            $this->data['alignet_order_status_id'] = $this->request->post['alignet_order_status_id'];
        } else {
            $this->data['alignet_order_status_id'] = $this->config->get('alignet_order_status_id');
        }

        $this->load->model('localisation/order_status');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['alignet_geo_zone_id'])) {
            $this->data['alignet_geo_zone_id'] = $this->request->post['alignet_geo_zone_id'];
        } else {
            $this->data['alignet_geo_zone_id'] = $this->config->get('alignet_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['alignet_status'])) {
            $this->data['alignet_status'] = $this->request->post['alignet_status'];
        } else {
            $this->data['alignet_status'] = $this->config->get('alignet_status');
        }

        if (isset($this->request->post['alignet_sort_order'])) {
            $this->data['alignet_sort_order'] = $this->request->post['alignet_sort_order'];
        } else {
            $this->data['alignet_sort_order'] = $this->config->get('alignet_sort_order');
        }

        $this->template = 'payment/alignet.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/alignet')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>