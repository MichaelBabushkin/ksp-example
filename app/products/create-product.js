$(document).ready(function () {

    // show html form when 'create product' button was clicked
    $(document).on('click', '.create-product-button', function () {
        // load list of categories
        $.getJSON("http://localhost/ksp-example/branch/read.php", function (data) {
            // build categories option html
            // loop through returned list of data
            var branches_options_html = `<select name='category_id' class='form-control'>`;
            $.each(data.records, function (key, val) {
                branches_options_html += `<option value='` + val.id + `'>` + val.category_id + `</option>`;
            });
            branches_options_html += `</select>`;
            // we have our html form here where product information will be entered
            // we used the 'required' html5 property to prevent empty fields
            var create_product_html = `
 
        <!-- 'read products' button to show list of products -->
        <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
            <span class='glyphicon glyphicon-list'></span> Read Products
        </div>
        <!-- 'create product' html form -->
        <form id='create-product-form' action='#' method='post' border='0'>
            <table class='table table-hover table-responsive table-bordered'>
        
        <!-- Product ID field -->
        <tr>
            <td>Product ID</td>
            <td><input type='text' name='product_id' class='form-control' required /></td>
        </tr>


        <!-- branches 'select' field -->
        <tr>
            <td>Branch</td>
            <td>` + branches_options_html + `</td>
        </tr>

        <!-- Product Name field -->
        <tr>
            <td>Product Name</td>
            <td><input type='text' name='product_name' class='form-control' required /></td>
        </tr>

        
        <!-- description field -->
        <tr>
        <td>Description</td>
        <td><textarea name='description' class='form-control' required></textarea></td>
        </tr>
        
        <!-- price field -->
        <tr>
        <td>Price</td>
        <td><input type='number' min='1' name='price' class='form-control' required /></td>
        </tr>
        
        <!-- Category Name field -->
        <tr>
            <td>Category Name</td>
            <td><input type='text' name='category_name' class='form-control' required /></td>
        </tr>
 
 
        <!-- button to submit form -->
        <tr>
            <td></td>
            <td>
                <button type='submit' class='btn btn-primary'>
                    <span class='glyphicon glyphicon-plus'></span> Create Product
                </button>
            </td>
        </tr>
 
    </table>
</form>`;
            // inject html to 'page-content' of our app
            $("#page-content").html(create_product_html);

            // chage page title
            changePageTitle("Create Product");
        });
    });

    // will run if create product form was submitted
    $(document).on('submit', '#create-product-form', function () {
        // get form data
        var form_data = JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "http://localhost/ksp-example/product/create.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function (result) {
                // product was created, go back to products list
                showProductsFirstPage();            },
            error: function (xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});