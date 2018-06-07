<div class="container-fluid">
    <div class="row">



        <div class="col-md-10 offset-md-1">

            <section class="block">
                <h3 class="block__title">Catalog</h3>
                <hr class="block__line">


                <div class="row">



                    <div class="col-3">
                        <form action = "/catalog" class="filter" method="get">
                            <section class="filter__section">
                                <h5 class="filter__title">Sort by</h5>
                                <select class="filter__select" name="sort_by">
                                    <option class="filter__option" selected value="price">Price</option>
                                    <option class="filter__option" value="name">Name</option>
                                </select>
                            </section>
                            <section class="filter__section">
                                <h5 class="filter__title">Categories</h5>
                                <ul class="filter__menu">
                                    <?php foreach ($categories as $category): ?>
                                        <li class="filter__menu-item">
                                            <input type="checkbox"
                                                   class="filter__menu-input" name="categories[]" value="<?= $category->name ?>"><?= $category->name ?> </input>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                            <section class="filter__section">
                                <h5 class="filter__title">Brands</h5>
                                <ul class="filter__menu">
                                    <?php foreach ($brands as $brand): ?>
                                        <li class="filter__menu-item">
                                            <input type="checkbox"
                                                   class="filter__menu-input" name="brands[]" value="<?= $brand->name ?>"><?= $brand->name ?> </input>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                            <section class="filter__section">
                                <button class="button button--bordered filter__button">Filter</button>
                            </section>
                        </form>
                    </div>




                    <div class="col-9">
                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <section class="product col-md-4">
                                    <a">
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
                        <div class="block__line"></div>
                        <div class="pages">
                            <ul class="pages__list">

                                <?php foreach ($pages as $page): ?>
                                <li class="pages__list-item">
                                    <a class="pages__list-link" href="/catalog/<?=$page?>?<?=$queryParams?>"><?=($page==$currentPage?"<span style='color:#ed1c24'>{$page}</span>":$page)?> </a>
                                </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>