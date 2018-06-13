<div class="container-fluid">
    <div class="row">
        <div class="jumbotron">
            <div class="row">
                <section class="col-lg-4 offset-lg-7 ">
                    <h3 class="jumbotron__title">ShoeShop</h3>
                    <p class="jumbotron__text">A great pair of shoes can take your entire look from flat to fantastic! Slip into a pair of shoes that allow you to define your personality no matter the color or silhouette. Just because you're hunting for a great price on a pair of high-quality brand-name shoes doesn't mean you should be limited to a small clearance section in a store. Expand your horizons with the amazing variety of shoes at 6pm.com! Let your feet explore this vast selection of top brand name shoes. </p>
                    <button class="button jumbotron__button">show me more</button>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 offset-md-1">
            <article class="card card--keds">
                <h5 class="card__title">2014 Chuck Taylor ALL STARS</h5>
                <p class="card__text">NOW IN STOCK!
                    <br> FREE SHIPPING
                    <br> STARTING AT $24.99</p>
                <button class="button">show me more</button>
            </article>
        </div>
        <div class="col-md-5 ">
            <article class="card card--shoes">
                <h5 class="card__title">2014 Le Blanc Dress Shoes</h5>
                <p class="card__text">NOW IN STOCK!
                    <br> FREE SHIPPING
                    <br> STARTING AT $299.99</p>
                <button class="button">show me more</button>
            </article>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <main class="col-lg-9">
                    <!-- FEATURED START -->
                    <section class="block ">
                        <h3 class="block__title">FEATURED PRODUCTS</h3>
                        <hr class="block__line">
                        <div class="row">
                            <?php foreach ($featuredProducts as $product): ?>
                                <section class="product col-md-4">
                                    <a href="/product/<?=$product->number?>">
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
                    </section>
                    <!-- FEATURED END -->
                    <!-- LATEST START -->
                    <section class="block">
                        <h3 class="block__title">LATEST PRODUCTS</h3>
                        <hr class="block__line">
                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <section class="product col-md-4">
                                    <a href="/product/<?=$product->number?>">
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
                    </section>
                    <!-- LATEST END -->
                </main>
                <aside class="col-lg-3">

                    <!-- SALES START -->
                    <section class="box box--sales">
                        <h5 class="box__title">Best sellers</h5>
                        <section class="item">
                            <section class="item__img">
                                <img src="/img/sniker-mini.png" alt="#" class="img-responsive">
                            </section>
                            <section class="item__info">
                                <h6 class="item__title">Sample Item Title Goes Here</h6>
                                <p class="item__price--old">$120.
                                    <span class="item__cents--old">00</span>
                                </p>
                                <p class="item__price--new">$120.
                                    <span class="item__cents--new">00</span>
                                </p>
                            </section>
                        </section>
                        <section class="item">
                            <section class="item__img">
                                <img src="/img/sniker-mini.png" alt="#" class="img-responsive">
                            </section>
                            <section class="item__info">
                                <h6 class="item__title">Sample Item Title Goes Here</h6>
                                <p class="item__price--old">$120.
                                    <span class="item__cents--old">00</span>
                                </p>
                                <p class="item__price--new">$120.
                                    <span class="item__cents--new">00</span>
                                </p>
                            </section>
                        </section>
                        <section class="item">
                            <section class="item__img">
                                <img src="/img/sniker-mini.png" alt="#" class="img-responsive">
                            </section>
                            <section class="item__info">
                                <h6 class="item__title">Sample Item Title Goes Here</h6>
                                <p class="item__price--old">$120.
                                    <span class="item__cents--old">00</span>
                                </p>
                                <p class="item__price--new">$120.
                                    <span class="item__cents--new">00</span>
                                </p>
                            </section>
                        </section>
                    </section>
                    <!-- SALES END -->

                    <!-- SLIDER START -->
                    <section class="box box--slider">
                        <h5 class="box__title">Special offers</h5>
                        <div id="carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel" data-slide-to="1"></li>
                                <li data-target="#carousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">

                                <section class="carousel-item active">
                                    <img class="carousel-item__image" src="/img/snikers.png" alt="First slide">
                                    <h5 class="carousel-item__title">Item Title Here</h5>
                                    <p class="carousel-item__paragraph">lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                                        lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                                    <button class="button carousel-item__button button--bordered ">show me more</button>
                                </section>
                                <section class="carousel-item">
                                    <img class="carousel-item__image" src="/img/snikers.png" alt="First slide">
                                    <h5 class="carousel-item__title">Item Title Here</h5>
                                    <p class="carousel-item__paragraph">lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                                        lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                                    <button class="button carousel-item__button button--bordered ">show me more</button>
                                </section>
                                <section class="carousel-item">
                                    <img class="carousel-item__image" src="/img/snikers.png" alt="First slide">
                                    <h5 class="carousel-item__title">Item Title Here</h5>
                                    <p class="carousel-item__paragraph">lorem ipsum lorem ipsum lorem ipsum lorem ipsum
                                        lorem ipsum lorem ipsum lorem ipsum lorem ipsum</p>
                                    <button class="button carousel-item__button button--bordered ">show me more</button>
                                </section>
                            </div>
                        </div>
                    </section>
                    <!-- SLIDER END -->
                </aside>
            </div>
        </div>
    </div>
</div>