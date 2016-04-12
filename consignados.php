<?php
include("./conf/config.php");
protegePagina();
include './conf/functions.php';
require_once './conf/versao.php';
$usuario=$_SESSION['usuarioID'];
//Apagar cmovimentos
if (isset($_GET['acao']) && $_GET['acao'] == 'apagar') {
    $id = $_GET['id'];
    $log=mysql_query("SELECT * FROM cmovimentos WHERE id='$id'");
    $logexc=mysql_fetch_array($log);
    $idmov=$logexc['id'];
    $tipomov=$logexc['tipo'];
    $descmov=$logexc['descricao'];
    $valormov=$logexc['valor'];
    $catmov=$logexc['cat'];
    $contamov=$logexc['conta'];
    $dataexc = date("Ymd");
	
    mysql_query("INSERT INTO cexclusoes (id_mov_exc,tipo_mov,desc_mov,valor_mov,cat_mov,conta_mov,data_exc,usuario_mov) values ('$idmov','$tipomov','$descmov','$valormov','$catmov','$contamov','$dataexc','$usuario')");
    mysql_query("DELETE FROM cmovimentos WHERE id='$id'");
    mysql_query("DELETE FROM chistorico WHERE id_mov='$id'");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=2");
    exit();
}
//Editar ccategorias
if (isset($_POST['acao']) && $_POST['acao'] == 'editar_cat') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];

    mysql_query("UPDATE ccategorias SET nome='$nome' WHERE id='$id'");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=3");
    exit();
}

//Apagar ccategorias
if (isset($_GET['acao']) && $_GET['acao'] == 'apagar_cat') {
    $id = $_GET['id'];

    $qr=mysql_query("SELECT c.id FROM cmovimentos g, ccategorias c WHERE c.id=g.cat && c.id=$id");
    if (mysql_num_rows($qr)!==0){
        header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_err=1");
        exit();
    }
    else{
    mysql_query("DELETE FROM ccategorias WHERE id='$id'");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=2");
    exit();
	}
}

//Editar cmovimentos
if (isset($_POST['acao']) && $_POST['acao'] == 'editar_mov') {
    $id = $_POST['id'];
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
    $tipo = $_POST['tipo'];
    $cat = $_POST['cat'];
    $descricao = $_POST['descricao'];
    $valor = str_replace(",", ".", $_POST['valor']);
    $dataed = date("Ymd");
	$qred=mysql_query("SELECT * FROM cmovimentos WHERE id='$id'");
	$rowed=mysql_fetch_array($qred);
	
if (empty($valor)){ 
echo "<script>
alert('O campo VALOR é obrigatório, e precisa ser diferente de zero para editar.'); location.href='index.php'; historico.go(-1);
</script>";
exit();
}
	if ($dia!=$rowed['dia']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','1','$dataed','1','$usuario')");
    echo mysql_error();}

	if ($mes!=$rowed['mes']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','2','$dataed','1','$usuario')");
    echo mysql_error();}
	
	if ($ano!=$rowed['ano']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','3','$dataed','1','$usuario')");
    echo mysql_error();}
	
	if ($tipo!=$rowed['tipo']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','4','$dataed','1','$usuario')");
    echo mysql_error();}
	
	if ($cat!=$rowed['cat']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','5','$dataed','1','$usuario')");
    echo mysql_error();}
	
	if ($descricao!=$rowed['descricao']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','6','$dataed','1','$usuario')");
    echo mysql_error();}
	
	if ($valor!=$rowed['valor']){
    mysql_query("UPDATE cmovimentos SET dia='$dia', mes='$mes', ano='$ano', tipo='$tipo', cat='$cat', descricao='$descricao', valor='$valor', edicao='Editado' WHERE id='$id'");
	mysql_query("INSERT INTO chistorico (id_mov,just_id,data,conta_mov,usuario) values ('$id','7','$dataed','1','$usuario')");
    echo mysql_error();}
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=3");
    exit();
}

//Cadastrar ccategorias
if (isset($_POST['acao']) && $_POST['acao'] == 2) {
    $nome = $_POST['nome'];

    mysql_query("INSERT INTO ccategorias (nome,usuario) values ('$nome','$usuario')");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&cat_ok=1");
    exit();
}

//Lançar cmovimentos
if (isset($_POST['acao']) && $_POST['acao'] == 1) {
    $data = $_POST['data'];
    $tipo = $_POST['tipo'];
    $cat = $_POST['cat'];
    $descricao = $_POST['descricao'];
    $valor_recebido = str_replace(".", "", $_POST['valor']);
	$valortotal = str_replace( ",", ".",$valor_recebido);
	$parcelas = $_POST['parcelas'];
	$valor = @$valortotal/$parcelas;
    $t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];

if (empty($valor)){
echo "<script>
alert('O campo VALOR é obrigatório, e precisa ser diferente de zero.'); location.href='index.php'; historico.go(-1);
</script>";
exit;
}
	$n=1;
	while ($n <= $parcelas) {
    mysql_query("INSERT INTO cmovimentos (dia,mes,ano,tipo,descricao,valor,cat,conta,nparcela,parcelas,usuario) values ('$dia','$mes','$ano','$tipo','$descricao','$valor','$cat','1','$n','$parcelas','$usuario')");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano'] . "&ok=1");
	if ($mes<=11){
	$mes++;}
	else{
	$mes = 1;
	$ano++;}
	$n++;
	}
	exit();
}

//Cadastrar orçamento
if (isset($_POST['acao']) && $_POST['acao'] == 'cad_orcamento') {
    $valor_recebido = str_replace(".", "", $_POST['valor']);
	$valor_orcamento = str_replace( ",", ".",$valor_recebido);
	$tipo = $_POST['tipo'];
    $data = $_POST['data'];
	$t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];
	$valida_meses=12-$mes+1;
	
