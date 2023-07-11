<?php

namespace Drupal\glossary_tooltip\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Database\Database;
use Drupal\Core\Database\DatabaseExceptionWrapper;

/**
 * Defines the Glossary entity.
 *
 * @ContentEntityType(
 *   id = "glossary_entity",
 *   label = @Translation("Glossary"),
 *   base_table = "key_value",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "word",
 *   },
 * )
 */
class GlossaryEntity extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Define fields for your entity, e.g., word and description.
    $fields['word'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Word'))
      ->setRequired(TRUE)
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ]);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 0,
      ]);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public static function getFormClass(EntityTypeInterface $entity_type) {
    return '\Drupal\glossary_tooltip\Form\GlossaryTermForm';
  }

  /**
   * {@inheritdoc}
   */
  public function save() {
    try {
      $connection = Database::getConnection();
      $query = $connection->insert('key_value')
        ->fields([
          'word' => $this->word->value,
          'description' => $this->description->value,
        ])
        ->execute();
    } catch (DatabaseExceptionWrapper $e) {
      echo('error  fatal y grave');
        // Handle database exception.
    }

    parent::save();
  }

}
