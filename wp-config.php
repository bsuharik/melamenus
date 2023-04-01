<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wordpress' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', 'LRdzaWdj4DT9qo' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^LVOMpQ^w+| rs^?WseYuOKOW$1z:x$LbMEZHKFZ96`xB/QJ~KDC<^S4z|iW@*d|' );
define( 'SECURE_AUTH_KEY',  'b=Xvbq~U/,3}_U#fsT=O|G6sbw_>62f(4Ti3-GmR#H<Z)Z_]FL.Gmc;]SX,6=i(b' );
define( 'LOGGED_IN_KEY',    '9@5pP}erAgjpQ}rW?plV:mat-=T+fu7+$Fg4^7/d[:]5}Td`Q0i&H5:7@~FLBFLj' );
define( 'NONCE_KEY',        'JSB^[:Y_wdG4pyT<zK[HX/|(G%z/FPC@j&?JVm~!}&KNuZ&:wvtxN!6$4K;%wA.d' );
define( 'AUTH_SALT',        'n~By[aMR7gyrP6B^g7UD6j8bDMjh[y4JW7iF-k.Nxfg.9{e+Yi8z83ri:8_wmDuk' );
define( 'SECURE_AUTH_SALT', 'eiB(^|W(0}vASW~O2ZXEb%:Y{T4iz&g54zj2jJ 9rHoUPAqaQ>j>qbpwLIkJN55.' );
define( 'LOGGED_IN_SALT',   '%AyT3_vg@;e7I_L?qjwF@|$wM,r=E7Ifr}jWyRYwR|~M],d#1)napr#fBR%lz+[w' );
define( 'NONCE_SALT',       '{OSu-IALy1.kss T?|nN4_GKoM.JijK$__[{qDmeWPpcu8w3{P?s(E3RR^1PQV4}' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD','direct');