if (empty($valor_orcamento)){
echo "<script>
alert('O campo VALOR é obrigatório, e precisa ser diferente de zero.'); location.href='index.php'; historico.go(-1);
</script>";
exit;
}
	if ($tipo!=0){
    mysql_query("INSERT INTO corcamento (mes,ano,valor,conta,usuario) values ('$mes','$ano','$valor_orcamento','1','$usuario')");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano']);
	exit();
	}
	$n=1;
	while ($n <= $valida_meses) {
    mysql_query("INSERT INTO corcamento (mes,ano,valor,conta,usuario) values ('$mes','$ano','$valor_orcamento','1','$usuario')");
    echo mysql_error();
    header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano']);
	if ($mes<=11){
	$mes++;}
	$n++;
	}
	exit();
}

//Editar orçamento
if (isset($_POST['acao']) && $_POST['acao'] == 'ed_orcamento') {
    $valor_recebido = str_replace(".", "", $_POST['valor']);
	$valor_orcamento = str_replace( ",", ".",$valor_recebido);
	$tipo = $_POST['tipo'];
    $data = $_POST['data'];
	$t = explode("/", $data);
    $dia = $t[0];
    $mes = $t[1];
    $ano = $t[2];
	$valida_meses=12-$mes+1;
	
if (empty($valor_orcamento)){
echo "<script>
alert('O campo VALOR é obrigatório, e precisa ser diferente de zero.'); location.href='index.php'; historico.go(-1);
</script>";
exit();
}
	if ($tipo!=0){
	mysql_query("UPDATE corcamento SET valor='$valor_orcamento' WHERE mes='$mes' && conta='1' && usuario='$usuario'");
    echo mysql_error();
	header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano']);
    exit();
	}
    mysql_query("UPDATE corcamento SET valor='$valor_orcamento' WHERE mes>=$mes && ano='$ano' && conta='1' && usuario='$usuario'");
    echo mysql_error();
	header("Location: ?mes=" . $_GET['mes'] . "&ano=" . $_GET['ano']);
    exit();
}

//Boas vindas em função da hora
$hora = date('G');
if (($hora >= 0) AND ($hora < 6)) {
$mensagem = "Boa noite";
} else if (($hora >= 6) AND ($hora < 12)) {
$mensagem = "Bom dia";
} else if (($hora >= 12) AND ($hora < 18)) {
$mensagem = "Boa tarde";
} else {
$mensagem = "Boa noite";
}

//Mês e ano hoje
if (isset($_GET['mes']))
    $mes_hoje = $_GET['mes'];
else
    $mes_hoje = date('m');

if (isset($_GET['ano']))
    $ano_hoje = $_GET['ano'];
else
    $ano_hoje = date('Y');

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title id='titulo'>CONSIGNADOS Jaqueline Arteira</title>
<link href="./conf/img/favicon.png" rel="icon" type="image/png"/>
<meta name="LANGUAGE" content="Portuguese" />
<meta name="AUDIENCE" content="all" />
<meta name="RATING" content="GENERAL" />
<link href="./conf/css/styles.css" rel="stylesheet" type="text/css" />
<link id="scrollUpTheme" rel="stylesheet" href="./conf/css/image.css">
<link href="../css/menubar.css" rel="stylesheet" type="text/css" id="scrollUpTheme">
<link rel="stylesheet" href="./conf/css/calculadora.css">
<script LANGUAGE="JavaScript" src="./conf/js/scripts.js"></script>
<script src="./conf/js/jquery.js"></script>
<script src="./conf/js/jquery.scroll.topo.js"></script>
<script src="./conf/js/jquery.easing.js"></script>
<script src="./conf/js/jquery.easing.compatibilidade.js"></script>
<script LANGUAGE="JavaScript" src="./conf/js/jquery.validar.formulario.js"></script>
<script src="./conf/js/jquery.calc.js"></script>
<script src="./conf/js/jquery.calculadora.js"></script>
<script>
(function ($) {
$.getQuery = function (query) {
	query = query.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
	var expr = '[\\?&]' + query + '=([^&#]*)';
	var regex = new RegExp(expr);
	var results = regex.exec(window.location.href);
		if (results !== null) {
		return results[1];
		} else {
		return false;
		}
	};
})(jQuery);

$(function () {

	$('.image-switch').click(function () {
	window.location = '?theme=image';
	});

	if ($.getQuery('theme') === 'image') {
	$(function () {
		$.scrollUp({
			animation: 'fade',
			activeOverlay: 'false',
			scrollImg: {
			active: true,
			type: 'background',
			src: './conf/img/topo.png'
			}
		});
	});
$('#scrollUpTheme').attr('href', './conf/css/image.css?1.1');
$('.image-switch').addClass('active');
} else {
	$(function () {
	$.scrollUp({
		animation: 'slide',
		activeOverlay: 'false'
		});
	});
$('#scrollUpTheme').attr('href', './conf/css/image.css?1.1');
$('.image-switch').addClass('active');
}
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#formulario_lancamento').validate({
			rules: {
				valor: {
					required: true,
				},
				parcelas: {
					required: true,
					digits: true
				},
			},
			messages: {
				valor: {
					required: "Campo obrigatório.",
				},
				parcelas: {
					required: "Campo obrigatório.",
					digits: "Digite apenas números."
				},
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#formulario').validate({
			rules: {
				novasenha: {
					required: true,
					minlength: 6
				},
				novasenhaconf: {
					required: true,
					equalTo: "#novasenha"
				},
			},
			messages: {
				novasenha: {
					required: "Campo obrigatório.",
					minlength: "Mínimo 6 caracteres."
				},
				novasenhaconf: {
					required: "Campo obrigatório.",
					equalTo: "Senhas n&atilde;o conferem."
				},
			}
		});
	});
</script>
<script>
function passwordStrength(password)
{
	var desc = new Array();
	desc[0] = "";
	desc[1] = "";
	desc[2] = "";
	desc[3] = "";
	desc[4] = "";
	desc[5] = "";
	var score   = 0;
	if (password.length > 6) score++;
	if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;
	if (password.match(/\d+/)) score++;
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
	if (password.length > 12) score++;
	document.getElementById("passwordDescription").innerHTML = desc[score];
	document.getElementById("passwordStrength").className = "strength" + score;
}
</script>
<script>
$(function () {
	$.calculator.setDefaults({showOn: 'both', buttonImageOnly: true, buttonImage: './conf/img/calc.png'});
	$('#valor').calculator(); //Calculadora comum para lançamento de cmovimentos
	$('#valororcamento').calculator({layout: $.calculator.scientificLayout}); //Calculadora cientifica para lançamento de orçamento
	$('#edorcamento').calculator({layout: $.calculator.scientificLayout}); //Calculadora cientifica para edição de orçamento
});
</script>


