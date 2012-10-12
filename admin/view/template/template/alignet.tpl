<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">

                    <tr>
                        <td><?php echo $entry_alignet_mode; ?></td>
                        <td>
                            <select name="alignet_mode">
                                <option value="0" <?php echo ($alignet_mode=="0") ? "selected" : "" ;?> >No</option>
                                <option value="1" <?php echo ($alignet_mode=="1") ? "selected" : "" ;?> >Si</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><?php echo $entry_alignet_url; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_url" value="<?php echo $alignet_url; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_vinit; ?></td>
                        <td><input type="text" name="alignet_vinit" value="<?php echo $alignet_vinit; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_adquiriente; ?></td>
                        <td><input type="text" name="alignet_adquiriente" value="<?php echo $alignet_adquiriente; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_comercio; ?></td>
                        <td><input type="text" name="alignet_comercio" value="<?php echo $alignet_comercio; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_moneda; ?></td>
                        <td><input type="text" name="alignet_moneda" value="<?php echo $alignet_moneda; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_mall; ?></td>
                        <td><input type="text" name="alignet_mall" value="<?php echo $alignet_mall; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_terminal; ?></td>
                        <td><input type="text" name="alignet_terminal" value="<?php echo $alignet_terminal; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_idioma; ?></td>
                        <td><input type="text" name="alignet_idioma" value="<?php echo $alignet_idioma; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_vpos_pub_crypto_key; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_vpos_pub_crypto_key" value="<?php echo $alignet_vpos_pub_crypto_key; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_vpos_pub_signature_key; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_vpos_pub_signature_key" value="<?php echo $alignet_vpos_pub_signature_key; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_com_prv_crypto_key; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_com_prv_crypto_key" value="<?php echo $alignet_com_prv_crypto_key; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_com_prv_signature_key; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_com_prv_signature_key" value="<?php echo $alignet_com_prv_signature_key; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_alignet_plugin; ?></td>
                        <td><input style="width: 375px" type="text" name="alignet_plugin" value="<?php echo $alignet_plugin; ?>" /></td>
                    </tr>

                    <tr>
                        <td><?php echo $entry_total; ?></td>
                        <td><input type="text" name="alignet_total" value="<?php echo $alignet_total; ?>" /></td>
                    </tr>        
                    <tr>
                        <td><?php echo $entry_order_status; ?></td>
                        <td><select name="alignet_order_status_id">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                    <?php if ($order_status['order_status_id'] == $alignet_order_status_id) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_geo_zone; ?></td>
                        <td><select name="alignet_geo_zone_id">
                                <option value="0"><?php echo $text_all_zones; ?></option>
                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                    <?php if ($geo_zone['geo_zone_id'] == $alignet_geo_zone_id) { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><select name="alignet_status">
                                <?php if ($alignet_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td><input type="text" name="alignet_sort_order" value="<?php echo $alignet_sort_order; ?>" size="1" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?> 