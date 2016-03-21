<?php

namespace Drupal\bd_contact;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class DeleteForm extends ConfirmFormBase {
  protected $id;

  function getFormId() {
    return 'bd_contact_delete';
  }

  function getQuestion() {
    return t('Are you sure you want to delete submission %id?', array('%id' => $this->id));
  }

  function getConfirmText() {
    return t('Delete');
  }

  function getCancelUrl() {
    return new Url('bd_contact_list');
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    return parent::buildForm($form, $form_state);
  }

  function submitForm(array &$form, FormStateInterface $form_state) {
    BdContactStorage::delete($this->id);
    //watchdog('bd_contact', 'Deleted BD Contact Submission with id %id.', array('%id' => $this->id));
    \Drupal::logger('bd_contact')->notice('@type: deleted %title.',
        array(
            '@type' => $this->id,
            '%title' => $this->id,
        ));
    drupal_set_message(t('BD Contact submission %id has been deleted.', array('%id' => $this->id)));
    $form_state->setRedirect('bd_contact_list');
  }
}
