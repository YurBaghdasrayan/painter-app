<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesTitle || $articlesMainImage || $articlesSideImage): ?>
    <section id="<?php echo e($sectionId ?? 'articles'); ?>" class="<?php echo e($sectionClass ?? 'home-articles'); ?>" aria-label="Articles">
        <div class="home-articles-inner">
            <div class="home-articles-head">
                <h2 class="home-articles-title"><?php echo e($articlesTitle); ?></h2>

                <div class="home-articles-toptexts">
                    <div class="home-articles-toptext home-articles-toptext--left">
                        <?php echo nl2br(e($articlesLeftText ?? '')); ?>

                    </div>

                    <div class="home-articles-toptext home-articles-toptext--right">
                        <?php echo nl2br(e($articlesRightText ?? '')); ?>

                    </div>
                </div>
            </div>

            <div class="home-articles-stage">
                <div class="home-articles-side-card">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesSideImage): ?>
                        <div class="home-articles-side-image-wrap">
                            <img
                                src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($articlesSideImage)); ?>"
                                alt="<?php echo e($articlesCardTitle ?: 'Articles image'); ?>"
                                class="home-articles-side-image"
                            >
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="home-articles-side-content">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesCardTitle): ?>
                            <div class="home-articles-card-title">“<?php echo e($articlesCardTitle); ?>”</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesCardText): ?>
                            <div class="home-articles-card-text">
                                <?php echo e($articlesCardText); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="home-articles-main-card">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesMainImage): ?>
                        <img
                            src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($articlesMainImage)); ?>"
                            alt="<?php echo e($articlesTitle ?: 'Articles main image'); ?>"
                            class="home-articles-main-image"
                        >
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="home-articles-right-card">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesCardTitle): ?>
                        <div class="home-articles-card-title">“<?php echo e($articlesCardTitle); ?>”</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesCardText): ?>
                        <div class="home-articles-card-text">
                            <?php echo e($articlesCardText); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="home-articles-footer">
                <div class="home-articles-more">
                    <span class="home-articles-more-text"><?php echo e($articlesMoreText ?? 'more'); ?></span>

                    <a class="home-articles-more-btn" href="<?php echo e(url($articlesMoreLink ?? '/articles')); ?>" aria-label="More">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5 12H18" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <path d="M13 7L18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/balasona/public_html/resources/views/partials/articles-section.blade.php ENDPATH**/ ?>