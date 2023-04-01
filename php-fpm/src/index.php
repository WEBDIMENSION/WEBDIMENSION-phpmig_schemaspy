<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


use eftec\bladeone\BladeOne;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);

$php_version = $_SERVER['PHP_VERSION'];
$ip = $_SERVER['REMOTE_ADDR'];

if (explode('.', $_SERVER['REMOTE_ADDR'])[0] == '172') {
    $docker_on = "Docker For Mac";
} else {
    $docker_on = "multipass";
}


$title = $_SERVER['CONTAINER_NAME_PREFIX'];
$protocol = $_SERVER['REQUEST_SCHEME'];
$host = explode(':', $_SERVER['HTTP_HOST'])[0];

function create_url($port): string
{
    global $protocol;
    global $host;
    return $protocol . '://' . $host . ':' . $port;
}

$links = [];
$links[] = ['service_name' => 'prism', 'href' => create_url(getenv('PRISM_CLIENT_PORT'))];
$links[] = ['service_name' => 'swagger-ui', 'href' => create_url(getenv('SWAGGER_UI_CLIENT_PORT'))];
$links[] = ['service_name' => 'schemaspy_mysql', 'href' => create_url(getenv('NGINX_SCHEMASPY_MYSQL_EXTERNAL_PORT'))];
$links[] = ['service_name' => 'schemaspy_postgres', 'href' => create_url(getenv('NGINX_SCHEMASPY_POSTGRES_EXTERNAL_PORT'))];
$links[] = ['service_name' => 'kibbana', 'href' => create_url(getenv('KIBANA_EXTERNAL_PORT'))];

echo $blade->run("index",
    compact(
        'php_version',
        'ip',
        'docker_on',
        'title',
        'host',
        'protocol',
        'links',
    )
);
