<?php

namespace Drupal\glossary_tooltip\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Formulario para agregar términos al glosario.
 */
class GlossaryTermForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'glossary_term_form';
  }

  /**
   * {@inheritdoc}
   */
  
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['word'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Palabra'),
      '#required' => TRUE,
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Descripción'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Agregar'),
      '#submit' => ['::submitForm'],
    ];
 
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Implementa la lógica de validación aquí si es necesario.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Obtiene los valores del formulario.
    $word = $form_state->getValue('word');
    $description = $form_state->getValue('description');
  
    // Crea el término de glosario y lo guarda en una entidad de taxonomía.
    $term = Term::create([
      'vid' => 'glossary',
      'name' => $word,
      'description' => $description,
    ]);
    $term->save();
  
    // Muestra un mensaje de éxito.
    $message = $this->t('La palabra del glosario ha sido agregada correctamente.');

    // Obtiene la lista de glosario y la agrega al mensaje.
    $glossaryList = $this->buildGlossaryList();
    $message .= $glossaryList['#markup'];

    drupal_set_message($message);
    $form_state->setRedirect('entity.taxonomy_term.collection', ['taxonomy_vocabulary' => 'glossary']);

  }

  /**
   * {@inheritdoc}
   */
  public function buildGlossaryList() {
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
      'vid' => 'glossary',
      'status' => 1,
    ]);

    $content = '<ul>';
    foreach ($terms as $term) {
      $word = $term->getName();
      $description = $term->getDescription();

      $content .= '<li>' . $word . ': ' . $description . '</li>';
    }
    $content .= '</ul>';

    return [
      '#markup' => $content,
    ];
  }

}
