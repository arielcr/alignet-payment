<form name="frmSolicitudPago" method="post" action="<?php echo $url_vpos; ?>">
<input type="hidden" name="IDACQUIRER" value="<?php echo $codigo_adquiriente; ?>" />
<input type="hidden" name="IDCOMMERCE" value="<?php echo $codigo_comercio; ?>" />
<input type="hidden" name="XMLREQ" value="<?php echo $array_get['XMLREQ'];?>" />
<input type="hidden" name="DIGITALSIGN" value="<?php echo $array_get['DIGITALSIGN'];?>" />
<input type="hidden" name="SESSIONKEY" value="<?php echo $array_get['SESSIONKEY'];?>" />
</form>


<script language="javascript" type="text/javascript">
    document.frmSolicitudPago.submit();
</script>