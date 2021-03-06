<?php

defined('C5_EXECUTE') or die("Access Denied.");

class AclissFaq extends Object {

	static function getByID($afID) {
		$db = Loader::db();
		$data = $db->getRow('SELECT * FROM aclissfaq WHERE afID = ?', array($afID));
		if (!empty($data)) {
			$aclissfaq = new AclissFaq();
			$aclissfaq->setPropertiesFromArray($data);
		}
		return (is_a($aclissfaq, "AclissFaq")) ? $aclissfaq : false;
	}

	static function getByQuestion($question) {
		$db = Loader::db();
		$data = $db->getRow('SELECT * FROM aclissfaq WHERE question = ?', array($question));
		if (!empty($data)) {
			$aclissfaq = new AclissFaq();
			$aclissfaq->setPropertiesFromArray($data);
		}
		return (is_a($aclissfaq, "AclissFaq")) ? $aclissfaq : false;
	}

	public function delete() {
		$db = Loader::db();
		$db->execute("DELETE FROM aclissfaq where afID = ?", array($this->getAclissFaqID()));
	}

	public function save($data) {
		$db = Loader::db();
		$question = $data['question'];
		$answer = $data['answer'];
		$dh = Loader::helper('date');
		$afDate = $dh->getSystemDateTime(); 
		$vals = array($question, $answer, $afDate, $this->getAclissFaqID());
		$db->query("UPDATE aclissfaq SET question = ?, answer = ?, afDateModified = ? WHERE afID = ?", $vals);
		$aclissfaq = AclissFaq::getByID($this->getAclissFaqID());
		return (is_a($aclissfaq, "AclissFaq")) ? $aclissfaq : false;
	}

	public static function add($data) {
		$db = Loader::db();
		$question = $data['question'];
		$answer = $data['answer'];
		$dh = Loader::helper('date');
		$afDate = $dh->getSystemDateTime(); 
		$do = $db->GetOne("SELECT max(afDisplayOrder) as domax FROM aclissfaq");
		if ($do) {
			$displayOrder = $do['domax'] + 1;
		} else {
			$displayOrder = 1;
		}

		$vals = array($question, $answer, $displayOrder, $afDate, $afDate);
		$db->query("INSERT INTO aclissfaq (question, answer, afDisplayOrder, afDateAdd, afDateModified) VALUES (?, ?, ?, ?, ?)", $vals);
		$afID = $db->_insertID();
		if (intval($afID) > 0) {
			return AclissFaq::getByID($afID);
		} else {
			return false;
		}
	}

	function setFaqDisplayOrder($displayOrder) {

		$db = Loader::db();
		$displayOrder = intval($displayOrder);
		$sql = "UPDATE aclissfaq SET afDisplayOrder = afDisplayOrder - 1 WHERE afDisplayOrder > ?";
		$vals = array($this->afDisplayOrder);
		$db->Execute($sql, $vals);

		$sql = "UPDATE aclissfaq SET afDisplayOrder = afDisplayOrder + 1 WHERE afDisplayOrder >= ?";
		$vals = array($displayOrder);
		$db->Execute($sql, $vals);

		$sql = "UPDATE aclissfaq SET afDisplayOrder = ? WHERE afID = ?";
		$vals = array($displayOrder, $this->afID);
		$db->Execute($sql, $vals);
	}

	public function getQuestion() {
		return $this->question;
	}

	public function getAnswer() {
		return $this->answer;
	}

	public function getAclissFaqID() {
		return intval($this->afID);
	}

	function br2nl($str) {
		$str = str_replace("\r\n", "\n", $str);
		$str = str_replace("<br />\n", "\n", $str);
		return $str;
	}

	function getAnswerEditMode() {
		$answer = $this->translateFromEditMode($this->answer);
		return $answer;
	}

	public static function replacePagePlaceHolderOnImport($match) {
		$cPath = $match[1];
		if ($cPath) {
			$pc = Page::getByPath($cPath);
			return '{CCM:CID_' . $pc->getCollectionID() . '}';
		} else {
			return '{CCM:CID_1}';
		}
	}

	public static function replaceDefineOnImport($match) {
		$define = $match[1];
		if (defined($define)) {
			$r = get_defined_constants();
			return $r[$define];
		}
	}

	public static function replaceImagePlaceHolderOnImport($match) {
		$filename = $match[1];
		$db = Loader::db();
		$fID = $db->GetOne('select fintval(ID from FileVersions where filename = ?', array($filename));
		return '{CCM:FID_' . $fID . '}';
	}

	public static function replaceFilePlaceHolderOnImport($match) {
		$filename = $match[1];
		$db = Loader::db();
		$fID = $db->GetOne('select fID from FileVersions where filename = ?', array($filename));
		return '{CCM:FID_DL_' . $fID . '}';
	}

