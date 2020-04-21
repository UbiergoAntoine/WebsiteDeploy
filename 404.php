<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
<div id="main" class="content djax-updatable">
<div class="page-content page-content--with-sidebar">
        <div class="page-main entry_body">
            <article id="post-0" class="post">
                <header class="entry__header">
                    <h1 class="entry__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'lens' ); ?></h1>
                    <div class="bleed--left"><hr class="separator separator--dotted grow"></div>
                </header>
                <div class="entry__body">
                    <p><?php printf( __( 'This may be because of a mistyped URL, faulty referral or out-of-date search engine listing.<br />You should try the <a href="%s">homepage</a> instead or maybe do a search?', 'lens' ), home_url()); ?></p>
                    <div class="search-form">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </article>
        </div>
		<div class="page-side">
			<?php get_sidebar(); ?>
		</div>
</div><!-- .page-content -->
</div><!-- .content -->
<?php get_footer();
