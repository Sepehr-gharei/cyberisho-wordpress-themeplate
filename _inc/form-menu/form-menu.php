<?php
class Admin_Form
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'form_menu'));
        add_action('init', array($this, 'check_and_create_tables'));
    }

    public function check_and_create_tables()
    {
        global $wpdb;
        $contact_table = $wpdb->prefix . 'contact_forms';
        $meeting_table = $wpdb->prefix . 'meeting_forms';
        $inperson_meeting_table = $wpdb->prefix . 'inperson_meeting_forms';
        $job_application_table = $wpdb->prefix . 'job_application_forms';

        // Create or update contact_forms table
        if ($wpdb->get_var("SHOW TABLES LIKE '$contact_table'") != $contact_table) {
            $this->create_custom_table_contact_form();
        } else {
            $columns = $wpdb->get_results("SHOW COLUMNS FROM $contact_table LIKE 'email'");
            if (empty($columns)) {
                $wpdb->query("ALTER TABLE $contact_table ADD email VARCHAR(100) DEFAULT NULL AFTER name");
                if ($wpdb->last_error) {
                    error_log('Failed to add email column to contact_forms: ' . $wpdb->last_error);
                } else {
                    error_log('Successfully added email column to contact_forms');
                }
            }
        }

        // Create meeting_forms table if it doesn't exist
        if ($wpdb->get_var("SHOW TABLES LIKE '$meeting_table'") != $meeting_table) {
            $this->create_custom_table_meeting_form();
        }

        // Create inperson_meeting_forms table if it doesn't exist
        if ($wpdb->get_var("SHOW TABLES LIKE '$inperson_meeting_table'") != $inperson_meeting_table) {
            $this->create_custom_table_inperson_meeting_form();
        }

        // Create job_application_forms table if it doesn't exist
        if ($wpdb->get_var("SHOW TABLES LIKE '$job_application_table'") != $job_application_table) {
            $this->create_custom_table_job_application_form();
        }
    }

    public function create_custom_table_contact_form()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_forms';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) DEFAULT NULL,
            email VARCHAR(100) DEFAULT NULL,
            phone VARCHAR(20) NOT NULL,
            message_content TEXT NOT NULL,
            is_read TINYINT NOT NULL DEFAULT 0,
            sent_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);

        if (!empty($wpdb->last_error)) {
            error_log('Contact Form Table Creation Error: ' . $wpdb->last_error);
        } else {
            error_log('Contact Form Table Creation Result: ' . print_r($result, true));
        }
    }

    public function create_custom_table_meeting_form()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'meeting_forms';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) DEFAULT NULL,
            phone VARCHAR(20) NOT NULL,
            is_read TINYINT NOT NULL DEFAULT 0,
            sent_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);
        error_log('Meeting Form Table Creation: ' . print_r($result, true));
    }

    public function create_custom_table_inperson_meeting_form()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'inperson_meeting_forms';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) DEFAULT NULL,
            phone VARCHAR(20) NOT NULL,
            city VARCHAR(50) NOT NULL,
            is_read TINYINT NOT NULL DEFAULT 0,
            sent_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);
        if (!empty($wpdb->last_error)) {
            error_log('In-Person Meeting Form Table Creation Error: ' . $wpdb->last_error);
        } else {
            error_log('In-Person Meeting Form Table Creation Result: ' . print_r($result, true));
        }
    }

    public function create_custom_table_job_application_form()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'job_application_forms';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            job_position VARCHAR(50) NOT NULL,
            description TEXT NOT NULL,
            file_path VARCHAR(255) DEFAULT NULL,
            is_read TINYINT NOT NULL DEFAULT 0,
            sent_datetime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);
        if (!empty($wpdb->last_error)) {
            error_log('Job Application Form Table Creation Error: ' . $wpdb->last_error);
        } else {
            error_log('Job Application Form Table Creation Result: ' . print_r($result, true));
        }
    }

    public function form_menu()
    {
        $all_count = $this->all_show_unread_forms_count();
        add_menu_page(
            'فرم ها',
            'فرم ها' . $all_count,
            'manage_options',
            'forms_menu',
            array($this, 'contact_forms_page'),
            'dashicons-feedback',
            20
        );
    }

    protected function get_unread_forms_count($form_type)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $form_type;
        $unread_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_read = 0");
        return $unread_count ? $unread_count : 0;
    }

    protected function show_unread_forms_count($form_type)
    {
        $count = $this->get_unread_forms_count($form_type);
        if ($count > 0) {
            $count = "<span class='awaiting-mod'><span class='pending-count'>$count</span></span>";
        } else {
            $count = '';
        }
        return $count;
    }

    protected function all_show_unread_forms_count()
    {
        $meeting_count = $this->get_unread_forms_count('meeting_forms');
        $contact_count = $this->get_unread_forms_count('contact_forms');
        $inperson_meeting_count = $this->get_unread_forms_count('inperson_meeting_forms');
        $job_application_count = $this->get_unread_forms_count('job_application_forms');
        $count = $meeting_count + $contact_count + $inperson_meeting_count + $job_application_count;
        if ($count > 0) {
            $count = "<span class='awaiting-mod'><span class='pending-count'>$count</span></span>";
        } else {
            $count = '';
        }
        return $count;
    }

    public function contact_forms_page()
    {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'meeting_form';
        $meeting_count = $this->show_unread_forms_count('meeting_forms');
        $contact_count = $this->show_unread_forms_count('contact_forms');
        $inperson_meeting_count = $this->show_unread_forms_count('inperson_meeting_forms');
        $job_application_count = $this->show_unread_forms_count('job_application_forms');
        echo "<div class='wrap received-forms'>"
            . "<nav class='nav-tab-wrapper'>";
        $settings = [
            'meeting_form' => 'فرم درخواست ملاقات ' . $meeting_count,
            'contact_form' => 'فرم تماس با ما ' . $contact_count,
            'inperson_meeting_form' => 'فرم ملاقات حضوری ' . $inperson_meeting_count,
            'job_application_form' => 'فرم درخواست شغل ' . $job_application_count,
        ];
        foreach ($settings as $id => $menu) {
            $tab_url = admin_url('admin.php?page=forms_menu&tab=' . $id);
            $active_class = ($active_tab == $id) ? ' nav-tab-active' : '';
            echo "<a href='$tab_url' class='nav-tab$active_class'>$menu</a>";
        }
        echo '</nav>';
        $this->display_forms_page($active_tab);
        echo '</div>';
    }

    protected function display_forms_page($form_type)
    {
        global $wpdb;
        $action = $this->Action();
        $rows_per_page = 50;
        $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
        $offset = ($current_page - 1) * $rows_per_page;

        if ($form_type == 'contact_form') {
            switch ($action) {
                case 'delete':
                    $user_id = $this->Delete_Action();
                    if ($user_id) {
                        $this->delete_form_entry('contact_forms', $user_id);
                    }
                    break;
                case 'read':
                    $user_id = $this->Read_Action();
                    if ($user_id) {
                        $this->mark_form_as_read('contact_forms', $user_id);
                    }
                    break;
            }

            $contact_forms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contact_forms ORDER BY id DESC LIMIT $offset, $rows_per_page", ARRAY_A);
            echo "<h1 class='wp-heading'>فرم های دریافتی تماس با ما</h1>";
            if ($wpdb->last_error) {
                echo '<div class="error"><p>خطا در دیتابیس: ' . esc_html($wpdb->last_error) . '</p></div>';
            }
            echo '<table class="wp-list-table widefat fixed striped table-view-list users">'
                . '<thead>'
                . '<tr>'
                . '<th>نام</th>'
                . '<th>ایمیل</th>'
                . '<th>تلفن</th>'
                . '<th>متن پیام</th>'
                . '<th>تاریخ و ساعت</th>'
                . '<th class="condition-lable">وضعیت</th>'
                . '<th class="remove-lable">حذف</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody id="the-list">';
            foreach ($contact_forms as $form) {
                echo '<tr>'
                    . '<td>' . esc_html($form['name'] ?? '-') . '</td>'
                    . '<td>' . esc_html($form['email'] ?? '-') . '</td>'
                    . '<td>' . esc_html($form['phone']) . '</td>'
                    . '<td>' . esc_html($form['message_content']) . '</td>'
                    . '<td>' . esc_html($this->mdate_to_jdate($form['sent_datetime'])) . '</td>'
                    . "<td class='read-btn'>";
                if ($form['is_read'] == 0) {
                    echo "<a href='" . esc_url(add_query_arg(['user_action' => 'read', 'user_id' => esc_html($form["id"])])) . "'>مشاهده نشده</a>";
                } else {
                    echo "<span>مشاهده شده</span>";
                }
                echo "</td>"
                    . "<td class='remove-btn'><a href='" . esc_url(add_query_arg(['user_action' => 'delete', 'user_id' => esc_html($form["id"])])) . "'><span class='dashicons dashicons-trash'></span></a></td>"
                    . '</tr>';
            }
            echo '</tbody>'
                . '</table>';

            $total_rows = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}contact_forms");
            $total_pages = ceil($total_rows / $rows_per_page);
            if ($total_pages > 1) {
                echo '<div class="pagination-links flex justify-content-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $class = ($current_page == $i) ? ' active' : '';
                    echo "<a href='admin.php?page=forms_menu&tab=contact_form&paged=$i' class='next-page button$class'>$i</a>";
                }
                echo '</div>';
            }
        } elseif ($form_type == 'meeting_form') {
            switch ($action) {
                case 'delete':
                    $user_id = $this->Delete_Action();
                    if ($user_id) {
                        $this->delete_form_entry('meeting_forms', $user_id);
                    }
                    break;
                case 'read':
                    $user_id = $this->Read_Action();
                    if ($user_id) {
                        $this->mark_form_as_read('meeting_forms', $user_id);
                    }
                    break;
            }

            $meeting_forms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}meeting_forms ORDER BY id DESC LIMIT $offset, $rows_per_page", ARRAY_A);
            echo "<h1 class='wp-heading'>فرم های دریافتی درخواست ملاقات</h1>";
            if ($wpdb->last_error) {
                echo '<div class="error"><p>خطا در دیتابیس: ' . esc_html($wpdb->last_error) . '</p></div>';
            }
            echo '<table class="wp-list-table widefat fixed striped table-view-list users">'
                . '<thead>'
                . '<tr>'
                . '<th>نام</th>'
                . '<th>تلفن</th>'
                . '<th>تاریخ و ساعت</th>'
                . '<th class="condition-lable">وضعیت</th>'
                . '<th class="remove-lable">حذف</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody id="the-list">';
            foreach ($meeting_forms as $form) {
                echo '<tr>'
                    . '<td>' . esc_html($form['name'] ?? '-') . '</td>'
                    . '<td>' . esc_html($form['phone']) . '</td>'
                    . '<td>' . esc_html($this->mdate_to_jdate($form['sent_datetime'])) . '</td>'
                    . "<td class='read-btn'>";
                if ($form['is_read'] == 0) {
                    echo "<a href='" . esc_url(add_query_arg(['user_action' => 'read', 'user_id' => esc_html($form["id"])])) . "'>مشاهده نشده</a>";
                } else {
                    echo "<span>مشاهده شده</span>";
                }
                echo "</td>"
                    . "<td class='remove-btn'><a href='" . esc_url(add_query_arg(['user_action' => 'delete', 'user_id' => esc_html($form["id"])])) . "'><span class='dashicons dashicons-trash'></span></a></td>"
                    . '</tr>';
            }
            echo '</tbody>'
                . '</table>';

            $total_rows = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}meeting_forms");
            $total_pages = ceil($total_rows / $rows_per_page);
            if ($total_pages > 1) {
                echo '<div class="pagination-links flex justify-content-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $class = ($current_page == $i) ? ' active' : '';
                    echo "<a href='admin.php?page=forms_menu&tab=meeting_form&paged=$i' class='next-page button$class'>$i</a>";
                }
                echo '</div>';
            }
        } elseif ($form_type == 'inperson_meeting_form') {
            switch ($action) {
                case 'delete':
                    $user_id = $this->Delete_Action();
                    if ($user_id) {
                        $this->delete_form_entry('inperson_meeting_forms', $user_id);
                    }
                    break;
                case 'read':
                    $user_id = $this->Read_Action();
                    if ($user_id) {
                        $this->mark_form_as_read('inperson_meeting_forms', $user_id);
                    }
                    break;
            }

            $inperson_meeting_forms = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inperson_meeting_forms ORDER BY id DESC LIMIT $offset, $rows_per_page", ARRAY_A);
            echo "<h1 class='wp-heading'>فرم های دریافتی ملاقات حضوری</h1>";
            if ($wpdb->last_error) {
                echo '<div class="error"><p>خطا در دیتابیس: ' . esc_html($wpdb->last_error) . '</p></div>';
            }
            echo '<table class="wp-list-table widefat fixed striped table-view-list users">'
                . '<thead>'
                . '<tr>'
                . '<th>نام</th>'
                . '<th>تلفن</th>'
                . '<th>شهر</th>'
                . '<th>تاریخ و ساعت</th>'
                . '<th class="condition-lable">وضعیت</th>'
                . '<th class="remove-lable">حذف</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody id="the-list">';
            foreach ($inperson_meeting_forms as $form) {
                echo '<tr>'
                    . '<td>' . esc_html($form['name'] ?? '-') . '</td>'
                    . '<td>' . esc_html($form['phone']) . '</td>'
                    . '<td>' . esc_html($form['city']) . '</td>'
                    . '<td>' . esc_html($this->mdate_to_jdate($form['sent_datetime'])) . '</td>'
                    . "<td class='read-btn'>";
                if ($form['is_read'] == 0) {
                    echo "<a href='" . esc_url(add_query_arg(['user_action' => 'read', 'user_id' => esc_html($form["id"])])) . "'>مشاهده نشده</a>";
                } else {
                    echo "<span>مشاهده شده</span>";
                }
                echo "</td>"
                    . "<td class='remove-btn'><a href='" . esc_url(add_query_arg(['user_action' => 'delete', 'user_id' => esc_html($form["id"])])) . "'><span class='dashicons dashicons-trash'></span></a></td>"
                    . '</tr>';
            }
            echo '</tbody>'
                . '</table>';

            $total_rows = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}inperson_meeting_forms");
            $total_pages = ceil($total_rows / $rows_per_page);
            if ($total_pages > 1) {
                echo '<div class="pagination-links flex justify-content-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $class = ($current_page == $i) ? ' active' : '';
                    echo "<a href='admin.php?page=forms_menu&tab=inperson_meeting_form&paged=$i' class='next-page button$class'>$i</a>";
                }
                echo '</div>';
            }
        } elseif ($form_type == 'job_application_form') {
            switch ($action) {
                case 'delete':
                    $user_id = $this->Delete_Action();
                    if ($user_id) {
                        $this->delete_form_entry('job_application_forms', $user_id);
                    }
                    break;
                case 'read':
                    $user_id = $this->Read_Action();
                    if ($user_id) {
                        $this->mark_form_as_read('job_application_forms', $user_id);
                    }
                    break;
            }

            $job_applications = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}job_application_forms ORDER BY id DESC LIMIT $offset, $rows_per_page", ARRAY_A);
            echo "<h1 class='wp-heading'>فرم های دریافتی درخواست شغل</h1>";
            if ($wpdb->last_error) {
                echo '<div class="error"><p>خطا در دیتابیس: ' . esc_html($wpdb->last_error) . '</p></div>';
            }
            echo '<table class="wp-list-table widefat fixed striped table-view-list users">'
                . '<thead>'
                . '<tr>'
                . '<th>نام</th>'
                . '<th>ایمیل</th>'
                . '<th>تلفن</th>'
                . '<th>ردیف شغلی</th>'
                . '<th>توضیحات</th>'
                . '<th>فایل</th>'
                . '<th>تاریخ و ساعت</th>'
                . '<th class="condition-lable">وضعیت</th>'
                . '<th class="remove-lable">حذف</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody id="the-list">';
            foreach ($job_applications as $form) {
                $file_link = !empty($form['file_path']) ? "<a href='" . esc_url($form['file_path']) . "' target='_blank'>دانلود فایل</a>" : '-';
                echo '<tr>'
                    . '<td>' . esc_html($form['name']) . '</td>'
                    . '<td>' . esc_html($form['email']) . '</td>'
                    . '<td>' . esc_html($form['phone']) . '</td>'
                    . '<td>' . esc_html($form['job_position']) . '</td>'
                    . '<td>' . esc_html($form['description']) . '</td>'
                    . '<td>' . $file_link . '</td>'
                    . '<td>' . esc_html($this->mdate_to_jdate($form['sent_datetime'])) . '</td>'
                    . "<td class='read-btn'>";
                if ($form['is_read'] == 0) {
                    echo "<a href='" . esc_url(add_query_arg(['user_action' => 'read', 'user_id' => esc_html($form["id"])])) . "'>مشاهده نشده</a>";
                } else {
                    echo "<span>مشاهده شده</span>";
                }
                echo "</td>"
                    . "<td class='remove-btn'><a href='" . esc_url(add_query_arg(['user_action' => 'delete', 'user_id' => esc_html($form["id"])])) . "'><span class='dashicons dashicons-trash'></span></a></td>"
                    . '</tr>';
            }
            echo '</tbody>'
                . '</table>';

            $total_rows = $wpdb->get_var("SELECT COUNT(id) FROM {$wpdb->prefix}job_application_forms");
            $total_pages = ceil($total_rows / $rows_per_page);
            if ($total_pages > 1) {
                echo '<div class="pagination-links flex justify-content-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $class = ($current_page == $i) ? ' active' : '';
                    echo "<a href='admin.php?page=forms_menu&tab=job_application_form&paged=$i' class='next-page button$class'>$i</a>";
                }
                echo '</div>';
            }
        }
    }

    protected function mdate_to_jdate($date)
    {
        if (function_exists('jdate')) {
            $timestamp = strtotime($date);
            $jalaliDate = jdate('Y-m-d H:i:s', $timestamp);
            return $jalaliDate;
        }
        return $date;
    }

    protected function delete_form_entry($form_type, $id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $form_type;

        // If deleting a job application, remove the associated file
        if ($form_type == 'job_application_forms') {
            $file_path = $wpdb->get_var($wpdb->prepare("SELECT file_path FROM $table_name WHERE id = %d", $id));
            if ($file_path && file_exists(WP_CONTENT_DIR . '/Uploads/job_applications/' . basename($file_path))) {
                unlink(WP_CONTENT_DIR . '/Uploads/job_applications/' . basename($file_path));
            }
        }

        $result = $wpdb->delete($table_name, array('id' => $id));
        if ($result === false) {
            error_log('Delete Error for ' . $form_type . ': ' . $wpdb->last_error);
        }
    }

    protected function mark_form_as_read($form_type, $id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $form_type;
        $result = $wpdb->update($table_name, array('is_read' => 1), array('id' => $id));
        if ($result === false) {
            error_log('Update Error for ' . $form_type . ': ' . $wpdb->last_error);
        }
    }

    protected function Action()
    {
        return isset($_GET['user_action']) ? $_GET['user_action'] : false;
    }

    protected function Delete_Action()
    {
        return $this->Action() == 'delete' ? $_GET['user_id'] : false;
    }

    protected function Read_Action()
    {
        return $this->Action() == 'read' ? $_GET['user_id'] : false;
    }
}

