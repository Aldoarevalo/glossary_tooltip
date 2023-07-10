<?php

namespace Drupal\glossary_tooltip\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\glossary_tooltip\Form\GlossaryTooltipSettingsForm;
use Drupal\glossary_tooltip\Form\GlossaryTermForm;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for Glossary Tooltip functionality.
 */
class GlossaryTooltipController extends ControllerBase {

  /**
   * Renders the glossary tooltip page.
   *
   * @return array
   *   A render array representing the glossary tooltip page.
   */
  public function glossaryTooltipPage() {
    // Obtén el contenido de la página actual.
  $current_page = \Drupal::routeMatch()->getParameter('node');
  $content = $current_page->get('body')->value;

  // Obtén todos los términos de glosario publicados.
  $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
    'vid' => 'glossary',
    'status' => 1,
  ]);

  // Busca las palabras del glosario en el contenido de la página y agrega la descripción correspondiente.
  foreach ($terms as $term) {
    $word = $term->getName();
    $description = $term->getDescription();

    if (strpos($content, $word) !== false) {
      // Si se encuentra la palabra en el contenido, agrega la descripción.
      $content = str_replace($word, $word . '<br>' . $description, $content);
    }
  }

  // Crea el render array para la página con el contenido modificado.
  $build = [
    '#type' => 'markup',
    '#markup' => $content,
  ];

  return $build;
  }

   /**
   * Form callback for the glossary term form.
   *
   * @return array
   *   A render array representing the glossary term form.
   */
  public function glossaryTermForm() {
    // Create an instance of the GlossaryTermForm.
    $form = $this->formBuilder()->getForm(GlossaryTermForm::class);

    // Render the form and return it as part of the response.
    return [
      '#theme' => 'glossary_term_form',
      '#form' => $form,
    ];
  }

}
