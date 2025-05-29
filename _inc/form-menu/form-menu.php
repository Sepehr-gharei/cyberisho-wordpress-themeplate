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

        // Create or update contact_forms table
        if ($wpdb->get_var("SHOW TABLES LIKE '$contact_table'") != $contact_table) {
            $this->create_custom_table_contact_form();
        } else {
            // Check if email column exists, add if missing
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
        $count = $meeting_count + $contact_count + $inperson_meeting_count;
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
        echo "<div class='wrap received-forms'>"
            . "<nav class='nav-tab-wrapper'>";
        $settings = [
            'meeting_form' => 'فرم درخواست ملاقات ' . $meeting_count,
            'contact_form' => 'فرم تماس با ما ' . $contact_count,
            'inperson_meeting_form' => 'فرم ملاقات حضوری ' . $inperson_meeting_count,
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
        } else {
            // Handle inperson_meeting_form
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
            . "<input type='submit' class='submit' name='submit_form' value='ثبت درخواست'>"
            . "</form>"
            . "</div>";
        return $form;
    }

    public function inperson_meeting_form()
    {
        $form = 
          
             "<form method='post' action='" . admin_url('admin-ajax.php') . "' id='inperson-meeting-form-id'>"
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
    wp_enqueue_script('form-handler', plugins_url('/js/form-handler.js', __FILE__), ['jquery'], '1.4', true);
    wp_localize_script('form-handler', 'ajax_object', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ]);
    wp_enqueue_style('form-styles', plugins_url('/css/form-styles.css', __FILE__), [], '1.4');
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
?>