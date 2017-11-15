<?php
# Apaga Menu
function redir_msg($msg,$local){
	print("<script>alert('".$msg."');window.location='principal.php?local=".$local."';</script>");
}

if(isset($_GET['apagar'])) {
	# Apaga os arquivos referentes ao ítem.
	$IDITEM = $_GET['IDITEM'];
	# apaga o registro do banco de dados.

	$verifica_subitens = $con->prepare("SELECT * FROM tbl_subitens WHERE cod_itens = ?");
	$verifica_subitens->bindValue(1,$IDITEM);
	$verifica_subitens->execute();
	$total_subitens = $verifica_subitens->rowCount();
	if($total_subitens > 0 ){
		$display = "Ítem não pode ser apagado por possuir subitens.";
	}else{	
		$delete = $con->prepare("DELETE FROM tbl_itens WHERE id = ?");
		$delete->bindValue(1,$IDITEM);
		$delete->execute();
		$display = "Ítem apagado com sucesso.";
		# Registra no LOG
		registralog("Apagou ítem de menu");
	}
	$msg = $display;
	$local = "menu";
	redir_msg($msg,$local);

}


# Insere novo menu
if(isset($_POST['bt_insere'])) {
	
	$IDMENU = $_POST['IDMENU'];
	$nome_item = $_POST['nome_item'];
	$sql_tipo_menu = $con->prepare("SELECT tipo FROM tbl_menu WHERE id = ?");
	$sql_tipo_menu->bindValue(1,$IDMENU);
	$sql_tipo_menu->execute();
	list($tipo_menu)=$sql_tipo_menu->fetch(PDO::FETCH_SERIALIZE);
	
	if($_POST['link'] == "" && $tipo_menu == '') {
		$link = "secoes";
	}else if($_POST['link'] == "" && $tipo_menu == 'doc'){
		$link = "doc";
	}else if($_POST['link'] != ''){
		$link = $_POST['link'];
	}else{
		$link = "";
	}
	if(isset($_POST['descricao'])){
		$descricao = nl2br($_POST['descricao']);
		$descricao = str_replace('"', "&quot;", $descricao);
	}else{
		$descricao = "";	
	}

	
	if(!empty($_FILES["fileArquivo"]["name"])){
		$arquivoNome = $_FILES["fileArquivo"]["name"];
		$arquivoNomeTemp = $_FILES["fileArquivo"]["tmp_name"];
		$dados = true;
	}else{
		$dados = false;	
	}
	
	if($dados == true){
	$arquivoNome = utf8_encode($arquivoNome);
	$arquivoNome = clearSpecialChars($arquivoNome);// retira os caracteres especiais. 
	$caminho = "arquivos/".$arquivoNome;
	$verifica = pathinfo($_FILES["fileArquivo"]["name"],PATHINFO_EXTENSION);
		if($verifica == "pdf"){
			if(move_uploaded_file($arquivoNomeTemp,$caminho)){
				$sql_intens_menu_insere = $con->prepare("INSERT INTO tbl_itens SET id_menu = ?, nome = ?, descricao = ?, link = ?, id_nivel = '2'");
				$sql_intens_menu_insere->bindValue(1,$IDMENU);
				$sql_intens_menu_insere->bindValue(2,$nome_item);
				$sql_intens_menu_insere->bindValue(3,$descricao);
				$sql_intens_menu_insere->bindValue(4,$link);
				$sql_intens_menu_insere->execute();
				$max = $con->prepare("SELECT MAX(id) FROM tbl_itens");
				$max->execute();
				list($max) = $max->fetch(PDO::FETCH_SERIALIZE);
				$insert = $con->prepare("INSERT INTO arquivos SET id_iten = ?,arquivo = ?");
				$insert->bindValue(1,$max);
				$insert->bindValue(2,$caminho);
				$insert->execute();
				echo utf8_decode("<script>alert('Item inserido com sucesso!')</script>");
			}else{
				echo utf8_decode("<script>alert('erro ao mover arquivo')</script>");
			}
		} else {
			echo utf8_decode("<script>alert('Arquivo sem extensão PDF!')</script>");
		}
	}else if($dados == false){
		$sql_intens_menu_insere = $con->prepare("INSERT INTO tbl_itens SET id_menu = ?,nome = ?,descricao = ?,link = ?,id_nivel = '2'");
		$sql_intens_menu_insere->bindValue(1,$IDMENU);
		$sql_intens_menu_insere->bindValue(2,$nome_item);
		$sql_intens_menu_insere->bindValue(3,$descricao);
		$sql_intens_menu_insere->bindValue(4,$link);
		$sql_intens_menu_insere->execute();
		$display = "Ítem inserido com sucessos.";
	}

	# Registra no LOG
	registralog("Inseriu ítem de menu");
	$msg = $display;
	$local = "menu";
	redir_msg($msg,$local);
}