</head>
<body style="padding:10px">

<table  width="100%" align="center" cellpadding="1" cellspacing="5"   background="imagens/menubar_bg.gif" class="we">
<tr>
<td colspan="11"  align="center" valign="middle" > <img src="imagens/saco.png" alt="#JaquelineArteira" width="49" height="45" align="left">         
  <h2><a href=index.php style="color:#FFFF00"> Movimento da Loja</a> | <a href=consignados.php style="color:#FFFFFF">Consignados</a> | <a href=servico.php style="color:#FFFF00">Servi&ccedil;os</a></h2>
</td>
<td colspan="2" align="right">
<a style="color:#FFF" href="?mes=<?php echo date('m')?>&ano=<?php echo date('Y')?>">Hoje:<strong> <?php echo date('d')?> de <?php echo mostraMes(date('m'))?> de <?php echo date('Y')?></strong></a>&nbsp; 
</td>
</tr>
<tr>
<td>
<select onChange="location.replace('?mes=<?php echo $mes_hoje?>&ano='+this.value)">
<?php
for ($i=2015;$i<=2020;$i++){
?>
<option value="<?php echo $i?>" <?php if ($i==$ano_hoje) echo "selected=selected"?> ><?php echo $i?></option>
<?php }?>
</select>
</td>
<?php
for ($i=1;$i<=12;$i++){
	?>
    <td align="center" style="<?php if ($i!=12) echo "border-right:1px solid #FFFFFF;"?> padding-right:5px">
    <a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>" style="
    <?php if($mes_hoje==$i){?>    
    color:#448ED3; font-size:16px; font-weight:bold; background-color:#FFFFFF; padding:5px
    <?php }else{?>
    color:#FFFFFF;  font-size:16px;
    <?php }?>
    ">
    <?php echo mostraMes($i);?>
    </a>
    </td>
<?php
}
?>
</tr>
</table>

<table width="100%" align="center" cellpadding="5" cellspacing="0" class="well">
<tr>
<?php
$qrvisita=mysql_query("SELECT * FROM usuarios where id='$usuario'");
$rowvisita=mysql_fetch_array($qrvisita);

$qracesso=mysql_query("SELECT * FROM usuarios where id='$usuario'");
$rowacesso=mysql_fetch_array($qracesso);
$n=$rowacesso['n_acesso_f'];
$n_acesso=$n+1;
?>
<td>
<b><font color="#035D81" size=1><?php if ($n>0) echo "Ultimo acesso: ".date('d/m/Y H:i:s', strtotime($rowvisita['ultimavisita'])); else echo ""?></font> <font color="#035D81" size=1><?php echo"Acesso N&ordm;: "?><?php if ($n=0) echo "1"; else echo"$n_acesso" ?></font>
</td>
<td><font color="#035D81" size=3><?php echo $mensagem?><?php echo " <img src='imagens/xyko.png' width='25' height='25'> "?><?php echo $_SESSION['usuarioNome'];?><?php echo " "?><?php echo $_SESSION['usuarioSobrenome'];?>.</font>
</td>
<td align="right" style="font-size:13px; color:rgba(4, 45, 191, 1)">
<a href="javascript:;" style="font-size:12px; color:rgba(4, 45, 191, 1)" onClick="abreFecha('orcamento')"><img src="imagens/orca.png" width="16" height="16"> Or&ccedil;amento </a>
<a href="javascript:;" style="font-size:12px; color:rgba(4, 45, 191, 1)" onClick="abreFecha('alterar_senha')"><img src="imagens/senha.png" width="16" height="16"> Alterar senha </a>
<a href="logout.php" style="font-size:12px; color:rgba(4, 45, 191, 1)"><img src="imagens/sair.png" width="16" height="16"><?php echo "  Sair "?></a>
</td>
</tr>
<tr>
<td>

</td>
</tr>
</table>

<table cellpadding="5" cellspacing="0" width="1000" align="center" >
<tr style="display:none; background-color:#ffffff" id="alterar_senha">
<td align="left" class="welll">
<form id="formulario" method="post" action="cadastro.php">
<input type="hidden" name="acao" value="alterar_senha" />
<input type="hidden" name="pagina" value="index.php" />
<input type="hidden" name="usuario" value="<?php echo $usuario?>" />
<b>Nova senha:</b> <input type="password" name="novasenha" id="novasenha" onKeyUp="passwordStrength(this.value)"> <b>Confirmar nova senha:</b> <input type="password" name="novasenhaconf" id="novasenhaconf"><br>
<label for="passwordStrength"><font size=2>For&ccedil;a da senha</font></label><br>
<div id="passwordDescription"></div>
<div id="passwordStrength" class="strength0"></div>
<p align="right">
<input type="submit" class="btn-warning" value="Alterar" /></p>
</form>
</td>
</tr>
</table>

<table cellpadding="5" cellspacing="0" width="1000" align="center">
<?php
$qr=mysql_query("SELECT SUM(valor) as total FROM corcamento WHERE mes='$mes_hoje' && ano='$ano_hoje' && conta=1 && usuario='$usuario'");
$row=mysql_fetch_array($qr);
$total=$row['total'];

$qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysql_fetch_array($qr);
$gasto=$row['total'];
$resta=$total-$gasto;
$percento = @round (($gasto/$total) * 100,2);

if ($percento>100){
	$comp=100;
}
if ($percento<=100){
	$comp=$percento;
}

//Percentual do orçamento anual
$qra=mysql_query("SELECT SUM(valor) as total FROM corcamento WHERE ano='$ano_hoje' && conta=1 && usuario='$usuario'");
$rowa=mysql_fetch_array($qra);
$total_ano=$rowa['total'];

$qra=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=1 && usuario='$usuario' && ano='$ano_hoje'");
$rowa=mysql_fetch_array($qra);
$gasto_ano=$rowa['total'];
$resta_ano=$total_ano-$gasto_ano;
$percento_ano = @round (($gasto_ano/$total_ano) * 100,2);

