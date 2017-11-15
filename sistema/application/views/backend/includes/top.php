<div class="topheader">
    <div class="left">
        <h1 class="logo">
            <?php if ($this->uri->segment(1) == 'contribuinte') { ?>
                <?php if (read_file($this->contribuinte_model->config_directory . $this->core_config['general_logo'])): ?>
                    <?php echo img(array('src' => image("media/" . $this->contribuinte_model->config_directory . $this->core_config['general_logo'], "0x40"), 'alt' => $this->core_config['general_client'])); ?>
                <?php else: ?>
                    <?php echo $this->core_config['general_client']; ?>
                <?php endif; ?>
            <?php }else { ?>
                <?php if (read_file($this->admin_model->config_directory . $this->core_config['general_logo'])): ?>
                    <?php echo img(array('src' => image("media/" . $this->admin_model->config_directory . $this->core_config['general_logo'], "0x40"), 'alt' => $this->core_config['general_client'])); ?>
                <?php else: ?>
                    <?php echo $this->core_config['general_client']; ?>
                <?php endif; ?>
            <?php } ?>

        </h1>
        <span class="slogan">Del&iacute;cias no Copinho</span>

        <!-- #@! general search div class="search">
                <form action="#" method="post">
                <input type="text" name="keyword" id="keyword" value="Enter keyword(s)" />
                <button class="submitbutton"></button>
            </form>
        </div><!--search-->

        <br clear="all" />

    </div><!--left-->

    <div class="right">
        <!-- #@! notification -->
        <!--div class="notification">
            <a class="count" href="ajax/notifications.html"><span>9</span></a>
        </div-->
        <div class="userinfo">
            <?php
            if ($this->uri->segment(1) == 'contribuinte') {
                $this->db->select("u.image image,pref_contribuintes.*, user_group.title group_title");
                $this->db->from("pref_contribuintes");
                $this->db->join('user u', 'pref_contribuintes.cnpj=u.cnpj');
                $this->db->join('user_group', 'pref_contribuintes.user_group_id = user_group.id', 'left');
                $this->db->where("pref_contribuintes.email = " . $this->db->escape($user['email']) . "AND pref_contribuintes.status = '1' AND pref_contribuintes.type_id = '2' ");
                $query = $this->db->get();
                $row = $query->row();
                $user['image'] = $row->image;
            }
            
            if (read_file('./upload/user/' . $user['image'])):
                echo img(array('src' => image("media/upload/user/" . $user['image'], "23x23"), 'alt' => $user['name']));
            else:
                echo img(image("media/upload/user/default.jpg", "23x23"));
            endif;
            ?>
            <span><?php echo $user['name']; ?> <?php echo $user['name_last']; ?> </span>
        </div><!--userinfo-->

        <div class="userinfodrop"><div class="avatar">
                <a href="javascript:void(0);">
                    <?php
                    if (read_file('./upload/user/' . $user['image'])):
                        echo img(array('src' => image("media/upload/user/" . $user['image'], "95x95"), 'alt' => $user['name']));
                    else:
                        echo img(image("media/upload/user/default.jpg", "95x95"));
                    endif;
                    ?>
                </a>
                <div class="changetheme">
                    Alterar Tema: <br />
                    <a class="default"></a>
                    <a class="blueline"></a>
                    <a class="greenline"></a>
                    <a class="contrast"></a>
                    <a class="custombg"></a>
                </div>
            </div><!--avatar-->
            <div class="userdata">
                <h4><?php
                    echo $user['name'];
                    echo $user['razao_social'];
                    ?> <?php echo $user['name_last']; ?></h4><br  />
                <span class="email"><?php echo $user['email']; ?></span>
                <ul>
                    <?php if ($this->uri->segment(1) == 'contribuinte') { ?>
                        <li><a href="<?php echo site_url('contribuinte/usuario/editar/' . $user['id']); ?>">Editar Usu&aacute;rio</a></li>
                        <!-- <li><a href="<?php echo site_url('contribuinte/config'); ?>">Configurações</a></li> -->
                        <li><a href="<?php echo site_url('contribuinte/ajuda'); ?>">Ajuda</a></li>
                        <li><a href="<?php echo site_url('contribuinte/login/logout'); ?>">Sair</a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo site_url('admin/usuarios/editar/' . $user['id']); ?>">Editar Usu&aacute;rio</a></li>
                        <!-- <li><a href="<?php echo site_url('admin/config'); ?>">Configurações</a></li> -->
                        <!-- <li><a href="<?php echo site_url('admin/sistema'); ?>">Configurações</a></li> -->
                        <li><a href="<?php echo site_url('admin/ajuda'); ?>">Ajuda</a></li>
                        <li><a href="<?php echo site_url('admin/login/logout'); ?>">Sair</a></li>
                    <?php } ?>

                </ul>
            </div><!--userdata-->
        </div><!--userinfodrop-->
    </div><!--right-->
</div><!--topheader-->