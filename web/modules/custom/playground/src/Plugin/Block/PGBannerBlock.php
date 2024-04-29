<?php

namespace Drupal\playground\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom block.
 *
 * @Block(
 *   id = "playground_banner",
 *   admin_label = @Translation("Banner"),
 * )
 */
class PGBannerBlock extends BlockBase implements ContainerFactoryPluginInterface {



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

    $menu_tree = \Drupal::menuTree();
    $menu_name = 'header-menu';

    $ids = \Drupal::service('menu.active_trail')->getActiveTrailIds($menu_name);

    $parameters = (new \Drupal\Core\Menu\MenuTreeParameters())->setActiveTrail($ids);

    $tree = $menu_tree
      ->load($menu_name, $parameters);

    $image = false;
    foreach($tree as $key => $link) {

      if (isset($link->subtree[reset($ids)])) {
        $image = $tree[$key]->link->pluginDefinition['options']['attributes']['image'];
      }
    }

    return [
      '#theme' => 'pg_banner',
      '#image' => $image
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
