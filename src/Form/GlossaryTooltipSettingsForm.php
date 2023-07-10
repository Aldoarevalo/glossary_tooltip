<?php

namespace Drupal\glossary_tooltip\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for displaying the glossary term form.
 */
class GlossaryTermFormController extends ControllerBase {

  /**
   * The route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a GlossaryTermFormController object.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   *   The route match service.
   * @param \Drupal\Core\Form\FormBuilderInterface $formBuilder
   *   The form builder service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(RouteMatchInterface $routeMatch, FormBuilderInterface $formBuilder, RendererInterface $renderer) {
    $this->routeMatch = $routeMatch;
    $this->formBuilder = $formBuilder;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match'),
      $container->get('form_builder'),
      $container->get('renderer')
    );
  }

  /**
   * Displays the glossary term form.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response object representing the form.
   */
  public function showForm() {
    $form = $this->formBuilder->getForm('\Drupal\glossary_tooltip\Form\GlossaryTermForm');

    // Build the render array for the form.
    $content = [
      'form' => $form,
    ];

    // Render the form and return it as part of the response.
    $output = $this->renderer->render($content);
    return new Response($output);
  }

}
