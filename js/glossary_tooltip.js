(function ($) {
    Drupal.behaviors.glossaryTooltip = {
      attach: function (context, settings) {
        // Función para manejar la respuesta AJAX y actualizar el campo de selección.
        var handleAjaxResponse = function (response) {
          // Actualiza el campo de selección con los datos obtenidos de la respuesta AJAX.
          $('#edit-glossary-select', context).replaceWith(response.field_glossary_select);
  
          // Muestra un mensaje de éxito.
          $('.messages', context).html(response.message);
        };
  
        // Envía el formulario mediante AJAX cuando se hace clic en el botón de guardar.
        $('#edit-submit', context).click(function (e) {
          e.preventDefault();
  
          // Obtiene los valores del formulario.
          var description = $('#edit-description', context).val();
          var word = $('#edit-word', context).val();
  
          // Realiza la solicitud AJAX.
          $.ajax({
            url: '/glossary-term-ajax', // Ruta del controlador de AJAX personalizado en tu módulo.
            type: 'POST',
            dataType: 'json',
            data: {
              description: description,
              word: word
            },
            success: function (response) {
              handleAjaxResponse(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log('Error:', textStatus, errorThrown);
            }
          });
        });
      }
    };
  })(jQuery);
  