<?php
/**
@file
Contains \Drupal\bd_contact\Controller\AdminController.
 */

namespace Drupal\bd_contact\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\bd_contact\BdContactStorage;

class AdminController extends ControllerBase {

function contentOriginal() {
  $url = Url::fromRoute('bd_contact_add');
  //$add_link = ;
  $add_link = '<p>' . \Drupal::l(t('New message'), $url) . '</p>';

  // Table header
  $header = array( 'id' => t('Id'), 'name' => t('Submitter name'), 'message' => t('Message'), 'operations' => t('Delete'), );

  $rows = array();
  foreach(BdContactStorage::getAll() as $id=>$content) {
    // Row with attributes on the row and some of its cells.
    $rows[] = array( 'data' => array($id, $content->name, $content->message, l('Delete', "admin/content/bd_contact/delete/$id")) );
   }

   $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'bd-contact-table', ), );
   return $add_link . drupal_render($table);
 }

  public function content1() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello World'),
    );
  }

  function content() {
    $url = Url::fromRoute('bd_contact_add');
    //$add_link = ;
    $add_link = '<p>' . \Drupal::l(t('New message'), $url) . '</p>';

    $text = array(
      '#type' => 'markup',
      '#markup' => $add_link,
    );

    // Table header.
    $header = array(
      'id' => t('Id'),
      'name' => t('Submitter name'),
      'message' => t('Message'),
      'operations' => t('Delete'),
    );
    $rows = array();
    foreach (BdContactStorage::getAll() as $id => $content) {
      // Row with attributes on the row and some of its cells.
      $editUrl = Url::fromRoute('bd_contact_edit', array('id' => $id));
      $deleteUrl = Url::fromRoute('bd_contact_delete', array('id' => $id));

      $rows[] = array(
        'data' => array(
          \Drupal::l($id, $editUrl),
          $content->name, $content->message,
          \Drupal::l('Delete', $deleteUrl)
        ),
      );
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'bd-contact-table',
      ),
    );
    //return $add_link . ($table);
    return array(
      $text,
      $table,
    );
  }
}
