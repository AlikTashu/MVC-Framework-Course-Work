<div class="container-fluid">
    <div class="row">

        <?php foreach ($pages as $page): ?>
                <a href="/catalog/<?=$page?>"><?=$page?> </a>
        <?php endforeach; ?>


        <div class="col-md-10 offset-md-1">

            <section class="block">
                <h3 class="block__title">Catalog</h3>
                <hr class="block__line">


                <div class="row">


                    <div class="col-3">
                        <form class="box">
                            <section class="box">
                                <h5 class="box__title">Sort by</h5>
                                <select name="sort_by">
                                    <option selected value="price">Price</option>
                                    <option value="name">Name</option>
                                    <option value="brand">Brand</option>
                                </select>
                            </section>
                            <section class="box">
                                <h5 class="box__title">Categories</h5>
                                <ul class="box__menu">
                                    <?php foreach ($categories as $category): ?>
                                        <li class="box__menu-item">
                                            <input type="checkbox"
                                                   class="box__menu-link"><?= $category->name ?> </input>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                            <section class="box">
                                <button type="submit">Filter</button>
                            </section>
                        </form>
                    </div>
                    <div class="col-9">

                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <section class="product col-md-4">
                                    <a>
                                        <img class="product__image" src="<?= $product->image_path ?>"
                                             alt="Sample image">
                                        <hr class="product__line">
                                        <h5 class="product__title"><?= $product->title ?></h5>
                                        <p class="font-weight-bold text-muted"><?= $product->name ?></p>
                                        <p class="product__price">$<?= $product->totalDollars ?>.
                                            <span class="product__price--cents"><?= $product->totalCents ?></span>
                                        </p>
                                    </a>
                                </section>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>