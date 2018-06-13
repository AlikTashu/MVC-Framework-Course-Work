<main class="container-fluid">
    <div class="row">

        <div class="col-lg-6 offset-lg-1">
            <section class="bag">
                <h3 class="bag__title">Your bag</h3>
                <hr class="bag__line">
                <section class="bag__cart">
                    <?php if (isset($products)&&count($products)!=0): ?>
                    <?php foreach ($products as $product): ?>
                    <form action="/" method="GET" class="cart row">
                        <div class="cart__wrapper">
                           ` <img src="<?=$product->image_path?>" alt="Image" class="cart__image">
                        </div>
                        <section class="cart__details">
                            <h4 class="cart__title"><?=$product->title?></h4>
                            <ul class="cart__list">
                                <li class="cart__attribute">Brand : <?=$product->name?> </li>
                                <li class="cart__attribute">Model : <?=$product->title?> </li>
                                <li class="cart__attribute">Color : <?=$product->color?> </li>
                            </ul>
                            <p class="cart__price">$<?=$product->totalDollars?>.<?=$product->totalCents?></p>
                        </section>
                        <a class="cart__delete text-center align-middle" href="/products/delete/<?=$product->number?>"></a>
<!--                        <button class="cart__delete"></button>-->
                    </form>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </section>
            </section>
        </div>

        <div class="col-lg-3 offset-lg-1">
            <section class="order">

                <h3 class="order__title">Order summary</h3>
                <hr class="order__line">
                <p class="order__products">Amount of products :
                    <span class="order__amount"><?=count($_SESSION["products"])?></span>
                </p>
                <p class="order__price">Total price :
                    <span class="order__price--accent">$<?=$total_price?></span>
                </p>
                <form action="/checkout" method="post">
                    <input type="hidden" name="total_price" value="<?=$total_price?>" />
                    <button class="button button--bordered order__button">Checkout</button>
                </form>
            </section>
        </div>
    </div>

</main>