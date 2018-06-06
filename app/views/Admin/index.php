<div class="container-fluid">







    <div id="tableName" class="d-none">
        <?= $table ?>
    </div>

    <div id="fieldList" class="d-none">
        <?= json_encode($columns) ?>
    </div>


    <main class="container-fluid ">
        <h3 class="block__title">ADMIN PANEL</h3>
        <hr class="block__line">

        <div class="row mt-2 mb-2">
            <div class="col-2">
                <button class="btn-dark btn-block" id="add__button" >Add item</button>
            </div>
            <div class="col-1">
                <a class="" href="/admin/categories">Cаtegories</a>
            </div>
            <div class="col-1">
                <a class="" href="/admin/brands">Brands</a>
            </div>
            <div class="col-1">
                <a class="" href="/admin/models">Models</a>
            </div>
            <div class="col-1">
                <a class="" href="/admin/products">Products</a>
            </div>
            <div class="col-1">
                <a class="" href="/admin/users">Users</a>
            </div>
        </div>
        <div style="margin: 20px" id="form_holder">
            <!--form appends here-->
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>

                    <?php foreach ($columns as $value): ?>
                        <th scope="col" value="<?= $value ?>"><?= $value ?></th>
                    <?php endforeach; ?>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="table__body">

                <? foreach ($entities as $entity): ?>
                    <form action="/edit" name="row_form" method="post">
                        <tr>
                            <input type="hidden" name="table" value="<?= $table ?>">
                            <? foreach ($entity as $key => $value): ?>
                                <td><input <?= $key == 'id' ? 'readonly' : '' ?> name="<?= $key ?>"
                                                                                 value="<?= $value ?>"></td>
                            <? endforeach; ?>
                            <td>
                                <button type="submit" name="delete">Delete</button>
                            </td>
                            <td>
                                <button type="submit" name="edit">Edit</button>
                            </td>
                        </tr>
                    </form>
                <? endforeach; ?>

                </tbody>
            </table>
        </div>
    </main>

</div>
