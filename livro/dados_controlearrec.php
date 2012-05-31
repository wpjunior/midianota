<?php 
	$livro = base64_decode($_GET['cod']);
	$sql_livro = mysql_query("
			SELECT 
				cad.nome,
				cad.inscrmunicipal, 
				cad.logo,
				if(cad.cnpj is null, cad.cpf, cad.cnpj) as cnpj, 
				livro.codcadastro,
				livro.periodo,
				DATE_FORMAT(livro.vencimento,'%d/%m/%Y') as vencimento,
				DATE_FORMAT(livro.geracao,'%d/%m/%Y') as geracao,
				livro.basecalculo,
				livro.reducaobc,
				livro.valoriss, 
				livro.valorissretido,
				livro.valorisstotal,
				livro.obs 				
				FROM livro
				INNER JOIN cadastro as cad ON cad.codigo=livro.codcadastro				
				WHERE livro.codigo = $livro");

$livro = mysql_fetch_object($sql_livro);
?>
<br /><br />
<table width="100%" style="border:1px solid #000000;">
    <tr>
    	<td width="80%">
        	<table width="100%">
		    	<tr>
                    <td width="30%">
                        <b>Nome:</b>
                    </td>
                    <td>
                         <?php echo $livro->nome;?>
                    </td>
                </tr>
                <tr>	
                    <td>
                        <b>Inscrição Municipal:</b>
                    </td>
                    <td>
                        <?php echo $livro->inscmunicipal;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>CNPJ/CPF:</b>
                    </td>
                    <td>
                        <?php echo $livro->cnpj;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Periodo:</b>
                    </td>
                    <td>
                        <?php echo $livro->Periodo;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Vencimento:</b>
                    </td>
                    <td>
                        <?php echo $livro->vencimento;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Geração:</b>
                    </td>
                    <td>
                       <?php echo $livro->geracao;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Base de Calculo:</b>
                    </td>
                    <td>
                        <?php echo $livro->basecalculo;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Valor do ISS</b>
                    </td>
                    <td>
                        <?php echo $livro->valoriss;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Valor do ISS Retido</b>
                    </td>
                    <td>
                        <?php echo $livro->valorissretido;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Valor do ISS Total</b>
                    </td>
                    <td>
                        <?php echo $livro->valorisstotal;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Observações</b>
                    </td>
                    <td>
                        <?php echo $livro->obs;?>
                    </td>
                </tr>
    		</table>
    	</td>
        <td align="left">
        	<a href="../livro/imprimir_controlearrec.php?livro=<?php echo $_GET['cod'];?>" target="_blank">
            	<img width="30" height="30" src="../sep/img/botao_imprimir.jpg" title="Imprimir" style="border:none;"/>
            </a>
        </td>
    </tr>    
    
</table>