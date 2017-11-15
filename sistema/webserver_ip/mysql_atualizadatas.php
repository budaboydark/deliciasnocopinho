<?php
$query = $con->prepare("UPDATE cadastro SET datainicio = '2013-01-01' WHERE datainicio = '0000-00-00' or datainicio is null");
$query->execute();
?>