if ($percento_ano>100){
	$comp_ano=100;
}
if ($percento_ano<=100){
	$comp_ano=$percento_ano;
}

//Percentual do orçamento dos consignados
$qrc=mysql_query("SELECT SUM(valor) as total FROM corcamento WHERE mes='$mes_hoje' && ano='$ano_hoje' && conta>1 && usuario='$usuario'");
$rowc=mysql_fetch_array($qrc);
$total_cart=$rowc['total'];

$qrc=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta>1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$rowc=mysql_fetch_array($qrc);
$gasto_cart=$rowc['total'];
$resta_cart=$total_cart-$gasto_cart;
$percento_cart = @round (($gasto_cart/$total_cart) * 100,2);

if ($percento_cart>100){
	$comp_cart=100;
}
if ($percento_cart<=100){
	$comp_cart=$percento_cart;
}
?>
<tr style="display:none;" id="orcamento" class="welll">
<td align="left" style="font-size:14px; color:rgb(0, 0, 0)" class="welll">
<a href="javascript:;" style="font-size:12px" onClick="abreFecha('lancar_orcamento')" title="Gereciar orçamento" >Or&ccedil;amento mensal: <?php echo formata_dinheiro($gasto)?><?php echo " de "?><?php echo formata_dinheiro($total)?><?php echo " resta "?><font color="<?php if ($resta <= 0) echo "#C00"?>"><?php echo formata_dinheiro($resta)?></font>.</a><br>
<style type="text/CSS">
.outter{
	height:20px;
	width:1000px;
	border:solid 0px #000;
}
.inner{
	height:20px;
	width:<?php echo $comp ?>%;
	background: <?php if (($percento >0) AND ($percento <=65)) echo "rgb(180,221,180); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(180,221,180,1) 0%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 30%, rgba(131,199,131,1) 42%, rgba(0,138,0,1) 100%, rgba(0,87,0,1) 100%, rgba(0,36,0,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=0 ); /* IE6-9 */"; else if (($percento >65) AND ($percento <=85)) echo "rgb(252,243,188); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(252,243,188,1) 0%, rgba(252,232,78,1) 50%, rgba(248,219,0,1) 51%, rgba(251,239,147,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcf3bc', endColorstr='#fbef93',GradientType=0 ); /* IE6-9 */"; else echo "rgb(246,25,0); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(246,25,0,1) 16%, rgba(186,0,0,1) 47%, rgba(246,25,0,1) 87%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f61900', endColorstr='#f61900',GradientType=0 ); /* IE6-9 */"?>
}
</style>
<style type="text/CSS">
.outter2{
	height:20px;
	width:1000px;
	border:solid 0px #000;
}
.inner2{
	height:20px;
	width:<?php echo $comp_ano ?>%;
	background: <?php if (($percento_ano >0) AND ($percento_ano <=65)) echo "rgb(180,221,180); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(180,221,180,1) 0%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 30%, rgba(131,199,131,1) 42%, rgba(0,138,0,1) 100%, rgba(0,87,0,1) 100%, rgba(0,36,0,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=0 ); /* IE6-9 */"; else if (($percento_ano >65) AND ($percento_ano <=85)) echo "rgb(252,243,188); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(252,243,188,1) 0%, rgba(252,232,78,1) 50%, rgba(248,219,0,1) 51%, rgba(251,239,147,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcf3bc', endColorstr='#fbef93',GradientType=0 ); /* IE6-9 */"; else echo "rgb(246,25,0); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(246,25,0,1) 16%, rgba(186,0,0,1) 47%, rgba(246,25,0,1) 87%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f61900', endColorstr='#f61900',GradientType=0 ); /* IE6-9 */"?>
}
</style>
<style type="text/CSS">
.outter3{
	height:20px;
	width:1000px;
	border:solid 0px #000;
}
.inner3{
	height:20px;
	width:<?php echo $comp_cart ?>%;
	background: <?php if (($percento_cart >0) AND ($percento_cart <=65)) echo "rgb(180,221,180); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(180,221,180,1) 0%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 4%, rgba(131,199,131,1) 30%, rgba(131,199,131,1) 42%, rgba(0,138,0,1) 100%, rgba(0,87,0,1) 100%, rgba(0,36,0,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 4%,rgba(131,199,131,1) 30%,rgba(131,199,131,1) 42%,rgba(0,138,0,1) 100%,rgba(0,87,0,1) 100%,rgba(0,36,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=0 ); /* IE6-9 */"; else if (($percento_cart >65) AND ($percento_cart <=85)) echo "rgb(252,243,188); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(252,243,188,1) 0%, rgba(252,232,78,1) 50%, rgba(248,219,0,1) 51%, rgba(251,239,147,1) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(252,243,188,1) 0%,rgba(252,232,78,1) 50%,rgba(248,219,0,1) 51%,rgba(251,239,147,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcf3bc', endColorstr='#fbef93',GradientType=0 ); /* IE6-9 */"; else echo "rgb(246,25,0); /* Old browsers */
	background: -moz-linear-gradient(top,  rgba(246,25,0,1) 16%, rgba(186,0,0,1) 47%, rgba(246,25,0,1) 87%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(246,25,0,1) 16%,rgba(186,0,0,1) 47%,rgba(246,25,0,1) 87%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f61900', endColorstr='#f61900',GradientType=0 ); /* IE6-9 */"?>
}
</style>
<div class="welll">
<div class="inner"><center><?php if ($percento <=0) echo ""; else echo $percento ?>%</center></div>
</div>
<a href="javascript:;" style="font-size:12px" onClick="abreFecha('orcamento_anual')" title="Exibir orçamento anual">[ Exibir or&ccedil;amento anual ]</a>
<a href="javascript:;" style="font-size:12px" onClick="abreFecha('orcamento_cartoes')" title="Exib. orçamento mensal consignados">[ Exib. or&ccedil;amento consignados ]</a>
</td>
</tr>
<tr style="display:none; background-color:#ffffff" id="lancar_orcamento">
<td class="welll">
<a href="javascript:;" style="font-size:12px; color:rgba(4, 45, 191, 1)" onClick="abreFecha('cad_orcamento')" title="Cadastre apenas uma vez."> [ Cad. Or&ccedil;amento ]</a> 
<a href="javascript:;" style="font-size:12px; color:rgba(4, 45, 191, 1)" onClick="abreFecha('ed_orcamento')" title="Edite um ou mais meses"> [ Editar Or&ccedil;amento ]</a>
</dt>
</tr>
<tr style="display:none; background-color:#ffffff" id="cad_orcamento">
<td class="welll">
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="cad_orcamento" />
Valor do or&ccedil;amento: R$  
<input type=text value="<?php echo $total?>" name=valor id="valororcamento" length=15 onKeyPress="return(FormataReais(this,'.',',',event))">&nbsp;|&nbsp;
<input type="radio" name="tipo" value="1" checked /> Este m&ecirc;s &nbsp; 
<input type="radio" name="tipo" value="0" /> Este ano &nbsp;|&nbsp;
Data inicial: <input type="text" name="data" size="11" maxlength="10" value="<?php echo date('d')?>/<?php echo $mes_hoje?>/<?php echo $ano_hoje?>" />
<input type="submit" class="btn-success" value="Gravar" />
</form>
</td>
</tr>
<tr style="display:none; background-color:#ffffff" id="ed_orcamento">
<td class="welll">
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="ed_orcamento" />
Novo valor: R$  <input type=text value="<?php echo $total?>" name=valor id="edorcamento" length=15 onKeyPress="return(FormataReais(this,'.',',',event))">&nbsp;|&nbsp;
<input type="radio" name="tipo" value="1" checked /> Somente este &nbsp; 
<input type="radio" name="tipo" value="0" /> Este e futuros&nbsp;|&nbsp;
Data inicial: <input type="text" name="data" size="11" maxlength="10" value="<?php echo date('d')?>/<?php echo $mes_hoje?>/<?php echo $ano_hoje?>" />
<input type="submit" class="btn-success" value="Gravar" />
</form>
</td>
</tr>
<tr style="display:none;" id="orcamento_anual">
<td>
<a href="javascript:;" style="font-size:12px" title="Orçamento anual">Or&ccedil;amento anual: <?php echo formata_dinheiro($gasto_ano)?><?php echo " de "?><?php echo formata_dinheiro($total_ano)?><?php echo " resta "?><font color="<?php if ($resta_ano <= 0) echo "#C00"?>"><?php echo formata_dinheiro($resta_ano)?></font>.</a><br>
<div class="welll">
<div class="inner2"><center><?php if ($percento_ano <=0) echo ""; else echo $percento_ano ?>%</center></div>
</div>
</dt>
</tr>
<tr style="display:none;" id="orcamento_cartoes">
<td>
<a href="javascript:;" style="font-size:12px" title="Orçamento mensal consignados">Or&ccedil;amento mensal consignados: <?php echo formata_dinheiro($gasto_cart)?><?php echo " de "?><?php echo formata_dinheiro($total_cart)?><?php echo " resta "?><font color="<?php if ($resta_cart <= 0) echo "#C00"?>"><?php echo formata_dinheiro($resta_cart)?></font>.</a><br>
<div class="welll">
<div class="inner3"><center><?php if ($percento_cart <=0) echo ""; else echo $percento_cart ?>%</center></div>
</div>
</dt>
</tr>
</table>

<table cellpadding="10" cellspacing="0" width="1000" align="center" >
<tr>
<td colspan="2">
<h2><?php echo mostraMes($mes_hoje)?>/<?php echo $ano_hoje?></h2>
</td>
<td align="right">
<a href="javascript:;" onClick="abreFecha('add_cat')" class="btn"><img src="imagens/add.png" width="16" height="16">  Adicionar Categoria</a>
<a href="javascript:;" onClick="abreFecha('add_movimento')" class="btn"><strong><img src="imagens/add.png" width="16" height="16">  Adicionar Movimento</strong></a>
</td>
</tr>
<tr >
<td colspan="3" >
<?php
if (isset($_GET['cat_err']) && $_GET['cat_err']==1){
?>
<div style="padding:5px; background-color:#FF6; text-align:center; color:#030">
<strong>Esta categoria n&atilde;o pode ser removida, pois há cmovimentos associados a mesma</strong>
</div>

<?php }?>

<?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==2){
?>

<div style="padding:5px; background-color:#9CC; text-align:center; color:#000">
<strong>Categoria removida com sucesso!</strong>
</div>

<?php }?>
    
