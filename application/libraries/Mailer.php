<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mailer
{
    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config('custom_config');
    }

    function mailer_template($args)
    {
        $content = $args['CONTENT'];
        $base_url = $this->ci->config->item('BASE_URL');
        $banner = $base_url.'/assets/images/mailer/banner.jpg';
        $logo_url = $base_url.'/assets/images/mailer/logo.png';
        $html =<<<HTML

<!DOCTYPE html>
<html>
<head>
    <title>Klentano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <table width="650" border="0" cellpadding="0" cellspacing="0" align="center" style="border:1px solid #bfbfbf;border-bottom:3px solid #bfbfbf;">
	<tr>
		<td style="font-family:Arial;font-size:12px;background:#ceedff;padding:20px;border-bottom:3px solid #f7a02e;text-align:center;">
			  <img src="<?php echo $logo_url; ?>" style="width:120px;height:auto;" />
		</td>
	</tr>
	<tr>	
		<td align="center"><p style="font-family:arial;display:block;font-size:14px;padding:20px;">$content</td>
	</tr>
	<tr>	
		<td align="center"><p style="font-family:arial;display:block;font-size:11px;padding:20px;border-top:1px solid #bfbfbf;background:#f1f1f1;margin-bottom:0px;">Copyright © 2020 ElKlentano. All rights reserved.</td>
	</tr>

</table>
</body>
</html>
HTML;
        return $html;
    }

    function smtp($args)
    {
        $this->ci->load->library('email');

        $subject = isset($args['SUBJECT']) && $args['SUBJECT']?$args['SUBJECT'] : 'Welcome to Klentano'; 
        $to_email = isset($args['EMAIL']) && $args['EMAIL'] ? $args['EMAIL'] : '';
        #$to_email = 'dheerusingh59@gmail.com';

        $from_email = isset($args['FROM']) && $args['FROM'] ? $args['FROM'] : $this->ci->config->item('FROM_EMAIL');

        $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => $this->ci->config->item('SMTP_HOST'),
                'smtp_port' => $this->ci->config->item('SMTP_PORT'),
                'smtp_user' => $this->ci->config->item('SMTP_USER'),
                'smtp_pass' => $this->ci->config->item('SMTP_PASS'),
                'mailtype'  => 'html',
                'charset'   => 'utf-8'
                );
        $this->ci->email->initialize($config);
        $this->ci->email->set_mailtype("html");
        $this->ci->email->set_newline("\r\n");

        $htmlContent = $this->mailer_template(array('CONTENT' => $args['CONTENT']));
        #$htmlContent = $args['CONTENT'];

        $this->ci->email->to($to_email);
        $this->ci->email->from($from_email,'Klentano');
        $this->ci->email->subject($subject);
        $this->ci->email->message($htmlContent);
        #$this->ci->email->set_header('x-job', '99999');
        #$this->ci->email->set_header('X-Priority', '1');

        if(!$this->ci->email->send())
        {
            return 0;
        }
        return 1;
    }

}
