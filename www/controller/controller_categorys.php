<?php
include_once "../models/functions.php";
$name_category = $_POST["name_category"];
$category_uppercase = strtoupper($name_category);
$status = 1;
// Verificar si la categoría ya existe
if (category_exists($category_uppercase)) {
    echo '<script>
    localStorage.setItem("mensaje", "La categoria ya existe. Por favor, elija un nombre diferente");
    localStorage.setItem("tipo", "error");
    window.location.href = "../views/crud_category.php";
        </script>';  
} else {
    // Insertar la nueva categoría
    if (add_category($category_uppercase, $status)) {
        echo '<script>
                localStorage.setItem("mensaje", "Categoría creada con éxito");
                localStorage.setItem("tipo", "success");
                window.location.href = "../views/crud_category.php";
                    </script>';     
    } else {
        echo '<script>
        localStorage.setItem("mensaje", "Error al crear la categoria");
        localStorage.setItem("tipo", "error");
        window.location.href = "../views/crud_category.php";
            </script>';
    }
}
?>
