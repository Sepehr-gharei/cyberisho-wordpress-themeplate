<div class="comment-container" id="comments-container">
  <?php
  $args = [
    "callback" => "cy_theme_comment",
    "style" => "ul",
  ];
  wp_list_comments($args);
  ?>
</div>

<div class="comment-pagination pagination-wrapper pagination reverse text-center">
  <?php
  $total_comments = get_comments_number();
  $comments_per_page = get_option('comments_per_page');
  $total_pages = ceil($total_comments / $comments_per_page);
  $current_page = get_query_var('cpage') ? get_query_var('cpage') : 1;

  if ($total_pages > 1) {
    $big = 999999999;
    echo paginate_links(array(
      'base' => add_query_arg('cpage', '%#%'),
      'format' => '',
      'current' => $current_page,
      'total' => $total_pages,
      'prev_text' => __('
        <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <g id="#000000ff">
            <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
          </g>
        </svg>
      '),
      'next_text' => __('
        <svg width="218pt" height="146pt" viewBox="0 0 218 146" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <g id="#000000ff">
            <path fill="var(--normal-text-color)" opacity="1.00" d="M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z"></path>
          </g>
        </svg>
      '),
    ));
  }
  ?>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const paginationContainer = document.querySelector('.comment-pagination');
    const commentsContainer = document.querySelector('#comments-container');

    if (!paginationContainer) return;

    // Delegate click events for pagination
    paginationContainer.addEventListener('click', function (e) {
      e.preventDefault();

      const link = e.target.closest('a');
      if (!link) return;

      const page = link.getAttribute('href').match(/cpage=(\d+)/)[1];
      const postId = <?php echo get_the_ID(); ?>;

      fetchComments(postId, page);
    });

    function fetchComments(postId, page) {
      fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'comment_pagination',
          post_id: postId,
          page: page,
          security: '<?php echo wp_create_nonce('comment_pagination_nonce'); ?>',
        }),
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            commentsContainer.innerHTML = data.data.comments_html;
            paginationContainer.innerHTML = data.data.pagination_html;
            bindCommentInteractions();
          } else {
            console.error('Error:', data.data);
          }
        })
        .catch(error => console.error('AJAX Error:', error));
    }

    // Rest of your JavaScript code...
  });
</script>