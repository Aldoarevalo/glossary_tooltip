<?php

namespace Drupal\glossary_tooltip\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\taxonomy\Entity\TermInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for displaying the glossary term form.
 */
class GlossaryTermFormController extends ControllerBase {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a GlossaryTermFormController object.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $formBuilder
   *   The form builder service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(FormBuilderInterface $formBuilder, MessengerInterface $messenger) {
    $this->formBuilder = $formBuilder;
    $this->messenger = $messenger;
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
      $container->get('form_builder'),
      $container->get('messenger')
    );
  }

  /**
   * Displays the glossary term form.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response object representing the form.
   
  * @Route("/admin/structure/form_action", name="glossary_tooltip.form_action")
 */
  public function showForm() {
    $form = $this->formBuilder->getForm('\Drupal\glossary_tooltip\Form\GlossaryTermForm');

    // Render the form.
    $renderedForm = \Drupal::service('renderer')->render($form);

    return new Response($renderedForm);
  }

  public function showForm1() {
    $form = $this->formBuilder->getForm('\Drupal\glossary_tooltip\Form\submit');

    // Render the form.
    $renderedForm = \Drupal::service('renderer')->render($form);

    return new Response($renderedForm);
  }
 

  /**
   * Submits the glossary term form.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Obtén los valores del formulario.
    $word = $form_state->getValue('word');
    $description = $form_state->getValue('description');
  
    // Crea el término de glosario y guárdalo como entidad de taxonomía.
    $term = TermInterface::create([
      'vid' => 'glossary',
      'name' => $word,
      'description' => $description,
    ]);
    $term->save();
  
    // Muestra un mensaje de éxito.
    $this->messenger->addStatus($this->t('El término del glosario se ha agregado correctamente.'));
  
    // Redirige al usuario a la página del formulario de acción.
    $response = new RedirectResponse('/admin/structure/glossary-term');
    $response->send();
  }

  /**
 * Implements hook_ENTITY_TYPE_presave() for node entities.
 */
public function nodePresave(EntityInterface $entity) {
    if ($entity->getEntityTypeId() === 'node' && $entity->bundle() === 'page') {
      $content = $entity->get('body')->value;
  
      // Obtiene todos los términos de glosario publicados.
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
  
      // Actualiza el campo de contenido de la página con la descripción agregada.
      $entity->set('body', $content);
    }
  }
  

}
