DirectoryIndex index.php
Options -Indexes
php_flag register_globals off
RewriteEngine on
# Ниже строка чпу благодаря ней урл будет выглядеть примерно так http://test-s.lok/-v465h
RewriteRule ^-(.*) short_url/redirect.php?key=$1 [L]