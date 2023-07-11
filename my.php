<?php

/**
 * Implements hook_menu().
 */
function mymodule_menu() {
  $items = array();

  // Enlace del menú para la página de administración de términos de glosario
  $items['admin/structure/glossary-term'] = array(
    'title' => 'Términos de Glosario',
    'description' => 'Administrar términos de glosario',
    'page callback' => 'drupal_goto',
    'page arguments' => array('admin/structure/glossary-term'),
    'access arguments' => array('administer site configuration'),
    'type' => MENU_NORMAL_ITEM,
  );

  return $items;
}
