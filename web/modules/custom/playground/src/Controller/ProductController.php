<?php

namespace Drupal\playground\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Defines the route controller.
 */
class ProductController extends ControllerBase {

  /**
   * Returns content for this controller.
   */
  public function cta(Request $request) {
    $currentUser = \Drupal::currentUser();
    $postData = $request->request->all();
    if ($currentUser->isAuthenticated()) {
      $email = $currentUser->getEmail();

      \Drupal::database()->insert('product_cta')
        ->fields([
          'nid' => $postData['id'],
          'email' => $email,
          'clicked' => \Drupal::time()->getRequestTime(),
        ])
        ->execute();

    }
    return new JsonResponse([
      'url' => "/node/{$postData['id']}"
    ]);
  }

}