class Form_Handler
{
    public function __construct()
    {
        add_action('wp_ajax_insert_contact_form_data', array($this, 'insert_contact_form_data'));
        add_action('wp_ajax_nopriv_insert_contact_form_data', array($this, 'insert_contact_form_data'));
        add_action('wp_ajax_insert_meeting_form_data', array($this, 'insert_meeting_form_data'));
        add_action('wp_ajax_nopriv_insert_meeting_form_data', array($this, 'insert_meeting_form_data'));
        add_action('wp_ajax_insert_inperson_meeting_form_data', array($this, 'insert_inperson_meeting_form_data'));
        add_action('wp_ajax_nopriv_insert_inperson_meeting_form_data', array($this, 'insert_inperson_meeting_form_data'));
        add_action('wp_ajax_insert_job_application_form_data', array($this, 'insert_job_application_form_data'));
        add_action('wp_ajax_nopriv_insert_job_application_form_data', array($this, 'insert_job_application_form_data'));
    }

    public function insert_contact_form_data()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
            wp_send_json_error('دسترسی غیرمجاز!');
        }

        $form_data = $_POST['form_data'];
        parse_str($form_data, $form_fields);

        error_log('Contact Form Fields: ' . print_r($form_fields, true));

        $honeypot = $form_fields['family'] ?? '';
        if (!empty($honeypot)) {
            wp_send_json_error('درخواست نامعتبر! لطفا فیلد نام خانوادگی را خالی بگذارید.');
        }

        $name = sanitize_text_field($form_fields['name'] ?? '');
        $email = sanitize_email($form_fields['email'] ?? '');
        $phone = sanitize_text_field(preg_replace('/[^0-9]/', '', $form_fields['phone'] ?? ''));
        $message_content = wp_kses($form_fields['message-content'] ?? '', array());

        if (empty($phone)) {
            wp_send_json_error('شماره تماس الزامی است!');
        }
        if (empty($message_content)) {
            wp_send_json_error('متن پیام الزامی است!');
        }

        if (!preg_match('/^(\+98|0)9\d{9}$/', $phone)) {
            wp_send_json_error('لطفاً یک شماره تلفن معتبر ایرانی وارد کنید.');
        }

        $result = $this->save_contact_form_data($name, $email, $phone, $message_content);
        if ($result === false) {
            global $wpdb;
            error_log('Contact Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }

        wp_send_json_success('فرم تماس با موفقیت ارسال شد!');
    }

    public function insert_meeting_form_data()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
            wp_send_json_error('دسترسی غیرمجاز!');
        }

        $form_data = $_POST['form_data'];
        parse_str($form_data, $form_fields);

        error_log('Meeting Form Fields: ' . print_r($form_fields, true));

        $honeypot = $form_fields['family'] ?? '';
        if (!empty($honeypot)) {
            wp_send_json_error('درخواست نامعتبر! لطفا فیلد نام خانوادگی را خالی بگذارید.');
        }
        $name = sanitize_text_field($form_fields['name'] ?? '');
        $phone = sanitize_text_field(preg_replace('/[^0-9]/', '', $form_fields['phone'] ?? ''));

        if (empty($phone)) {
            wp_send_json_error('شماره تماس الزامی است!');
        }

        if (!preg_match('/^(\+98|0)9\d{9}$/', $phone)) {
            wp_send_json_error('لطفاً یک شماره تلفن معتبر ایرانی وارد کنید.');
        }

        $this->save_meeting_form_data($name, $phone);

        wp_send_json_success('فرم درخواست ملاقات با موفقیت ارسال شد!');
    }

    public function insert_inperson_meeting_form_data()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
            wp_send_json_error('دسترسی غیرمجاز!');
        }

        $form_data = $_POST['form_data'];
        parse_str($form_data, $form_fields);

        error_log('In-Person Meeting Form Fields: ' . print_r($form_fields, true));

        $honeypot = $form_fields['family'] ?? '';
        if (!empty($honeypot)) {
            wp_send_json_error('درخواست نامعتبر! لطفا فیلد نام خانوادگی را خالی بگذارید.');
        }
        $name = sanitize_text_field($form_fields['name'] ?? '');
        $phone = sanitize_text_field(preg_replace('/[^0-9]/', '', $form_fields['phone'] ?? ''));
        $city = sanitize_text_field($form_fields['city'] ?? '');

        if (empty($phone)) {
            wp_send_json_error('شماره تماس الزامی است!');
        }
        if (empty($city)) {
            wp_send_json_error('شهر الزامی است!');
        }

        if (!preg_match('/^(\+98|0)9\d{9}$/', $phone)) {
            wp_send_json_error('لطفاً یک شماره تلفن معتبر ایرانی وارد کنید .');
        }

        $result = $this->save_inperson_meeting_form_data($name, $phone, $city);
        if ($result === false) {
            global $wpdb;
            error_log('In-Person Meeting Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }

        wp_send_json_success('فرم ملاقات حضوری با موفقیت ارسال شد!');
    }

    public function insert_job_application_form_data()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ajax-nonce')) {
            wp_send_json_error('دسترسی غیرمجاز!');
        }

        error_log('Raw POST Data: ' . print_r($_POST, true));
        error_log('Raw FILES Data: ' . print_r($_FILES, true));

        $name = sanitize_text_field($_POST['name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field(preg_replace('/[^0-9]/', '', $_POST['phone'] ?? ''));
        $job_position = sanitize_text_field($_POST['job_position'] ?? '');
        $description = wp_kses($_POST['description'] ?? '', array());

        error_log('Processed Name: ' . $name);

        // اعتبارسنجی فیلدها
        if (empty($name)) {
            wp_send_json_error('نام الزامی است!');
        }
        if (empty($email)) {
            wp_send_json_error('ایمیل الزامی است!');
        }
        if (empty($phone)) {
            wp_send_json_error('شماره تماس الزامی است!');
        }
        if (empty($job_position)) {
            wp_send_json_error('ردیف شغلی الزامی است!');
        }
        if (empty($description)) {
            wp_send_json_error('توضیحات الزامی است!');
        }
        if (!preg_match('/^(\+98|0)9\d{9}$/', $phone)) {
            wp_send_json_error('لطفاً یک شماره تلفن معتبر ایرانی وارد کنید.');
        }
        if (!in_array($job_position, ['برنامه نویس', 'گرافیست', 'طراح سایت', 'متخصص فروش', 'تولید کننده محتوا'])) {
            wp_send_json_error('ردیف شغلی نامعتبر است!');
        }

        // مدیریت آپلود فایل
        $file_path = '';
        if (!empty($_FILES['resume']['name'])) {
            $allowed_types = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
            $file_type = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($file_type), $allowed_types)) {
                wp_send_json_error('نوع فایل نامعتبر است! فقط فایل‌های PDF، JPG، PNG و Word مجاز هستند.');
            }

            $upload_dir = WP_CONTENT_DIR . '/Uploads/job_applications/';
            if (!file_exists($upload_dir)) {
                wp_mkdir_p($upload_dir);
            }

            $unique_filename = wp_unique_filename($upload_dir, $_FILES['resume']['name']);
            $destination = $upload_dir . $unique_filename;
            if (!move_uploaded_file($_FILES['resume']['tmp_name'], $destination)) {
                wp_send_json_error('خطا در آپلود فایل!');
            }
            $file_path = content_url('/Uploads/job_applications/' . $unique_filename);
        } else {
            wp_send_json_error('فایل رزومه الزامی است!');
        }

        $result = $this->save_job_application_form_data($name, $email, $phone, $job_position, $description, $file_path);
        if ($result === false) {
            global $wpdb;
            error_log('Job Application Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }

        wp_send_json_success('فرم درخواست شغل با موفقیت ارسال شد!');
    }

    public function save_contact_form_data($name, $email, $phone, $message_content)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_forms';
        $data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message_content' => $message_content,
            'is_read' => 0,
        );
        $format = array('%s', '%s', '%s', '%s', '%d');
        return $wpdb->insert($table_name, $data, $format);
    }

    public function save_meeting_form_data($name, $phone)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'meeting_forms';
        $data = array(
            'name' => $name,
            'phone' => $phone,
            'is_read' => 0,
        );
        $format = array('%s', '%s', '%d');
        $result = $wpdb->insert($table_name, $data, $format);
        if ($result === false) {
            error_log('Meeting Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }
    }

    public function save_inperson_meeting_form_data($name, $phone, $city)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'inperson_meeting_forms';
        $data = array(
            'name' => $name,
            'phone' => $phone,
            'city' => $city,
            'is_read' => 0,
        );
        $format = array('%s', '%s', '%s', '%d');
        $result = $wpdb->insert($table_name, $data, $format);
        if ($result === false) {
            error_log('In-Person Meeting Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }
        return $result;
    }

    public function save_job_application_form_data($name, $email, $phone, $job_position, $description, $file_path)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'job_application_forms';
        $data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'job_position' => $job_position,
            'description' => $description,
            'file_path' => $file_path,
            'is_read' => 0,
        );
        $format = array('%s', '%s', '%s', '%s', '%s', '%s', '%d');
        $result = $wpdb->insert($table_name, $data, $format);
        if ($result === false) {
            error_log('Job Application Form Insert Error: ' . $wpdb->last_error);
            wp_send_json_error('خطا در ذخیره اطلاعات در پایگاه داده: ' . $wpdb->last_error);
        }
        return $result;
    }
}

