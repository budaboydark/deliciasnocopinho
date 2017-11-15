<div class="loginbox">
    <div class="loginboxinner">
        <?php
        $pref_conf = $this->db->get('pref_configuracoes')->first_row('array');
        ?>
        <div class="logo">
            <h3 style="color:white;"><?php echo utf8_decode($pref_conf['municipio']) . ' - ' . $pref_conf['uf']; ?></h3>
            <br />
        </div>
        <div class="logo">
            <h1>
                <?php if (read_file($this->admin_model->config_directory . $this->core_config['general_logo'])): ?>
                    <?php echo img(array('src' => image("media/" . $this->admin_model->config_directory . $this->core_config['general_logo'], "150x0"), 'alt' => $this->core_config['general_client'])); ?>
                <?php else: ?>
                    <span><?php echo $this->core_config['general_client']; ?></span>
                <?php endif; ?>
            </h1>
            <p></p>
        </div><!--logo-->

        <br clear="all" /><br />

        <div class="nousername">
            <div class="loginmsg"></div>
        </div><!--nousername-->

        <div class="nopassword">
            <div class="loginmsg">&nbsp;</div>
            <div class="loginf">
                <div class="thumb"><img alt="" src="<?php echo image("media/upload/user/default.jpg", "50x50"); ?>" /></div>
                <div class="userlogged">
                    <h4></h4>
                    <a href="<?php echo site_url('admin/login'); ?>">Este n&atilde;o sou eu</a> 
                </div>
            </div><!--loginf-->
        </div><!--nopassword-->

        <form id="login" action="<?php echo site_url('admin/login/logon'); ?>" method="post">
            <div class="username">
                <div class="usernameinner">
                    <input type="text" name="email" id="email" />
                </div>
            </div>

            <div class="password">
                <div class="passwordinner">
                    <input type="password" name="pass" id="pass" />
                </div>
            </div>

            <button>ENTRAR</button>

            <div class="keep"><input type="checkbox" name="remember" value="1" /> Continuar Logado</div>
        </form>

    </div><!--loginboxinner-->
</div><!--loginbox-->