<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------
  | MENU
  | -------------------------------------------------------------------
  | List menus array in application
  |
  |
  |--------------------------------------------------------------------------
  | left menus admin
  |--------------------------------------------------------------------------
  |
  | list all left menus and sub menus on the admin, create over the permissions
  | all class types (editor, gallery, elements, widgets, calendar, support, type, tables, buttons, error, addons)
  |
 */

$config['menu_admin']['dashboard']['dashboard'] = array('title' => 'Inicial', 'link' => 'admin/dashboard', 'permissions' => '1,2', 'class' => 'widgets');
$config['menu_admin']['dashboard']['user'] = array('title' => 'Funcion&aacute;rios', 'link' => 'admin/usuarios', 'permissions' => '1,2', 'class' => 'editor');
$config['menu_admin']['dashboard']['logs'] = array('title' => 'Logs do Sistema', 'link' => 'admin/logs', 'permissions' => '1,2', 'class' => 'editor');
$config['menu_admin']['dashboard']['clientes'] = array('title' => 'Clientes', 'link' => 'admin/cliente', 'permissions' => '1,2', 'class' => 'editor');

$config['menu_admin']['relatorios']['reltitulos'] = array('title' => 'T&iacute;tulos', 'link' => 'admin/reltitulos', 'permissions' => '1,2', 'class' => 'gallery');
$config['menu_admin']['relatorios']['relirregularidades'] = array('title' => 'Irregularidades', 'link' => 'admin/relirregularidades', 'permissions' => '1,2', 'class' => 'gallery');
$config['menu_admin']['relatorios']['relgrafico'] = array('title' => 'Gr&aacute;fico', 'link' => 'admin/relgrafico', 'permissions' => '1,2', 'class' => 'gallery');

$config['menu_admin']['ajuda']['manuais'] = array('title' => 'Manuais', 'link' => 'admin/manuais', 'permissions' => '1,2', 'class' => 'support');
$config['menu_admin']['ajuda']['suporte'] = array('title' => 'Suporte', 'link' => 'admin/suporte', 'permissions' => '1,2', 'class' => 'support');
$config['menu_admin']['user']['user'] = array('title' => 'Usu&aacute;rios', 'link' => 'admin/user', 'permissions' => '1,2', 'class' => 'editor');
$config['menu_admin']['user']['usergroup'] = array('title' => 'Grupos de Usu&aacute;rios', 'link' => 'admin/usergroup', 'permissions' => '1,2', 'class' => 'tables');
$config['menu_admin']['user']['acl'] = array('title' => 'ACL', 'link' => 'admin/acl', 'permissions' => '1', 'class' => 'support');
$config['menu_admin']['config']['config'] = array('title' => 'Configura&ccedil;&otilde;es', 'link' => 'admin/config', 'permissions' => '1,2', 'class' => 'tables');
$config['menu_admin']['config']['url'] = array('title' => 'Urls', 'link' => 'admin/url', 'permissions' => '1', 'class' => 'editor');
$config['menu_admin']['config']['modules'] = array('title' => 'Gerencia de Módulos', 'link' => 'admin/modules', 'permissions' => '@0.2', 'class' => 'widgets');
$config['menu_admin']['config']['help'] = array('title' => 'Ajuda', 'link' => 'admin/help', 'permissions' => '1,2', 'class' => 'support');
$config['menu_admin']['config']['phpinfo'] = array('title' => 'Informações do Servidor', 'link' => 'admin/phpinfo', 'permissions' => '1', 'class' => 'support');

$config['menu_admin']['financeiro']['contas'] = array('title' => 'Contas', 'link' => 'admin/financeiro', 'permissions' => '1,2', 'class' => 'editor');
$config['menu_admin']['financeiro']['pagar'] = array('title' => 'Contas pagar', 'link' => 'admin/financeiroPagar', 'permissions' => '1,2', 'class' => 'editor');
$config['menu_admin']['financeiro']['receber'] = array('title' => 'Contas receber', 'link' => 'admin/financeiroReceber', 'permissions' => '1,2', 'class' => 'editor');

/*
  |--------------------------------------------------------------------------
  | top menus admin
  |--------------------------------------------------------------------------
  |
  | list top menus on the admin, create over the permissions
  | all ico types (flatscreen, pencil, message, speech, users, chart)
  |
 */
$config['menu_top_admin']['dashboard'] = array('title' => 'Administra&ccedil;&atilde;o', 'link' => 'admin/dashboard', 'permissions' => '1,2', 'ico' => 'users');
$config['menu_top_admin']['financeiro'] = array('title' => 'Financeiro', 'link' => 'admin/financeiro', 'permissions' => '1,2', 'ico' => 'users');
$config['menu_top_admin']['relatorios'] = array('title' => 'Relat&oacute;rios', 'link' => 'admin/relatorios', 'permissions' => '1,2', 'ico' => 'chart');
$config['menu_top_admin']['ajuda'] = array('title' => 'Ajuda', 'link' => 'admin/ajuda', 'permissions' => '1,2', 'ico' => 'speech');

$config['menu_top_contribuinte']['dashboard'] = array('title' => 'Administra&ccedil;&atilde;o', 'link' => 'contribuinte/dashboard', 'permissions' => '1,2', 'ico' => 'users');
$config['menu_top_contribuinte']['ajuda'] = array('title' => 'Ajuda', 'link' => 'contribuinte/ajuda', 'permissions' => '1,2', 'ico' => 'speech');
