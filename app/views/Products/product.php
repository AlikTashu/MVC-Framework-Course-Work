<main class="container-fluid">
    <div class="detail row">
        <div class="col-lg-6 offset-lg-1 d-flex flex-column">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="#">Collection</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $product->title ?></li>
                </ol>
            </nav>
            <div class="detail__wrapper">
                <img src="<?= $product->image_path ?>" alt="Image" class="detail__image">
            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <h3 class="detail__title"><?= $product->title ?></h3>
            <p class="detail__info"><?=$product->description?>
            </p>
            <form class="purchase" action="action" method="post">

                <p class="purchase__price">$<?= $product->totalDollars ?>.
                    <span class="purchase__price--cents"><?= $product->totalCents ?></span>
                </p>
                <div class="purchase__row">
                    <label for="staticMark" class="purchase__label ">Brand</label>
                    <input type="text" readonly class="purchase__input " id="staticMark" value="<?= $product->name ?>">
                </div>
                <div class="purchase__row">
                    <label for="staticModel" class="purchase__label ">Model</label>
                    <input type="text" readonly class="purchase__input" id="staticModel" value="<?= $product->title ?>">
                </div>
                <div class="purchase__row">
                    <label for="staticColor" class="purchase__label ">Color</label>
                    <input type="text" readonly class="purchase__input" id="staticColor" value="<?= $product->color ?>">
                </div>
                <select class="purchase__select">
                    <option disabled selected>Choose size</option>
                    <option value="<?= $product->size ?>"><?= $product->size ?></option>
                </select>
                <div class="purchase__buttons">
                    <a style="text-align: center; padding-top: 10px; " class="button purchase__button button--bordered" href="/products/add/<?= $product->number?>">Add to bag</a>
                    <button class="button purchase__button button--bordered">View bag</button>
                </div>

            </form>
        </div>
    </div>
</main>
