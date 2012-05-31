
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/

//Função para escoinder a div apos o clique
function EscondeDiv(div)
{
 document.getElementById(div).style.display='none';
}

//Função para validar o formulário de criação de novas bases de dados
function ValidaCreatedb()
	{
		if((document.frmNovaBase.txtPrefeitura.value=="")||(document.frmNovaBase.txtMunicipio.value=="")||(document.frmNovaBase.txtLink.value=="")||(document.frmNovaBase.txtUsuario.value=="")||(document.frmNovaBase.txtSenha.value=="")||(document.frmNovaBase.txtBanco.value=="")||(document.frmNovaBase.arqTopo.value=="")||(document.frmNovaBase.arqFundo.value=="")||(document.frmNovaBase.arqBrasao.value==""))
		{
			alert('Preencha os dados corretamente.');
			return false;
		}
	}
function ValidaLogin()
	{
		var i;
		var campo=document.forms[0];
		for (i=0; i<campo.elements.length; i++)
			{
				var valida=campo.elements[i].value;
				if (valida=='')
					{
						alert('Preencha os dados corretamente.');
						return false;
					}
			}
	}
