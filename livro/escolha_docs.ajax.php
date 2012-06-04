
    <script type="text/javascript" language="javascript" src="../sep/scripts/jquery.js"></script>
	<script src="../sep/scripts/padrao.js" type="text/javascript" language="javascript"></script>
    <script src="../sep/scripts/jquery-1.1.3.1.pack.js" type="text/javascript"></script>
    <script src="../sep/scripts/jquery.history_remote.pack.js" type="text/javascript"></script>
    <script src="../sep/scripts/jquery.tabs.pack.js" type="text/javascript"></script>
<?php 	

	require_once("../sep/inc/conect.php");
	require_once("../sep/inc/nocache.php");		
?>	
 <div class="conteudolb" id="conteudoDiv">    	
    	<div align="right">
    		<a style="font-size:36px" onClick="document.getElementById('DivAbas').innerHTML='';">
    			<img src="../img/fechar_30x30.png"></img>
    		</a>
    	</div>	       		
				
                <div id="container-1">
                    <ul>
                        <li><a href="#fragment-1"><span>Controle Arrecadação</span></a></li>
                        <li><a href="#fragment-2"><span>Notas Emitidas</span></a></li>
                        <li><a href="#fragment-3"><span>Notas Tomadas</span></a></li>
                    </ul>
                    <div id="fragment-1">
						Impressão do documento de arrecadação						
						<a href="../livro/imprimir_controlearrec.php?livro=<?php echo $_GET['cod'];?>" target="_blank">
            				<img width="30" height="30" src="../sep/img/botao_imprimir.jpg" title="Imprimir" style="border:none;"/>
			            </a>
						
						<?php //include("dados_controlearrec.php");?>
                    </div>
                    <div id="fragment-2">
                    	Impressão do documento de Notas Emitidas					
						<a href="../livro/imprimir_nfeemitidas.php?livro=<?php echo $_GET['cod'];?>" target="_blank">
            				<img width="30" height="30" src="../sep/img/botao_imprimir.jpg" title="Imprimir" style="border:none;"/>
			            </a>
                        <?php //include("livro/dados_notasemitidas.php");?>
                    </div>
                    <div id="fragment-3">
                    	Impressão do documento de Notas Tomadas					
						<a href="../livro/imprimir_nfetomadas.php?livro=<?php echo $_GET['cod'];?>" target="_blank">
            				<img width="30" height="30" src="../sep/img/botao_imprimir.jpg" title="Imprimir" style="border:none;"/>
			            </a>
                        <?php //include("livro/dados_notastomadas.php");?>
                    </div>
                </div>
        
        
        
    </div>
    <div id="fundoDiv" class="fundolb"></div>