# SQL de Nível de Acesso
$sql_nivel = $con->prepare("SELECT id, nivel, descricao FROM tbl_nivel_acesso WHERE nivel <= '4' ORDER BY nivel ASC");
$sql_nivel->execute();

# SQL para seleção de ítens conforme nível de permissão.
$IDMENU = (int) $_GET['IDMENU'];
$sql_gerenciador = $con->prepare("SELECT tbl_itens.id_menu,tbl_itens.id, tbl_itens.nome, tbl_itens.link, tbl_itens.id_nivel FROM tbl_itens WHERE tbl_itens.id_menu = ? ORDER BY tbl_itens.nome ASC");
$sql_gerenciador->bindValue(1,$IDMENU);
$sql_gerenciador->execute();

$sql_link = $con->prepare("SELECT tbl_menu.menu,tbl_menu.tipo FROM tbl_menu INNER JOIN tbl_nivel_acesso ON (tbl_nivel_acesso.id = tbl_menu.id_nivel) WHERE tbl_menu.id = ? AND tbl_menu.id_nivel <= ? ");
$sql_link->bindValue(1,$IDMENU);
$sql_link->bindValue(2,$_SESSION['niveldeacesso']);
$sql_link->execute();

$lista_link = $sql_link->fetch(PDO::FETCH_ASSOC);
$c1 = "#FFFFFF"; // Cor1 : branco
$c2 = "#F0F0EA"; // Cor2 : cinza claro
$c=0; // Inicia em 0
?>
<br>

