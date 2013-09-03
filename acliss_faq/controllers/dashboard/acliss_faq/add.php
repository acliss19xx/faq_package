<?php

defined('C5_EXECUTE') or die("Access Denied.");

class DashboardAclissFaqAddController extends Controller {

	public function on_start() {
		Loader::model('acliss_faq', 'acliss_faq');
		Loader::model('acliss_faq_list', 'acliss_faq');
		$this->set('form', Loader::helper('form'));
		$this->set('valt', Loader::helper('validation/token'));
		$this->set('valc', Loader::helper('concrete/validation'));
		$this->set('ih', Loader::helper('concrete/interface'));

		$this->error = Loader::helper('validation/error');
	}

	public function view() {

		$vals = Loader::helper('validation/strings');
		$valt = Loader::helper('validation/token');
		$valc = Loader::helper('concrete/validation');

		if ($_POST['create']) {

			$question = $_POST['question'];
			if (!$vals->notempty($question)) {
				$this->error->add(t('Please include a question.'));
			}

			$answer = $_POST['answer'];
			if (!$vals->notempty($answer)) {
				$this->error->add(t('Please include answer.'));
			}


			if (!$this->error->has()) {
				$data = array(
					'question' => $question,
					'answer' => $answer);
				$aclissfaq = AclissFaq::add($data);
				if (is_a($aclissfaq, "AclissFaq")) {
					$this->redirect('/dashboard/acliss_faq/search?afID=' . $aclissfaq->getAclissFaqID() . '&acliss_faq_created=1');
				} else {
					$this->error->add(t('An error occurred while trying to create this FAQ.'));
					$this->set('error', $this->error);
				}
			} else {
				$this->set('error', $this->error);
			}
		}

		if ($_POST['update']) {

			$afID = $_POST['afID'];
			if (!intval($afID) > 0) {
				$this->error->add(t('Invalid FAQ ID.'));
			}

			$question = $_POST['question'];
			if (!$vals->notempty($question)) {
				$this->error->add(t('Please include a question.'));
			}

			$answer = $_POST['answer'];
			if (!$vals->notempty($answer)) {
				$this->error->add(t('Please include answer.'));
			}

			if (!$valt->validate('update_acliss_faq')) {
				$this->error->add($valt->getErrorMessage());
			}

			if (!$this->error->has()) {
				$aclissfaq = AclissFaq::getByID($afID);
				$data = array(
					'question' => $question,
					'answer' => $answer);
				if (is_a($aclissfaq, "AclissFaq")) {
					$aclissfaq->save($data);
					$this->redirect('/dashboard/acliss_faq/search?afID=' . $aclissfaq->getAclissFaqID() . '&acliss_faq_updated=1');
				} else {
					$this->error->add(t('An error occurred while trying to update this FAQ.'));
					$this->set('error', $this->error);
				}
			} else {
				$this->set('error', $this->error);
			}
		}
	}

	public function edit($afID) {
		$aclissfaq = AclissFaq::getByID($afID);
		if (is_a($aclissfaq, "AclissFaq")) {
			$this->set("aclissfaq", $aclissfaq);
			$this->view();
		} else {
			$this->error->add(t("Invalid FAQ ID"));
		}
	}

	public function delete($afID) {
		$valt = Loader::helper('validation/token');
		if (!$valt->validate('delete_acliss_faq')) {
			$this->error->add($valt->getErrorMessage());
		}

		if (!$this->error->has()) {

			$aclissfaq = AclissFaq::getByID($afID);

			if (is_a($aclissfaq, "AclissFaq")) {
				$aclissfaq->delete();
				$this->redirect('/dashboard/acliss_faq/search?acliss_faq_deleted=1');
			}
		} else {
			$aclissfaq = AclissFaq::getByID($afID);
			if (is_a($aclissfaq, "AclissFaq")) {
				$this->set("aclissfaq", $aclissfaq);
				$this->set("delete", 1);
				$this->view();
			} else {
				$this->error->add(t("Invalid FAQ ID"));
			}
			$this->set('error', $this->error);
		}
	}

	public function confirm_delete($afID) {
		$aclissfaq = AclissFaq::getByID($afID);
		if (is_a($aclissfaq, "AclissFaq")) {
			$this->set("aclissfaq", $aclissfaq);
			$this->set("delete", 1);
			$this->view();
		} else {
			$this->error->add(t("Invalid FAQ ID"));
			$this->view();
		}
	}

}
