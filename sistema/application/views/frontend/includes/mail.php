<style>
    .context p {
        color: #999;
    }
    .context a {
        text-decoration: none;
    }
    .p_texto p {
        font: normal 13px Arial;
        color: #666;
    }
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="context">
    <tr>
        <td align="center" bgcolor="#fff">
            <table width="90%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="100" colspan="3" align="center" background="<?php echo base_url(); ?>assets/mail/bg_header.png">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/mail/logo.png" border="0"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td height="40" colspan="3" valign="top">
                        <font size="+1" face="Arial, Helvetica, sans-serif" color="#333"><?php echo $subject; ?></font>
                    </td>
                </tr>
                <tr>
                    <td width="40" valign="top">&nbsp;</td>
                    <td width="520" valign="top" class="p_texto">
                        <p><?php echo $body; ?></p>
                    </td>
                    <td width="40" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">&nbsp;</td>
                    <td height="30" valign="top" class="p_texto">&nbsp;</td>
                    <td valign="top">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" background="<?php echo base_url(); ?>assets/mail/bg2.jpg" bgcolor="#FFFFFF">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="425">&nbsp;</td>
                    <td width="175">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <font size="1" face="Arial, Helvetica, sans-serif" color="#999"> <br/>
                        Copyright © <?php echo date('Y'); ?> - <?php echo $title; ?> 
                        </font>
                    </td>
                    <td align="right" valign="top">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/mail/logo2.png" border="0"/>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br /></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
