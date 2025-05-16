<!--************************* start comment-section *************************-->
<div class="comment-section">
  <div class="container">
    <div class="user-comment-container">
      <div class="title">
        <h3>دیدگاه کاربران</h3>
      </div>
      <?php
      global $post;
      $post_id = $post->ID;
      $comments_count = get_comments_number($post_id);

      if ($comments_count > 0) {
        comments_template(null, true);

      } else {
        echo 'تاکنون کامنتی گزاشته نشده';

      }
      ?>
      <div class="comment-form">
        <div class="comment-form-title">
          <p>دیدگاه خود را بنویسید . نشانی ایمیل شما منتشر نخواهد شد</p>
        </div>
        <?php if (comments_open()): ?>
          <form id="custom-comment-form" method="post" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>">
            <textarea name="comment" id="comment" placeholder="متن پیام*" required></textarea>
            <input type="text" name="author" placeholder="نام شما" required />
            <input type="email" name="email" placeholder="ایمیل شما" required />

            <input type="hidden" name="post_id" value="<?php the_ID(); ?>" />
            <input type="hidden" name="comment_parent" id="comment_parent" value="0" />
            <input type="hidden" name="action" value="custom_ajax_comment" />
            <?php wp_nonce_field('custom_ajax_comment_nonce', 'security'); ?>

            <input type="submit" class="button" value="ارسال دیدگاه" />
            <div id="ajax-response"></div>
          </form>
        <?php else: ?>
          <p>ثبت دیدگاه برای این پست بسته است.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!--************************* end comment-section *************************-->