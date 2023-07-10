<?php

namespace Drupal\glossary_tooltip\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Entity\EntityTypeManagerInterface;

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
      '#value' => $this->t('Grabar'),
      '#submit' => [[$this, 'submitForm']],
    ];

    // Agregar la lista de términos del glosario debajo del formulario.
    $form['glossary_list'] = $this->buildGlossaryList();

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
    // Obtén los valores enviados por el formulario.
    $values = $form_state->getValues();

    // Crea una conexión a la base de datos.
    $connection = Database::getConnection();

    // Guarda la palabra en la base de datos.
    $connection->insert('glossary_table')
      ->fields([
        'title' => $values['title'],
        'word' => $values['word'],
      ])
      ->execute();
      var_dump($values);
    // Muestra un mensaje de éxito.
    \Drupal::messenger()->addMessage($this->t('La palabra se ha guardado correctamente.'));

    // /Redirecciona al formulario vacío después de guardar.
    $form_state->setRedirect('glossary_tooltip.glossary_term_form');
  }

  /**
   * Construye la lista de términos del glosario.
   *
   * @return array
   *   La lista de términos del glosario.
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