	function translateFromEditMode($text) {
		// now we add in support for the links

		$text = preg_replace(
				'/{CCM:CID_([0-9]+)}/i', BASE_URL . DIR_REL . '/' . DISPATCHER_FILENAME . '?cID=\\1', $text);

		// now we add in support for the files

		$text = preg_replace_callback(
				'/{CCM:FID_([0-9]+)}/i', array('AclissFaq', 'replaceFileIDInEditMode'), $text);


		$text = preg_replace_callback(
				'/{CCM:FID_DL_([0-9]+)}/i', array('AclissFaq', 'replaceDownloadFileIDInEditMode'), $text);


		return $text;
	}

	function translateFrom($text) {
		// old stuff. Can remove in a later version.
		$text = str_replace('href="{[CCM:BASE_URL]}', 'href="' . BASE_URL . DIR_REL, $text);
		$text = str_replace('src="{[CCM:REL_DIR_FILES_UPLOADED]}', 'src="' . BASE_URL . REL_DIR_FILES_UPLOADED, $text);

		// we have the second one below with the backslash due to a screwup in the
		// 5.1 release. Can remove in a later version.

		$text = preg_replace(
				array(
			'/{\[CCM:BASE_URL\]}/i',
			'/{CCM:BASE_URL}/i'), array(
			BASE_URL . DIR_REL,
			BASE_URL . DIR_REL)
				, $text);

		// now we add in support for the links

		$text = preg_replace_callback(
				'/{CCM:CID_([0-9]+)}/i', array('AclissFaq', 'replaceCollectionID'), $text);

		$text = preg_replace_callback(
				'/<img [^>]*src\s*=\s*"{CCM:FID_([0-9]+)}"[^>]*>/i', array('AclissFaq', 'replaceImageID'), $text);

		// now we add in support for the files that we view inline			
		$text = preg_replace_callback(
				'/{CCM:FID_([0-9]+)}/i', array('AclissFaq', 'replaceFileID'), $text);

		// now files we download

		$text = preg_replace_callback(
				'/{CCM:FID_DL_([0-9]+)}/i', array('AclissFaq', 'replaceDownloadFileID'), $text);

		return $text;
	}

	private function replaceFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$path = File::getRelativePathFromID($fID);
			return $path;
		}
	}

	private function replaceImageID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			preg_match('/width\s*="([0-9]+)"/', $match[0], $matchWidth);
			preg_match('/height\s*="([0-9]+)"/', $match[0], $matchHeight);
			$file = File::getByID($fID);
			if (is_object($file) && (!$file->isError())) {
				$imgHelper = Loader::helper('image');
				$maxWidth = ($matchWidth[1]) ? $matchWidth[1] : $file->getAttribute('width');
				$maxHeight = ($matchHeight[1]) ? $matchHeight[1] : $file->getAttribute('height');
				if ($file->getAttribute('width') > $maxWidth || $file->getAttribute('height') > $maxHeight) {
					$thumb = $imgHelper->getThumbnail($file, $maxWidth, $maxHeight);
					return preg_replace('/{CCM:FID_([0-9]+)}/i', $thumb->src, $match[0]);
				}
			}
			return $match[0];
		}
	}

	private function replaceDownloadFileID($match) {
		$fID = $match[1];
		if ($fID > 0) {
			$c = Page::getCurrentPage();
			if (is_object($c)) {
				return View::url('/download_file', 'view', $fID, $c->getCollectionID());
			} else {
				return View::url('/download_file', 'view', $fID);
			}
		}
	}

	private function replaceDownloadFileIDInEditMode($match) {
		$fID = $match[1];
		if ($fID > 0) {
			return View::url('/download_file', 'view', $fID);
		}
	}

	private function replaceFileIDInEditMode($match) {
		$fID = $match[1];
		return View::url('/download_file', 'view_inline', $fID);
	}

	private function replaceCollectionID($match) {
		$cID = $match[1];
		if ($cID > 0) {
			$c = Page::getByID($cID, 'APPROVED');
			return Loader::helper("navigation")->getLinkToCollection($c);
		}
	}

	public static function translateTo($text) {
		// keep links valid
		$url1 = str_replace('/', '\/', BASE_URL . DIR_REL . '/' . DISPATCHER_FILENAME);
		$url2 = str_replace('/', '\/', BASE_URL . DIR_REL);
		$url3 = View::url('/download_file', 'view_inline');
		$url3 = str_replace('/', '\/', $url3);
		$url3 = str_replace('-', '\-', $url3);
		$url4 = View::url('/download_file', 'view');
		$url4 = str_replace('/', '\/', $url4);
		$url4 = str_replace('-', '\-', $url4);
		$text = preg_replace(
				array(
			'/' . $url1 . '\?cID=([0-9]+)/i',
			'/' . $url3 . '([0-9]+)\//i',
			'/' . $url4 . '([0-9]+)\//i',
			'/' . $url2 . '/i'), array(
			'{CCM:CID_\\1}',
			'{CCM:FID_\\1}',
			'{CCM:FID_DL_\\1}',
			'{CCM:BASE_URL}')
				, $text);
		return $text;
	}

}