<?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==1){
?>

<div style="padding:5px; background-color:#9CC; text-align:center; color:#000">
<strong>Categoria Cadastrada com sucesso!</strong>
</div>

<?php }?>
    
<?php
if (isset($_GET['cat_ok']) && $_GET['cat_ok']==3){
?>

<div style="padding:5px; background-color:#9CC; text-align:center; color:#000">
<strong>Categoria alterada com sucesso!</strong>
</div>

<?php }?>

<?php
if (isset($_GET['ok']) && $_GET['ok']==1){
?>

<div style="padding:5px; background-color:#9CC; text-align:center; color:#000">
<strong>Movimento Cadastrado com sucesso!</strong>
</div>

<?php }?>

<?php
if (isset($_GET['ok']) && $_GET['ok']==2){
?>

<div style="padding:5px; background-color:#900; text-align:center; color:#FFF">
<strong>Movimento removido com sucesso!</strong>
</div>

<?php }?>
    
<?php
if (isset($_GET['ok']) && $_GET['ok']==3){
?>

<div style="padding:5px; background-color:#9CC; text-align:center; color:#000">
<strong>Movimento alterado com sucesso!</strong>
</div>

<?php }?>

<div style=" background-color:#F1F1F1; padding:30px;  margin:5px; display:none" id="add_cat" class="welll">
<p><h3>Adicionar Categoria</h3>

<table width="90%">
<tr>
<td valign="top">
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="2" />
Nome: <input type="text" name="nome" size="20" maxlength="50" />
<br />
<br />

<input type="submit" class="btn-success" value="Gravar" />
</form>
</td>
            <td valign="top" align="right">
                <b>Editar/Remover Categorias:</b><br/><br/>
