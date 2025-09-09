<!-- ************************* start contact us container   *************************-->
<?Php
$theme_options = get_option('cyberisho_main_option', []);
$glossary_options = $theme_options['glossary'];
$glossary_archive_title = $glossary_options['glossary_archive_title'];
?>
<section class="header-page-title-section">
  <div class="container">
    <div class="row">
      <div class="col-12 title-header-text">
        <small>GLOSSARY</small>
        <h2>واژه نامه</h2>
      </div>
      <?php custom_breadcrumb(); ?>
      <div class="col-12 content-title-text">
        <p id="main-text" class="main-text">
          <?php
          echo $glossary_archive_title
            ?>
        </p>
      </div>
    </div>
  </div>
</section>
<!-- ************************* end contact us container   *************************-->