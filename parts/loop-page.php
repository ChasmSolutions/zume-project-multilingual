<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">

	<header class="article-header">

    <?php
    global $post;
    if($post->post_parent == 'groups'){?>
	  	<h1 class="page-title"><?php the_title();?></h1>
    <?php } else { ?>
      <!--<h1 class="page-title"><?php /*the_title(); */?></h1>-->
    <?php } ?>
	</header> <!-- end article header -->

    <section class="entry-content" itemprop="articleBody">
	    <?php the_content(); ?>
	    <?php wp_link_pages(); ?>
	</section> <!-- end article section -->

	<footer class="article-footer">

	</footer> <!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->
