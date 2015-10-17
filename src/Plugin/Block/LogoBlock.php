<?php

/**
 * @file
 * Contains Drupal\logo_block\Plugin\Block\Logo.
 */

namespace Drupal\logo_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a logo block.
 *
 * @Block(
 *  id = "logo",
 *  admin_label = @Translation("Logo"),
 * )
 */
class LogoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['linked'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Link logo'),
      '#description' => $this->t('Check when logo should be linked.'),
      '#default_value' => isset($this->configuration['linked']) ? $this->configuration['linked'] : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['linked'] = $form_state->getValue('linked');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $theme = \Drupal::theme()->getActiveTheme()->getName();
    $logo = theme_get_setting('logo', $theme);
    $linked = $this->configuration['linked'];

    $build = [
      '#theme' => 'image',
      '#uri' => $logo['url'],
    ];

    if ($linked) {
      $build = [
        '#type' => 'link',
        '#title' => \Drupal::service('renderer')->render($build),
        '#url' => Url::fromRoute('<front>'),
      ];
    }

    return $build;
  }

}
