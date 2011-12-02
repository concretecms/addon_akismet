<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

$form = Loader::helper('form');
$pkg = Package::getByHandle('recaptcha');
?>

<div class="clearfix">
	<?=$form->label('ANTISPAM_AKISMET_API_KEY', t('API Key'))?>
	<div class="input">
		<?=$form->text('ANTISPAM_AKISMET_API_KEY', $pkg->config('ANTISPAM_AKISMET_API_KEY'), array('class' => 'span4'))?>
	</div>
</div>