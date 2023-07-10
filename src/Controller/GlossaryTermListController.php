<?php
use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;

// ...

class GlossaryTermListController extends ControllerBase {

  public function build() {
    // Obtener los términos del glosario.
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'glossary',
      'status' => 1,
    ]);

    // Construir el contenido de la lista de términos del glosario.
    $content = '<ul>';
    foreach ($terms as $term) {
      $word = $term->getName();
      $description = $term->getDescription();

      $content .= '<li>' . $word . ': ' . $description . '</li>';
    }
    $content .= '</ul>';

    // Crear el render array para la página de visualización del glosario.
    $build = [
      '#markup' => $content,
    ];

    return $build;
  }

}
