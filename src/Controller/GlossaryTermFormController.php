<?php

namespace Drupal\glossary_tooltip\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for displaying the glossary term form.
 */
class GlossaryTermFormController extends ControllerBase {

  /**
   * Constructs a GlossaryTermFormController object.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The route match service.
   */
  public function __construct(RouteMatchInterface $routeMatch) {
    $this->routeMatch = $routeMatch;
  }

  /**
   * Creates a new instance of the GlossaryTermFormController.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   *   The created instance of the GlossaryTermFormController.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match')
    );
  }

  /**
   * Displays the glossary term form.
   *
   * @return array|\Symfony\Component\HttpFoundation\Response
   *   The render array or response object representing the form.
   */
  public function showForm() {
    $form = $this->formBuilder()->getForm('\Drupal\glossary_tooltip\Form\GlossaryTermForm');

    // Build the render array for the form.
    $content = [
      'form' => $form,
    ];

    // Return the form as part of the response.
    return new Response($this->renderer()->render($content));
  }

}
