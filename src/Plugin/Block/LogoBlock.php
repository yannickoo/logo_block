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
  public function build() {
    $theme = \Drupal::theme()->getActiveTheme()->getName();
    $logo = theme_get_setting('logo', $theme);

    $image = [
      '#theme' => 'image',
      '#uri' => $logo['url'],
    ];

    $link = [
      '#type' => 'link',
      '#title' => \Drupal::service('renderer')->render($image),
      '#url' => Url::fromRoute('<front>'),
    ];

    return $link;
  }

}
