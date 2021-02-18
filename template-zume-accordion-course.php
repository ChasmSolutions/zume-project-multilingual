<?php
/*
Template Name: Zúme Accordion Course
*/

get_header();
?>
<style>
    #accordion-course li a.accordion-title {
        font-size: 2.5rem;

    }
</style>
<div id="content" class="max-content-width">
    <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
        <div id="main" class="large-12 cell" role="main">


            <ul id="accordion-course" class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 1</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_1( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 2</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_2( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 3</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_3( ); ?>
                    </div>
                </li>


                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 4</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_4( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 5</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_5( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 6</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_6( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 7</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_7( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 8</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_8( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 9</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_9( ); ?>
                    </div>
                </li>

                <li class="accordion-item" data-accordion-item>
                    <!-- Accordion tab title -->
                    <a href="#" class="accordion-title">Session 10</a>

                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                    <div class="accordion-content" data-tab-content>
                        <?php Zume_Course_Content::get_course_content_10( ); ?>
                    </div>
                </li>

            </ul>


        </div> <!-- end #main -->
    </div> <!-- end #inner-content -->
</div><!-- end #content -->

<script>
    jQuery(document).ready(function($){
        jQuery('.activity-description').hide()
        jQuery('.activity-title').hide()
        jQuery('.video-section').hide().next().hide()

        jQuery('.step-title').on('click', function(e){
            window.x = jQuery(this)
            console.log(window.x)
            window.x.parent().parent().find('div').show()
        })
    })
</script>

<?php get_footer(); ?>
