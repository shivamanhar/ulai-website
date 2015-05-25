<?php

/**
 * Script helping to set up environment after first pull on linux
 * Just run [sudo php first_pull_init.php]
 * 
 * @author, initiator and just good person: ailok <m.kecha
 */
/*
 * Root path - all path will be relative to this constant
 */
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);


/*
 * simple check if root path is valid
 */
if (
        !file_exists(ROOT_PATH . 'index.php') ||
        !is_dir(ROOT_PATH . 'application') ||
        !is_dir(ROOT_PATH . 'system')
) {
    exit('ROOT_PATH seems to be invalid');
}

function _readLine($message) {
    file_put_contents('php://stdout', $message);
    $handle = fopen("php://stdin", "r");
    return trim(fgets($handle), PHP_EOL);
}

function outputLine($message) {
    file_put_contents('php://stdout', $message . PHP_EOL);
}

function executeAndOutputResult($command) {
    file_put_contents('php://stdout', `{$command}`);
}

/*
 * Getting "type" of CMS version (for database)
 */
$cmsType = _readLine('Shop[1] or Corporate[2] (enter 1 or 2): ');
if (!in_array($cmsType, [1, 2])) {
    outputLine('Wrong type - only 1 or 2 values a acceptable');
    exit;
}


/*
 * Creating needed ignored folders 
 */
mkdir(ROOT_PATH . 'application/logs', 0777);
mkdir(ROOT_PATH . 'captcha', 0777);
mkdir(ROOT_PATH . 'system/cache', 0777);
mkdir(ROOT_PATH . 'system/cache/templates_c', 0777);

$root = ROOT_PATH;
outputLine('Cppying uploads. It may take some time...');
`cp -r {$root}uploads_site {$root}uploads`;


/*
 * Configuration database
 */
outputLine('php://stdout', 'Configuring database: ');
$database = _readline('New database name: ');
$user = _readline('Username: ');
$password = _readline('Password: ');

if (empty($database) || empty($user)) {
    outputLine('Bad database params - please set up it by yourself');
} else {
    $password = $password;
    $password_ = !empty($password) ? '-p' . $password . ' ' : ' ';

    $sqlDumpPath = ROOT_PATH . 'application/modules/install/' . ($cmsType == 1 ? 'sqlPre.sql' : 'sqlSite.sql');

    executeAndOutputResult(`mysql -u{$user} {$password_} -e "CREATE DATABASE {$database}"`);
    executeAndOutputResult(`mysql -u{$user} {$password_} {$database} < {$sqlDumpPath}`);

    /*
     * setting up config credentials for cms 
     */
    $databaseConfigSample = ROOT_PATH . 'application/config/database.sample.php';
    $databaseConfig = ROOT_PATH . 'application/config/database.php';
    copy($databaseConfigSample, $databaseConfig);

    $databaseConfigContent = file_get_contents($databaseConfig);

    $basePattern = "/db\['default'\]\['__KEY__'\]\s+=\s+'([a-zA-Z0-9\-\_]*)';/";
    $baseReplacement = "db['default']['__KEY__'] = '__VALUE__';";

    $data = [
        'hostname' => 'localhost',
        'username' => $user,
        'password' => $password,
        'database' => $database,
    ];

    foreach ($data as $key => $value) {
        $keyPattern = str_replace('__KEY__', $key, $basePattern);
        $replacement = str_replace(['__KEY__', '__VALUE__'], [$key, $value], $baseReplacement);
        $databaseConfigContent = preg_replace($keyPattern, $replacement, $databaseConfigContent);
    }

    file_put_contents($databaseConfig, $databaseConfigContent);
}

`chmod -R 0777 {$root}`;

/*
 * Updating dependecies
 */
echo "Updating dependecies... Please wait...\n";
executeAndOutputResult(`composer update`);



exit;

/**
 * Optional - creating new host
 */
if ("yes" == _readline('Create new apache local host? (type "yes" to proceed): ')) {
        
    if ($newHostName = _readLine('Enter new host name: ')) {
        
        $virtualHostContent = "
            <VirtualHost *:80>
                ServerAdmin webmaster@{$newHostName}
                ServerName {$newHostName}
                ServerAlias www.{$newHostName}
                DocumentRoot /var/www/{$newHostName}
                <Directory />
                        Options FollowSymLinks
                        AllowOverride All
                </Directory>
                <Directory /var/www/{$newHostName}>
                        Options Indexes FollowSymLinks MultiViews
                        AllowOverride All
                        Order allow,deny
                        allow from all
                </Directory>
            </VirtualHost>  
        ";
                
        $configFile = "{$newHostName}.conf";
        $confFilePath = "/etc/apache2/sites-aviable/{$configFile}";
        
        executeAndOutputResult(`a2ensite {$configFile}`);
        executeAndOutputResult(`service apache2 restart`);
        
        file_put_contents('/etc/hosts', "127.0.0.1\t{$newHostName}\n", FILE_APPEND);
        
        outputLine("New host created. Address: http://{$newHostName}");        
    }
    
    
} else {
    outputLine('Host creation skipped');
}



outputLine('Finish!');
