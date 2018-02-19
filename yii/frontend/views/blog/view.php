<div class="container">
    <div class="body-content">

        <div class="row">
            <?php if($blog) : ?>
               
                    <div class="col-lg-12">
                        <h1>
                            <?= $blog->title; ?>
                        </h1>

                        <p>
                            <?= $blog->text; ?>
                        </p>
                    </div>
            <?php endif; ?>
        </div>

    </div>
</div>
