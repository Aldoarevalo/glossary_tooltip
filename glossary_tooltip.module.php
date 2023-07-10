<?php

use Drupal\Core\Form\FormStateInterface;

use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\taxonomy\Entity\Term;

use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Implements hook_help().
 */
function glossary_tooltip_help($route_name, RouteMatchInterface $route_match) {
  switch ($route_name) {
    case 'help.page.glossary_tooltip':
      return '<p>' . t('Display help for Glossary Tooltip module.') . '</p>';
  }
}

/**
 * Implements hook_menu().
 */
function glossary_tooltip_menu() {
  $items['admin/config/glossary_tooltip/form'] = [
    'title' => 'Formulario del glosario',
    'page callback' => 'drupal_get_form',
    'page arguments' => ['glossary_tooltip_custom_form'],
    'access arguments' => ['administer glossary tooltip'],
  ];

  $items['admin/config/glossary_tooltip/form-submit'] = [
    'title' => 'Envío del formulario del glosario',
    'page callback' => 'glossary_tooltip_custom_form_submit',
    'access arguments' => ['administer glossary tooltip'],
  ];

  return $items;
}

/**
 * Implements hook_permission().
 */
function glossary_tooltip_permission() {
  return [
    'administer glossary tooltip' => [
      'title' => t('Administer Glossary Tooltip'),
      'description' => t('Manage the Glossary Tooltip module settings.'),
    ],
  ];
}

/**
 * Custom form for the glossary.
 */
function glossary_tooltip_custom_form($form, &$form_state) {
  $form['word'] = [
    '#type' => 'textfield',
    '#title' => t('Palabra'),
    '#required' => TRUE,
  ];

  $form['description'] = [
    '#type' => 'textarea',
    '#title' => t('Descripción'),
    '#required' => TRUE,
  ];

  $form['submit'] = [
    '#type' => 'submit',
    '#value' => t('Agregar'),
  ];

  return $form;
}

/**
 * Submit handler for the glossary form.
 */
function glossary_tooltip_custom_form_submit($form, &$form_state) {
  // Implement the form submission logic here.
  $word = $form_state->getValue('word');
  $description = $form_state->getValue('description');

  // Save the word and description to your glossary.
  // For example, you can use taxonomy terms to store the glossary terms.

  drupal_set_message(t('La palabra del glosario ha sido agregada correctamente.'), 'status');
}