class Form
{
    public function contact_form()
    {
        $form = "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='contact-form-id'>"
            . wp_nonce_field('ajax-nonce', 'nonce', false, false)
            . "<input type='hidden' name='action' value='insert_contact_form_data'>"
            . "<div class='form-item type-text honeypot' data-field='family' style='display:none;'>"
            . "<input type='text' name='family'>"
            . "</div>"
            . "<input type='text' name='name' placeholder='نام شما'>"
            . "<input type='email' name='email' placeholder='ایمیل'>"
            . "<input type='text' name='phone' placeholder='تلفن*' pattern='[0-9]{10,11}' required oninvalid=\"setCustomValidity('لطفا شماره تماس خود را به فرمت صحیح وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<textarea name='message-content' placeholder='متن پیام*' cols='30' required></textarea>"
            . "<input type='submit' class='submit' name='submit_form' value='ارسال پیام'>"
            . "</form>";
        return $form;
    }

    public function meeting_form()
    {
        $form = "<div class='metting-form-container'>"
            . "<h3>درخواست ملاقات حضوری :</h3>"
            . "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='meeting-form-id'>"
            . wp_nonce_field('ajax-nonce', 'nonce', false, false)
            . "<input type='hidden' name='action' value='insert_meeting_form_data'>"
            . "<div class='form-item type-text honeypot' data-field='family' style='display:none;'>"
            . "<input type='text' name='family'>"
            . "</div>"
            . "<input type='text' name='name' placeholder='نام شما'>"
            . "<input type='text' name='phone' placeholder='شماره تماس*' pattern='[0-9]{10,11}' required oninvalid=\"setCustomValidity('لطفا شماره تماس خود را به فرمت صحیح وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<input type='submit' class='submit' name='submit_form' value='ثبت'>"
            . "</form>"
            . "</div>";
        return $form;
    }
    public function new_meeting_form()
    {
        $form = "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='new-meeting-form-id'>"
            . wp_nonce_field('ajax-nonce', 'nonce', false, false)
            . "<input type='hidden' name='action' value='insert_meeting_form_data'>"
            . "<div class='name-field input-field'>"
            . "<div class='icon'>"
            . "<svg id='telephone-icon-2' viewBox='0 0 458 458'>"
            . "<g id='var(--background-medium-blue-color)ff'>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 97.47 5.71 C 110.04 2.90 123.72 5.34 134.44 12.52 C 140.01 16.17 144.43 21.23 149.16 25.85 C 164.96 41.72 180.89 57.47 196.63 73.40 C 209.71 86.73 213.58 107.96 206.20 125.10 C 203.29 132.30 198.28 138.39 192.69 143.69 C 186.37 150.05 179.95 156.32 173.69 162.74 C 169.13 167.49 168.01 175.14 171.07 180.98 C 196.32 224.79 233.27 261.71 276.95 287.15 C 281.39 289.67 287.04 289.86 291.65 287.65 C 295.15 286.03 297.65 282.97 300.37 280.34 C 306.75 274.05 312.97 267.58 319.45 261.40 C 334.34 247.56 358.19 245.29 375.81 255.11 C 380.25 257.48 384.12 260.75 387.63 264.33 C 404.80 281.50 421.99 298.67 439.16 315.86 C 453.17 329.03 457.88 350.86 450.45 368.61 C 447.87 375.10 443.73 380.88 438.74 385.73 C 426.12 398.12 414.13 411.22 400.19 422.18 C 384.19 434.90 365.95 445.27 345.99 450.20 C 326.01 455.29 304.76 454.32 285.03 448.62 C 261.03 441.81 239.13 429.29 218.62 415.35 C 158.12 373.37 104.41 321.68 59.90 263.03 C 47.03 245.92 34.59 228.37 24.57 209.42 C 11.33 184.57 2.46 156.30 5.60 127.88 C 8.50 99.26 23.18 73.21 41.76 51.78 C 51.66 40.38 62.71 30.05 73.30 19.30 C 79.85 12.59 88.30 7.73 97.47 5.71 M 103.24 37.27 C 98.23 38.64 95.07 43.01 91.48 46.42 C 81.22 56.86 70.36 66.80 61.30 78.36 C 51.61 90.62 43.52 104.46 39.67 119.71 C 35.54 135.61 36.75 152.55 41.66 168.14 C 48.03 188.59 59.36 207.03 71.44 224.57 C 103.53 270.30 141.49 311.89 183.91 348.23 C 204.58 365.80 226.09 382.47 249.00 397.03 C 268.76 409.22 290.50 419.90 314.06 421.25 C 333.87 422.52 353.44 415.72 369.76 404.80 C 387.11 393.57 400.95 378.04 415.60 363.68 C 423.17 357.87 424.24 345.56 417.05 339.02 C 399.71 321.68 382.36 304.34 365.02 287.00 C 362.17 283.85 358.43 281.28 354.10 280.94 C 348.64 280.14 343.05 282.36 339.46 286.50 C 331.95 293.97 324.57 301.59 316.92 308.92 C 302.48 322.25 279.59 325.08 262.35 315.64 C 212.85 287.31 171.14 245.57 142.82 196.07 C 133.60 179.05 136.23 156.57 149.17 142.17 C 157.22 133.56 165.90 125.55 174.02 117.01 C 179.42 111.12 179.16 101.13 173.49 95.50 C 156.54 78.44 139.49 61.49 122.51 44.47 C 117.97 38.80 110.57 34.82 103.24 37.27 Z'></path>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 284.42 6.59 C 285.91 6.03 287.48 5.68 289.08 5.61 C 320.36 5.27 351.66 14.35 377.94 31.32 C 403.89 47.95 424.97 72.07 437.91 100.05 C 447.92 121.56 453.09 145.31 452.95 169.03 C 452.86 176.65 446.47 183.51 438.92 184.30 C 431.80 185.31 424.50 180.72 422.01 174.03 C 420.77 170.84 421.02 167.34 420.88 163.98 C 419.99 131.97 406.57 100.60 384.29 77.64 C 360.24 52.45 325.79 37.58 290.94 37.57 C 283.60 37.90 276.39 32.72 274.63 25.55 C 272.48 17.92 276.98 9.26 284.42 6.59 Z'></path>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 284.44 70.58 C 288.43 69.04 292.78 69.61 296.95 69.80 C 319.91 71.27 342.15 81.24 358.67 97.24 C 378.00 115.72 389.34 142.29 388.95 169.06 C 388.85 174.64 385.40 179.87 380.55 182.51 C 375.08 185.55 367.87 184.88 363.06 180.89 C 359.13 177.84 356.86 172.93 356.99 167.96 C 356.92 152.82 351.50 137.79 341.87 126.12 C 331.30 113.11 315.71 104.31 299.08 102.15 C 295.48 101.60 291.82 101.69 288.19 101.39 C 280.64 100.57 274.20 93.72 274.14 86.06 C 273.80 79.39 278.18 72.87 284.44 70.58 Z'></path>"
            . "</g>"
            . "</svg>"
            . "</div>"
            . "<input type='text' name='name' placeholder='نام شما'>"
            . "</div>"
            . "<div class='phone-number input-field'>"
            . "<div class='icon'>"
            . "<svg id='telephone-icon-2' viewBox='0 0 458 458'>"
            . "<g id='var(--background-medium-blue-color)ff'>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 97.47 5.71 C 110.04 2.90 123.72 5.34 134.44 12.52 C 140.01 16.17 144.43 21.23 149.16 25.85 C 164.96 41.72 180.89 57.47 196.63 73.40 C 209.71 86.73 213.58 107.96 206.20 125.10 C 203.29 132.30 198.28 138.39 192.69 143.69 C 186.37 150.05 179.95 156.32 173.69 162.74 C 169.13 167.49 168.01 175.14 171.07 180.98 C 196.32 224.79 233.27 261.71 276.95 287.15 C 281.39 289.67 287.04 289.86 291.65 287.65 C 295.15 286.03 297.65 282.97 300.37 280.34 C 306.75 274.05 312.97 267.58 319.45 261.40 C 334.34 247.56 358.19 245.29 375.81 255.11 C 380.25 257.48 384.12 260.75 387.63 264.33 C 404.80 281.50 421.99 298.67 439.16 315.86 C 453.17 329.03 457.88 350.86 450.45 368.61 C 447.87 375.10 443.73 380.88 438.74 385.73 C 426.12 398.12 414.13 411.22 400.19 422.18 C 384.19 434.90 365.95 445.27 345.99 450.20 C 326.01 455.29 304.76 454.32 285.03 448.62 C 261.03 441.81 239.13 429.29 218.62 415.35 C 158.12 373.37 104.41 321.68 59.90 263.03 C 47.03 245.92 34.59 228.37 24.57 209.42 C 11.33 184.57 2.46 156.30 5.60 127.88 C 8.50 99.26 23.18 73.21 41.76 51.78 C 51.66 40.38 62.71 30.05 73.30 19.30 C 79.85 12.59 88.30 7.73 97.47 5.71 M 103.24 37.27 C 98.23 38.64 95.07 43.01 91.48 46.42 C 81.22 56.86 70.36 66.80 61.30 78.36 C 51.61 90.62 43.52 104.46 39.67 119.71 C 35.54 135.61 36.75 152.55 41.66 168.14 C 48.03 188.59 59.36 207.03 71.44 224.57 C 103.53 270.30 141.49 311.89 183.91 348.23 C 204.58 365.80 226.09 382.47 249.00 397.03 C 268.76 409.22 290.50 419.90 314.06 421.25 C 333.87 422.52 353.44 415.72 369.76 404.80 C 387.11 393.57 400.95 378.04 415.60 363.68 C 423.17 357.87 424.24 345.56 417.05 339.02 C 399.71 321.68 382.36 304.34 365.02 287.00 C 362.17 283.85 358.43 281.28 354.10 280.94 C 348.64 280.14 343.05 282.36 339.46 286.50 C 331.95 293.97 324.57 301.59 316.92 308.92 C 302.48 322.25 279.59 325.08 262.35 315.64 C 212.85 287.31 171.14 245.57 142.82 196.07 C 133.60 179.05 136.23 156.57 149.17 142.17 C 157.22 133.56 165.90 125.55 174.02 117.01 C 179.42 111.12 179.16 101.13 173.49 95.50 C 156.54 78.44 139.49 61.49 122.51 44.47 C 117.97 38.80 110.57 34.82 103.24 37.27 Z'></path>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 284.42 6.59 C 285.91 6.03 287.48 5.68 289.08 5.61 C 320.36 5.27 351.66 14.35 377.94 31.32 C 403.89 47.95 424.97 72.07 437.91 100.05 C 447.92 121.56 453.09 145.31 452.95 169.03 C 452.86 176.65 446.47 183.51 438.92 184.30 C 431.80 185.31 424.50 180.72 422.01 174.03 C 420.77 170.84 421.02 167.34 420.88 163.98 C 419.99 131.97 406.57 100.60 384.29 77.64 C 360.24 52.45 325.79 37.58 290.94 37.57 C 283.60 37.90 276.39 32.72 274.63 25.55 C 272.48 17.92 276.98 9.26 284.42 6.59 Z'></path>"
            . "<path fill='var(--background-medium-blue-color)' opacity='1.00' d=' M 284.44 70.58 C 288.43 69.04 292.78 69.61 296.95 69.80 C 319.91 71.27 342.15 81.24 358.67 97.24 C 378.00 115.72 389.34 142.29 388.95 169.06 C 388.85 174.64 385.40 179.87 380.55 182.51 C 375.08 185.55 367.87 184.88 363.06 180.89 C 359.13 177.84 356.86 172.93 356.99 167.96 C 356.92 152.82 351.50 137.79 341.87 126.12 C 331.30 113.11 315.71 104.31 299.08 102.15 C 295.48 101.60 291.82 101.69 288.19 101.39 C 280.64 100.57 274.20 93.72 274.14 86.06 C 273.80 79.39 278.18 72.87 284.44 70.58 Z'></path>"
            . "</g>"
            . "</svg>"
            . "</div>"
            . "<input type='text' name='phone' placeholder='شماره تماس*' pattern='[0-9]{10,11}' required oninvalid=\"setCustomValidity('لطفا شماره تماس خود را به فرمت صحیح وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "</div>"
            . "<div class='form-item type-text honeypot' data-field='family' style='display:none;'>"
            . "<input type='text' name='family'>"
            . "</div>"
            . "<div class='button-field'>"
            . "<input type='submit' class='submit' name='submit_form' value='ارســال فرم'>"
            . "</div>"
            . "</form>";
        return $form;
    }
    public function inperson_meeting_form()
    {
        $form = "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='inperson-meeting-form-id'>"
            . wp_nonce_field('ajax-nonce', 'nonce', false, false)
            . "<input type='hidden' name='action' value='insert_inperson_meeting_form_data'>"
            . "<div class='form-item type-text honeypot' data-field='family' style='display:none;'>"
            . "<input type='text' name='family'>"
            . "</div>"
            . "<input type='text' name='name' placeholder='نام شما'>"
            . "<input type='text' name='phone' placeholder='شماره تلفن*' pattern='[0-9]{10,11}' required oninvalid=\"setCustomValidity('لطفا شماره تماس خود را به فرمت صحیح وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<input type='text' name='city' placeholder='شهر شما*' required oninvalid=\"setCustomValidity('لطفا شهر خود را وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<input type='submit' class='submit' name='submit_form' value='ثبت درخواست'>"
            . "</form>";
        return $form;
    }

