<div class="mt-30">
    <div class="all">
        <div class="container">
            <div class="row align-my-status">
                <div class="col-70">
                    <div class="profile-home ds-flex">

                        <div class="foto">
                            <?= photo_img($delivery->image, $delivery->fullName(), 56, 56); ?>
                        </div>
                        <div class="welcome">
                            <h1 class="text-default">Olá,</h1>
                            <p class="text-dark"><?= $delivery->first_name; ?> <?= $delivery->last_name; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-30">
                    <div id="profile" class="my-status center <?= $delivery->status == 'active' ? ' active' : 'sleep';?>">
                        <a href="#" id="<?= $delivery->id;?>" class="text-white jsc-in-activity"
                           data-activity="<?= $delivery->status; ?>"><?= $delivery->status == 'active' ? ' Ativo' : 'Modo soneca';?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
