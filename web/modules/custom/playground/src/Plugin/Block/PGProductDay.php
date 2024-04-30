<?php

namespace Drupal\playground\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

/**
 * Provides a custom block.
 *
 * @Block(
 *   id = "playground_product_day",
 *   admin_label = @Translation("Product of the day"),
 * )
 */
class PGProductDay extends BlockBase implements ContainerFactoryPluginInterface {



  /**
   * Constructs a TermListBlock object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($container, $configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $nids = playground_product_day();
    $node = FALSE;
    $image_url = FALSE;
    if (count($nids) > 0) {
      $key = rand(0, count($nids) - 1);

      $node = Node::load(array_values($nids)[$key]);

      if ($node->field_media_image->entity != NULL) {
        $image_uri = $node->field_media_image->entity->field_media_image->entity->getFileUri();
        $image_url = \Drupal::service('file_url_generator')->generateAbsoluteString($image_uri);
      }

    }

    return [
      '#theme' => 'pg_product_day',
      '#title' => 'Product of the Day!',
      '#node' => $node,
      '#image' => $image_url
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