<?php
$qr=mysql_query("SELECT id, nome FROM ccategorias where usuario='$usuario' ORDER BY nome");
while ($row=mysql_fetch_array($qr)){
?>
                <div id="editar2_cat_<?php echo $row['id']?>">
<?php echo $row['nome']?>  
                    
                     <a style="font-size:10px; color:#666" onClick="return confirm('Tem certeza que deseja remover esta categoria?\nAtenção: Apenas ccategorias sem cmovimentos associados poderão ser removidas.')" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&acao=apagar_cat&id=<?php echo $row['id']?>" title="Remover" class="btn-mini"><img src="imagens/delete.png" width="16" height="16"> remover </a>
                     <a href="javascript:;" style="font-size:10px; color:#666" onClick="document.getElementById('editar_cat_<?php echo $row['id']?>').style.display=''; document.getElementById('editar2_cat_<?php echo $row['id']?>').style.display='none'" title="Editar"> <img src="imagens/edit.png" width="16" height="16"> editar </a>
                    
              </div>
                <div style="display:none" id="editar_cat_<?php echo $row['id']?>">
                    
<form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="editar_cat" />
<input type="hidden" name="id" value="<?php echo $row['id']?>" />
<input type="text" name="nome" value="<?php echo $row['nome']?>" size="20" maxlength="50" />
<input type="submit" class="input" value="Alterar" />
</form> 
                </div>

<?php }?>

            </td>
        </tr>
    </table>
</div>

<div style=" background-color:#F1F1F1; padding:30px;  margin:5px; display:none" id="add_movimento" class="welll">
<h3><b>Adicionar Movimento</b></h3>
<?php
$qr=mysql_query("SELECT id, nome FROM ccategorias where usuario='$usuario' ORDER BY nome");
if (mysql_num_rows($qr)==0)
	echo "Adicione ao menos uma categoria";

else{
?>
<form id="formulario_lancamento" method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
<input type="hidden" name="acao" value="1" />
<strong>Data: </strong>
<input type="text" name="data" size="11" maxlength="10" value="<?php echo date('d')?>/<?php echo date('m')?>/<?php echo date('Y')?>" />
&nbsp;  |  &nbsp;
<strong>Tipo:</strong>
<label for="tipo_receita" style="color:rgba(4, 45, 191, 1)"><input type="radio" name="tipo" value="1" id="tipo_receita" /> Receita</label>&nbsp; 
<label for="tipo_despesa" style="color:#C00"><input type="radio" name="tipo" value="0" checked id="tipo_despesa" /> Despesa</label>
&nbsp;  |  &nbsp;
<strong>Categoria:</strong>
<select name="cat">
<?php
while ($row=mysql_fetch_array($qr)){
?>
<option value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
<?php }?>
</select>

<br />
<br />

<strong>Descri&ccedil;&atilde;o:</strong><br />
<input type="text" name="descricao" size="100" maxlength="255" />
<br />
<br />

<font color="#000" size=1>Obs.: Em gastos parcelados, deve ser informado o valor total da compra, <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e n&atilde;o o valor da parcela.</font><br />
<strong>Valor:</strong> R$ <input type=text name=valor id="valor" length=15 onKeyPress="return(FormataReais(this,'.',',',event))">
&nbsp;  |  &nbsp;
<strong>Parcelas:</strong>
<input type="text" value="1" name="parcelas" size="2" maxlength="4" id="parcelas"/>

<br />
<br />
<center>
<input type="submit" class="btn-success" value="Gravar" />
</center>
</form>
<?php }?>
</div>
</td>
</tr>

<tr>
<td align="left" valign="top" width="450" style="background-color:#D3FFE2" class="welll">

<?php
$qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=1 && conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysql_fetch_array($qr);
$entradas=$row['total'];

$qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysql_fetch_array($qr);
$saidas=$row['total'];

$resultado_mes=$entradas-$saidas;
?>

    <fieldset>
        <legend><strong>Balan&ccedil;o Mensal</strong></legend>
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td><span style="font-size:18px; color:#000">Entradas:</span></td>
                <td align="right"><span style="color:rgba(4, 45, 191, 1); font-size:18px"><?php echo formata_dinheiro($entradas) ?></span></td>
            </tr>
            <tr>
                <td><br><span style="font-size:18px; color:#000">Sa&iacute;das:</span></td>
                <td align="right"><br><span style="font-size:18px; color:#C00"><?php echo formata_dinheiro($saidas) ?></span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr size="1" />
                </td>
            </tr>
            <tr>
                <td><strong style="font-size:22px; color:#000">Saldo Final:</strong></td>
                <td align="right"><strong style="font-size:22px; color:<?php if ($resultado_mes < 0) echo "#C00"; else echo "rgba(4, 45, 191, 1)" ?>"><?php echo formata_dinheiro($resultado_mes) ?></strong></td>
            </tr>
        </table>
    </fieldset>

</td>

<td width="15">
</td>

<td align="left" valign="top" width="450" style="background-color:#F1F1F1" class="welll">
<fieldset>
<legend>Balan&ccedil;o Geral</legend>

<?php
$qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=1 && conta=1 && usuario='$usuario'");
$row=mysql_fetch_array($qr);
$entradas=$row['total'];

$qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=1 && usuario='$usuario'");
$row=mysql_fetch_array($qr);
$saidas=$row['total'];

$resultado_geral=$entradas-$saidas;
?>

<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td><span style="font-size:19px; color:#000">Entradas:</span></td>
<td align="right"><span style="font-size:16px; color:rgba(4, 45, 191, 1)"><?php echo formata_dinheiro($entradas)?></span></td>
</tr>
<tr>
<td><br><span style="font-size:19px; color:#000">Sa&iacute;das:</span></td>
<td align="right"><br><span style="font-size:16px; color:#C00"><?php echo formata_dinheiro($saidas)?></span></td>
</tr>
<tr>
<td colspan="2">
<hr size="1" />
</td>
</tr>
<tr>
<td><strong style="font-size:22px; color:#000">Saldo Final:</strong></td>
<td align="right"><strong style="font-size:22px; color:<?php if ($resultado_geral<0) echo "#C00"; else echo "rgba(4, 45, 191, 1)"?>"><?php echo formata_dinheiro($resultado_geral)?></strong></td>
</tr>
</table>

