<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add More Field Using</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body class="bg-dark">
    <div class="container">
        <div class="row my-4">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow">
                    <div class="card-header">
                        <h4>Add Items</h4>
                    </div>

                    <div class="card-body p-4">
                        <div id="show_alert"></div>
                        <form action="#" method="POST" id="add_form">
                            <div id="show_item">
                                <div class="row">
                                    <!-- Inputs -->
                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="product_name[]" class="form-control" placeholder="Nombre Articulo" require>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <input type="number" name="product_price[]" class="form-control" placeholder="Precio Articulo" require>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <input type="number" name="product_qty[]" class="form-control" placeholder="Cantidad Articulo" require>
                                    </div>

                                    <div class="col-md-2 mb-3 d-grid">
                                        <button class="btn btn-success add_item_btn">Agregar Más</button>
                                    </div>
                                </div>
                            </div> <!-- End Row -->

                            <!-- Boton Submit -->
                            <div>
                                <input type="submit" value="Agregar" class="btn btn-primary w-25" id="add_btn">
                                <a href="index.php" class="btn btn-danger" target="_blank">Crear PDF</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".add_item_btn").click(function(e) { // Cunado se haga click en el boton agregar "Muestrame este otro contenido"
                e.preventDefault();
                $("#show_item").prepend(`
                <div class="row append_item">
                                    <!-- Inputs -->
                                    <div class="col-md-4 mb-3">
                                        <input type="text" name="product_name[]" class="form-control" placeholder="Nombre Articulo" require>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <input type="number" name="product_price[]" class="form-control" placeholder="Precio Articulo" require>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <input type="number" name="product_qty[]" class="form-control" placeholder="Cantidad Articulo" require>
                                    </div>

                                    <div class="col-md-2 mb-3 d-grid">
                                        <button class="btn btn-danger remove_item_btn">Remover</button>
                                    </div>
                                </div>
                            </div> <!-- End Row --> 
                `);
            });

            // Si das click en boton "Remover" quita los "Items" agregados
            $(document).on('click', '.remove_item_btn', function(e) {
                e.preventDefault()
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            });

            // Solicitud con ajax
            $("#add_form").submit(function(e) {
                e.preventDefault();
                $("add_btn").val('Adding...');
                $.ajax({
                    url:"action.php",
                    method: "post",
                    data: $(this).serialize(),
                    success:function(response){
                        $("#add_btn").val("Add");
                        $("#add_form")[0].reset();
                        $(".append_item").remove();
                        $("#show_alert").html(`<div class="alert alert-success" role="alert">${response}</div>`)
                    }
                });
            });
        })
    </script>

</body>

</html>