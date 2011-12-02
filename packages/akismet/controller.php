<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class AkismetPackage extends Package {

	protected $pkgHandle = 'akismet';
	protected $appVersionRequired = '5.5.0b1';
	protected $pkgVersion = '1.0';
	
	public function getPackageDescription() {
		return t("Adds akismet as an anti-spam service.");
	}
	
	public function getPackageName() {
		return t("Akismet");
	}
	
	public function install() {
		$pkg = parent::install();
		Loader::model('system/antispam/library');
		SystemAntispamLibrary::add('akismet', t('Akismet'), $pkg);		
	}
	
}