</fieldset>
</td>

</tr>
</table>
<br />
<table cellpadding="5" cellspacing="1" width="1000" align="center">
<tr><td>
<a href="javascript:;" style="font-size:17px; color:#035D81" onClick="abreFecha('export_pdf');" title="Relatórios PDF"><img src="imagens/pdf.png" width="48" height="48"> </a>
</td>
<td align="right">
<?php
$qrconta2=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=2 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysql_fetch_array($qrconta2);
$conta2=$row['total'];

$qrconta3=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=3 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje'");
$row=mysql_fetch_array($qrconta3);
$conta3=$row['total'];

$totalcontascart=$conta2+$conta3
?>
 </td>
</tr>
</table>
<table border="0" cellpadding="5" cellspacing="1" width="1000" align="center">
<tr style="display:none; background-color:#FFFFFF" id="export_pdf" >
<td style="font-size:14px"  class="welll">
<b>
<center>Movimentos mensal</b><br>
Informe m&ecirc;s e ano desejados.
</center>
<br>
<br>
<form method="post" action="./exportar/cmovimentos.php">
<input type="hidden" name="acao" value="movimentos" />
<input type="hidden" name="conta" value="1" />
<input type="hidden" name="nome" value="Movimento de Consignados" />
M&ecirc;s:
<input type="number" name="mes" size="2" maxlength="2" value="<?php echo date('m')?>" />
<br><br>
Ano: <input type="number" name="ano" size="4" maxlength="4" value="<?php echo date('Y')?>" />
<br><br><center>
<input type="submit" class="btn-primary" value="Exportar" />
</form>
</td>
<td style="font-size:14px"  class="welll">
<b>
<center>
  Estat&iacute;stica mensal</b><br>
Informe m&ecirc;s e ano desejados.
</center>
<br>
<br>
<form method="post" action="./exportar/cestatistica.php">
<input type="hidden" name="acao" value="estatistica_mensal" />
<input type="hidden" name="nome" value="Movimento de Consignados" />
<input type="hidden" name="conta" value="1" />
M&ecirc;s:
<input type="number" name="mes" size="2" maxlength="2" value="<?php echo date('m')?>" />
<br><br>
Ano: <input type="number" name="ano" size="4" maxlength="4" value="<?php echo date('Y')?>" />
<br><br><center>
<input type="submit" class="btn-primary" value="Exportar" />
</form>
</td>
<td style="font-size:14px"  class="welll">
<b>
<center>
  Estat&iacute;stica anual</b><br>
Informe o ano desejado.</center>
<br>
<br>
<form method="post" action="./exportar/cestatistica.php">
<input type="hidden" name="acao" value="estatistica_anual" />
<input type="hidden" name="nome" value="Movimento de Consignados" />
<input type="hidden" name="conta" value="1" />
Ano: <input type="number" name="ano" size="4" maxlength="4" value="<?php echo date('Y')?>" />
<br><br><br><br><center>
<input type="submit" class="btn-primary" value="Exportar" />
</form>
</td>
<td style="font-size:14px"  class="welll">
<b>
<center>
  Exclus&otilde;es de cmovimentos</b><br>
Listar exclus&otilde;es desta conta.
</center>
<form method="post" action="./exportar/cexclusoes.php">
<input type="hidden" name="conta" value="1" />
<input type="hidden" name="nome" value="Movimento de Consignados" />
<br><br><br><br><br><br><center><input type="submit" class="btn-primary" value="Exportar" />
</form>
</td>
</tr>
</table>
<table cellpadding="5" cellspacing="0" width="1000" align="center">
<tr>
<td align="right">
<hr size="1" />
</td>
</tr>
</table>
<table cellpadding="5" cellspacing="0" width="1000" align="center">
<tr>
<td colspan="2">
    <div style="float:right; text-align:right" class="welll">
<form name="form_filtro_cat" method="get" action=""  >
<input type="hidden" name="mes" value="<?php echo $mes_hoje?>" >
<input type="hidden" name="ano" value="<?php echo $ano_hoje?>" >
    <b><img src="imagens/filtro.png" width="16" height="16"> Filtrar por categoria:</b>  <select name="filtro_cat" onChange="form_filtro_cat.submit()">
<option value="">Tudo</option>
<?php
$qr=mysql_query("SELECT DISTINCT c.id, c.nome, c.usuario FROM ccategorias c, cmovimentos m WHERE m.cat=c.id && c.usuario='$usuario' && m.mes=$mes_hoje && m.ano=$ano_hoje && m.conta=1 ORDER BY c.nome");
while ($row=mysql_fetch_array($qr)){
?>
<option <?php if (isset($_GET['filtro_cat']) && $_GET['filtro_cat']==$row['id'])echo "selected=selected"?> value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
<?php }?>
</select>
</form>
    </div>

<h2>Movimentos deste m&ecirc;s </h2>

</td>
<tr>
<tr style="background-color:#E0E0E0">
<td align="center" width="15"><b><?php echo "Dia"?></td>
<td><b><?php echo "Descri&ccedil;&atilde;o e categoria"?></td>
<td align="center"><b><?php echo "Valor"?></td>
</tr>
<?php
$filtros="";
if (isset($_GET['filtro_cat'])){
	if ($_GET['filtro_cat']!=''){	
		$filtros="&& cat='".$_GET['filtro_cat']."'";
                
                $qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=1 && conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje' $filtros");
                $row=mysql_fetch_array($qr);
                $entradas=$row['total'];

                $qr=mysql_query("SELECT SUM(valor) as total FROM cmovimentos WHERE tipo=0 && conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje' $filtros");
                $row=mysql_fetch_array($qr);
                $saidas=$row['total'];

                $resultado_mes=$entradas-$saidas;
                
        }
}

