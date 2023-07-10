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
  public function buildForm(array $form, FormStateInterface $form_state) {
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
    drupal_set_message($this->t('La palabra del glosario ha sido agregada correctamente.'), 'status');
  }

}