<?php
if($_SESSION['niveldeacesso'] >= 2) {
	$NOMEMENU = $_GET['NOMEMENU'];			
	$IDMENU = $_GET['IDMENU'];
?>
<table cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td>
			<ul class="intranet">
				<li><a href="principal.php?local=menu" class="intranet">Menu</a></li>
				<li><a href="principal.php?local=itens_menu&INSERIR=true&NOMEMENU=<?php echo utf8_decode($NOMEMENU); ?>&IDMENU=<?php echo $IDMENU; ?>" class="intranet">Inserir Ítem</a></li>
			</ul>
		</td>
	</tr>
</table>
<br>
<?php
}
?>
<table width="98%" cellpadding="2" cellspacing="0" align="center">
<?php
	if($_SESSION['niveldeacesso'] >= 2) {
		if(isset($_GET['INSERIR'])) {
			if($_GET['INSERIR'] == "true"){
			
			$IDMENU = $_GET['IDMENU'];
			
			$sql_tbl_menu = $con->prepare("SELECT * FROM tbl_menu WHERE id = ?");
			$sql_tbl_menu->bindValue(1,$IDMENU);
			$sql_tbl_menu->execute();
			$dados_tbl_menu = $sql_tbl_menu->fetch(PDO::FETCH_ASSOC);
			$lista_link = $sql_link->fetch(PDO::FETCH_ASSOC);
?>
			<tr><td align="center">
				<?php
				if($dados_tbl_menu['menu'] != 'Links Úteis'){
                ?>
				<form action="principal.php?local=itens_menu" method="post" enctype="multipart/form-data">
				<input type="hidden" name="NOMEMENU" value="<?php echo $dados_tbl_menu['menu'];?>">
				<input type="hidden" name="IDMENU" value="<?php echo $dados_tbl_menu['id']; ?>">
                <input type="hidden" name="link" value="">
					<table cellpadding="5" cellspacing="0" class="intranet">
						<tr><td class="intranet" colspan="2">Inserir novo ítem em <?php echo $dados_tbl_menu['menu'];?></td></tr>
						<tr><td><strong>Nome do Ítem:</strong></td><td><input type="text" name="nome_item" size="40"></td></tr>
                        <?php if($dados_tbl_menu['tipo'] == 'secoes'){ ?>
						<tr><td><strong>Descrição</strong>:</td><td><textarea name="descricao" cols="52" rows="10" wrap="PHYSICAL" >Aguardando material para publicação.</textarea></td></tr>
                        <?php }?>
                    <!--<tr>
                    <td colspan="2">Arquivo para publicação: <input type="file" name="fileArquivo" id="fileArquivo" /></td>
                    </tr>-->
						<tr><td colspan="2" align="center"><input type="submit" name="bt_insere" value="Inserir" class="botao"></td></tr>
					</table>
				</form>
                <?php 
				}else{
					/*
					* - quando for links uteis só nome e endereco.
					*/
				?>
                
				<form action="principal.php?local=itens_menu" method="post">
				<input type="hidden" name="NOMEMENU" value="<?php echo $dados_tbl_menu['menu'];?>">
				<input type="hidden" name="IDMENU" value="<?php echo $dados_tbl_menu['id']; ?>">
					<table cellpadding="5" cellspacing="0" class="intranet">
						<tr><td class="intranet" colspan="2">Inserir novo ítem em <?php echo $dados_tbl_menu['menu'];?></td></tr>
						<tr><td><strong>Nome do Ítem:</strong></td><td><input type="text" name="nome_item" size="52"></td></tr>
						<tr><td><strong>Endereco(URL):</strong></td><td><input type="text" name="link" size="52" /></td></tr>
						<tr><td colspan="2" align="center"><input type="submit" name="bt_insere" value="Inserir" class="botao"></td></tr>
					</table>
				</form>
                
                <?php } ?>
			</td></tr>
	<?php	
			}
		}
	}
	$NOMEMENU = $_GET['NOMEMENU'];
	?>
	<tr><td align="center">
		<table cellpadding="5" cellspacing="0" class="intranet">
			<tr><td class="intranet" colspan="3">Gerenciador de <?php echo ($NOMEMENU); ?></td></tr>
			<tr bgcolor="#FFFFCC"><td><strong>Ítens</strong></td><td align="center"><strong>Nível requerido para Acesso</strong></td><td align="center">&nbsp;</td></tr>
			<?php
			while($lista_menu = $sql_gerenciador->fetch(PDO::FETCH_ASSOC)) {
				$sql_arq = $con->prepare("SELECT arquivo FROM arquivos WHERE id_iten = ?");
				$sql_arq->bindValue(1,$lista_menu['id']);
				$sql_arq->execute();
				$sql_rows = $sql_arq->rowCount();
				
				$sql_sub = $con->prepare("SELECT * FROM tbl_subitens WHERE cod_itens = ?");
				$sql_sub->bindValue(1,$lista_menu['id']);
				$sql_sub->execute();
				$sql_sub_rows = $sql_sub->rowCount();
				
				if($lista_link['tipo'] == 'doc'){
					
					?>	
					<tr bgcolor="<?php echo (($c++&1)?$c1:$c2); ?>">
					<td><a href="principal.php?local=doc&IDITEM=<?php echo $lista_menu['id'];?>"><?php echo $lista_menu['nome']; ?></a></td>
					<td align="center"><?php echo $lista_menu["id_nivel"]; ?></td>
					<?php
					}else if($lista_menu['id'] == '53'){
					?>	
					<tr bgcolor="<?php echo (($c++&1)?$c1:$c2); ?>">
					<td><a href="principal.php?local=conta"><?php echo $lista_menu['nome']; ?></a></td>
					<td align="center"><?php echo $lista_menu["id_	nivel"]; ?></td>
					<?php
					}else if($lista_menu['link'] == 'noticia' ){
					?>
					<tr bgcolor="<?php echo (($c++&1)?$c1:$c2); ?>">
					<td><a href="principal.php?local=<?php echo $lista_menu['link']; ?>"><?php echo $lista_menu['nome']; ?></a></td>
					<td align="center"><?php echo $lista_menu["id_nivel"]; ?></td>
					<?php	
				}else{
					
					if($sql_rows > 0 || $sql_sub_rows == 0 ){
					print("<tr bgcolor=\"".(($c++&1)?$c1:$c2)."\">
						<td><a href=\"principal.php?local=itens&IDITEM=".$lista_menu["id"]."&NOMEITEM=".$lista_menu["nome"]."&NOMEMENU=$NOMEMENU&IDMENU=$IDMENU\">".$lista_menu["nome"]."</a></td>
						<td align=\"center\">".$lista_menu["id_nivel"]."</td>
					");
					
					}else{
						
						if(utf8_decode($NOMEMENU) == "Links Úteis") {
							print("<tr bgcolor=\"".(($c++&1)?$c1:$c2)."\">
							<td><a href=\"principal.php?local=".$lista_menu["link"]."\" target=\"_blank\">".utf8_decode($lista_menu["nome"])."</a></td>
							<td align=\"center\">".$lista_menu["id_	nivel"]."</td>
							");
						} else {
								print("<tr bgcolor=\"".(($c++&1)?$c1:$c2)."\">
									<td><a href=\"principal.php?local=subitens&IDITEM=".$lista_menu["id"]."&NOMEITEM=".$lista_menu["nome"]."&NOMEMENU=$NOMEMENU&IDMENU=$IDMENU\">".$lista_menu["nome"]."</a></td>
									<td align=\"center\">".$lista_menu["id_nivel"]."</td>
								");
						}
					}
				}
				print("<td align=\"right\">");
				
				
			if($_SESSION['niveldeacesso'] >= 4) {
				if($lista_menu["nome"] == "Contas Públicas") {
				
				}else if ($lista_menu["nome"] == "Notícias"){
					
				}else{
					
				print("<a href=\"principal.php?local=itens_menu&IDITEM=".$lista_menu["id"]."&apagar=apagar\"><img src=\"../img/botoes/bt_apagar.png\"></a>");
				}
					
				} else {
					if($lista_menu["nome"] == "Contas Públicas") {
					}else if ($lista_menu["nome"] == "Notícias"){
					}else{
						print("<img src=\"../img/botoes/bt_apagar.png\">");
					}

				}
				print("</td></tr>");
			}
			?>
		</table>
		<br>
	</td></tr>
</table>
<br>