$qr=mysql_query("SELECT * FROM cmovimentos WHERE conta=1 && usuario='$usuario' && mes='$mes_hoje' && ano='$ano_hoje' $filtros ORDER BY dia desc");
$cont=0;
while ($row=mysql_fetch_array($qr)){
$cont++;

$cat=$row['cat'];
$qr2=mysql_query("SELECT nome FROM ccategorias WHERE id='$cat'");
$row2=mysql_fetch_array($qr2);
$categoria=$row2['nome'];
?>
<script>
$(function () {
	$.calculator.setDefaults({showOn: 'both', buttonImageOnly: true, buttonImage: './conf/img/calc.png'});
	$("#<?php echo $row['id']?>").calculator(); //Calculadora comum para edição de cmovimentos
});
</script>
<tr style="background-color:<?php if ($cont%2==0) echo "#F1F1F1"; else echo "#E0E0E0"?>" >
<td align="center" width="15"><?php echo $row['dia']?></td>
<td><?php echo $row['descricao']?> <?php if($row['parcelas']>=2) echo 'Parcela'?> <?php if($row['parcelas']>=2) echo $row['nparcela']?><?php if($row['parcelas']>=2) echo '/'?><?php if($row['parcelas']>=2) echo $row['parcelas']?> <em>(<a href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><?php echo $categoria?></a>)</em> <a href="javascript:;" style="font-size:12px; color:#666" onClick="abreFecha('editar_mov_<?php echo $row['id']?>');" title="Editar"><img src="imagens/edit.png" width="16" height="16"> Editar  </a> <a href="javascript:;" style="font-size:12px; color:#666" onClick="abreFecha('hist_mov_<?php echo $row['id']?>');" title="Ver hist&oacute;rico"> <img src="imagens/historico.png" width="16" height="16"> Hist&oacute;rico</a><br>
</td>
<td align="right"><strong style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "rgba(4, 45, 191, 1)"?>"><?php echo formata_dinheiro($row['valor'])?></strong></td>
</tr>
    <tr style="display:none; background-color:<?php if ($cont%2==0) echo "#F1F1F1"; else echo "#E0E0E0"?>" id="editar_mov_<?php echo $row['id']?>">
  <td colspan="3" >
            <hr/>

            <form method="post" action="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>">
            <input type="hidden" name="acao" value="editar_mov" />
            <input type="hidden" name="id" value="<?php echo $row['id']?>" />
                     
            <b>Dia:</b> <input type="text" name="dia" size="2" maxlength="2" value="<?php echo $row['dia']?>" />&nbsp;|&nbsp;
            <b>M&ecirc;s:</b> <input type="text" name="mes" size="2" maxlength="2" value="<?php echo $row['mes']?>" />&nbsp;|&nbsp;
            <b>Ano:</b> <input type="text" name="ano" size="3" maxlength="4" value="<?php echo $row['ano']?>" />&nbsp;|&nbsp;
            <b>Tipo:</b> <label for="tipo_receita<?php echo $row['id']?>" style="color:rgba(4, 45, 191, 1)"><input <?php if($row['tipo']==1) echo "checked=checked"?> type="radio" name="tipo" value="1" id="tipo_receita<?php echo $row['id']?>" /> Receita</label>&nbsp; <label for="tipo_despesa<?php echo $row['id']?>" style="color:#C00"><input <?php if($row['tipo']==0) echo "checked=checked"?> type="radio" name="tipo" value="0" id="tipo_despesa<?php echo $row['id']?>" /> Despesa</label>&nbsp;&nbsp;&nbsp;|&nbsp;
            <b>Categoria:</b>
<select name="cat">
<?php
$qr2=mysql_query("SELECT * FROM ccategorias where usuario='$usuario' ORDER BY nome");
while ($row2=mysql_fetch_array($qr2)){
?>
    <option <?php if($row2['id']==$row['cat']) echo "selected"?> value="<?php echo $row2['id']?>"><?php echo $row2['nome']?></option>
<?php }?>
</select><br /><br />            
            <b>Descri&ccedil;&atilde;o:</b> 
            <input type="text" name="descricao" value="<?php echo $row['descricao']?>" size="90" maxlength="255" />
         <br /><br />
            <b>Valor:</b> R$  <input type=text id="<?php echo $row['id']?>" value="<?php echo $row['valor']?>" name=valor length=15 onKeyPress="return(FormataReais(this,'.',',',event))">
</select>&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;            
            <input type="submit" class="btn-success" value="Gravar" />
            </form> 
            <div style="text-align: right">
            <a href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&acao=apagar&id=<?php echo $row['id']?>" title="Remover" class="btn-warning" style="color:#FF0000" onClick="return confirm('Tem certeza que deseja apagar?')">[remover]</a> 
  </div>
            <hr/>
        </td>
    </tr>
<tr style="display:none; background-color:<?php if ($cont%2==0) echo "#F1F1F1"; else echo "#E0E0E0"?>" id="hist_mov_<?php echo $row['id']?>">
<td align="center" width="15"></td>
<td>
<?php
$id=$row['id'];
$hist=mysql_query("SELECT * FROM chistorico WHERE id_mov = '$id' ORDER BY id_hist");
$qrhist=mysql_query("SELECT j.just, h.data, h.id_hist FROM (cjust_ed j INNER JOIN chistorico h ON j.id = h.just_id) INNER JOIN cmovimentos g ON h.id_mov = g.id && g.id = '$id' ORDER BY h.id_hist");

if (mysql_num_rows($hist)!==0){
echo "Hist&oacute;rico de alterações:" ."<br>";
while ($rowhist = mysql_fetch_array($qrhist)){
echo date('d/m/y', strtotime($rowhist['data'])) ."  -  " .$rowhist['just'] ."<br>";
}
}
else{
echo "Não há histórico de alterações.";
}
?>
</td>
<td></td>
</tr>
   
<?php
}
?>
<tr>
<td colspan="3" align="right" class="welll">
<strong style="font-size:22px; color:<?php if ($resultado_mes<0) echo "#C00"; else echo "rgba(4, 45, 191, 1)"?>"><?php echo formata_dinheiro($resultado_mes)?></strong>
</td>
</tr>
</table></div>

<table cellpadding="5" cellspacing="0" width="1000" align="center">
<tr>
<td align="right">
<hr size="1" />
<?php echo $desenvolvedor?>  | <?  
   echo 'Voc&ecirc; est&aacute; em:  http://' . $server . $endereco;
?>   <?php echo $versao?>  





</td>
</tr>
</table>
</body>
</html>
