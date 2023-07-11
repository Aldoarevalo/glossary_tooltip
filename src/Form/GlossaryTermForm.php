<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $word = $_POST['word'];
  $descripcion = $_POST['descripcion'];

  // Valida los datos recibidos si es necesario

  // Realiza la operación de guardado en la base de datos
  $servername = "localhost";
  $database = "drupal";
  $username = "root";
  $password = "";

  $conn = mysqli_connect($servername, $username, $password, $database);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Verifica si la palabra ya existe en glossary_table
  $checkSql = "SELECT id FROM glossary_table WHERE word = '$word'";
  $checkResult = mysqli_query($conn, $checkSql);

  if (mysqli_num_rows($checkResult) > 0) {
    // La palabra ya existe, inserta solo la descripción en glossary_table_detalle
    $row = mysqli_fetch_assoc($checkResult);
    $glossaryId = $row['id'];

    $detalleSql = "INSERT INTO glossary_table_detalle (glossary_id, descripcion) VALUES ('$glossaryId', '$descripcion')";

    if (mysqli_query($conn, $detalleSql)) {
      echo "La descripción se ha guardado correctamente";
    } else {
      echo "Error al guardar la descripción: " . mysqli_error($conn);
    }
  } else {
    // La palabra no existe, inserta la palabra y la descripción en glossary_table y glossary_table_detalle
    $sql = "INSERT INTO glossary_table (word) VALUES ('$word')";

    if (mysqli_query($conn, $sql)) {
      $glossaryId = mysqli_insert_id($conn);

      $detalleSql = "INSERT INTO glossary_table_detalle (glossary_id, descripcion) VALUES ('$glossaryId', '$descripcion')";

      if (mysqli_query($conn, $detalleSql)) {
        echo "La palabra y la descripción se han guardado correctamente";
      } else {
        echo "Error al guardar la descripción: " . mysqli_error($conn);
      }
    } else {
      echo "Error al guardar la palabra: " . mysqli_error($conn);
    }
  }

  mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Glossary Term Form</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
  }

  h1 {
    color: #333;
    text-align: center;
    margin-top: 30px;
  }

  .container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-weight: bold;
  }

  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .form-group input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    cursor: pointer;
  }

  .glossary-list {
    margin-top: 40px;
  }

  .glossary-list table {
    width: 100%;
    border-collapse: collapse;
  }

  .glossary-list th,
  .glossary-list td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  .glossary-list th {
    background-color: #4CAF50;
    color: #fff;
  }

  .menu {
    background-color: #333;
    color: #fff;
    padding: 10px;
  }

  .menu a {
    color: #fff;
    text-decoration: none;
    margin-right: 10px;
  }

  .term-details {
    display: none;
    padding-left: 20px;
  }

  .term-details li {
    margin-bottom: 10px;
  }

  .highlight {
    background-color: green;
    color: white;
    padding: 2px 4px;
    border-radius: 3px;
  }
</style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#glossary-form').submit(function(event) {
        event.preventDefault();
        var word = $('#word').val();
        var descripcion = $('#descripcion').val();

        // Resalta las palabras ingresadas en los campos de texto
        var content = $('#content').html();
        var pattern = new RegExp('\\b' + word + '\\b', 'gi');
        var replacement = "<span class='highlight'>" + word + "</span>";
        content = content.replace(pattern, replacement);
        $('#content').html(content);

        // Realiza la petición AJAX para guardar los datos
        $.ajax({
          url: $(this).attr('action'),
          method: $(this).attr('method'),
          data: $(this).serialize(),
          success: function(response) {
            alert(response);
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText);
          }
        });

        // Limpia los campos de texto después de guardar los datos
        $('#word').val('');
        $('#descripcion').val('');
      });

      $('.glossary-list').on('click', '.show-details', function() {
        var details = $(this).next('.term-details');
        if (details.is(':visible')) {
          details.hide();
          $(this).text('Mostrar Detalles');
        } else {
          details.show();
          $(this).text('Ocultar Detalles');
        }
      });
    });
  </script>
</head>
<body>
  <div class="container">
    <h1>Glossary Term Form</h1>
    <form id="glossary-form" method="post" action="">
      <div class="form-group">
        <label for="word">Palabra:</label>
        <input type="text" id="word" name="word" required>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
      </div>

      <div class="form-group">
        <input type="submit" value="Grabar">
      </div>
    </form>

    <div id="content">
      <!-- Coloca aquí el contenido donde se realizará el escaneo y reemplazo de palabras -->
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo felis vel lorem convallis tincidunt. Nullam at sollicitudin nulla, ac sagittis ex. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin elementum mi eget velit aliquam, eu tempus nibh posuere. Mauris luctus, nisi in commodo bibendum, metus turpis interdum purus, id consectetur ante lacus non tortor.</p>
    </div>

    <div class="glossary-list">
      <?php
        // Obtén los términos del glosario de la base de datos
        $servername = "localhost";
        $database = "drupal";
        $username = "root";
        $password = "";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM glossary_table";
        $result = mysqli_query($conn, $sql);

        // Construye un array con los términos y descripciones
        $terms = array();
        while ($row = mysqli_fetch_assoc($result)) {
          $termId = $row['id'];
          $term = $row['word'];

          // Obtiene la descripción asociada a la palabra
          $detalleSql = "SELECT descripcion FROM glossary_table_detalle WHERE glossary_id = '$termId'";
          $detalleResult = mysqli_query($conn, $detalleSql);
          $descriptions = array();
          while ($detalleRow = mysqli_fetch_assoc($detalleResult)) {
            $descriptions[] = $detalleRow['descripcion'];
          }

          $terms[] = array(
            'term' => $term,
            'descriptions' => $descriptions
          );
        }

        mysqli_close($conn);

        // Imprime la lista de términos y descripciones
        if (!empty($terms)) {
          echo "<table>";
          echo "<tr><th>Palabra</th><th>Descripción</th></tr>";
          foreach ($terms as $term) {
            echo "<tr>";
            echo "<td><span class='highlight'>" . $term['term'] . "</span></td>";
            echo "<td>";
            if (!empty($term['descriptions'])) {
              echo "<button class='show-details'>Mostrar Detalles</button>";
              echo "<ul class='term-details'>";
              foreach ($term['descriptions'] as $description) {
                echo "<li>" . $description . "</li>";
              }
              echo "</ul>";
            }
            echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo "No hay términos disponibles";
        }
      ?>
    </div>
  </div>
</body>
</html>
