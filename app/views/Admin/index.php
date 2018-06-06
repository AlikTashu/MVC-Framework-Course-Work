<div class="container-fluid">
    <!--    <div class="row">-->
    <!--        <div class="col-md-10 offset-md-1">-->
    <!---->
    <!--            <section class="block">-->
    <h3 class="block__title">TEST TEST</h3>
    <hr class="block__line">


    <form style="" action="admin" method="post">
        <p><select name="selection">
                <option disabled>Choose table</option>
                <option value="brands">brands</option>
                <option selected value="categories">categories</option>
                <option value="models">models</option>
                <option value="products">products</option>
                <option value="users">users</option>
            </select></p>
        <p><input type="submit" name="sub_btn" value="Submit"></p>
    </form>
    <div>
        <button id="add__button" onclick="appendRow()" style="margin: 10px">Add item</button>
    </div>

    <div style="margin: 20px" id="form_holder">

    </div>

    <div id="tableName" class="d-none">
        <?= $table ?>
    </div>
</div>

<div id="fieldList" class="d-none">
    <?= json_encode($columns) ?>
</div></div>

<table class="table table-fit">
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
                    <td><input <?= $key == 'id' ? 'readonly' : '' ?> name="<?= $key ?>" value="<?= $value ?>"></td>
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

<!---->
<!--            </section>-->
<!--        </div>-->
</div>