    public function job_application_form()
    {
        $form = "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='job-application-form-id' enctype='multipart/form-data'>"
            . wp_nonce_field('ajax-nonce', 'nonce', false, false)
            . "<input type='hidden' name='action' value='insert_job_application_form_data'>"
            . "<input type='text' name='name' placeholder='نام*' required oninvalid=\"setCustomValidity('لطفا نام خود را وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<input type='email' name='email' placeholder='ایمیل*' required oninvalid=\"setCustomValidity('لطفا ایمیل خود را وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<input type='text' name='phone' placeholder='شماره تلفن*' pattern='[0-9]{10,11}' required oninvalid=\"setCustomValidity('لطفا شماره تماس خود را به فرمت صحیح وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<div class='select'>"
            . "<select name='job_position' required oninvalid=\"setCustomValidity('لطفا ردیف شغلی را انتخاب کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<option value='' disabled selected>انتخاب ردیف شغلی*</option>"
            . "<option value='برنامه نویس'>برنامه نویس</option>"
            . "<option value='گرافیست'>گرافیست</option>"
            . "<option value='طراح سایت'>طراح سایت</option>"
            . "<option value='متخصص فروش'>متخصص فروش</option>"
            . "<option value='تولید کننده محتوا'>تولید کننده محتوا</option>"
            . "</select>"
            . "<div class='icon'> <svg viewBox='0 0 218 146' version='1.1'   xmlns='http://www.w3.org/2000/svg' >  <g id='#000000ff'> <path  fill='var(--normal-text-color)'  opacity='1.00'  d=' M 30.79 30.75 C 34.54 29.49 38.76 30.85 41.39 33.72 C 63.29 55.55 85.13 77.44 107.01 99.30 C 127.75 78.58 148.47 57.86 169.19 37.12 C 171.53 34.86 173.70 32.01 177.01 31.16 C 181.48 29.82 186.63 32.17 188.60 36.39 C 190.63 40.30 189.53 45.33 186.31 48.27 C 163.96 70.60 141.65 92.97 119.27 115.28 C 113.07 121.79 101.72 122.09 95.27 115.77 C 73.36 94.00 51.59 72.08 29.70 50.29 C 27.35 47.92 24.49 45.55 24.00 42.04 C 23.01 37.26 26.13 32.14 30.79 30.75 Z' /></g> </svg>  </div>"
            . "</div>"
            . "<textarea name='description' placeholder='توضیحات*' required oninvalid=\"setCustomValidity('لطفا توضیحات را وارد کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\"></textarea>"
            . " <label for='file_upload' class='file-upload-label'>انتخاب فایل</label>"
            . "   <input   type='file'   id='file_upload' type='file' name='resume' accept='.pdf,.jpg,.jpeg,.png,.doc,.docx' required oninvalid=\"setCustomValidity('لطفا فایل رزومه را آپلود کنید')\" onchange=\"try{setCustomValidity('')}catch(e){}\">"
            . "<div id='file_name' class='file-name'>  پسوند مجاز: pdf، jpg، png، word و حداکثر حجم مجاز 2 مگابایت می‌باشد. </div>"
            . "<input type='submit' class='button' name='submit_form' value='ارسال'>"
            . "</form>";
        return $form;
    }
}

// Instantiate classes
new Admin_Form();
new Form_Handler();

// Hook table creation to plugin activation
register_activation_hook(__FILE__, function () {
    $admin_form = new Admin_Form();
    $admin_form->check_and_create_tables();
});

// Enqueue scripts and styles
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('form-handler', plugins_url('/js/form-handler.js', __FILE__), ['jquery'], '1.5', true);
    wp_localize_script('form-handler', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ]);
    wp_enqueue_style('form-styles', plugins_url('/css/form-styles.css', __FILE__), [], '1.5');
});
add_shortcode('new_meeting_form', function () {
    $form = new Form();
    return $form->new_meeting_form();
});
// Shortcodes for forms
add_shortcode('contact_form', function () {
    $form = new Form();
    return $form->contact_form();
});
add_shortcode('meeting_form', function () {
    $form = new Form();
    return $form->meeting_form();
});
add_shortcode('inperson_meeting_form', function () {
    $form = new Form();
    return $form->inperson_meeting_form();
});
add_shortcode('job_application_form', function () {
    $form = new Form();
    return $form->job_application_form();
});
?>