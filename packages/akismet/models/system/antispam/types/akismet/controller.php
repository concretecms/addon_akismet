<?

class AkismetSystemAntispamTypeController extends Object {
	
	public function saveOptions($args) {
		$pkg = Package::getByHandle('akismet');
		$pkg->saveConfig('ANTISPAM_AKISMET_API_KEY', $args['ANTISPAM_AKISMET_API_KEY']);
	}

	public function report($args) {
		Loader::library('3rdparty/microakismet/library', 'akismet');
		$pkg = Package::getByHandle('akismet');
		$akismet = new MicroAkismet($pkg->config('ANTISPAM_AKISMET_API_KEY'), BASE_URL . DIR_REL, t('concrete5 Akismet Plugin') );
		$v = array();
		$v['user_ip'] = $args['ip_address'];
		$v['user_agent'] = $args['user_agent'];
		$v['comment_type'] = $args['type'];
		$v['comment_author'] = $args['author'];
		$v['comment_author_email'] = $args['author_email'];
		$v['comment_content'] = $args['content'];
		$akismet->spam($v);
	}

	public function check($args) {
		$pkg = Package::getByHandle('akismet');
		Loader::library('3rdparty/microakismet/library', 'akismet');
		$c = Page::getCurrentPage();
		if (is_object($c)) { 
			$link = Loader::helper('navigation')->getLinkToCollection($c, true);
		} else { 
			$link = BASE_URL . DIR_REL;
		}
		$v = array();
		$v['user_ip'] = $args['ip_address'];
		$v['user_agent'] = $args['user_agent'];
		$v['comment_content'] = $args['content'];

		$akismet = new MicroAkismet($pkg->config('ANTISPAM_AKISMET_API_KEY'), $link, t('concrete5 Akismet Plugin') );
		$r = $akismet->check( $v );
		if (!$r) {
			return true; // it passes the test
		} else {
			return false;
		}

		/*
		Each function takes one argument, $vars, which is a list of information
		about the comment that is being checked.  $vars *must* contain at least
		this information:
		
		   $vars["user_ip"]              // The IP of the comment poster
		   $vars["user_agent"]           // The user-agent of the comment poster
		
		The "blog" value (the homepage of the blog that this post came from) is
		added automatically by the code.  The following extra information can also
		be added, to help Akismet classify the message more accurately:
		
		   $vars["referrer"]             // The content of the HTTP_REFERER header
		   $vars["permalink"]            // Permalink to the comment
		   $vars["comment_type"]         // May be blank, comment, trackback, etc
		   $vars["comment_author"]       // Submitted name with the comment
		   $vars["comment_author_email"] // Submitted email address
		   $vars["comment_author_url"]   // Commenter URL
		   $vars["comment_content"]      // The content that was submitted

		*/
		
		
	}

}