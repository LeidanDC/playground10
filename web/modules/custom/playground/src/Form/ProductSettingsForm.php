<?php

namespace Drupal\playground\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ProductSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'playground_product_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'playground.product_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('playground.product_settings');
    $form['block_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Product of the day block title'),
      '#default_value' => $config->get('block_title') ?? '',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('playground.product_settings')
      ->set('block_title', $form_state->getValue('block_title'))
      ->save();
    return parent::submitForm($form, $form_state);
  }
}
