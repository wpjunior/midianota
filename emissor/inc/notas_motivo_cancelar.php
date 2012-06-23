<?php
$codigo = $_GET['hdcod'];
?>
<table width="100%" bgcolor="#CCCCCC">
    <tr>
        <td align="center">Informe o motivo do cancelamento da nota</td>
    </tr>
    <tr>
        <td align="center"><textarea name="txtMotivoCancelar" id="txtMotivoCancelar" class="texto" rows="10" cols="40"></textarea></td>
    </tr>
    <tr>
        <td align="center">
            <input type="hidden" name="btCancel" id="btCancel" value="<?php echo $codigo; ?>" />
            <input type="hidden" name="txtCodigo" value="<?php echo $codigo; ?>" />
            <input type="button" name="btCancela" value="Cancelar Nota" class="botao" onclick="if((ValidaFormulario('txtMotivoCancelar','Preencha o motivo do cancelamento!')) && (CancelarNota())){ document.getElementById('btCancel').value='Cancelar Nota';document.getElementById('frmPesquisar').submit();}" />
        </td>
    </tr>
</table>